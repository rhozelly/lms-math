import {
  mdiAccountOutline,
  mdiSchoolOutline,
  mdiNoteOutline,
  mdiChartBoxPlusOutline,
  mdiCogOutline,
} from '@mdi/js'

export default [
  {
    subheader: '관리페이지',
  },
  {
    title: '사용자',
    icon: mdiAccountOutline,
    children: [
      {
        title: '사용자 목록',
        to: 'admin-user-list',
      },
      {
        title: '사용자 상세화면',
        to: { name: 'admin-user-view', params: { id: 0 } },
      },
    ],
  },
  {
    title: '수업',
    icon: mdiSchoolOutline,
    children: [
      {
        title: '수업 목록',
        to: 'admin-course-list',
      },
      {
        title: '수업 상세화면',
        to: { name: 'admin-course-view', params: { id: 0 } },
      },
    ],
  },
  {
    title: '평가',
    icon: mdiChartBoxPlusOutline,
    children: [
      {
        title: '강사평가',
        to: 'admin-test-tabs',
      },
    ],
  },
  {
    title: '상담',
    icon: mdiNoteOutline,
    children: [
      {
        title: '상담목록',
        to: 'dashboard-crm',
      },
    ],
  },
  {
    title: '설정',
    icon: mdiCogOutline,
    children: [
      {
        title: '기본설정',
        to: 'admin-course-name',
      },
      {
        title: '분석페이지',
        to: 'dashboard-analytics',
      },
    ],
  },
]
