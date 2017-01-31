import axios from 'axios'
// each of these calls can prob be abstracted a bit too.
let makeCall = (context, url, cb) => {
  return axios.get(url)
  .then((res) => {
    if (cb) {
      cb(res)
    }
    return res.data
  }).catch((e) => {
    return context.error({ statusCode: 404, message: e.message })
  })
}

export default {
  getPageData (context) {
    let promises = [
      makeCall (context, `${process.env.BASE_URL}/content/site-meta`),
      makeCall (context, `${process.env.BASE_URL}/content/menus`),
      makeCall (context, `${process.env.BASE_URL}/content${context.route.path}`, (res) => {
        res.data.current_url = context.route.path
      })
    ]

    return Promise.all(promises).then((data) => {
      let pageData = data[2]
      pageData.site_meta = data[0]
      pageData.menus = data[1]

      return pageData
    });
  }
}
