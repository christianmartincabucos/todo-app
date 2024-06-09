// ~/plugins/apollo-client.js
import { ApolloClient, InMemoryCache } from '@apollo/client/core';
import { DefaultApolloClient } from '@vue/apollo-composable';
import { defineNuxtPlugin } from '#app';

export default defineNuxtPlugin((nuxtApp) => {
  const apolloClient = new ApolloClient({
    cache: new InMemoryCache(),
    uri: 'http://127.0.0.1:8000/graphql'
  });

  nuxtApp.vueApp.provide(DefaultApolloClient, apolloClient);
});
