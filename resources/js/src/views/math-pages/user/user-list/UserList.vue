<template>
  <div id="user-list">
    <!-- app drawer -->
    <user-list-add-new v-model="isAddNewUserSidebarActive" :role-options="roleOptions" :branch-options="branchOptions"
      :grade-options="gradeOptions" @refetch-data="fetchUsers2" @err-msg="openSnackbar"></user-list-add-new>

    <!-- app drawer -->
    <!-- <user-list-add-new2
      v-model="isAddNewUserSidebarActive"
      :role-options="roleOptions"
      :plan-options="planOptions"
      @refetch-data="fetchUsers"
    ></user-list-add-new2> -->

    <v-snackbar v-model="isRoundedSnackbarVisible" rounded="pill" top :light="$vuetify.theme.dark" right>
      관리자에게 문의하세요
    </v-snackbar>

    <!-- user total card -->
    <v-row class="mb-5">
      <v-col v-for="(total, index) in userTotalLocal2" :key="index" cols="12" sm="6" md="3">
        <v-card>
          <v-card-text class="d-flex align-center justify-space-between pa-4">
            <div>
              <h2 class="font-weight-semibold mb-1">
                {{ total.total }}
              </h2>
              <span>{{ total.title }}</span>
            </div>

            <v-avatar :color="resolveUserTotalIcon(total.title).color"
              :class="`v-avatar-light-bg ${resolveUserTotalIcon(total.title).color}--text`">
              <v-icon size="25" :color="resolveUserTotalIcon(total.title).color" class="rounded-0">
                {{ resolveUserTotalIcon(total.title).icon }}
              </v-icon>
            </v-avatar>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- list filters -->
    <v-card>
      <v-card-title> 검색 &amp; 필터</v-card-title>

      <!-- actions -->
      <v-card-text class="d-flex align-center flex-wrap pb-0">
        <v-select v-model="searchType" :items="['이름', '전화번호']" placeholder="타입" class="user-search me-3 mb-4" single-line
          outlined dense hide-details></v-select>
        <!-- search -->
        <v-text-field v-model.lazy="searchQuery" placeholder="검색" outlined hide-details dense
          class="user-search me-3 mb-4" clearable>
        </v-text-field>

        <v-spacer></v-spacer>

        <div class="d-flex align-center flex-wrap">
          <v-btn color="primary" class="mb-4 me-3" @click.stop="isAddNewUserSidebarActive = !isAddNewUserSidebarActive">
            <v-icon>{{ icons.mdiPlus }}</v-icon>
            <span>사용자 등록</span>
          </v-btn>

          <!-- <v-btn color="secondary" outlined class="mb-4">
            <v-icon size="17" class="me-1">
              {{ icons.mdiExportVariant }}
            </v-icon>
            <span>공유</span>
          </v-btn> -->
        </div>
      </v-card-text>

      <!-- table -->
      <v-data-table v-model="selectedRows" :headers="tableColumns" :items="userListTable2" :options.sync="options"
        :server-items-length="totalUserListTable2" :loading="loading" :page="page">
        <!-- name -->
        <template #[`item.fullName`]="{ item }">
          <div class="d-flex align-center">
            <v-avatar :color="item.avatar ? '' : 'primary'" :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
              size="32">
              <v-img v-if="item.avatar" :src="require(`@/assets/images/avatars/${item.avatar}`).default"></v-img>
              <span v-else class="font-weight-medium">{{ avatarText(item.fullName) }}</span>
            </v-avatar>

            <div class="d-flex flex-column ms-3">
              <!-- <router-link
                :to="{ name: 'admin-user-view', params: { id: item.id } }"
                class="text--primary font-weight-semibold text-truncate cursor-pointer text-decoration-none"
              > -->
              <span @click="selectUser(item.id)"
                class="text--primary font-weight-semibold text-truncate cursor-pointer text-decoration-none">
                {{ item.fullName }}
              </span>
              <!-- </router-link> -->
              <small>@{{ item.username }}</small>
            </div>
          </div>
        </template>

        <!-- role -->
        <template #[`item.role`]="{ item }">
          <div class="d-flex align-center">
            <v-avatar size="30" :color="resolveUserRoleVariant(item.role)"
              :class="`v-avatar-light-bg ${resolveUserRoleVariant(item.role)}--text me-3`">
              <v-icon size="18" :color="resolveUserRoleVariant(item.role)">
                {{ resolveUserRoleIcon(item.role) }}
              </v-icon>
            </v-avatar>
            <span class="text-capitalize">{{ item.role }}</span>
          </div>
        </template>

        <!-- plan -->
        <!-- <template #[`item.currentPlan`]="{ item }">
          <span class="text-capitalize font-weight-semibold text--primary">{{ item.currentPlan }}</span>
        </template> -->

        <!-- status -->
        <template #[`item.status`]="{ item }">
          <v-chip small :color="resolveUserStatusVariant(item.status)"
            :class="`${resolveUserStatusVariant(item.status)}--text`"
            class="v-chip-light-bg font-weight-semibold text-capitalize">
            {{ item.status ? 'active' : 'inactive' }}
          </v-chip>
        </template>

        <!-- actions -->
        <template #[`item.actions`]="{ item }">
          <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>{{ icons.mdiDotsVertical }}</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item :to="{ name: 'admin-user-view', params: { id: item.id } }">
                <v-list-item-title>
                  <v-icon size="20" class="me-2">
                    {{ icons.mdiFileDocumentOutline }}
                  </v-icon>
                  <span>상세페이지</span>
                </v-list-item-title>
              </v-list-item>

              <v-list-item link>
                <v-list-item-title>
                  <v-icon size="20" class="me-2">
                    {{ icons.mdiDeleteOutline }}
                  </v-icon>
                  <span>삭제</span>
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
  mdiSquareEditOutline,
  mdiDotsVertical,
  mdiPlus,
  mdiFileDocumentOutline,
  mdiDeleteOutline,
  mdiExportVariant,
  mdiAccountOutline,
} from '@mdi/js'
import store from '@/store'
import { onUnmounted, ref, computed, watch } from '@vue/composition-api'

// sidebar
import { avatarText } from '@core/utils/filter'
import UserListAddNew from './UserListAddNew.vue'
import UserListAddNew2 from './UserListAddNew2.vue'
import userStoreModule from '../userStoreModule'

import useUsersList from './useUsersList'
import { consoleError } from 'vuetify/lib/util/console'

export default {
  components: {
    UserListAddNew,
    UserListAddNew2,
  },
  setup() {
    const USER_APP_STORE_MODULE_NAME = 'app-user'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    const {
      page,
      userListTable,
      tableColumns,
      searchQuery,
      searchType,
      roleFilter,
      planFilter,
      statusFilter,
      totalUserListTable,
      loading,
      options,
      userTotalLocal,
      selectedRows,

      fetchUsers,
      resolveUserRoleVariant,
      resolveUserRoleIcon,
      resolveUserStatusVariant,
      resolveUserTotalIcon,

      userListTable2,
      totalUserListTable2,
      userTotalLocal2,
      fetchUsers2,
      selectUser,
    } = useUsersList()


    const isAddNewUserSidebarActive = ref(false)
    const isRoundedSnackbarVisible = ref(false)
    const errMsgs = [
      { 422: "입력값오류" },
      { 500: "서버오류" },
    ]

    const openSnackbar = (payload) => {
      let key;
      for (key in errMsgs) {
        console.log('etsset', errMsgs[key])
      }
      console.log(payload, errMsgs);
      isRoundedSnackbarVisible.value = true
    };
    // const roleOptions = [
    //   { title: 'Admin', value: 'admin' },
    //   { title: 'Author', value: 'author' },
    //   { title: 'Editor', value: 'editor' },
    //   { title: 'Maintainer', value: 'maintainer' },
    //   { title: 'Subscriber', value: 'subscriber' },
    // ]

    // const planOptions = [
    //   { title: 'Basic', value: 'basic' },
    //   { title: 'Company', value: 'company' },
    //   { title: 'Enterprise', value: 'enterprise' },
    //   { title: 'Standard', value: 'standard' },
    // ]

    const statusOptions = [
      { title: '활동', value: 1 },
      { title: '미활동', value: 0 },
    ]

    const roleOptions = ref([])
    const branchOptions = ref([])
    const gradeOptions = ref([])

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

    // const roleOptions = [
    //   { title: '마스터', value: '1' },
    //   { title: '관리자', value: '2' },
    //   { title: '강사', value: '3' },
    //   { title: '학생', value: '4' },
    // ]

    // const branchOptions = [
    //   { title: '권선관', value: '1' },
    //   { title: '매탄관', value: '2' },
    //   { title: '아이파크관', value: '3' },
    //   { title: '매교관', value: '4' },
    // ]

    // const gradeOptions = [
    //   { title: '없음', value: '0' },
    //   { title: '초등 1학년', value: '1' },
    //   { title: '초등 2학년', value: '2' },
    //   { title: '초등 3학년', value: '3' },
    //   { title: '초등 4학년', value: '4' },
    //   { title: '초등 5학년', value: '5' },
    //   { title: '초등 6학년', value: '6' },
    //   { title: '중등 1학년', value: '7' },
    //   { title: '중등 2학년', value: '8' },
    //   { title: '중등 3학년', value: '9' },
    //   { title: '고등 1학년', value: '10' },
    //   { title: '고등 2학년', value: '11' },
    //   { title: '고등 3학년', value: '12' },
    // ]

    return {
      selectUser,
      page,
      userListTable,
      tableColumns,
      searchQuery,
      searchType,
      roleFilter,
      planFilter,
      statusFilter,
      totalUserListTable,
      roleOptions,
      branchOptions,
      gradeOptions,
      statusOptions,
      loading,
      options,
      userTotalLocal,
      isAddNewUserSidebarActive,
      selectedRows,
      avatarText,
      resolveUserRoleVariant,
      resolveUserRoleIcon,
      resolveUserStatusVariant,
      resolveUserTotalIcon,
      fetchUsers,
      isRoundedSnackbarVisible,
      openSnackbar,

      userListTable2,
      totalUserListTable2,
      userTotalLocal2,
      fetchUsers2,
      selectUser,

      // icons
      icons: {
        mdiSquareEditOutline,
        mdiFileDocumentOutline,
        mdiDotsVertical,
        mdiDeleteOutline,
        mdiPlus,
        mdiExportVariant,
        mdiAccountOutline,
      },
    }
  },
}
</script>

<style lang="scss">
@import '@resources/sass/preset/apps/user.scss';
</style>
