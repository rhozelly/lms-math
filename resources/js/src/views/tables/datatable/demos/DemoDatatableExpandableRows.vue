<template>
  <v-data-table :headers="headers" :items="userList" :items-per-page="5" :expanded.sync="expanded" show-expand>
    <!-- name -->
    <template #[`item.full_name`]="{ item }">
      <div class="d-flex align-center">
        <v-avatar
          :color="item.avatar ? '' : 'primary'"
          :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
          size="32"
        >
          <v-img v-if="item.avatar" :src="require(`@/assets/images/avatars/${item.avatar}`).default"></v-img>
          <span v-else>{{ item.full_name.slice(0, 2).toUpperCase() }}</span>
        </v-avatar>
        <div class="d-flex flex-column ms-3">
          <span class="d-block font-weight-semibold text--primary text-truncate">{{ item.full_name }}</span>
          <small>{{ item.post }}</small>
        </div>
      </div>
    </template>

    <!-- salary -->
    <template #[`item.salary`]="{ item }">
      {{ `$${item.salary}` }}
    </template>

    <!-- status -->
    <template #[`item.status`]="{ item }">
      <v-chip
        small
        :color="statusColor[status[item.status]]"
        :class="`${statusColor[status[item.status]]}--text`"
        class="v-chip-light-bg"
      >
        {{ status[item.status] }}
      </v-chip>
    </template>

    <!-- expandad data -->
    <template #expanded-item="{ headers, item }">
      <td :colspan="headers.length">
        <p class="my-1">City: {{ item.city }}</p>
        <p class="mb-1">Experience: {{ item.experience }}</p>
        <p>Post: {{ item.post }}</p>
      </td>
    </template>
  </v-data-table>
</template>

<script>
import { ref } from '@vue/composition-api'
import { mdiSquareEditOutline, mdiDotsVertical } from '@mdi/js'
import data from '../datatable'

export default {
  setup() {
    const statusColor = {
      /* eslint-disable key-spacing */
      Current: 'primary',
      Professional: 'success',
      Rejected: 'error',
      Resigned: 'warning',
      Applied: 'info',
      /* eslint-enable key-spacing */
    }
    const expanded = ref([])

    return {
      headers: [
        { text: 'NAME', value: 'full_name' },
        { text: 'EMAIL', value: 'email' },
        { text: 'DATE', value: 'start_date' },
        { text: 'SALARY', value: 'salary' },
        { text: 'AGE', value: 'age' },
        { text: 'STATUS', value: 'status' },
      ],
      userList: data,
      status: {
        1: 'Current',
        2: 'Professional',
        3: 'Rejected',
        4: 'Resigned',
        5: 'Applied',
      },
      statusColor,
      expanded,

      // icons
      icons: {
        mdiSquareEditOutline,
        mdiDotsVertical,
      },
    }
  },
}
</script>
