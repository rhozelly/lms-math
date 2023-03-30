<template>
  <div class="user-tab-security">
    <!-- change password -->
    <v-card class="mb-7">
      <v-card-title>
        이력 현황
        <v-spacer></v-spacer>
        <v-btn color="primary" class="me-3" @click="isNoteAddDialogVisible = !isNoteAddDialogVisible">
          <v-icon size="18" class="me-1">
            {{ icons.mdiPlus }}
          </v-icon>
          <span>상담노트 작성</span>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <div>
          <v-chip color="primary">옮기다</v-chip> <!-- Transfer -->
          <v-chip color="info">잡고 있다</v-chip> <!-- Hold -->
          <v-chip color="warning">반품</v-chip> <!-- Return -->
        </div>


        <v-data-table :headers="tableColumnHeaders" :items="noteList" :loading="loading" :items-per-page="5"
          :footer-props="{
            'items-per-page-options': [3, 5, 10, -1],
            'items-per-page-text': '출력 페이지 수'
          }">
          <template #[`item.category`]="{ item }">
            <div style="text-align:left">
              {{ item.category }}
            </div>
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
                <v-list-item @click="
                  (isNoteEditDialogVisible = !isNoteEditDialogVisible) |
                  (noteData = JSON.parse(JSON.stringify(item)))">
                  <v-list-item-title>
                    <v-icon size="20" class="me-2">
                      {{ icons.mdiFileDocumentOutline }}
                    </v-icon>
                    <span>수정</span>
                  </v-list-item-title>
                </v-list-item>

                <v-list-item @click="
                  (isDeleteDialogVisible = !isDeleteDialogVisible) |
                  (noteData = JSON.parse(JSON.stringify(item)))">
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

      </v-card-text>
    </v-card>
    <NoteAdd :is-note-add-dialog-visible.sync="isNoteAddDialogVisible" :user-data="userData" @refetch-data="fetchNote">
    </NoteAdd>
    <NoteEdit :is-note-edit-dialog-visible.sync="isNoteEditDialogVisible" :note-data="noteData" @refetch-data="fetchNote">
    </NoteEdit>

    <v-dialog v-model="isDeleteDialogVisible" width="500">
      <v-card>
        <v-card-title>
          상담 노트 삭제
        </v-card-title>

        <v-card-text>
          정말로 [{{ noteData.title }}]상담 노트를 삭제하시겠습니까?
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="isDeleteDialogVisible = false">
            취소
          </v-btn>
          <v-btn color="error" @click="deletNote()">
            삭제하기
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
  mdiPlus,
  mdiSquareEditOutline,
  mdiDeleteOutline,
  mdiEyeOutline,
  mdiEyeOffOutline,
  mdiDotsVertical,
  mdiFileDocumentOutline,
} from '@mdi/js'
import { ref, watch } from '@vue/composition-api'
import NoteAdd from './NoteAdd.vue'
import NoteEdit from './NoteEdit.vue'
import store from '@/store'

export default {
  components: {
    NoteAdd,
    NoteEdit,
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const loading = ref(false)
    const isNoteAddDialogVisible = ref(false)
    const isNoteEditDialogVisible = ref(false)
    const noteData = ref({})
    const isDeleteDialogVisible = ref(false)

    // branch id, course, category, status
    const tableColumnHeaders = [
      {
        text: '제목',
        value: 'title',
        sortable: false,
        width: '5%',
        align: 'center',
      },
      // { text: '내용', value: 'text', sortable: false, width: '35%', align: 'center', },
      { text: '글쓴이', value: 'writer', sortable: false, width: '20%', align: 'center', },
      { text: '지사', value: 'branch', sortable: false, width: '20%', align: 'center', },
      { text: '범주', value: 'category', sortable: false, width: '5%', align: 'center', },
      { text: '종류', value: 'type', sortable: false, width: '5%', align: 'center', },
      { text: '시간', value: 'created_at', sortable: false, width: '15%', align: 'center', },
      { text: '작업', value: 'actions', sortable: false, width: '5%', align: 'center', },

    ]

    // const noteList = [
    //   {
    //     title: 'chrome.png',
    //     text: 'Chrome on Windows',
    //     writer: 'Dell XPS 15',
    //     created_at: 'United States',
    //   },
    //   {
    //     title: 'chrome.png',
    //     text: 'Chrome on Android',
    //     writer: 'Google Pixel 3a',
    //     created_at: 'Ghana',
    //   },
    //   {
    //     title: 'chrome.png',
    //     text: 'Chrome on MacOS',
    //     writer: 'Apple iMac',
    //     created_at: 'Mayotte',
    //   },
    //   {
    //     title: 'chrome.png',
    //     text: 'Chrome on IPhone',
    //     writer: 'Apple iPhone XR',
    //     created_at: 'Mauritania',
    //   },
    // ]

    const noteList = ref([])
    const fetchNote = () => {
      loading.value = true
      store.dispatch('app-user/getNotes')
        .then((rs) => {
          console.log(rs)
          console.log('noteList!', noteList)
          noteList.value = rs.data.noteList
        })
        .catch((err) => {
          console.log(err)
        }).then(() => {
          loading.value = false
        })
    }
    const deletNote = () => {
      store.dispatch('app-user/deleteNote', { id: noteData.value.id })
        .then((rs) => {
          console.log(rs)
          console.log('noteDelete!', noteList)
          fetchNote()
        })
        .catch((err) => {
          console.log(err)
        })
      isDeleteDialogVisible.value = false
    }

    fetchNote()

    return {
      fetchNote,
      deletNote,
      loading,
      isDeleteDialogVisible,
      noteData,
      tableColumnHeaders,
      noteList,
      isNoteAddDialogVisible,
      isNoteEditDialogVisible,
      icons: {
        mdiSquareEditOutline,
        mdiDeleteOutline,
        mdiEyeOutline,
        mdiEyeOffOutline,
        mdiPlus,
        mdiDotsVertical,
        mdiFileDocumentOutline,
        mdiDeleteOutline,
      },
    }
  },
}
</script>
