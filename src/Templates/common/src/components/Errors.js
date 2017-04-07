import _ from 'lodash'

class Errors {

  constructor () {
    this.errors = Object.create({})
  }

  set (errors) {
    this.errors = Object.assign({}, errors)
  }

  get (path) {
    if (_.isEmpty(this.errors)) { return }
    if (path == null) {
      return this.errors
    }
    return _.get(this.errors, path)
  }

  unset (path) {
    if (!this.errors) {
      return
    }
    _.unset(this.errors, path)
    this.errors = Object.assign({}, this.errors)
  }
}

export default Errors

