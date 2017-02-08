import Home from './components/Home'
import Login from './components/Login'
import ListView from './components/ListView'
import EditView from './components/EditView'
import CreateView from './components/CreateView'

export default [
  {
    path: '/',
    name: 'dashboard',
    component: Home
  }, {
    path: '/login',
    name: 'login',
    component: Login
  }, {
    path: '/:model',
    name: 'list',
    component: ListView
  }, {
    path: '/:model/create',
    name: 'create',
    component: CreateView
  }, {
    path: '/:model/:id',
    name: 'edit',
    component: EditView,
    children: [
      {
        path: ':sub',
        component: ListView,
        name: 'sub'
      }
    ]
  }
]
