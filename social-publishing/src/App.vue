<template>
  <main>
    <router-view/>
  </main>
</template>

<script>
import {defineComponent} from "vue";
import {checkCurrentSession} from "@/api/auth.js";
import {storeUserData} from "@/helpers/auth.js";

export default defineComponent({
  data() {
    return {
      user: null
    };
  },
  async created() {
    await this.checkAuth();
  },
  methods: {
    async checkAuth() {
      if (!localStorage.token) {
        this.$router.push('/login')
      }

      try {
        const response = await checkCurrentSession();

        storeUserData(response.data.id, response.data.name, response.data.email)

        this.$router.push('/posts')
      } catch (e) {
        localStorage.token = null;

        this.$router.push('/login')
      }
    }
  }
})
</script>

<style scoped>
header {
  line-height: 1.5;
}

main {
  padding: 32px;
  margin: 32px;
  color: black;
  background-color: #cbd5e0;
  border-radius: 12px;
  height: 100%;
}
</style>
