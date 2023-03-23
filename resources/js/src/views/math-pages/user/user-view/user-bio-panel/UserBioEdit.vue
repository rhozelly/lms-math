<template>
  <!-- edit profile dialog -->
  <v-dialog v-model="isBioDialogOpen" persistent max-width="650px">
    <v-card class="user-edit-info pa-sm-10 pa-3">
      <v-card-title class="justify-center text-h5">
        사용자 정보 수정
      </v-card-title>
      <v-card-text class="text-center mt-n2">
        {{ userData.fullName }}({{ userData.username }})
      </v-card-text>

      <div>
          <v-form class="multi-col-validation" ref="form" v-model="valid" @submit.prevent="onSubmit">
        <v-expansion-panels accordion>
            <v-expansion-panel>
              <v-expansion-panel-header>
                기본 정보 <!-- Basic Information -->
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-card-text class="mt-10">
                <v-row>
                  <v-col cols="12" sm="6">
                    <v-text-field v-model="userDataLocal.username" :rules="[validators.required]" outlined dense
                      label="아이디"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field v-model="userDataLocal.fullName" :rules="[validators.required]" outlined dense
                      label="이름"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6">
                    <v-text-field v-model="userDataLocal.birth"
                      :rules="[validators.required, v => !isNaN(v) || '숫자만 가능합니다.']" outlined dense label="생일" maxlength="8"
                      placeholder="YYYYMMDD"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6">
                    <v-select v-model="userDataLocal.sex" :rules="[v => !!v || '필수 입력값 입니다.']" :items="sexOptions"
                      item-text="title" item-value="value" outlined dense label="성별"></v-select>
                  </v-col>

                  <v-col cols="12" sm="6">
                    <v-select v-model="userDataLocal.role_id" :rules="[v => !!v || '필수 입력값 입니다.']" :items="roleOptions"
                      item-text="title" item-value="value" outlined dense label="역할"></v-select>
                  </v-col>

                  <v-col cols="12" sm="6">
                    <v-select v-model="userDataLocal.branch_id" :rules="[v => !!v || '필수 입력값 입니다.']" :items="branchOptions"
                      item-text="title" item-value="value" outlined dense label="지점관"></v-select>
                  </v-col>

                  <v-col cols="12" sm="6">
                    <v-dialog ref="paymentDialog" v-model="modal2" :return-value.sync="userDataLocal.payment_day" persistent
                      width="290px">
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field v-model="userDataLocal.payment_day" label="결제일" :rules="[validators.required]"
                          readonly outlined dense placeholder="" hide-details="auto" class="mb-6" v-bind="attrs"
                          v-on="on"></v-text-field>
                      </template>

                      <v-date-picker v-model="userDataLocal.payment_day" scrollable locale="ko-KR" color="primary">
                        <v-btn text color="primary" @click="modal2 = false">
                          취소
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.paymentDialog.save(userDataLocal.payment_day)">
                          석택
                        </v-btn>
                      </v-date-picker>
                    </v-dialog>
                  </v-col>

                  <v-col cols="12">
                    <v-switch v-model="userDataLocal.status" class="mt-0" hide-details>
                      <template #label>
                        <span class="font-weight-medium text--primary">사용자 활성화</span>
                      </template>
                    </v-switch>
                  </v-col>
                </v-row>
              </v-card-text>
              </v-expansion-panel-content>
            </v-expansion-panel>

            <v-expansion-panel>
              <v-expansion-panel-header>              
                연락처 및 학부모 정보 <!-- Contact & Parent Information -->
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-card-text class="mt-10">
                  <v-col cols="12"> Contact Information</v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field v-model="userDataLocal.email" :rules="[validators.required]" outlined dense
                      label="이메일"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field v-model="userDataLocal.phone" :rules="[validators.required]" maxlength="13" outlined dense
                      label="전화번호"></v-text-field>
                  </v-col>
                  <v-col cols="12"> Parent Information</v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field v-model="userDataLocal.parent_name" outlined dense label="부모님 성함"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field v-model="userDataLocal.parent_phone" maxlength="13" outlined dense
                      label="부모님 연락처"></v-text-field>
                  </v-col>
              </v-card-text>
              </v-expansion-panel-content>
            </v-expansion-panel>

            <v-expansion-panel>
              <v-expansion-panel-header>
                기타 정보<!-- Other Information -->
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-card-text class="mt-10">
                <v-col cols="12" sm="12">
                  <v-select v-model="userDataLocal.grade_id" :items="gradeOptions" item-text="title" item-value="value"
                    outlined dense label="학년"></v-select>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field v-model="userDataLocal.address" outlined dense label="주소"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field v-model="userDataLocal.inflow_path" outlined dense label="유입경로"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field v-model="userDataLocal.etc" outlined dense label="특이사항"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-dialog ref="firstDayDialog" v-model="modal1" :return-value.sync="userDataLocal.first_day" persistent
                    width="290px">
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field v-model="userDataLocal.first_day" label="첫등원일" :rules="[validators.required]" readonly
                        outlined dense placeholder="" hide-details="auto" class="mb-6" v-bind="attrs"
                        v-on="on"></v-text-field>
                    </template>

                    <v-date-picker v-model="userDataLocal.first_day" scrollable locale="ko-KR" color="primary">
                      <v-btn text color="primary" @click="modal1 = false">
                        취소
                      </v-btn>
                      <v-btn text color="primary" @click="$refs.firstDayDialog.save(userDataLocal.first_day)">
                        석택
                      </v-btn>
                    </v-date-picker>
                  </v-dialog>
                </v-col>
              </v-card-text>
              </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
          </v-form>
        <v-col cols="12" class="d-flex justify-end mt-3">
            <v-btn color="primary" class="me-3" type="submit" @click.prevent="onSubmit">
              수정하기
            </v-btn>
            <v-btn outlined color="secondary" @click.prevent="$emit('update:is-bio-dialog-open', false)">
              닫기
            </v-btn>
          </v-col>
      </div>



      <!-- .tabs -->
      <!-- <v-tabs v-model="currentTab">
        <v-tab>Basic Information</v-tab>
        <v-tab>Contact & Parent Information</v-tab>
        <v-tab>Other Information</v-tab>
        <v-tab>Payment Method</v-tab>
      </v-tabs>

      <v-tabs-items v-model="currentTab">
        <v-form class="multi-col-validation" ref="form" v-model="valid" @submit.prevent="onSubmit">
          <v-tab-item :key="1">
            <v-card-text class="mt-10">
              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field v-model="userDataLocal.username" :rules="[validators.required]" outlined dense
                    label="아이디"></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field v-model="userDataLocal.fullName" :rules="[validators.required]" outlined dense
                    label="이름"></v-text-field>
                </v-col>

                <v-col cols="12" sm="6">
                  <v-text-field v-model="userDataLocal.birth"
                    :rules="[validators.required, v => !isNaN(v) || '숫자만 가능합니다.']" outlined dense label="생일" maxlength="8"
                    placeholder="YYYYMMDD"></v-text-field>
                </v-col>

                <v-col cols="12" sm="6">
                  <v-select v-model="userDataLocal.sex" :rules="[v => !!v || '필수 입력값 입니다.']" :items="sexOptions"
                    item-text="title" item-value="value" outlined dense label="성별"></v-select>
                </v-col>

                <v-col cols="12" sm="6">
                  <v-select v-model="userDataLocal.role_id" :rules="[v => !!v || '필수 입력값 입니다.']" :items="roleOptions"
                    item-text="title" item-value="value" outlined dense label="역할"></v-select>
                </v-col>

                <v-col cols="12" sm="6">
                  <v-select v-model="userDataLocal.branch_id" :rules="[v => !!v || '필수 입력값 입니다.']" :items="branchOptions"
                    item-text="title" item-value="value" outlined dense label="지점관"></v-select>
                </v-col>

                <v-col cols="12" sm="6">
                  <v-dialog ref="paymentDialog" v-model="modal2" :return-value.sync="userDataLocal.payment_day" persistent
                    width="290px">
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field v-model="userDataLocal.payment_day" label="결제일" :rules="[validators.required]"
                        readonly outlined dense placeholder="" hide-details="auto" class="mb-6" v-bind="attrs"
                        v-on="on"></v-text-field>
                    </template>

                    <v-date-picker v-model="userDataLocal.payment_day" scrollable locale="ko-KR" color="primary">
                      <v-btn text color="primary" @click="modal2 = false">
                        취소
                      </v-btn>
                      <v-btn text color="primary" @click="$refs.paymentDialog.save(userDataLocal.payment_day)">
                        석택
                      </v-btn>
                    </v-date-picker>
                  </v-dialog>
                </v-col>

                <v-col cols="12">
                  <v-switch v-model="userDataLocal.status" class="mt-0" hide-details>
                    <template #label>
                      <span class="font-weight-medium text--primary">사용자 활성화</span>
                    </template>
                  </v-switch>
                </v-col>
              </v-row>
            </v-card-text>
          </v-tab-item>
          <v-tab-item :key="2">
            <v-card-text class="mt-10">
              <v-col cols="12"> Contact Information</v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="userDataLocal.email" :rules="[validators.required]" outlined dense
                  label="이메일"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="userDataLocal.phone" :rules="[validators.required]" maxlength="13" outlined dense
                  label="전화번호"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-col cols="12"> Parent Information</v-col>
                <v-col cols="12" sm="12">
                  <v-text-field v-model="userDataLocal.parent_name" outlined dense label="부모님 성함"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field v-model="userDataLocal.parent_phone" maxlength="13" outlined dense
                    label="부모님 연락처"></v-text-field>
                </v-col>
              </v-col>
            </v-card-text>
          </v-tab-item>
          <v-tab-item :key="3">
            <v-card-text class="mt-10">
              <v-col cols="12"> Other Information</v-col>
              <v-col cols="12" sm="12">
                <v-select v-model="userDataLocal.grade_id" :items="gradeOptions" item-text="title" item-value="value"
                  outlined dense label="학년"></v-select>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="userDataLocal.address" outlined dense label="주소"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="userDataLocal.inflow_path" outlined dense label="유입경로"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="userDataLocal.etc" outlined dense label="특이사항"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-dialog ref="firstDayDialog" v-model="modal1" :return-value.sync="userDataLocal.first_day" persistent
                  width="290px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="userDataLocal.first_day" label="첫등원일" :rules="[validators.required]" readonly
                      outlined dense placeholder="" hide-details="auto" class="mb-6" v-bind="attrs"
                      v-on="on"></v-text-field>
                  </template>

                  <v-date-picker v-model="userDataLocal.first_day" scrollable locale="ko-KR" color="primary">
                    <v-btn text color="primary" @click="modal1 = false">
                      취소
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.firstDayDialog.save(userDataLocal.first_day)">
                      석택
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>
            </v-card-text>
          </v-tab-item>
          <v-tab-item :key="4">
            <v-card-text class="mt-10">
              <v-row>
                <v-col md="12" cols="12">
                  <v-form>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field label="Card Number" outlined dense hide-details> </v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field label="Name" outlined dense hide-details></v-text-field>
                      </v-col>
                      <v-col cols="6" md="3">
                        <v-text-field label="Expiry Date" dense outlined hide-details></v-text-field>
                      </v-col>
                      <v-col cols="6" md="3">
                        <v-text-field label="CVV Code" outlined dense hide-details></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-col>
              </v-row>
              <v-divider class="my-5"></v-divider>
              <v-row>
                <v-col cols="12">
                  <v-btn color="primary" class="me-5"> Place Order </v-btn>
                  <v-btn outlined color="secondary"> Cancel </v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-tab-item>
          <v-col cols="12" class="d-flex justify-end mt-3">
            <v-btn color="primary" class="me-3" type="submit" @click.prevent="onSubmit">
              수정하기
            </v-btn>
            <v-btn outlined color="secondary" @click.prevent="$emit('update:is-bio-dialog-open', false)">
              닫기
            </v-btn>
          </v-col>
        </v-form>
      </v-tabs-items> -->

      <!-- .tabs -->
    </v-card>
  </v-dialog>
</template>

<script>
import { ref, watch } from '@vue/composition-api'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'
import { required, emailValidator, confirmedValidator } from '@core/utils/validation'

export default {
  props: {
    isBioDialogOpen: {
      type: Boolean,
      required: true,
    },
    userData: {
      type: Object,
      required: true,
    },
  },

  setup(props, { emit }) {
    const isBillingAddress = ref(true)
    const modal1 = ref(false)
    const modal2 = ref(false)
    const currentTab = ref(0)
    const tabItemContent = `
    Candy canes donut chupa chups candy canes lemon drops oat cake wafer. Cotton candy candy canes marzipan carrot cake. Sesame snaps lemon drops candy marzipan donut brownie tootsie roll. Icing croissant bonbon biscuit gummi bears. Pudding candy canes sugar plum cookie chocolate cake powder croissant.
    `

    const userDataLocal = ref({})
    userDataLocal.value = JSON.parse(JSON.stringify(props.userData))
    console.log(JSON.parse(JSON.stringify(props.userData)))

    const sexOptions = [
      { title: '남성', value: 'm' },
      { title: '여성', value: 'f' },
    ]

    const unixTimestampConv = (date) => {
      return Math.floor(new Date(date).getTime() / 1000)
    }

    const isJson = (v) => (typeof v === 'object')

    // on form submit
    const onSubmit = () => {
      if (valid.value) {
        store.dispatch('app-user/editUser', {
          id: userDataLocal.value.id,
          username: userDataLocal.value.username,
          name: userDataLocal.value.fullName,
          email: userDataLocal.value.email,
          phone: userDataLocal.value.phone,
          birth: userDataLocal.value.birth,
          sex: userDataLocal.value.sex,
          branch_id: userDataLocal.value.branch_id,
          role_id: userDataLocal.value.role_id,
          activity: userDataLocal.value.status,
          grade_id: userDataLocal.value.grade_id,
          school_name: userDataLocal.value.school_name,
          first_day: unixTimestampConv(userDataLocal.value.first_day),
          payment_day: unixTimestampConv(userDataLocal.value.payment_day),
          parent_name: userDataLocal.value.parent_name,
          parent_phone: userDataLocal.value.parent_phone,
          address: userDataLocal.value.address,
          inflow_path: userDataLocal.value.inflow_path,
          etc: userDataLocal.value.etc,
        }).then((rs) => {
          console.log(rs.code);
          console.log(rs);
          console.log(rs.message);
          emit('update:is-bio-dialog-open', false)
        }).catch(err => {
          console.log('err', err);
          console.log('err', err.response.status);
          console.log('err', err.response);
          // emit('err-msg',{msg:'test 입니다.'});
        }).then(() => {
          let users = store.getters['app-user/getSelectedUsers']
          let userData = ''
          let existingIndex = users.findIndex(user => user.id == userDataLocal.value.id)
          console.log('test', users, existingIndex)
          store.dispatch('app-user/getUser', { id: userDataLocal.value.id })
            .then(response => {
              userData = response.data
              store.commit('app-user/updateUser', { userData, index: existingIndex })
            })
            .catch(error => {
              if (error.response.status === 404) {
                userData = {}
                store.commit('app-user/updateUser', { userData, index: existingIndex })
              }
            })
        })
        // emit('update:is-bio-dialog-open', false)
      } else {
        validate()
      }
    }
    const form = ref(null)
    const valid = ref(false)
    const roleOptions = ref([])
    const branchOptions = ref([])
    const gradeOptions = ref([])

    const validate = () => {
      form.value.validate()
    }

    store
      .dispatch('app-user/getRoles')
      .then(response => {
        roleOptions.value = response.data
      })
      .catch(error => {
        console.log('error :>> ', error)
      })

    store
      .dispatch('app-user/getBranches')
      .then(response => {
        branchOptions.value = response.data
      })
      .catch(error => {
        console.log('error :>> ', error)
      })

    store
      .dispatch('app-user/getGrades')
      .then(response => {
        gradeOptions.value = [
          { title: '없음', value: '0' },
          ...response.data
        ]
      })
      .catch(error => {
        console.log('error :>> ', error)
      })

    watch(
      () => props.isBioDialogOpen,
      () => {
        userDataLocal.value = JSON.parse(JSON.stringify(props.userData))
      },
    )

    watch(() => userDataLocal.value.phone, (newValue) => {
      userDataLocal.value.phone = phoneFomatter(newValue)
    })

    watch(() => userDataLocal.value.parent_phone, (newValue) => {
      userDataLocal.value.parent_phone = phoneFomatter(newValue)
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

    return {
      modal1,
      modal2,
      roleOptions,
      branchOptions,
      gradeOptions,
      validators: { required, emailValidator, confirmedValidator },
      form,
      valid,

      isBillingAddress,
      sexOptions,
      countries,
      userDataLocal,
      onSubmit,

      currentTab,
      tabItemContent
    }
  },
}
</script>
