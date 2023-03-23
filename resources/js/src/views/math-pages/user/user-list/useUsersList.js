import store from '@/store'
import {
  mdiAccountCheckOutline,
  mdiAccountOutline,
  mdiAccountPlusOutline,
  mdiAccountRemoveOutline,
  mdiCogOutline,
  mdiDatabaseOutline,
  mdiDnsOutline,
  mdiPencilOutline,
} from '@mdi/js'
import { ref, watch } from '@vue/composition-api'
import router from '@/router'

export default function useUsersList() {
  const userListTable = ref([])
  const page = ref(1)

  const tableColumns = [
    { text: '사용자', value: 'fullName' },
    { text: '이메일', value: 'email' },
    { text: '역할', value: 'role', sortable: false },
    { text: '상태', value: 'status', sortable: false },
    {
      text: '동작',
      value: 'actions',
      align: 'center',
      sortable: false,
    },
  ]

  const searchQuery = ref('')
  const searchType = ref('이름')
  const roleFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)
  const totalUserListTable = ref(0)
  const loading = ref(false)
  const options = ref({
    sortBy: ['id'],
    sortDesc: [true],
  })
  const userTotalLocal = ref([])
  const selectedRows = ref([])

  const userListTable2 = ref([])
  const totalUserListTable2 = ref(0)
  const userTotalLocal2 = ref([])

  const courseList = ref([])
  const courseLoading = ref(false)

  const fetchUsers2 = () => {
    store
      .dispatch('app-user/getUsers', {
        q: searchQuery.value,
        searchType: searchType.value,
        ...options.value,
        activity: statusFilter.value,
        role_id: roleFilter.value,
        // plan: planFilter.value,
      })
      .then(response => {
        let { filteredData, total, userTotal } = response.data

        userListTable2.value = filteredData
        totalUserListTable2.value = total
        userTotalLocal2.value = userTotal
        console.log(response);
        // remove loading state
        loading.value = false
      })
      .catch(error => {
        console.log(error)
      })
  }

  // fetch data
  const fetchUsers = () => {
    store
      .dispatch('app-user/fetchUsers', {
        q: searchQuery.value,
        options: options.value,
        status: statusFilter.value,
        role: roleFilter.value,
        plan: planFilter.value,
      })
      .then(response => {
        const { filteredData, total, userTotal } = response.data

        userListTable.value = filteredData
        totalUserListTable.value = total
        userTotalLocal.value = userTotal

        // remove loading state
        loading.value = false
      })
      .catch(error => {
        console.log(error)
      })
  }

  //fetch course
  const fetchCourses = () => {
    courseLoading.value = true;
    store.dispatch('app-user/fetchCourses')
    .then(rs=>{
      courseList.value = rs.data
      console.log('list!!',rs)
    })
    .catch(err=>{
      console.log(err)
    }).then(()=>{
      courseLoading.value=false
      console.log(courseLoading,'then')
  })
  }

  watch([roleFilter, planFilter, statusFilter, options], () => {
    loading.value = true
    selectedRows.value = []
    // fetchUsers()
    fetchUsers2()
  })
  var timer = null
  watch([searchQuery,searchType], () => {
      if (timer) {
          clearTimeout(timer);
          timer = null
      }
      timer = setTimeout(() => {
        loading.value = true
        selectedRows.value = []
        options.value.page = 1
        fetchUsers2()
      }, 800)
  })

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveUserRoleVariant = role => {
    if (role === 'manager') return 'primary'
    if (role === 'principal') return 'warning'
    if (role === 'teacher') return 'success'
    if (role === 'student') return 'info'
    if (role === 'admin') return 'error'

    return 'primary'
  }

  const resolveUserRoleIcon = role => {
    if (role === 'manager') return mdiAccountOutline
    if (role === 'principal') return mdiCogOutline
    if (role === 'teacher') return mdiDatabaseOutline
    if (role === 'student') return mdiPencilOutline
    if (role === 'admin') return mdiDnsOutline

    return mdiAccountOutline
  }

  const resolveUserStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 1) return 'success'
    if (status === 0) return 'secondary'

    return 'primary'
  }

  const resolveUserTotalIcon = total => {
    if (total === 'Total Users') return { icon: mdiAccountOutline, color: 'primary' }
    if (total === 'Paid Users') return { icon: mdiAccountPlusOutline, color: 'error' }
    if (total === 'Active Users') return { icon: mdiAccountCheckOutline, color: 'success' }
    if (total === 'Pending Users') return { icon: mdiAccountRemoveOutline, color: 'warning' }

    return { icon: mdiAccountOutline, color: 'primary' }
  }

  const selectUser = ( id ) => {
    let users = store.getters['app-user/getSelectedUsers']
    let userData = ''
    //만약 아이디가 중복되면 바로 이동
    let existingIndex = users.findIndex(user => user.id == id)
    if(existingIndex !== -1){
      store.dispatch('app-user/getUser', { id })
      .then(response => {
        userData = response.data
        store.commit('app-user/updateUser', { userData , index: existingIndex })
      })
      .catch(error => {
        if (error.response.status === 404) { 
          userData = {} 
          store.commit('app-user/updateUser', { userData , index: existingIndex })
        }
      }).then(()=>{
        router.push({
          name:'admin-user-view',
          params:{ id }
        })
      })
    }else{
      store
        .dispatch('app-user/getUser', { id })
        .then(response => {
          userData = response.data
          store.commit('app-user/selectUser',{ userData })
          // console.log( 'from getters',store.getters['app-user/getSelectedUsers'] )
          router.push({
            name:'admin-user-view',
            params:{ id }
          })
        })
        .catch(error => {
          if (error.response.status === 404) { userData = {} }
        })
    }
  }

  return {
    userListTable,
    tableColumns,
    searchQuery,
    searchType,
    roleFilter,
    planFilter,
    statusFilter,
    totalUserListTable,
    loading,
    options,
    userTotalLocal,
    selectedRows,
    fetchUsers,
    resolveUserRoleVariant,
    resolveUserRoleIcon,
    resolveUserStatusVariant,
    resolveUserTotalIcon,

    courseLoading,
    courseList,
    fetchCourses,

    userListTable2,
    totalUserListTable2,
    userTotalLocal2,
    fetchUsers2,
    selectUser,
    page,
  }
}
