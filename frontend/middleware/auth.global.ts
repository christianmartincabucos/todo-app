import { defineNuxtRouteMiddleware, navigateTo, useCookie } from 'nuxt/app';

export default defineNuxtRouteMiddleware((to) => {
  const token = useCookie('auth-token').value;

  if (!token && to.path !== '/login') {
    return navigateTo('/login');
  } else if (token && (to.name === 'login' || to.name === 'index')) {
    if (to.path !== '/tasks') {
      return navigateTo('/tasks');
    }
  }
});
