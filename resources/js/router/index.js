import { createRouter, createWebHistory } from "vue-router"
import { useAuthStore } from '@/stores/auth'
import { useTesStore } from "@/stores/tes"
import routes from '@/router/routes.js'

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  const { isAuthenticated, isAuthenticatedSiswa } = useAuthStore()
  const { isRunningTest } = useTesStore()


  const adminRoute = to.matched.some((record) => record.meta.admin)
  const privateRoute = to.matched.some((record) => !record.meta.public)
  const publicRoute = to.matched.some((record) => record.meta.public)

  if(adminRoute) {
    if (privateRoute && !isAuthenticated) {
      next('/admin/login')
    }
    else if (publicRoute && isAuthenticated) {
      next('/admin')
    }
    else next()
  }else{
    if (privateRoute && !isAuthenticatedSiswa) {
      next('/login')
    }else if (publicRoute && isAuthenticatedSiswa) {
      next('/')
    }
    else next()
  }

});

export default router;
