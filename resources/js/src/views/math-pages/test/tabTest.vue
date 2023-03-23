<template>
  <div>
        <!-- buttons -->
    <div class="text-center mb-6">
      <v-btn
        :disabled="!totalTabs"
        text
        @click="totalTabs--"
      >
        Remove Tab
      </v-btn>

      <v-divider
        class="mx-4"
        vertical
      ></v-divider>

      <v-btn
        text
        @click="totalTabs++"
      >
        Add Tab
      </v-btn>
    </div>
    <v-tabs v-model="currentTab">
      <v-tab
        v-for="n in totalTabs"
        :key="n"
      >
        Tab {{ n }}
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="currentTab">
      <v-tab-item
        v-for="item in totalTabs"
        :key="item"
      >
        <v-card flat>
          <v-card-text>{{ tabItemText }}</v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>

<script>
import { ref, watch } from '@vue/composition-api'

export default {
  setup() {
    const totalTabs = ref(3)
    const currentTab = ref(0)
    const tabItemText = `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.`

    watch(totalTabs, newValue => {
      currentTab.value = newValue - 1
    })

    return { totalTabs, currentTab, tabItemText }
  },
}
</script>
