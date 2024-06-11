<template>
  <v-layout>
    <v-app-bar class="mx-auto">
      <v-spacer></v-spacer>
      <v-app-bar-title>
        <nuxt-link class="text-white px-2  text-decoration-none" to="/">
          TODO
        </nuxt-link>
      </v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn 
        v-if="isAuthenticated"
        class="mx-2"
        color="white"
        rounded="lg"
        variant="text"
      >
        Tasks
      </v-btn>
      <v-btn icon
        id="menu-activator"
        class="mx-2"
        color="white"
        rounded="lg"
      >
        <v-icon>mdi-account</v-icon>
      </v-btn>
      <v-menu 
        transition="scale-transition"
        activator="#menu-activator">
        <v-list>
          <v-list-item v-if="!isAuthenticated">
            <v-list-item-title color="white">
              <nuxt-link class="text-white px-2 text-decoration-none" to="/login">
                LOGIN
              </nuxt-link>
            </v-list-item-title>
          </v-list-item>
          <v-list-item v-if="!isAuthenticated">
            <v-list-item-title>
              <nuxt-link class="text-white px-2  text-decoration-none" to="/register">
                REGISTER
              </nuxt-link>
            </v-list-item-title>
          </v-list-item>
          <v-list-item v-if="isAuthenticated">
            <v-list-item-title>
              <nuxt-link class="text-white px-2 text-decoration-none cursor-pointer" @click="logout">
                LOGOUT
              </nuxt-link>
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-spacer></v-spacer>
    </v-app-bar>
    <v-main>
      <v-container class="py-16" fluid>
          <slot />
      </v-container>
    </v-main>
  </v-layout>
</template>
<script setup>
import { ref } from 'vue';
import { useCookie, navigateTo } from 'nuxt/app';

const authToken = useCookie('auth-token');
const isAuthenticated = computed(() => !!authToken.value);

const logout = async () => {
  authToken.value = null;
  isAuthenticated.value = false;

  navigateTo('/login');
};
</script>

