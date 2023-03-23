<template>
  <div class="user-tab-security">
    <!-- change password -->
    <v-card class="mb-7">
      <v-card-title>비밀번호 변경</v-card-title>

      <v-card-text>
        <v-alert color="warning" text>
          <p class="font-weight-semibold mb-1">비밀번호 규칙</p>
          <p class="text-sm mb-0">최소 8자 길이, 대문자 및 기호</p>
        </v-alert>

        <!-- form -->
        <v-form 
            ref="form"
            v-model="valid"
            @submit.prevent="onSubmit"
            class="multi-col-validation"
        >
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="newPassword"
                :rules="[validators.required]"
                outlined
                dense
                label="새로운 비밀 번호"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-icon="isPasswordVisible ? icons.mdiEyeOutline : icons.mdiEyeOffOutline"
                @click:append="isPasswordVisible = !isPasswordVisible"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                v-model="confirmPassword"
                :rules="[
                  validators.required,
                  validators.confirmedValidator(newPassword,confirmPassword)
                  ]"
                outlined
                dense
                label="새로운 비밀 번호 체크"
                :type="isPasswordConfirmVisible ? 'text' : 'password'"
                :append-icon="isPasswordConfirmVisible ? icons.mdiEyeOutline : icons.mdiEyeOffOutline"
                @click:append="isPasswordConfirmVisible = !isPasswordConfirmVisible"
              ></v-text-field>
            </v-col>

            <v-col cols="12">
              <v-btn color="primary" @click="onSubmit"> 비밀번호 변경하기 </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiSquareEditOutline, mdiDeleteOutline, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import store from '@/store'
import { required,confirmedValidator } from '@core/utils/validation'

export default {
  props:{
    userData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const istwoFactorDialogOpen = ref(false)
    const newPassword = ref('')
    const confirmPassword = ref('')
    const smsVerificationNumber = ref('+1(968) 819-2547')
    const isPasswordVisible = ref(false)
    const isPasswordConfirmVisible = ref(false)
    const form = ref(null)
    const valid = ref(false)

    const tableColumnHeaders = [
      { text: 'BROWSER', value: 'browser', sortable: false },
      { text: 'DEVICE', value: 'device', sortable: false },
      { text: 'LOCATION', value: 'location', sortable: false },
      { text: 'RECENT ACTIVITY', value: 'recentActivity', sortable: false },
    ]

    const recenntDevices = [
      {
        browser: 'chrome.png',
        name: 'Chrome on Windows',
        device: 'Dell XPS 15',
        location: 'United States',
        recentActivity: '10, Jan 2020 20:07',
      },
      {
        browser: 'chrome.png',
        name: 'Chrome on Android',
        device: 'Google Pixel 3a',
        location: 'Ghana',
        recentActivity: '11, Jan 2020 10:16',
      },
      {
        browser: 'chrome.png',
        name: 'Chrome on MacOS',
        device: 'Apple iMac',
        location: 'Mayotte',
        recentActivity: '11, Jan 2020 12:10',
      },
      {
        browser: 'chrome.png',
        name: 'Chrome on IPhone',
        device: 'Apple iPhone XR',
        location: 'Mauritania',
        recentActivity: '12, Jan 2020 8:29',
      },
    ]

    const resetPassword = () => {
      store.dispatch('app-user/resetPassword',{
        id: props.userData.id,
        new_password: newPassword.value
        })
        .then(rs => {
          console.log(rs)
          resetForm()
        }).catch(err => {
          console.log(err)
        })
    }

    const onSubmit = () => {
      if(valid.value){
        resetPassword()
      }else {
        validate()
      }
    }
    const validate = () => {
      form.value.validate()
    }

    const resetForm = () => {
      form.value.reset()
    }

    return {
      form,
      valid,
      onSubmit,
      tableColumnHeaders,
      recenntDevices,
      istwoFactorDialogOpen,
      newPassword,
      confirmPassword,
      smsVerificationNumber,
      isPasswordVisible,
      isPasswordConfirmVisible,
      icons: {
        mdiSquareEditOutline,
        mdiDeleteOutline,
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
      validators: {
        required,
        confirmedValidator
      },
    }
  },
}
</script>
