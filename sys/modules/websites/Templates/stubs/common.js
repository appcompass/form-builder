import axios from 'axios'
// each of these calls can prob be abstracted a bit too.
let makeCall = (context, url, cb) => {
  return axios.create({
    // we need a more portable way of doing this...
    baseURL: process.env.BASE_URL || '/api'
  }).get(url)
  .then((res) => {
    if (cb) {
      cb(res)
    }
    return res.data
  })
}

export default {
  getPageData (context) {
    let promises = [
      makeCall (context, `/content/site-meta`),
      makeCall (context, `/content/menus`),
      makeCall (context, `/content${context.route.path}`, (res) => {
        res.data.current_url = context.route.path
      })
    ]

    return Promise.all(promises).then((data) => {
      let pageData = data[2]
      pageData.site_meta = data[0]
      pageData.menus = data[1]

      return pageData
    }).catch((e) => {
      context.error({ statusCode: 404, message: e.message + ' api endpoint: "' + e.config.url + '" not reachable.' });
    });
  }
}
