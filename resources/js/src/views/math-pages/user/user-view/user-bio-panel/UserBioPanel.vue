<template>
  <v-row class="user-bio-panel">
    <!-- user profile -->
    <v-col cols="12">
      <v-card class="pt-10">
        <v-card-title class="justify-start flex-row">
          <v-avatar
            :color="userData.avatar ? '' : 'primary'"
            :class="userData.avatar ? '' : 'v-avatar-light-bg primary--text'"
            size="120"
            rounded
            class="mb-4"
          >
            <v-img v-if="userData.avatar" :src="require(`@/assets/images/avatars/${userData.avatar}`).default"></v-img>
            <span v-else class="font-weight-semibold text-5xl">{{ avatarText(userData.fullName) }}</span>
          </v-avatar>
        <v-col class="justify-start flex-column">
            <span class="mb-2">{{ userData.fullName }}</span>
            <v-chip label small :color="resolveUserRoleVariant(userData.role)" :class="`v-chip-light-bg text-sm font-weight-semibold ${resolveUserRoleVariant( userData.role,)}--text text-capitalize`">
              {{ userData.role_name }}
            </v-chip>                    
            <v-col class="justify-start flex-row">
                <v-btn color="primary" class="me-3"> 사진 업로드</v-btn>
            </v-col>
        </v-col>
        </v-card-title>

        <v-card-text>
          <h2 class="text-xl font-weight-semibold mb-2">기본 정보</h2>

          <v-divider></v-divider>

          <v-list>
            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium me-2">아이디:</span>
              <span class="text--secondary">{{ userData.username }}</span>
            </v-list-item>

            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium me-2">이 름:</span>
              <span class="text--secondary">{{ userData.fullName }}</span>
            </v-list-item>

            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium text-no-wrap me-2">이메일:</span>
              <span class="text--secondary">{{ userData.email }}</span>
            </v-list-item>

            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium me-2">상태:</span>
              <span class="text--secondary">
                <v-chip
                  small
                  label
                  :color="resolveUserStatusVariant(userData.status)"
                  :class="`v-chip-light-bg ${resolveUserStatusVariant(
                    userData.status,
                  )}--text font-weight-medium text-capitalize`"
                >
                  {{ userData.status==1?'활동':'휴면' }}
                </v-chip>
              </span>
            </v-list-item>

            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium me-2">역할:</span>
              <span class="text--secondary text-capitalize">{{ userData.role_name }}({{userData.role}})</span>
            </v-list-item>

            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium me-2">연락처:</span>
              <span class="text--secondary">{{ userData.phone }}</span>
            </v-list-item>
            
            <v-list-item dense class="px-0 mb-n2">
              <span class="font-weight-medium me-2">학원:</span>
              <span class="text--secondary">{{ userData.branch }}</span>
            </v-list-item>

          </v-list>
        </v-card-text>

        <v-card-actions class="justify-center">
          <v-btn color="primary" class="me-3" @click="isBioDialogOpen = !isBioDialogOpen"> 프로필 수정 </v-btn>
          <!-- <v-btn color="error" outlined> 휴면전환 </v-btn> -->
        </v-card-actions>
      </v-card>

      <!-- edit profile dialog data -->
      <user-bio-edit :is-bio-dialog-open.sync="isBioDialogOpen" :user-data="userData"></user-bio-edit>
    </v-col>

    <!-- user plan -->
    <v-col cols="12">
      <!-- <v-card class="user-plan" flat>
        <v-card-title class="flex-start align-start justify-space-between pb-0">
          <v-chip label color="primary" small class="v-chip-light-bg primary--text font-weight-semibold mb-3 me-3">
            {{ userData.currentPlan }}
          </v-chip>

          <div class="user-pricing">
            <sup class="primary--text">$</sup>
            <span class="text-5xl font-weight-semibold primary--text">{{
              resolveCurrentPlanValue(userData.currentPlan)
            }}</span>
            <sub class="text-base font-weight-light">/ 월</sub>
          </div>
        </v-card-title>

        <v-card-text>
          <v-list class="pa-0">
            <v-list-item v-for="benefit in standardPlan.benefits" :key="benefit" dense class="px-0 mb-n2">
              <v-icon size="10" class="me-2">
                {{ icons.mdiCheckboxBlankCircle }}
              </v-icon>
              <span>{{ benefit }}</span>
            </v-list-item>
          </v-list>

          <p class="d-flex font-weight-semibold text--primary mt-5 mb-2">
            <span>수업일</span>
            <v-spacer></v-spacer>
            <span>26/30일 진행</span>
          </p>
          <v-progress-linear value="86" height="8" rounded></v-progress-linear>
          <p class="mt-2">수강 종료까지 4일 남았습니다.</p>

          <v-btn color="primary" block @click.stop="$emit('update:is-plan-upgrade-dialog-visible', true)">
            연장하기
          </v-btn>
        </v-card-text>
      </v-card> -->
    </v-col>
  </v-row>
</template>

<script>
import { mdiCheck, mdiBriefcaseVariantOutline, mdiCheckboxBlankCircle } from '@mdi/js'
import { avatarText, kFormatter } from '@core/utils/filter'
import { ref } from '@vue/composition-api'
import UserBioEdit from './UserBioEdit.vue'
import useUsersList from '../../user-list/useUsersList'

export default {
  components: {
    UserBioEdit,
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
    isPlanUpgradeDialogVisible: {
      type: Boolean,
      required: true,
    },
  },
  setup() {
    const { resolveUserStatusVariant, resolveUserRoleVariant } = useUsersList()

    const isBioDialogOpen = ref(false)

    const standardPlan = {
      plan: 'Standard',
      price: 99,
      benefits: ['예비중과정', '서동우 선생님', '이벤트:겨울방학특강'],
    }

    // ui
    const resolveCurrentPlanValue = plan => {
      if (plan === 'basic') return '0'
      if (plan === 'standard') return '99'
      if (plan === 'enterprise') return '499'
      if (plan === 'company') return '999'

      return '0'
    }

    return {
      resolveUserStatusVariant,
      resolveUserRoleVariant,
      avatarText,
      kFormatter,
      resolveCurrentPlanValue,

      isBioDialogOpen,
      standardPlan,
      icons: {
        mdiCheck,
        mdiBriefcaseVariantOutline,
        mdiCheckboxBlankCircle,
      },
    }
  },
}
</script>
