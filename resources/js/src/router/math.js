const math = [
  {
    path: '/admin/user/list',
    name: 'admin-user-list',
    component: () => import('@/views/math-pages/user/user-list/UserList.vue'),
    meta: {
      layout: 'content',
    },
  },
  {
    path: '/admin/user/view/:id',
    name: 'admin-user-view',
    component: () => import('@/views/math-pages/user/user-view/UserView.vue'),
    meta: {
      layout: 'content',
      // navActiveLink: 'apps-user-list',
    },
  },
  {
    path: '/admin/course/list',
    name: 'admin-course-list',
    component: () => import('@/views/math-pages/course/course-list/UserList.vue'),
    meta: {
      layout: 'content',
    },
  },
  {
    path: '/admin/course/view/:id',
    name: 'admin-course-view',
    component: () => import('@/views/math-pages/course/course-view/UserView.vue'),
    meta: {
      layout: 'content',
      // navActiveLink: 'apps-user-list',
    },
  },
  {
    path: '/admin/test/tabs',
    name: 'admin-test-tabs',
    component: () => import('@/views/math-pages/test/tabTest.vue'),
    meta: {
      layout: 'content',
      // navActiveLink: 'apps-user-list',
    },
  },
  {
    path: '/admin/course/name',
    name: 'admin-course-name',
    component: () => import('@/views/math-pages/course/course-name/courseName.vue'),
    meta: {
      layout: 'content',
      // navActiveLink: 'apps-user-list',
    },
  },

  // //
  // //* ——— Invoice ——————————————————
  // //

  // {
  //   path: '/apps/invoice/list',
  //   name: 'apps-invoice-list',
  //   component: () => import('@/views/apps/invoice/invoice-list/InvoiceList.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },
  // {
  //   path: '/apps/invoice/preview/:id',
  //   name: 'apps-invoice-preview',
  //   component: () => import('@/views/apps/invoice/invoice-preview/InvoicePreview.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },
  // {
  //   path: '/apps/invoice/add/',
  //   name: 'apps-invoice-add',
  //   component: () => import('@/views/apps/invoice/invoice-add/InvoiceAdd.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },
  // {
  //   path: '/apps/invoice/edit/:id',
  //   name: 'apps-invoice-edit',
  //   component: () => import('@/views/apps/invoice/invoice-edit/InvoiceEdit.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },

  // //
  // //* ——— User ——————————————————
  // //

  // {
  //   path: '/apps/user/list',
  //   name: 'apps-user-list',
  //   component: () => import('@/views/apps/user/user-list/UserList.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },
  // {
  //   path: '/apps/user/view/:id',
  //   name: 'apps-user-view',
  //   component: () => import('@/views/apps/user/user-view/UserView.vue'),
  //   meta: {
  //     layout: 'content',
  //     // navActiveLink: 'apps-user-list',
  //   },
  // },

  // //
  // //* ——— Chat ——————————————————
  // //

  // {
  //   path: '/apps/chat',
  //   name: 'apps-chat',
  //   component: () => import('@/views/apps/chat/Chat.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },

  // //
  // //* ——— Email ——————————————————
  // //

  // {
  //   path: '/apps/email',
  //   name: 'apps-email',
  //   component: () => import('@/views/apps/email/Email.vue'),
  //   meta: {
  //     layout: 'content',
  //   },
  // },
  // {
  //   path: '/apps/email/:folder',
  //   name: 'apps-email-folder',
  //   component: () => import('@/views/apps/email/Email.vue'),
  //   meta: {
  //     layout: 'content',
  //     navActiveLink: 'apps-email',
  //   },
  //   beforeEnter(to, _, next) {
  //     if (['sent', 'draft', 'starred', 'spam', 'trash'].includes(to.params.folder)) next()
  //     else next({ name: 'error-404' })
  //   },
  // },
  // {
  //   path: '/apps/email/label/:label',
  //   name: 'apps-email-label',
  //   component: () => import('@/views/apps/email/Email.vue'),
  //   meta: {
  //     layout: 'content',
  //     navActiveLink: 'apps-email',
  //   },
  //   beforeEnter(to, _, next) {
  //     if (['personal', 'company', 'important', 'private'].includes(to.params.label)) next()
  //     else next({ name: 'error-404' })
  //   },
  // },
]

export default math
