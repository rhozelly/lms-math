          
<template>
  <v-dialog
    v-model="isHoldOutDialogVisible"
    persistent
    max-width="600px"
  >
    <v-card>
      <v-card-title>
        <span class="headline">홀드/휴강</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form
            ref="form"
            v-model="valid"
            @submit.prevent="onSubmit"
          >
            <v-row>
              <v-col
                cols="6"
              >
                <v-select
                  label="종류"
                  v-model="holdOutDataLocal.status"
                  :items="statusOptions"
                  item-text="title"
                  item-value="value"
                  :rules="[validators.required]"
                  dense
                ></v-select>
              </v-col>
              <v-col
                cols="6"
              >
                <v-dialog
                  ref="returnDayDialog"
                  v-model="modal"
                  :return-value.sync="holdOutDataLocal.return_day"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      label="복귀일"
                      v-model="holdOutDataLocal.return_day"
                      :prepend-icon="icons.mdiCalendar"
                      :rules="holdOutDataLocal.status==='hold'? [validators.required] : []"
                      readonly
                      :disabled="holdOutDataLocal.status=='hold'?false:true"
                      dense
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
  
                  <v-date-picker
                    v-model="holdOutDataLocal.return_day"
                    scrollable
                    locale="ko-KR"
                    color="primary"
                  >
                    <v-btn
                      text
                      color="primary"
                      @click="modal = false"
                    >
                      취소
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.returnDayDialog.save(holdOutDataLocal.return_day)"
                    >
                      선택
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="홀드/퇴원 사유"
                  v-model="holdOutDataLocal.text"
                  :rules="[validators.required]"
                  dense
                ></v-text-field>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="error"
          outlined
          @click="$emit('update:is-hold-out-dialog-visible',false)"
        >
          닫기
        </v-btn>
        <v-btn
          color="success"
          @click="onSubmit"
        >
          변경하기
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { ref,watch } from '@vue/composition-api'
import { required } from '@core/utils/validation'
import {  mdiCalendar, } from '@mdi/js'
import store from "@/store"

export default {
  props:{
    isHoldOutDialogVisible:{
      type: Boolean,
      required: true,
    },
    courseData:{
      type: Object,
      required: true,
    }
  },
  setup(props,{emit}) {
    const form = ref(null)
    const valid = ref(false)
    const holdOutDataLocal = ref({})
    const modal = ref(false)
    const origin_teacher_name = ref("")
    // const blankHoldOutData = {
    //   type: "",
    //   return_day:null,
    //   text:""
    // }

    const statusOptions = [
      { title: '홀드', value: 'hold' },
      { title: '퇴원', value: 'out' },
    ]

    const validate = () => {
      form.value.validate()
    }

    const resetForm = () => {
      form.value.reset()
    }

    const unixTimestampConv = (date) =>
    {
        return Math.floor(new Date(date).getTime() / 1000)
    }

    const onSubmit = () => {
      console.log('hi',valid.value);
      if(valid.value){

        holdOutDataLocal.value.title = `마지막 강사: ${origin_teacher_name.value}`
        let return_day = holdOutDataLocal.value.status === "hold" ? unixTimestampConv(holdOutDataLocal.value.return_day) : "";
        let prefix = `${holdOutDataLocal.value.title}/복귀날짜: ${holdOutDataLocal.value.return_day}/`;
        
        store.dispatch('app-user/addMoveHoldOut',{
          ...holdOutDataLocal.value,
          text: prefix+holdOutDataLocal.value.text,
          return_day,
        })
        .then(rs => {
          console.log(rs)
        }).catch(err => {
          console.log(err)
        }).then(() => {
          emit('refetch-data')
          emit('update:is-hold-out-dialog-visible',false)
        })
      } else {
        validate()
      }
    }

    watch(
      () => props.isHoldOutDialogVisible,
      () => {
        let blankHoldOutData = {
          user_id:props.courseData.student.id,
          course_id:props.courseData.id,
          branch_id:props.courseData.branch.id,
          old_teacher_id:props.courseData.teacher.id,
          new_teacher_id:"",
          status:"",
          title:"",
          text:"",
          return_day:"",
        }
        origin_teacher_name.value = props.courseData.teacher.name
        holdOutDataLocal.value = JSON.parse(JSON.stringify(blankHoldOutData))
        if(null !== form.value) resetForm()
    })
    // return { isHoldOutDialogVisible }
    return { 
      form,
      valid,
      holdOutDataLocal,
      statusOptions,
      onSubmit,
      modal,
      icons:{
        mdiCalendar,
      },
      validators:{
        required,
      }
     }
  },
}
</script>