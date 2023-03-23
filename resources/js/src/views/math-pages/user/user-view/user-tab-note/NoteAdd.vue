          
<template>
  <v-dialog
    v-model="isNoteAddDialogVisible"
    persistent
    max-width="600px"
  >

    <v-card>
      <v-card-title>
        <span class="headline">상담노트</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form 
            ref="form"
            v-model="valid"
            @submit.prevent="onSubmit"
          >
            <v-row>
              <v-col
                cols="12"
              >
                <v-text-field
                  label="제목"
                  v-model="noteDataLocal.title"
                  :rules="[validators.required]"
                >
                </v-text-field>
              </v-col>
              <v-col
                cols="12"
              >
                <v-select
                  label="종류"
                  v-model="noteDataLocal.type"
                  :items="['신규', '이탈', '정기상담']"
                  :rules="[validators.required]"
                  dense
                ></v-select>
              </v-col>
              <v-col
                cols="12"
              >
              <v-textarea
                  filled
                  label="내용"
                  v-model="noteDataLocal.text"
                  :rules="[validators.required]"
                  auto-grow
                  value=""
                ></v-textarea>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="error"
          @click="$emit('update:is-note-add-dialog-visible',false)"
        >
          닫기
        </v-btn>
        <v-btn
          color="success"
          @click.prevent="onSubmit"
        >
          입력하기
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { ref } from '@vue/composition-api'
import { required } from '@core/utils/validation'
import store from '@/store'

export default {
  props: {
    isNoteAddDialogVisible: {
      type: Boolean,
      required: true,
    },
    userData: {
      type: Object,
      required: true,
    },
  },
  setup(props, { emit }) {
    // const isDialogVisible = ref(false)

    // return { isDialogVisible }
    const form = ref(null)
    const valid = ref(false)
    const noteDataLocal = ref({})
    const blankNoteData = {
      title:'',
      type:'',
      text:'',
    }

    const onSubmit = () => {
      if(valid.value){
        console.log('hi',noteDataLocal);
        console.log('hi2',props.userData);
        store.dispatch(`app-user/addNote`,{
          user_id:props.userData.id,
          title:noteDataLocal.value.title,
          text:noteDataLocal.value.text,
          type:noteDataLocal.value.type,
          branch_id:props.userData.branch_id,
        })
        .then(rs=>{
          console.log(rs)
          resetNoteData()
          emit('refetch-data')
          emit('update:is-note-add-dialog-visible',false)
        }).catch(err => {
          console.log(err)
        })

      } else {
        validate()
      }
    }

    const validate = () => {
      form.value.validate()
    }

    const resetForm = () => {
      form.value.reset()
    }

    const resetNoteData = () => {
      noteDataLocal.value = JSON.parse(JSON.stringify(blankNoteData))
      resetForm()
      // emit('update:is-note-add-dialog-visible',false)
    }

    return {
      form,
      valid,
      noteDataLocal,
      onSubmit,
      validators: { required },
    }
  },
}
</script>
