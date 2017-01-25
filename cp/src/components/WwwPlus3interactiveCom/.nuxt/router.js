'use strict'

import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)


const _aeff8f4a = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/index.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/index.vue')

const _59e6c646 = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/company.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/company.vue')

const _7aa42469 = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/contact.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/contact.vue')

const _6d3d52fe = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/projects.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/projects.vue')

const _2cb5a5ba = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions.vue')

const _21960d66 = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/index.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/index.vue')

const _2da7ee82 = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/our-process.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/our-process.vue')

const _e75118fe = process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/customer-login.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/customer-login.vue')


const scrollBehavior = (to, from, savedPosition) => {
  if (savedPosition) {
    // savedPosition is only available for popstate navigations.
    return savedPosition
  } else {
    let position = {}
    // if no children detected
    if (to.matched.length < 2) {
      position = { x: 0, y: 0 }
    }
    else if (to.matched.some((r) => r.components.default.scrollToTop || (r.components.default.options && r.components.default.options.scrollToTop))) {
      position = { x: 0, y: 0 }
    }
    // if link has anchor,  scroll to anchor by returning the selector
    if (to.hash) {
      position = { selector: to.hash }
    }
    return position
  }
}

export default new Router({
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  scrollBehavior,
  routes: [
		{
			path: "/",
			component: _aeff8f4a,
			name: "index"
		},
		{
			path: "/company",
			component: _59e6c646,
			name: "company"
		},
		{
			path: "/contact",
			component: _7aa42469,
			name: "contact"
		},
		{
			path: "/projects",
			component: _6d3d52fe,
			name: "projects"
		},
		{
			path: "/solutions",
			component: _2cb5a5ba,
			children: [
				{
					path: "",
					component: _21960d66,
					name: "solutions"
				},
				{
					path: "our-process",
					component: _2da7ee82,
					name: "solutions-our-process"
				}
			]
		},
		{
			path: "/customer-login",
			component: _e75118fe,
			name: "customer-login"
		}
  ]
})
