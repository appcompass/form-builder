import { app, router, store } from './app'

// the store actions we fire at load
let initActions = ['menus', 'fetchContent']

const meta = app.$meta()

export default context => {
  // set router's location
  router.push(context.url)
  // measure request time
  const s = Date.now()
  // call prefetch hooks on components matched by the route
  return Promise.all(router.getMatchedComponents().map(component => {
    if (component.prefetch) {
      return component.prefetch(store)
    }
  })).then(() => {
    // @TODO for some reason catch doesn't seem to get hit
    return Promise.all(initActions.map(action => { return store.dispatch(action) })).then(response => {
      context.initialState = store.state
      // pass state through
      context.state = store.state
      context.meta = meta
      console.log(`data loading: ${Date.now() - s}ms`)
      return app
    }).catch(error => {
      console.log(error)
    })
  })
}
