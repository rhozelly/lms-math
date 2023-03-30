<template>
  <div id="user-view">
     <!-- buttons -->
    <!-- <v-tabs v-model="currentTab">
      <v-tab
        v-for="n in totalTabs"
        :key="n"
      >
        Data {{ n }}
      </v-tab>
    </v-tabs> -->
    <v-tabs v-model="currentTab">
      <v-tab
        v-for="(user,idx) in users"
        :key="idx"
      >
        {{ user.fullName }}
      </v-tab>
    </v-tabs>
    <!-- <p> {{typeof users}} </p>
    <p> {{totalTabs}} </p>
    <div v-for="(user, idx) in users" :key="idx" class="mb-10">
      % {{ JSON.stringify(user) }} % <br/>
      % {{ user.id }} % <br/>
    </div> -->

    <v-card v-if="!totalTabs">
      <v-card-text class="text-center">
        <div class="page-title text-center px-5">
          <h2 class="text-2xl font-weight-semibold text--primary">보여줄 사용사 정보가 없습니다! 🚧</h2>
          <p class="text-sm">확인하실 사용자를 리스트에서 클릭해 주세요.</p>

          <div class="misc-character d-flex justify-center mb-10">
            <v-img max-width="700" :src="require('@/assets/images/3d-characters/under-maintenance.png').default"></v-img>
          </div>

          <v-btn color="primary" :to="{ name: 'admin-user-list' }" class="mb-4"> 사용자 목록 가기 </v-btn>
        </div>
      </v-card-text>
    </v-card>

    <!-- <v-tabs-items v-model="currentTab">
      <v-tab-item
        v-for="item in totalTabs"
        :key="item"
      > -->
    <v-tabs-items v-model="currentTab">
      <v-tab-item
        v-for="(user,idx) in users"
        :key="idx"
      >
        <v-card flat>
          <v-card-text>
            <div class="text-right">
              <v-btn
                text
                @click="oepnCloseComfirm(user.id)"
              >
                탭 닫기
              </v-btn>
            </div>

            <v-row>
              <v-col cols="12" md="5" lg="4">
                <user-bio-panel
                  :user-data="user"
                  :is-plan-upgrade-dialog-visible.sync="isPlanUpgradeDialogVisible"
                ></user-bio-panel>
              </v-col>
              
              <v-col cols="12" md="7" lg="8">
                <v-tabs v-model="userTab" show-arrows class="user-tabs">
                  <v-tab v-for="tab in tabs" :key="tab.icon">
                    <v-icon size="20" class="me-3">
                      {{ tab.icon }}
                    </v-icon>
                    <span>{{ tab.title }}</span>
                  </v-tab>
                </v-tabs>

                <v-tabs-items id="user-tabs-content" v-model="userTab" class="mt-5 pa-1">
                  <v-tab-item>
                    <user-tab-overview :user-data="user"></user-tab-overview>
                  </v-tab-item>

                  <v-tab-item>
                    <user-tab-note :user-data="user"></user-tab-note>
                  </v-tab-item>

                  <!-- <v-tab-item>
                    <user-tab-billings-plans
                      :is-plan-upgrade-dialog-visible.sync="isPlanUpgradeDialogVisible"
                    ></user-tab-billings-plans>
                  </v-tab-item> -->

                  <v-tab-item>
                    <user-tab-security :user-data="user"></user-tab-security>
                  </v-tab-item>

                  <!-- <v-tab-item>
                    <user-tab-notifications></user-tab-notifications>
                  </v-tab-item>
                  <v-tab-item>
                    <user-tab-connections></user-tab-connections>
                  </v-tab-item> -->
                </v-tabs-items>
              </v-col>
            </v-row>

            <v-dialog v-model="isPlanUpgradeDialogVisible" max-width="650">
              <v-card class="py-8">
                <v-card-title class="justify-center text-h5 px-5"> Upgrade Plan </v-card-title>
                <v-card-text class="text-center mt-n2 px-5"> Choose the best plan for user. </v-card-text>
                <v-card-text class="d-flex align-center flex-wrap flex-sm-nowrap mt-5 px-15">
                  <v-select
                    v-model="selectedPlan"
                    label="Choose Plan"
                    :items="plansList"
                    item-text="text"
                    item-value="value"
                    outlined
                    dense
                    hide-details
                    class="me-3"
                  ></v-select>
                  <v-btn color="primary" class="mt-3 mt-sm-0"> Upgrade </v-btn>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-text class="px-15 pt-8">
                  <p class="font-weight-medium text--primary mb-2">User current plan is {{ userData.currentPlan }} plan</p>
                  <div class="d-flex justify-space-between flex-wrap">
                    <div class="user-pricing me-3">
                      <sup class="primary--text">$</sup>
                      <span class="text-5xl font-weight-semibold primary--text">{{
                        resolveCurrentPlanValue(userData.currentPlan)
                      }}</span>
                      <sub class="text-base font-weight-light">/ month</sub>
                    </div>
                    <v-btn color="error" outlined class="mt-3"> Cancel Subscription </v-btn>
                  </div>
                </v-card-text>
              </v-card>
            </v-dialog>

          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>

    <v-dialog
      v-model="isCloseDialogVisible"
      width="500"
    >
      <v-card>
        <v-card-title>
          현재 탭 닫기
        </v-card-title>

        <v-card-text>
          정말로 탭을 닫으시겠습니까?
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            @click="closeTab()"
          >
            탭 닫기
          </v-btn>
          <v-btn
            color="primary"
            @click="isCloseDialogVisible = false"
          >
            취소
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


  </div>
</template>

<script>
import { onUnmounted, ref, watch, computed } from '@vue/composition-api'
import router from '@/router'
import store from '@/store'

// eslint-disable-next-line object-curly-newline
import { mdiAccountOutline, mdiLockOutline, mdiBookmarkOutline, mdiBellOutline, mdiLinkVariant } from '@mdi/js'
import UserBioPanel from './user-bio-panel/UserBioPanel.vue'
import userStoreModule from '../userStoreModule'
import UserTabOverview from './user-tab-overview/UserTabOverview.vue'
import UserTabSecurity from './user-tab-security/UserTabSecurity.vue'
import UserTabBillingsPlans from './user-tab-billings-plans/UserTabBillingsPlans.vue'
import UserTabNotifications from './user-tab-notifications/UserTabNotifications.vue'
import UserTabConnections from './user-tab-connections/UserTabConnections.vue'
import UserTabNote from './user-tab-note/UserTabNote.vue'

export default {
  components: {
    UserBioPanel,
    UserTabOverview,
    UserTabSecurity,
    UserTabBillingsPlans,
    UserTabNotifications,
    UserTabNote,
  },
  setup() {
    const USER_APP_STORE_MODULE_NAME = 'app-user'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    const userTab = ref(null)
    const userData = ref({})
    const selectedPlan = ref('')
    const isPlanUpgradeDialogVisible = ref(false)
    const currentTab = ref(0)
    const isCloseDialogVisible = ref(false)
    const closeDialogId = ref(0);

    const users = computed(() => store.getters['app-user/getSelectedUsers']);
    const totalTabs = computed(() => users.value.length);

    const oepnCloseComfirm = (id) => {
      isCloseDialogVisible.value  = !isCloseDialogVisible.value
      closeDialogId.value         = id
    }

    const closeTab = () => {
      store.commit('app-user/unselectUser', { id:closeDialogId.value });
      isCloseDialogVisible.value  = !isCloseDialogVisible.value
    };

    const focusClickUserTab = () => {
      for (let i = 0; i < users.value.length; i++) {
        if(users.value[i]['id'] == router.currentRoute.params.id){
          currentTab.value = i;
          return true;
        } 
      }
    }

    focusClickUserTab()

    const plansList = [
      { text: 'Basic - $0/month', value: 'basic' },
      { text: 'Standard - $99/month', value: 'standard' },
      { text: 'Enterprise - $499/month', value: 'enterprise' },
      { text: 'Company - $999/month', value: 'company' },
    ]

    const tabs = [
      { icon: mdiAccountOutline, title: '수업 리스트' }, // Class List
      { icon: mdiBellOutline, title: '이력 현황' },  // History Status
      { icon: mdiBookmarkOutline, title: '노트' },  // Note
      { icon: mdiLockOutline, title: '비밀번호 변경' },  // Change Passwrod
      { icon: mdiBellOutline, title: '지불' }, // Payment
      // { icon: mdiLinkVariant, title: '연동' },
    ]

    // ui
    const resolveCurrentPlanValue = plan => {
      if (plan === 'basic') return '0'
      if (plan === 'standard') return '99'
      if (plan === 'enterprise') return '499'
      if (plan === 'company') return '999'

      return '0'
    }

    return {
      users,
      tabs,
      userTab,
      plansList,
      selectedPlan,
      isPlanUpgradeDialogVisible,
      userData,
      resolveCurrentPlanValue,
      oepnCloseComfirm,
      closeTab,
      totalTabs, 
      currentTab,
      isCloseDialogVisible,
    }
  },
}
</script>

<style lang="scss">
@import '@resources/sass/preset/apps/user.scss';
</style>
