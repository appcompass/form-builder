import axios from 'axios'

// @NOTE you never pass parameters to the Store
// @TODO look into Vue2.3 exceptions handling, loogs awesome
// @TODO we could just catch 422s and append them to the store.Form

const request = axios.create({
  baseURL: 'https://www.plus3interactive.com/api/',
  timeout: 1000
})

export const fetchContent = ({ commit, state }) => {
  return request.get('content' + state.route.fullPath).then((response) => {
    commit('CONTENT', response.data.content)
  }, (response) => {
    response
    console.log('404')
  })
}

export const menus = ({ commit, state }) => {
  return request.get('content/menus/')
    .then(response => {
      commit('MENUS', response.data)
    }).catch(response => {
      response
    })
}

export const form = ({ commit, state }) => {
  // @NOTE a component needs to set formName before dispatching the action
  // @TODO not a particular fan of this way of declaring the formName, but it's handy for now
  return request.get(`web-forms/${state.formName}/`)
    .then(response => {
      commit('FORM', response.data)
    }).catch(response => {
    })
}

export const submit = ({ commit, state }) => {
  return request.post(`web-forms/${state.formName}/`, state.form.collection)
    .then(response => {
      commit('SUBMIT', response)
    }).catch((response, other) => {
      state.form.fails(response.response.data)
    })
}
