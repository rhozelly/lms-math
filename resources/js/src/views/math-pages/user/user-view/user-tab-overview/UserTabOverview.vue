<template>
  <div class="user-tab-overview">

    <!-- user project list -->
    <v-card class="mb-7">
      <v-card-title> 
        수업 리스트
        <v-spacer></v-spacer>
        <v-btn color="primary" class="me-3" @click = "isCourseAddDialogVisible = !isCourseAddDialogVisible">
          <v-icon size="18" class="me-1">
            {{ icons.mdiPlus }}
          </v-icon>
          <span>수업 등록하기</span>
        </v-btn>
      </v-card-title>

      <v-data-table 
        :headers="tableColumnHeaders" 
        :items="courseList" 
        :loading = "loading"
        :items-per-page="itemsPerPage"
        :footer-props="footerProps"
      >
        <!-- Course -->
        <template #[`item.course`]="{ item }">
          <div class="d-flex align-center">
            <v-avatar size="33" class="me-3">
              <!-- <v-img :src="require(`@/assets/images/icons/project-icons/${item.logo}`).default"></v-img> -->
              <v-icon> {{ icons.mdiSchoolOutline }} </v-icon>
            </v-avatar>
            <div class="text-no-wrap">
              <p class="font-weight-medium text--primary mb-n1 cursor-pointer" @click="courseData = item, isCourseEditDialogVisible = !isCourseAddDialogVisible">
                {{ item.name }}
              </p>
              <span class="text-xs text--disabled">{{ item.course }}</span>
            </div>
          </div>
        </template>

        <!-- progress -->
        <template #[`item.active`]="{ item }">
          <v-chip 
            :color="(item.active == 1)?'success':'error'" 
            small
          >
            {{ (item.active == 1) ? '진행' : '정지' }}
          </v-chip>
        </template>

        <!-- actions -->
        <template #[`item.actions`]="{ item }">
           <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>{{ icons.mdiDotsVertical }}</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item @click="openDialog(item,'move')">
                <v-list-item-title>
                  <v-icon size="20" class="me-2">
                    {{ icons.mdiArrowRightBoldCircleOutline }}
                  </v-icon>
                  <span>전반처리</span>
                </v-list-item-title>
              </v-list-item>

              <v-list-item @click="openDialog(item,'holdOut')">
                <v-list-item-title>
                  <v-icon size="20" class="me-2">
                    {{ icons.mdiTableCancel }}
                  </v-icon>
                  <span>퇴원/홀드</span>
                </v-list-item-title>
              </v-list-item>

               <v-list-item @click="openDialog(item,'delete')">
                <v-list-item-title>
                  <v-icon size="20" class="me-2">
                    {{ icons.mdiDeleteOutline }}
                  </v-icon>
                  <span>삭제</span>
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>

      </v-data-table>
    </v-card>

    <user-course-add :is-course-add-dialog-visible.sync = "isCourseAddDialogVisible" :user-data="userData" @refetch-data="fetchCourses"></user-course-add>
    <user-course-edit :isCourseEditDialogVisible.sync = "isCourseEditDialogVisible" :course-data="courseData" @refetch-data="fetchCourses"></user-course-edit>
    <user-course-delete :isCourseDeleteDialogVisible.sync = "isCourseDeleteDialogVisible" :course-data="courseData" @refetch-data="fetchCourses"></user-course-delete>
    <course-move :isMoveDialogVisible.sync = "isMoveDialogVisible"  :course-data="courseData" @refetch-data="fetchCourses"></course-move>
    <course-hold-out :isHoldOutDialogVisible.sync = "isHoldOutDialogVisible"  :course-data="courseData" @refetch-data="fetchCourses"></course-hold-out>
    <!-- <user-course-add :is-course-edit-dialog-visible.sync = "isCourseAddDialogVisible"></user-course-add> -->

  </div>
</template>

<script>
import { mdiDotsVertical, mdiFilePdf, mdiSchoolOutline, mdiPlus, mdiFileDocumentOutline, mdiDeleteOutline, mdiArrowRightBoldCircleOutline, mdiTableCancel, } from '@mdi/js'
import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
import UserCourseAdd from '@/views/math-pages/user/user-view/user-tab-overview/UserCourseAdd'
import UserCourseEdit from '@/views/math-pages/user/user-view/user-tab-overview/UserCourseEdit'
import UserCourseDelete from '@/views/math-pages/user/user-view/user-tab-overview/UserCourseDelete'
import CourseMove from '@/views/math-pages/user/user-view/user-tab-overview/CourseMove'
import CourseHoldOut from '@/views/math-pages/user/user-view/user-tab-overview/CourseHoldOut'
import { ref,watch } from '@vue/composition-api'
import store from '@/store'
import useUsersList from '../../user-list/useUsersList'

export default {
  components: { InvoiceList, UserCourseAdd, UserCourseEdit, UserCourseDelete, CourseMove, CourseHoldOut },
  props:{
    userData:{
      type: Object,
      required: true,
    },
  },
  setup() {
    const isCourseAddDialogVisible = ref(false)
    const isCourseEditDialogVisible = ref(false)
    const isCourseDeleteDialogVisible = ref(false)
    const isMoveDialogVisible = ref(false)
    const isHoldOutDialogVisible = ref(false)
    const courseData = ref({})
    const itemsPerPage = ref(3)
    const footerProps = ref({
        "items-per-page-options": [3,5,10,-1],
        "items-per-page-text": '페이지 수'
    })

    watch(courseData,(oldData)=>{
      console.log('this is watch',oldData)
    })

    const tableColumnHeaders = [
      {
        text: '수업',
        value: 'course',
        sortable: false,
      },
      { text: '상태', value: 'active', sortable: false },
      { text: '동작', value: 'actions', sortable: false },
    ]

    const resolveUserProgressVariant = progrss => {
      if (progrss <= 25) return 'error'
      if (progrss > 25 && progrss <= 50) return 'warning'
      if (progrss > 50 && progrss <= 75) return 'primary'
      if (progrss > 75 && progrss <= 100) return 'success'

      return 'secondary'
    }

    const openDialog = (item,type) => {
      switch (type) {
        case 'move':    courseData.value = item; isMoveDialogVisible.value = true; break;
        case 'holdOut': courseData.value = item; isHoldOutDialogVisible.value = true; break;
        case 'delete':  courseData.value = item; isCourseDeleteDialogVisible.value = true; break;
        default: break;
      }
    }

    const {courseList,courseLoading, fetchCourses} = useUsersList()
    const loading = courseLoading
    console.log(loading)

    fetchCourses()

    return {
      isCourseAddDialogVisible,
      isCourseEditDialogVisible,
      isCourseDeleteDialogVisible,
      isMoveDialogVisible,
      isHoldOutDialogVisible,
      tableColumnHeaders,
      courseList,
      loading,
      courseData,
      itemsPerPage,
      footerProps,
      openDialog,
      fetchCourses,
      resolveUserProgressVariant,
      icons: {
        mdiDotsVertical,
        mdiFilePdf,
        mdiSchoolOutline,
        mdiPlus,
        mdiFileDocumentOutline, 
        mdiDeleteOutline,
        mdiArrowRightBoldCircleOutline,
        mdiTableCancel,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
.project-progress {
  min-width: 4rem;
}
</style>
