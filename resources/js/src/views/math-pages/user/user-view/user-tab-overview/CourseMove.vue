          
<template>
  <v-dialog v-model="isMoveDialogVisible" persistent max-width="600px">
    <v-card>
      <v-card-title>
        <span class="headline">전반처리</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" @submit.prevent="onSubmit">
            <v-row>
              <v-col cols="12">
                <span class="caption">현재 선생님</span><br>
                <p class="subtitle-2" style="border-bottom:1px solid #5e566924"><b>{{ origin_teacher_name }}</b></p>
              </v-col>
              <v-col cols="12">
                <v-select label="새 선생님" dense v-model="moveDataLocal.new_teacher_id" :items="teacherList"
                  item-text="title" item-value="value" :rules="[validators.required]"></v-select>
              </v-col>
              <v-col cols="12">
                <v-select label="변경 사유" dense v-model="moveDataLocal.status" :items="statusOptions" item-text="title"
                  item-value="value" :rules="[validators.required]"></v-select>
              </v-col>
              <v-col cols="12">
                <v-textarea label="변경 사유 메모" dense v-model="moveDataLocal.text"
                  :rules="[validators.required]"></v-textarea>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" outlined @click="$emit('update:is-move-dialog-visible', false)">
          닫기
        </v-btn>
        <v-btn color="success" @click="onSubmit">
          변경하기
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { ref, watch } from '@vue/composition-api'
import { required } from '@core/utils/validation'
import store from "@/store"


export default {
  props: {
    isMoveDialogVisible: {
      type: Boolean,
      required: true,
    },
    courseData: {
      type: Object,
      required: true,
    }
  },
  setup(props, { emit }) {
    const form = ref(null)
    const valid = ref(false)
    const moveDataLocal = ref({})
    const teacherList = ref([])
    const origin_teacher_name = ref("")
    // const blankMoveData = {
    //         user_id:props.courseData.id,
    //         course_id:props.courseData.student.id,
    //         branch_id:props.courseData.branch.id,
    //         old_teacher:props.courseData.teacher.id,
    //         new_teacher:"",
    //         status:"",
    //         title:"",
    //         text:"",
    //         return_day:"",
    //       }

    const statusOptions = [
      { title: '정상전반', value: 'move_normal' },
      { title: '이슈전반', value: 'move_issue' },
    ]

    const validate = () => {
      form.value.validate()
    }

    const resetForm = () => {
      form.value.reset()
    }

    const fetchTeachers = () => {
      //강사 아이디 6
      store.dispatch('app-user/getUsers', {
        role_id: 6,
        branch_id: props.courseData.branch.id,
      }).then(rs => {
        // console.log('uca',rs)
        teacherList.value = rs.data.filteredData.map(item => {
          return { title: item.fullName, value: String(item.id) }
        })
        console.log('rs', teacherList)
        // teacherList.value = rs.data
      }).catch(err => {
        console.log(err)
      })
    }

    const onSubmit = () => {
      if (valid.value) {
        let old_teacher = origin_teacher_name
        let new_teacher = teacherList.value.find(obj => {
          if (obj.value == moveDataLocal.value.new_teacher_id) return true
        })
        new_teacher = new_teacher.title
        moveDataLocal.value.title = `${old_teacher} -> ${new_teacher}`
        store.dispatch('app-user/addMoveHoldOut', {
          ...moveDataLocal.value,
          text: moveDataLocal.value.title + "\r\n" + moveDataLocal.value.text,
        })
          .then(rs => {
            console.log(rs)
          }).catch(err => {
            console.log(err)
          }).then(() => {
            emit('refetch-data')
            emit('update:is-move-dialog-visible', false)
          })
      } else {
        validate()
      }
    }

    watch(
      () => props.isMoveDialogVisible,
      () => {
        let blankMoveData = {
          user_id: props.courseData.student.id,
          course_id: props.courseData.id,
          branch_id: props.courseData.branch.id,
          old_teacher_id: props.courseData.teacher.id,
          new_teacher_id: "",
          status: "",
          title: "",
          text: "",
          return_day: "",
        }
        console.log(props.courseData)
        fetchTeachers()
        origin_teacher_name.value = props.courseData.teacher.name
        moveDataLocal.value = JSON.parse(JSON.stringify(blankMoveData))
        if (null !== form.value) { resetForm() }
      }
    )


    return {
      form,
      valid,
      teacherList,
      statusOptions,
      origin_teacher_name,
      moveDataLocal,
      onSubmit,
      validators: {
        required
      }
    }
  },
}
</script>