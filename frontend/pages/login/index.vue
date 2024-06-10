<script setup>
import { ref } from 'vue';
import { LOGIN_MUTATION } from '@/graphql/user.mutations';
const visible = ref(false);
const email = ref('');
const password = ref(''); 
const router = useRouter();

const handleLogin = async () => {
  try {
      const { mutate: login } = useMutation(LOGIN_MUTATION);
      const result = await login({
        email: email.value,
        password: password.value,
      });
      console.log(result.data.login.token);
      const token = useCookie('auth-token'); // useCookie new hook in nuxt 3
      token.value = result.data.login.token;
      router.push('/tasks');
  } catch (e) {
      console.error('Error login :', e);
  }
}
</script>
<template>
  <div>
    <v-img class="mx-auto my-6" max-width="228"
      src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"></v-img>

    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
      <div class="text-subtitle-1 text-medium-emphasis">Account</div>

      <v-text-field density="compact" placeholder="Email address" prepend-inner-icon="mdi-email-outline"
        variant="outlined" v-model="email"></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Password

        <a class="text-caption text-decoration-none text-blue" href="#" rel="noopener noreferrer" target="_blank">
          Forgot login password?</a>
      </div>

      <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
        density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline" variant="outlined"
        @click:append-inner="visible = !visible" v-model="password"></v-text-field>

      <v-btn block class="mb-8" color="blue" size="large" variant="tonal" @click="handleLogin">
        Log In
      </v-btn>

      <v-card-text class="text-center">
        <a class="text-blue text-decoration-none" href="#" rel="noopener noreferrer" target="_blank">
          Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
        </a>
      </v-card-text>
    </v-card>
  </div>
</template>
