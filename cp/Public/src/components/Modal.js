import _ from 'lodash'

export default {
  active: false,
  form: null,
  cb: null,
  data: {

  },
  show (data, dataObject, cb) {
    this.active = true
    this.cb = cb
    this.dataObject = dataObject
    this.form = data
  },
  disable () {
    this.active = false
    this.form = null
  },
  done () {
    if (this.cb) {
      this.cb(this.dataObject)
      this.disable()
    } else {
      this.disable()
    }
  },
  set (data) {
    _.set(this.dataObject, data.pointer, data.value)
  },
  value (fieldName) {
    return _.get(this.dataObject, fieldName)
  }
}
