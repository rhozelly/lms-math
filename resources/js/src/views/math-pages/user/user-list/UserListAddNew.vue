<template>
  <v-dialog v-model="isAddNewUserSidebarActive" persistent max-width="650px">
    <v-card class="user-edit-info pa-sm-10 pa-3">
      <v-card-title class="justify-center text-h5">
        사용자 등록 양식 <!-- User Registration Information -->
      </v-card-title>
      <v-form ref="form" v-model="valid" @submit.prevent="onSubmit">
        <v-col cols="12"> 기본 정보 <!-- Basic Information --></v-col>
        <v-text-field v-model="userData.name" :rules="[validators.required]" outlined dense label="이름" placeholder="홍길동"
          hide-details="auto" class="mb-6"></v-text-field>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.birth" :rules="[validators.required, v => !isNaN(v) || '숫자만 가능합니다.']" outlined
              dense label="생일" maxlength="8" placeholder="YYYYMMDD" hide-details="auto" type="number"
              class="mb-6"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-select v-model="userData.sex" :rules="[validators.required]" label="성별"
              :items="[{ title: '남자', value: 'M' }, { title: '여자', value: 'W' }]" item-text="title" item-value="value"
              outlined dense hide-details="auto" class="mb-6"></v-select>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="6">
            <v-select v-model="userData.role_id" :rules="[validators.required]" label="역할" :items="roleOptions"
              item-text="title" item-value="value" outlined dense hide-details="auto" class="mb-6">
            </v-select>
          </v-col>
          <v-col cols="12" sm="6">
            <v-select v-model="userData.branch_id" :rules="[validators.required]" label="지점관" :items="branchOptions"
              item-text="title" item-value="value" outlined dense hide-details="auto" class="mb-6">
            </v-select>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="6">
            <!-- <v-date-picker v-model="userData.payment_day" scrollable locale="ko-KR" color="primary">
              <v-btn text color="primary" @click="modal2 = false">
                취소
              </v-btn>
              <v-btn text color="primary" @click="$refs.paymentDialog.save(userData.payment_day)">
                석택
              </v-btn>
            </v-date-picker> -->
            <!-- <v-dialog ref="paymentDialog" v-model="modal2" :return-value.sync="userData.payment_day" persistent
              width="290px">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field v-model="userData.payment_day" label="결제일" :rules="[validators.required]" readonly outlined
                  dense placeholder="" hide-details="auto" class="mb-6" v-bind="attrs" v-on="on"></v-text-field>
              </template>

            </v-dialog> -->
          </v-col>
        </v-row>


        <v-col cols="12"> 연락처 및 학부모 정보 <!-- Contact & Parent Information --></v-col>

        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.email" :rules="[validators.required, validators.emailValidator]" outlined
              dense type="email" label="이메일" placeholder="Email@jkl.com" hide-details="auto" class="mb-6"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.phone" :rules="[validators.required]" outlined dense label="전화번호"
              placeholder="010-0000-0000" hide-details="auto" maxlength="13" class="mb-6"></v-text-field>
          </v-col>
        </v-row>

        <v-col cols="12">학부모 정보 <!-- Parent's Information --></v-col>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.parent_name" :rules="[validators.required]" outlined dense label="부모님 성함"
              placeholder="부모님" hide-details="auto" class="mb-6"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.parent_phone" :rules="[validators.required]" outlined dense label="부모님 연락처"
              placeholder="010-0000-0000" hide-details="auto" maxlength="13" class="mb-6"></v-text-field>
          </v-col>
        </v-row>

        <v-col cols="12"> 기타 정보<!-- Other Information --></v-col>
        <v-select v-model="userData.grade_id" :rules="[validators.required]" label="학년" :items="gradeOptions"
          item-text="title" item-value="value" outlined dense hide-details="auto" class="mb-6">
        </v-select>

        <v-text-field v-model="userData.address" :rules="[]" outlined dense label="주소" placeholder="" hide-details="auto"
          class="mb-6"></v-text-field>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.inflow_path" :rules="[]" outlined dense label="유입경로" placeholder=""
              hide-details="auto" class="mb-6"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field v-model="userData.school_name" :rules="[]" outlined dense label="학교이름" placeholder=""
              hide-details="auto" class="mb-6"></v-text-field>
          </v-col>
        </v-row>


        <v-col cols="12">신임장<!-- Credentials --></v-col>
        <v-text-field v-model="userData.username" outlined dense :rules="[validators.required]" label="아이디"
          placeholder="jklmath" hide-details="auto" class="mb-6"></v-text-field>

        <v-text-field v-model="userData.password" :rules="[validators.required]"
          :append-icon="showPassword ? icons.mdiEye : icons.mdiEyeOff" :type="showPassword ? 'text' : 'password'" outlined
          dense label="비밀번호" placeholder="" hide-details="auto" class="mb-6"
          @click:append="showPassword = !showPassword"></v-text-field>

        <v-text-field v-model="userData.password_confirmation" :rules="[validators.required, validators.confirmedValidator(userData.password, userData.password_confirmation)
        ]" :append-icon="showPassword2 ? icons.mdiEye : icons.mdiEyeOff" :type="showPassword2 ? 'text' : 'password'"
          outlined dense label="비밀번호 확인" placeholder="" hide-details="auto" class="mb-6"
          @click:append="showPassword2 = !showPassword2"></v-text-field>

      </v-form>

      <v-col cols="12" class="d-flex justify-end mt-3">
        <v-btn color="secondary" class="mr-3" outlined type="reset" @click="resetuserData"> 취소 </v-btn>
        <v-btn color="primary" class="me-3" type="submit"> 등록 </v-btn>
      </v-col>

    </v-card>
  </v-dialog>

  <!-- <v-navigation-drawer
    :value="isAddNewUserSidebarActive"
    temporary
    touchless
    :right="!$vuetify.rtl"
    :width="$vuetify.breakpoint.smAndUp ? 350 : '100%'"
    app
    @input="(val) => $emit('update:is-add-new-user-sidebar-active', val)"
  >
    <v-card height="100%">
      <div class="drawer-header d-flex align-center mb-4">
        <span class="font-weight-semibold text-base text--primary">사용자 추가</span> sample here
        <v-spacer></v-spacer>
        <v-btn
          icon
          small
          @click="$emit('update:is-add-new-user-sidebar-active',false)"
        >
          <v-icon size="22">
            {{ icons.mdiClose }}
          </v-icon>
        </v-btn>
      </div>

      <v-card-text>
        <v-form
          ref="form"
          v-model="valid"
          @submit.prevent="onSubmit"
        >
          <v-text-field
            v-model="userData.username"
            outlined
            dense
            :rules="[validators.required]"
            label="아이디"
            placeholder="jklmath"
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.name"
            :rules="[validators.required]"
            outlined
            dense
            label="이름"
            placeholder="홍길동"
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.email"
            :rules="[validators.required,validators.emailValidator]"
            outlined
            dense
            type="email"
            label="이메일"
            placeholder="Email@jkl.com"
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.password"
            :rules="[validators.required]"
            :append-icon="showPassword ? icons.mdiEye : icons.mdiEyeOff"
            :type="showPassword ? 'text' : 'password'"
            outlined
            dense
            label="비밀번호"
            placeholder=""
            hide-details="auto"
            class="mb-6"
            @click:append="showPassword = !showPassword"
          ></v-text-field>

          <v-text-field
            v-model="userData.password_confirmation"
            :rules="[
              validators.required,
              validators.confirmedValidator(userData.password,userData.password_confirmation)
              ]"
            :append-icon="showPassword2 ? icons.mdiEye : icons.mdiEyeOff"
            :type="showPassword2 ? 'text' : 'password'"
            outlined
            dense
            label="비밀번호 확인"
            placeholder=""
            hide-details="auto"
            class="mb-6"
            @click:append="showPassword2 = !showPassword2"
          ></v-text-field>

          <v-text-field
            v-model="userData.phone"
            :rules="[validators.required]"
            outlined
            dense
            label="전화번호"
            placeholder="010-0000-0000"
            hide-details="auto"
            maxlength="13"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.birth"
            :rules="[validators.required, v => !isNaN(v) || '숫자만 가능합니다.']"
            outlined
            dense
            label="생일"
            maxlength="8"
            placeholder="YYYYMMDD"
            hide-details="auto"
            type="number"
            class="mb-6"
          ></v-text-field>

          <v-select
            v-model="userData.sex"
            :rules="[validators.required]"
            label="성별"
            :items="[{title:'남자',value:'M'},{title:'여자',value:'W'}]"
            item-text="title"
            item-value="value"
            outlined
            dense
            hide-details="auto"
            class="mb-6"
          ></v-select>

          <v-text-field
            v-model="userData.parent_name"
            :rules="[validators.required]"
            outlined
            dense
            label="부모님 성함"
            placeholder="부모님"
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.parent_phone"
            :rules="[validators.required]"
            outlined
            dense
            label="부모님 연락처"
            placeholder="010-0000-0000"
            hide-details="auto"
            maxlength="13"
            class="mb-6"
          ></v-text-field>

          <v-select
            v-model="userData.branch_id"
            :rules="[validators.required]"
            label="지점관"
            :items="branchOptions"
            item-text="title"
            item-value="value"
            outlined
            dense
            hide-details="auto"
            class="mb-6"
          >
          </v-select>

          <v-select
            v-model="userData.role_id"
            :rules="[validators.required]"
            label="역할"
            :items="roleOptions"
            item-text="title"
            item-value="value"
            outlined
            dense
            hide-details="auto"
            class="mb-6"
          >
          </v-select>

          <v-select
            v-model="userData.grade_id"
            :rules="[validators.required]"
            label="학년"
            :items="gradeOptions"
            item-text="title"
            item-value="value"
            outlined
            dense
            hide-details="auto"
            class="mb-6"
          >
          </v-select>

          <v-text-field
            v-model="userData.address"
            :rules="[]"
            outlined
            dense
            label="주소"
            placeholder=""
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.inflow_path"
            :rules="[]"
            outlined
            dense
            label="유입경로"
            placeholder=""
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.school_name"
            :rules="[]"
            outlined
            dense
            label="학교이름"
            placeholder=""
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-text-field
            v-model="userData.etc"
            :rules="[]"
            outlined
            dense
            label="특이사항"
            placeholder=""
            hide-details="auto"
            class="mb-6"
          ></v-text-field>

          <v-dialog
            ref="firstDayDialog"
            v-model="modal1"
            :return-value.sync="userData.first_day"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="userData.first_day"
                label="첫등원일"
                :rules="[validators.required]"
                readonly
                outlined
                dense 
                placeholder=""
                hide-details="auto"
                class="mb-6"
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>

            <v-date-picker
              v-model="userData.first_day"
              scrollable
              locale="ko-KR"
              color="primary"
            >
              <v-btn
                text
                color="primary"
                @click="modal1 = false"
              >
                취소
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="$refs.firstDayDialog.save(userData.first_day)"
              >
                석택
              </v-btn>
            </v-date-picker>
          </v-dialog>

          <v-dialog
            ref="paymentDialog"
            v-model="modal2"
            :return-value.sync="userData.payment_day"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="userData.payment_day"
                label="결제일"
                :rules="[validators.required]"
                readonly
                outlined
                dense 
                placeholder=""
                hide-details="auto"
                class="mb-6"
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>

            <v-date-picker
              v-model="userData.payment_day"
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
                @click="$refs.paymentDialog.save(userData.payment_day)"
              >
                석택
              </v-btn>
            </v-date-picker>
          </v-dialog>

          <v-btn
            color="primary"
            class="me-3"
            type="submit"
          >
            등록
          </v-btn>
          <v-btn
            color="secondary"
            outlined
            type="reset"
            @click="resetuserData"
          >
            취소
          </v-btn>
          <v-btn
            color="error"
            outlined
            type="reset"
            @click="logOut"
          >
            logOut
          </v-btn>
          <v-btn
            color="error"
            outlined
            type="reset"
            @click="getUser"
          >
            Test
          </v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-navigation-drawer> -->
</template>

<script>
import { mdiClose, mdiEye, mdiEyeOff } from '@mdi/js'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'
import { ref, watch } from '@vue/composition-api'
import { required, emailValidator, confirmedValidator } from '@core/utils/validation'
import axios from 'axios'

export default {
  model: {
    prop: 'isAddNewUserSidebarActive',
    event: 'update:is-add-new-user-sidebar-active',
  },
  props: {
    isAddNewUserSidebarActive: {
      type: Boolean,
      required: true,
    },
    roleOptions: {
      type: Array,
      required: true,
    },
    branchOptions: {
      type: Array,
      required: true,
    },
    gradeOptions: {
      type: Array,
      required: true,
    },
  },
  setup(props, { emit }) {

    const blankUserData = {
      // username: '',
      // name: '',
      // email: '',
      // password: '',
      // password_confirmation: '',
      // phone: '',
      // branch_id: '',
      // role_id: '',
      // grade_id: '',

      // birth: '',
      // sex: '',
      // parent_name: '',
      // parent_phone: '',
      // address: '',
      // inflow_path: '',
      // etc: '',

      username: 'kokokoko2',
      name: '이강준',
      email: 'gmail@gamil.com',
      password: '123123123',
      password_confirmation: '123123123',
      phone: '010-4403-3900',
      branch_id: '0',
      role_id: '1',
      grade_id: '0',
      school_name: '권선중학교',
      first_day: '2022-08-17',
      payment_day: '2022-08-17',

      birth: '19920915',
      sex: 'm',
      parent_name: '이기식',
      parent_phone: '010-4403-3900',
      address: '경기도수원시',
      inflow_path: '검색',
      etc: '몰라',

    }

    const valid = ref(false)
    const form = ref(null)
    const showPassword = ref(false)
    const showPassword2 = ref(false)
    const modal1 = ref(false)
    const modal2 = ref(false)

    const validate = () => {
      form.value.validate()
    }

    const resetForm = () => {
      form.value.reset()
    }

    const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
    const resetuserData = () => {
      userData.value = JSON.parse(JSON.stringify(blankUserData))
      resetForm()
      emit('update:is-add-new-user-sidebar-active', false)
    }

    const unixTimestampConv = (date) => {
      return Math.floor(new Date(date).getTime() / 1000)
    }

    const onSubmit = () => {
      if (valid.value) {
        store.dispatch('app-user/registerUser', {
          ...userData.value,
          first_day: unixTimestampConv(userData.value.first_day),
          payment_day: unixTimestampConv(userData.value.payment_day),
        }).then((rs) => {
          console.log(rs.code);
          console.log(rs);
          console.log(rs.message);
          emit('refetch-data')
          emit('update:is-add-new-user-sidebar-active', false)
        }).catch(err => {
          console.log('err', err.response.status);
          emit('err-msg', { msg: 'test 입니다.' });

        })

        // store.dispatch('app-user/addUser', userData.value).then(() => {
        //   emit('refetch-data')
        //   emit('update:is-add-new-user-sidebar-active', false)
        // })

        // resetuserData()
      } else {
        validate()
      }
    }

    const logOut = () => {
      store.dispatch('app-user/logoutUser', {}).then((rs) => {
        console.log(rs);
        emit('refetch-data')
        emit('update:is-add-new-user-sidebar-active', false)
      })
    }

    watch(() => userData.value.phone, (newValue) => {
      userData.value.phone = phoneFomatter(newValue)
    })

    watch(() => userData.value.parent_phone, (newValue) => {
      userData.value.parent_phone = phoneFomatter(newValue)
    })

    const phoneFomatter = (num) => {
      if (num == null) return num
      var formatNum = "";
      num = num.replace(/[^0-9]/g, '')
      if (num.length == 11) {
        formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, "$1-$2-$3");
      } else if (num.length == 8) {
        formatNum = num.replace(/(\d{4})(\d{4})/, "$1-$2");
      } else {
        if (num.indexOf("02") == 0) {
          formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, "$1-$2-$3");
        } else {
          formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
        }
      }
      return formatNum;
    }

    const getUser = () => {
      axios.get('/api/user').then(res => { console.log(res) }).catch(err => { console.log(err) })
    }


    return {
      getUser,
      logOut,
      resetuserData,
      form,
      onSubmit,
      countries,
      userData,
      valid,
      validate,
      showPassword,
      showPassword2,
      modal1,
      modal2,

      // validation
      validators: { required, emailValidator, confirmedValidator },
      icons: {
        mdiClose,
        mdiEye,
        mdiEyeOff,
      },
    }
  },
}
</script>
