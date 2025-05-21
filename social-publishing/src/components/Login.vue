<template>
  <div class="login">
    E-mail
    <input v-model="email" type="email">
    Password
    <input v-model="password" type="password">

    <button :disabled="!canSubmitForm" @click="login()">Login</button>
  </div>
</template>

<script>
import {authenticate, checkCurrentSession} from "@/api/auth.js";
import {storeUserData} from "@/helpers/auth.js";

export default {
  name: 'Login',
  data() {
    return {
      email: null,
      password: null,
    };
  },
  computed: {
    canSubmitForm() {
      return this.email && this.password;
    }
  },
  methods: {
    async login() {
      if (!this.canSubmitForm) {
        return;
      }

      try {
        const response = await authenticate(this.email, this.password)

        localStorage.token = response.data.token;

        const currentSessionResponse = await checkCurrentSession();

        storeUserData(
          currentSessionResponse.data.id,
          currentSessionResponse.data.name,
          currentSessionResponse.data.email,
        )

        this.$router.push('/posts')
      } catch (e) {
        alert('Failed to authenticate.')
      }
    }
  }
}
</script>


<style scoped>
.login {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
}
</style>
