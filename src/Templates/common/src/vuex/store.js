import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import Form from '../components/Form'
import FormsJquery from '../assets/js/forms.js'

Vue.use(Vuex)

const defaultState = {
  content: {},
  meta: {},
  sitemeta: {},
  formName: undefined,
  form: new Form(),
  count: 0
}

const inBrowser = typeof window !== 'undefined'

// if in browser, use pre-fetched state injected by SSR
const state = (inBrowser && window.__INITIAL_STATE__) || defaultState

const mutations = {
  CONTENT: (state, content) => {
    state.content = content
  },

  META: (state, meta) => {
    state.meta = meta
  },

  MENUS: (state, menus) => {
    state.menus = menus
  },

  SITEMETA: (state, sitemeta) => {
    state.sitemeta = sitemeta
  },

  FORM: (state, formData) => {
    let form = new Form()
    form.init(formData)
    state.form = form
    setTimeout(() => {
      FormsJquery.init()
    }, 200)
  },

  SUBMIT: (state, response) => {
    // @TODO we are now using form name to get the submit endpoint
    // this needs to carried suggested by the form itself so we can delegate 100% to Form.js
    console.log(response)
    return 'foooo'
  }
}

export default new Vuex.Store({
  state,
  actions,
  mutations,
  getters
})
