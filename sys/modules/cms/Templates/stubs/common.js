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
    // @TODO: needs better handling.
    var page_url = context ? context.route.path : '/404';
    let promises = [
      makeCall (context, `/content${page_url}`, (res) => {
        res.data.current_url = page_url
      }),
      makeCall (context, `/content/site-meta`),
      makeCall (context, `/content/menus`)
    ]

    return Promise.all(promises).then((data) => {
      let pageData = data[0]
      pageData.site_meta = data[1]
      pageData.menus = data[2]

      return pageData
    }).catch((e) => {
      context.error({ statusCode: 404, message: e.message + ' api endpoint: "' + e.config.url + '" not reachable.' });
    });
  }
}
