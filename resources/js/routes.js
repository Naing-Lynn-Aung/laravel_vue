import PostIndex from './components/posts/Index.vue'
import PostCreate from './components/posts/Create.vue'
import PostEdit from './components/posts/Edit.vue'

import UserIndex from './components/users/Index.vue'
import UserCreate from './components/users/Create.vue'
import UserEdit from './components/users/Edit.vue'

import Login from './components/auth/Login.vue'

import ErrorPage from './components/Error.vue'

export const routes = [

  {
    path: '/posts',
    component: PostIndex,
    name: 'PostIndex',
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/posts/create',
    component: PostCreate,
    name: 'PostCreate',
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/posts/edit/:id',
    component: PostEdit,
    name: 'PostEdit',
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/users',
    component: UserIndex,
    name: 'UserIndex',
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/users/create',
    component: UserCreate,
    name: 'UserCreate',
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/users/edit/:id',
    component: UserEdit,
    name: 'UserEdit',
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/login',
    component: Login,
    name: 'Login'
  },
  {
    path: '/:catchAll(.*)',
    name: 'ErrorPage',
    component: ErrorPage
 }

];
