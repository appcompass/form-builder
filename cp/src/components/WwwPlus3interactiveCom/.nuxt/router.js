'use strict'

import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)


const _73ff7a04 = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/index.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/index.vue')

const _429c41af = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/company.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/company.vue')

const _63599fd2 = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/contact.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/contact.vue')

const _11496f90 = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/projects.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/projects.vue')

const _7ae9724c = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions.vue')

const _36b20fcf = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/index.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/index.vue')

const _7ca8be2b = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/our-process.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/solutions/our-process.vue')

const _29ecfff8 = process.BROWSER_BUILD ? () => System.import('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/customer-login.vue') : require('/var/www/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/pages/customer-login.vue')


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
			component: _73ff7a04,
			name: "index"
		},
		{
			path: "/company",
			component: _429c41af,
			name: "company"
		},
		{
			path: "/contact",
			component: _63599fd2,
			name: "contact"
		},
		{
			path: "/projects",
			component: _11496f90,
			name: "projects"
		},
		{
			path: "/solutions",
			component: _7ae9724c,
			children: [
				{
					path: "",
					component: _36b20fcf,
					name: "solutions"
				},
				{
					path: "our-process",
					component: _7ca8be2b,
					name: "solutions-our-process"
				}
			]
		},
		{
			path: "/customer-login",
			component: _29ecfff8,
			name: "customer-login"
		}
  ]
})
