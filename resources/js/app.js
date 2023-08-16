import './bootstrap'

import { createApp } from "vue"
import App from "./App.vue"
import router from "./router"
import { createPinia } from 'pinia'
import Notifications from '@kyvg/vue3-notification'
import { useAuthStore } from '@/stores/auth'

/* Create Vue app */
const app = createApp(App)
app.use(createPinia())
const { getUser } = useAuthStore()
getUser().then(() => {
    app.use(Notifications)
    app.use(router)
    app.mount('#app')
})