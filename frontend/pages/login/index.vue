<script setup>
import { ref } from 'vue';
import { LOGIN_MUTATION } from '@/graphql/user.mutations';
const visible = ref(false);
const email = ref('');
const password = ref(''); 
const router = useRouter();
const errorMessage = ref('');

const handleLogin = async () => {
  try {
      if(!email.value) {
        return errorMessage.value = "Email is required";
      } else if (!password.value) {
        return errorMessage.value = "Password is required";
      }
      errorMessage.value = '';
      const { mutate: login } = useMutation(LOGIN_MUTATION);
      const result = await login({
        email: email.value,
        password: password.value,
      });
      if (result.data && result.data.login && result.data.login.token) {
      const token = useCookie('auth-token');
      token.value = result.data.login.token;

      router.push('/tasks');
    } else {
      console.error('Login successful but no token received');
    }
  } catch (e) {
    errorMessage.value = 'An error occurred during login. Please try again.';
    console.error('Error during login:', e);
  }
}
</script>
<template>
  <div>
      <v-card class="mx-auto pa-12 pb-8 my-6" elevation="8" max-width="500" rounded="lg">
        <v-alert
          border="top"
          type="warning"
          variant="outlined"
          prominent
          class="my-2"
          :text="errorMessage"
          v-if="errorMessage"
        ></v-alert>
        <div class="text-subtitle-1 text-medium-emphasis">Email</div>

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
          <nuxt-link class="text-blue text-decoration-none" to="/register">
            Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
          </nuxt-link>
        </v-card-text>
      </v-card>
  </div>
</template>
