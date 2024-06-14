export default defineNuxtPlugin((nuxtApp) => {
  // Access cookie for auth
  const cookie = useCookie('auth-token');

  // Watch the cookie and update the Apollo Client's token reactively
  watchEffect(() => {
    nuxtApp.hook('apollo:auth', ({ client, token }) => {
      // `client` can be used to differentiate logic on a per client basis.
      // Apply the latest token to the Apollo Client
      if (cookie.value) {
        token.value = cookie.value;
      }
    });
  });
});
