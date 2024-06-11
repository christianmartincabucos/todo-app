<script setup>
import { ref } from 'vue';
import { REGISTRATION_MUTATION } from '@/graphql/user.mutations';
const visible = ref(false);
const form = ref({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
});
const errorMessage = ref('');
const router = useRouter();

const handleRegister = async () => {
  try {
    // Validation checks
    if (!form.value.name) {
      return errorMessage.value = "Name is required";
    } else if (!form.value.email) {
      return errorMessage.value = "Email is required";
    } else if (!form.value.password) {
      return errorMessage.value = "Password is required";
    } else if (!form.value.password_confirmation) {
      return errorMessage.value = "Confirm Password is required";
    }

    // Reset error message
    errorMessage.value = '';

    // Perform registration mutation
    const { mutate: register } = useMutation(REGISTRATION_MUTATION);
    const result = await register({
      name: form.value.name,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.password_confirmation,
    });

    // Check if the registration was successful and the token is received
    if (result.data && result.data.register && result.data.register.token) {
      // Set the token in a cookie
      const token = useCookie('auth-token');
      token.value = result.data.register.token;

      // Redirect to the tasks page
      router.push('/tasks');
    } else {
      // Handle case where token is not received
      console.error('Registration successful but no token received');
    }
  } catch (e) {
    // Handle errors from the registration process
    console.error('Error during registration:', e);
    errorMessage.value = 'An error occurred during registration. Please try again.';
  }
}

</script>
<template>
  <div>
    <v-img class="mx-auto my-6" max-width="228"
      src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"></v-img>

    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="500" rounded="lg">
      <v-alert
          border="top"
          type="warning"
          variant="outlined"
          prominent
          class="my-2"
          :text="errorMesssage"
          v-if="errorMesssage"
        ></v-alert>
      <div class="text-subtitle-1 text-medium-emphasis">Name</div>

      <v-text-field density="compact" placeholder="Name" prepend-inner-icon="mdi-account-outline"
        variant="outlined" v-model="form.name"></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis">Email</div>

      <v-text-field density="compact" placeholder="Email address" prepend-inner-icon="mdi-email-outline"
        variant="outlined" v-model="form.email"></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Password
      </div>

      <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
        density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline" variant="outlined"
        @click:append-inner="visible = !visible" v-model="form.password"></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Confirm Password
      </div>

      <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
        density="compact" placeholder="Enter your confirm password" prepend-inner-icon="mdi-lock-outline" variant="outlined"
        @click:append-inner="visible = !visible" v-model="form.password_confirmation">
      </v-text-field>

      <v-btn block class="mb-8" color="blue" size="large" variant="tonal" @click="handleRegister">
        Register
      </v-btn>

      <v-card-text class="text-center">
        <nuxt-link class="text-blue text-decoration-none" rel="noopener noreferrer" to="/login">
          Login now <v-icon icon="mdi-chevron-right"></v-icon>
        </nuxt-link>
      </v-card-text>
    </v-card>
  </div>
</template>
