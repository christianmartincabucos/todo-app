import { defineNuxtRouteMiddleware, navigateTo, useCookie } from 'nuxt/app';

export default defineNuxtRouteMiddleware((to) => {
  const token = useCookie('auth-token').value;

  // If the user is not logged in and is not on the login or register page, redirect to login
  if (!token && !['/login', '/register'].includes(to.path)) {
    return navigateTo('/login');
  }

  // If the user is logged in and is trying to access the login or home page, redirect to tasks
  if (token && (to.name === 'login' || to.name === 'index')) {
    return navigateTo('/tasks');
  }
});
