import axios from '@axios'
import Vue from 'vue'

export default {
  namespaced: true,
  state: { 
    selectedUsers:[], 
  },
  getters: {
    getSelectedUsers(state){
      return state.selectedUsers
    }
  },
  mutations: {
    selectUser(state,{ userData }){//유저 탭 선택
      state.selectedUsers.unshift( userData )
    },
    updateUser(state,{ userData,index }){//유저 탭 선택
      const isEmpty = (Object.keys(userData).length === 0)
      if(isEmpty){
        Vue.delete(state.selectedUsers, index)
        // state.selectedUsers.splice(index,1)
        // console.log('hi this is delete')
      }else{
        console.log('hi this is change')
        Vue.set(state.selectedUsers, index, userData)
        // state.selectedUsers[index] = userData
      }
    },
    unselectUser(state,{ id }){ //유저 탭 지우기
      for(let i = 0; i < state.selectedUsers.length; i++) {
        if(state.selectedUsers[i]['id'] === id)  {
          state.selectedUsers.splice(i, 1)
          i--;
        }
      }
    },
  },
  actions: {
    fetchUsers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/apps/user/users', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchUser(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/apps/user/users/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addUser(ctx, userData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/apps/user/users', { user: userData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    registerUser(ctx, userData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/register', { ...userData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    logoutUser(ctx, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/logout')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getUser(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/users/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getUsers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/users', {params: queryParams})
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getRoles(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/roles')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getBranches(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/branches')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getGrades(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/grades')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    editUser(ctx, userData) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/users/${userData.id}`, { ...userData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getNotes(ctx, userData) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/notes`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    addNote(ctx, noteData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/note`,{ ...noteData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    editNote(ctx, noteData) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/note/${noteData.id}`,{ ...noteData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    deleteNote(ctx, {id}) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/note/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    resetPassword(ctx, {id,new_password}) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/users/${id}/password`,{ new_password })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    fetchCourses(ctx) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/courses')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    getTuitions(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/tuitions')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    addCourse(ctx, courseData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/course',{ ...courseData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    editCourse(ctx, courseData) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/course/${courseData.id}`,{ ...courseData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    deleteCourse(ctx, {id}) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/course/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    addCourseName(ctx, courseNameData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/courseName',{ ...courseNameData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    fetchCourseNames(ctx) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/courseNames')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    editCourseName(ctx, courseNameData) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/courseName/${courseNameData.id}`,{ ...courseNameData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    deleteCourseName(ctx, {id}) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/courseName/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    addMoveHoldOut(ctx, moveOutHoldData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/moveHoldOut',{ ...moveOutHoldData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

  },
}
