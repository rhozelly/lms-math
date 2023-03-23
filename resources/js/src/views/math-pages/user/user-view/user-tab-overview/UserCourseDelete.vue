<template>
  <v-dialog
        v-model="isCourseDeleteDialogVisible"
        width="500"
      >
      <v-card>
        <v-card-title>
          수업 삭제
        </v-card-title>

        <v-card-text>
          정말로 해당 수업을 삭제하시겠습니까?
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            @click="$emit('update:is-course-delete-dialog-visible',false)"
          >
            취소
          </v-btn>
          <v-btn
            color="error"
            @click="deletCourse()"
          >
            삭제하기
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
import { ref, watch } from '@vue/composition-api'
import store from '@/store'

export default {
  props:{
    isCourseDeleteDialogVisible:{
      type:Boolean,
      required:true
    },
    courseData:{
      type:Object,
      required:true
    }
  },
  setup(props, {emit}) {
    watch(
      () => props.isCourseDeleteDialogVisible,
      () => {
        console.log(props)
      }
    )
    const deletCourse = () => {
      store.dispatch('app-user/deleteCourse',{id:props.courseData.item.id})
        .then((rs)=>{
          console.log(rs)
          emit('refetch-data')
          console.log('courseDelete!',courseData)
          // fetchNote()
        })
        .catch((err)=>{
          console.log(err)
        })
      emit('update:is-course-delete-dialog-visible',false)
    }
    return { 
      deletCourse,
      }
  },
}
</script>


