import type { NuxtPage } from "nuxt/schema"

export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@nuxtjs/apollo'],
  css: [
    'vuetify/lib/styles/main.sass',
    '@mdi/font/css/materialdesignicons.min.css'
  ],
  build: {
    transpile: ['vuetify']
  },
  apollo: {
    clients: {
      default: {
        httpEndpoint: 'http://127.0.0.1:8000/graphql',
      }
    },
  },
})
