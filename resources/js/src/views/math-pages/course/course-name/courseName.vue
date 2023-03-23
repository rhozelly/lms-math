<template>
  <div>
    <v-card>
      <v-card-title>설정페이지</v-card-title>
      <v-card-text>
        <v-row class="px-2 ma-0">
          <v-col cols="6">
            <h3>반 이름 {{action == 'add' ? '추가' : '수정'}}({{action}})</h3>
            <v-form
              ref="form"
              v-model="valid"
              @submit.prevent="addCourseName"
            >
              <v-text-field
                v-model="courseNameData.name"
                :append-outer-icon="courseNameData.name && !loading ? icons.mdiSendOutline : ''"
                :clear-icon=" !loading ? icons.mdiCloseCircleOutline : ''"
                clearable
                label="반 이름을 입력해주세요."
                type="text"
                :rules="[validators.required]"
                hide-details
                @click:append-outer="addCourseName"
                @click:clear="clearInputField"
              >
                <template v-slot:append>
                  <v-fade-transition leave-absolute>
                    <v-progress-circular
                      v-if="loading"
                      size="24"
                      color="info"
                      indeterminate
                    ></v-progress-circular>
                  </v-fade-transition>
                </template>
              </v-text-field>
            </v-form>

            <v-list>

              <v-list-item v-for="(courseName, index) in courseNameLits" :key="index">
                <v-list-item-content>{{courseName.name}}</v-list-item-content>
                <v-list-item-action>
                  <v-menu bottom left>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>{{ icons.mdiDotsVertical }}</v-icon>
                      </v-btn>
                    </template>

                    <v-list>
                      <v-list-item @click="set4('edit',courseName.id,courseName.name)">
                        <v-list-item-title>
                          <v-icon size="20" class="me-2">
                            {{ icons.mdiFileDocumentOutline }}
                          </v-icon>
                          <span>수정하기</span>
                        </v-list-item-title>
                      </v-list-item>

                      <v-list-item @click="deleteCourseName(courseName.id)">
                        <v-list-item-title>
                          <v-icon size="20" class="me-2">
                            {{ icons.mdiDeleteOutline }}
                          </v-icon>
                          <span>삭제</span>
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </v-list-item-action>
              </v-list-item>

            </v-list>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { onUnmounted, ref } from '@vue/composition-api'
import router from '@/router'
import store from '@/store'
import { required } from '@core/utils/validation'

import {
  mdiDotsVertical,
  mdiFileDocumentOutline,
  mdiDeleteOutline,

  mdiSendOutline,
  mdiMicrophone,
  mdiCloseCircleOutline,
} from '@mdi/js'

import userStoreModule from '../../user/userStoreModule'

export default {
  components: {
  },
  setup() {
    const userData = JSON.parse( localStorage.getItem('userData') )
    const USER_APP_STORE_MODULE_NAME = 'app-user'
    const form = ref(null)
    const valid = ref(false)
    const loading = ref(false)
    const courseNameLits = ref([])
    const action = ref('add')
    const courseNameData = ref({
      id:null,
      name:'',
    })

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule)

    // // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    const clearInputField = () => {
      courseNameData.value.name = ''
      action.value = 'add'
    }
    
    const resetForm = () => {
      form.value.reset()
    }

    const set4 = (ac, id = 0, txt = "") => {
      action.value = ac
      courseNameData.value.name = txt 
      courseNameData.value.id = id
    }

    const deleteCourseName = id => {
      loading.value = true
      store.dispatch('app-user/deleteCourseName',{id})
      .then(rs => { 
        console.log(rs)
        fetchCourseNames()
        }).catch(err => {
          console.log(err)
        }).finally(() => {
          loading.value = false
        })
    }

    const fetchCourseNames = () => {
      store.dispatch('app-user/fetchCourseNames')
      .then(rs => { 
        console.log(rs)
        courseNameLits.value = rs.data 
        }).catch(err => {
          console.log(err)
        })
    }

    fetchCourseNames()

    const addCourseName = () => {
      if (valid.value&&!loading.value) {
        loading.value = true
        if(action.value == 'add'){
          console.log('hi')
          store.dispatch('app-user/addCourseName',{
            name: courseNameData.value.name,
            branch_id: userData.branch_id
          }).then( rs => {
            console.log(rs)
            clearInputField()
            resetForm()
            fetchCourseNames()
          }).catch( err => {
            console.log(err)
          }).finally(() => {
            loading.value = false
          })
        }else if(action.value == 'edit'){
          console.log('hi2')
          store.dispatch('app-user/editCourseName',{
            ...courseNameData.value,
            branch_id: userData.branch_id
          }).then( rs => {
            console.log(rs)
            clearInputField()
            resetForm()
            fetchCourseNames()
          }).catch( err => {
            console.log(err)
          }).finally(() => {
            loading.value = false
          })
        }
        
      }
    }

    return {
      form,
      valid,
      action,
      courseNameData,
      courseNameLits,
      set4,
      loading,
      clearInputField,
      addCourseName,
      deleteCourseName,
      
      icons:{
        mdiDotsVertical,
        mdiFileDocumentOutline,
        mdiDeleteOutline,

        mdiSendOutline,
        mdiMicrophone,
        mdiCloseCircleOutline,
      },
      validators:{
        required
      }
    }
  },
}
</script>

<style lang="scss">
@import '@resources/sass/preset/apps/user.scss';
</style>
