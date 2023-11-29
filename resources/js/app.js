import './bootstrap'

import { createApp } from "vue"
import App from "./App.vue"
import router from "./router"
import { createPinia } from 'pinia'
import Notifications from '@kyvg/vue3-notification'
import { useAuthStore } from '@/stores/auth'
import Vue3VideoPlayer from '@cloudgeek/vue3-video-player'
import VuePdf from 'vue3-pdfjs'
import '@cloudgeek/vue3-video-player/dist/vue3-video-player.css'

/* Create Vue app */
const app = createApp(App)
app.use(createPinia())
app.use(Vue3VideoPlayer)
app.use(VuePdf)
// const { getUser } = useAuthStore()
// getUser().then(() => {
//     app.use(Notifications)
//     app.use(router)
//     app.mount('#app')
// })

app.use(Notifications)
app.use(router)
app.mount('#app')