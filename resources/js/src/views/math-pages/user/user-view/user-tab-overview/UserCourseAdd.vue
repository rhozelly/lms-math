          
<template>
  <v-dialog
    v-model="isCourseAddDialogVisible"
    persistent
    max-width="800px"
  >

    <v-card>
      <v-card-title>
        <span class="headline"> <v-icon>{{icons.mdiCalendarPlus}}</v-icon> 수업 등록</span>
      </v-card-title>
      <v-card-text>
        <v-form 
          ref="form"
          v-model="valid"
          @submit.prevent="onSubmit"
        >
          <v-container>
            <v-row>
              <v-col cols="12">
                <span class="text-subtitle-2"><v-icon color="green darken-2">{{icons.mdiInformation}}</v-icon> 수업 정보</span>
              </v-col>

              <!--과정(이름)-->
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-select
                  v-model="courseDataLocal.name"
                  :items="['초등과정', '중등과정', '고등과정']"
                  :prepend-icon="icons.mdiClipboardTextOutline"
                  :rules="[validators.required]"
                  label="과정"
                  dense
                ></v-select>
              </v-col>
              <!--선생님-->
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-select
                  v-model="courseDataLocal.teacher_id"
                  :items="teacherList"
                  :prepend-icon="icons.mdiClipboardAccount"
                  :rules="[validators.required]"
                  item-text="title"
                  item-value="value"
                  no-data-text="데이터가 없습니다."
                  label="선생님"
                  dense
                ></v-select>
              </v-col>

              <v-col
                cols="6"
              >
                <v-text-field
                  v-model="courseDataLocal.tuition"
                  label="수강료"
                  type="number"
                  :prepend-icon="icons.mdiCreditCardMarker"
                  :rules="[validators.required]"
                  :hint="hintTuition"
                  dense
                ></v-text-field>
              </v-col>
              <v-col
                cols="6"
              >
                <v-dialog
                  ref="paymentDayDialog"
                  v-model="modal3"
                  :return-value.sync="courseDataLocal.payment_day"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="courseDataLocal.payment_day"
                      label="수강결제일"
                      :prepend-icon="icons.mdiCalendarMultiselect"
                      readonly
                      v-bind="attrs"
                      dense
                      clearable
                      v-on="on"
                    ></v-text-field>
                  </template>

                  <v-date-picker
                    v-model="courseDataLocal.payment_day"
                    scrollable
                    locale="ko-KR"
                    color="primary"
                  >
                    <v-btn
                      text
                      color="primary"
                      @click="modal3 = false"
                    >
                      취소
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.paymentDayDialog.save(courseDataLocal.payment_day)"
                    >
                      선택
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>

              <!--시작일 종료일-->
              <v-col cols="6">
                <v-dialog
                  ref="startDayDialog"
                  v-model="modal"
                  :return-value.sync="courseDataLocal.start_day"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="courseDataLocal.start_day"
                      label="시작일"
                      :prepend-icon="icons.mdiCalendar"
                      :rules="[validators.required]"
                      readonly
                      dense
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>

                  <v-date-picker
                    v-model="courseDataLocal.start_day"
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
                      @click="$refs.startDayDialog.save(courseDataLocal.start_day)"
                    >
                      선택
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>
              <v-col cols="6">
                <v-dialog
                  ref="endDayDialog"
                  v-model="modal2"
                  :return-value.sync="courseDataLocal.end_day"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="courseDataLocal.end_day"
                      label="종료일"
                      :prepend-icon="icons.mdiCalendar"
                      :rules="[validators.required]"
                      readonly
                      dense
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>

                  <v-date-picker
                    v-model="courseDataLocal.end_day"
                    scrollable
                    locale="ko-KR"
                    color="primary"
                  >
                    <v-btn
                      text
                      color="primary"
                      @click="modal2 = false"
                    >
                      취소
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.endDayDialog.save(courseDataLocal.end_day)"
                    >
                      석택
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>

              <v-col cols="12">
                <span class="text-subtitle-2"><v-icon>{{icons.mdiCalendarClockOutline }}</v-icon> 수업 요일 시간</span>
              </v-col>
              <!--요일 시작/종료 시간1-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day1"
                  label="월"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time1"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day1?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time1"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day1?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간1-->

              <!--요일 시작/종료 시간2-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day2"
                  label="화"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time2"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day2?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time2"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day2?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간2-->

              <!--요일 시작/종료 시간3-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day3"
                  label="수"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time3"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day3?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time3"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day3?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간3-->

              <!--요일 시작/종료 시간4-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day4"
                  label="목"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time4"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day4?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time4"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day4?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간4-->

              <!--요일 시작/종료 시간5-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day5"
                  label="금"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time5"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day5?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time5"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day5?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간5-->

              <!--요일 시작/종료 시간6-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day6"
                  label="토"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time6"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day6?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time6"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day6?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간6-->

              <!--요일 시작/종료 시간7-->
              <v-col cols="2">
                <v-checkbox
                  v-model="courseDataLocal.day7"
                  label="일"
                ></v-checkbox>
              </v-col>
              <v-col cols="5">
                <v-autocomplete
                  v-model="courseDataLocal.start_time7"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockOutline"
                  :rules="courseDataLocal.day7?[validators.required]:[]"
                  label="시작시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="5"
              >
                <v-autocomplete
                  v-model="courseDataLocal.end_time7"
                  :items="timeList"
                  :prepend-icon="icons.mdiClockTimeSeven"
                  :rules="courseDataLocal.day7?[validators.required]:[]"
                  label="종료시간"
                  dense
                  hide-no-data
                ></v-autocomplete>
              </v-col>
              <!--//요일 시작/종료 시간7-->

            </v-row>
          </v-container>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="error"
          @click="$emit('update:is-course-add-dialog-visible',false)"
        >
          닫기
        </v-btn>
        <v-btn
          color="success"
          @click="onSubmit"
        >
          등록하기
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { ref,watch } from '@vue/composition-api'
import { required } from '@core/utils/validation'
import store from "@/store"
import {  mdiCalendarPlus,
          mdiCalendar,
          mdiClipboardTextOutline,
          mdiClipboardAccount,
          mdiClockOutline,
          mdiClockTimeSeven,
          mdiCalendarMultiselect,
          mdiCreditCardMarker,
          mdiInformation,
          mdiCalendarClockOutline ,
        } from '@mdi/js'

export default {
  props: {
    isCourseAddDialogVisible: {
      type: Boolean,
      required: true,
    },
    userData: {
      type: Object,
      required: true,
    }
  },
  setup(props,{emit}) {
    // const isDialogVisible = ref(false)
    const form = ref(null)
    const valid = ref(false)
    // const startDay = new Date().toISOString().substr(0, 10)
    // const endDay = new Date().toISOString().substr(0, 10)

    const courseDataLocal = ref({})
    const blankCourseData = {
      name:'',
      student_id: props.userData.id,
      teacher_id:'',
      branch_id:props.userData.branch_id,
      start_day:'',
      end_day:'',
      payment_day:'',
      tuition:'',
      day1:0,
      day2:0,
      day3:0,
      day4:0,
      day5:0,
      day6:0,
      day7:0,
      start_time1:null,
      end_time1:null,
      start_time2:null,
      end_time2:null,
      start_time3:null,
      end_time3:null,
      start_time4:null,
      end_time4:null,
      start_time5:null,
      end_time5:null,
      start_time6:null,
      end_time6:null,
      start_time7:null,
      end_time7:null,
      active:1,
      courriculum_id:0,
      type:'regular',
    }

    const teacherList = ref([])
    const modal = ref(false)
    const modal2 = ref(false)
    const modal3 = ref(false)
    const timeList = ref([])
    const tuitionList = ref([])
    const hintTuition = ref('')

    const setTimeList = () => {
      let arr = []
      let hour = "", min = ""
      for (let h = 0; h < 24; h++) {
        for (let m = 0; m < 60; m+=10) {
          hour = (h < 10)? "0"+h : h
          min = (m < 10)? "0"+m : m
          arr.push(`${hour}:${min}`)
        }
      }
      timeList.value = arr
    }

    const fetchTeachers = () => {
      //강사 아이디 6
      store.dispatch('app-user/getUsers',{
        role_id: 6,
        branch_id:props.userData.branch_id,
      }).then(rs => {
        // console.log('uca',rs)
        teacherList.value = rs.data.filteredData.map(item => {
          return {title:item.fullName, value:String(item.id)}
        })
        // console.log('rs',teacherList)
        // teacherList.value = rs.data
      }).catch(err => {
        console.log(err)
      })
    }

    const getTuitions = () => {
      //강사 아이디 6
      store.dispatch('app-user/getTuitions').then(rs => {
        tuitionList.value = rs.data.map(item => {
          return String(item.price)
        })
        let set = new Set(tuitionList.value)
        hintTuition.value = "추천:"+[...set].join()
      }).catch(err => {
        console.log(err)
      })
    }

    const validate = () => {
      form.value.validate()
    }

    const resetForm = () => {
      form.value.reset()
    }

    const resetCourseData = () => {
      courseDataLocal.value = JSON.parse(JSON.stringify(blankCourseData))
      resetForm()
      // emit('update:is-note-add-dialog-visible',false)
    }

    const unixTimestampConv = (date) =>
    {
        return Math.floor(new Date(date).getTime() / 1000)
    }

    
    const onSubmit = () => {
      if(valid.value){
        console.log('hi',courseDataLocal)
        // console.log('hi2',props.userData)
        // console.log('start_day',unixTimestampConv(courseDataLocal.value.start_day))
        // console.log('start_day',unixTimestampConv(courseDataLocal.value.end_day))
        // courseDataLocal.value.start_day = unixTimestampConv(courseDataLocal.value.startDay)
        // courseDataLocal.value.end_day = unixTimestampConv(courseDataLocal.value.endDay)
        let courseData = {
          ...courseDataLocal.value,
          start_day: unixTimestampConv(courseDataLocal.value.start_day),
          end_day: unixTimestampConv(courseDataLocal.value.end_day),
          payment_day: unixTimestampConv(courseDataLocal.value.payment_day),
        }
        store.dispatch(`app-user/addCourse`,{
          ...courseData
        })
        .then(rs=>{
          console.log(rs)
          resetCourseData()
          emit('refetch-data')
          emit('update:is-course-add-dialog-visible',false)
        }).catch(err => {
          console.log(err)
        })
        // emit('update:is-course-add-dialog-visible',false)
      } else {
        validate()
      }
    }

    watch(
      () => props.isCourseAddDialogVisible,
      () => {
        courseDataLocal.value = JSON.parse(JSON.stringify(blankCourseData))
        // console.log(props.courseData)
        // resetForm()
      },
    )
    
    setTimeList()
    getTuitions()
    fetchTeachers()

    return {
      form,
      valid,
      courseDataLocal,
      modal,
      modal2,
      modal3,
      teacherList,
      tuitionList,
      hintTuition,
      timeList,
      validators: { required },
      onSubmit,

      // icons
      icons: {
        mdiCalendarPlus,
        mdiCalendar,
        mdiClipboardAccount,
        mdiClipboardTextOutline,
        mdiClockOutline,
        mdiClockTimeSeven,
        mdiCalendarMultiselect,
        mdiCreditCardMarker,
        mdiInformation,
        mdiCalendarClockOutline ,
      },
    }
  },
}
</script>
