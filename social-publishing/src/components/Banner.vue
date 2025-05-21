<template>
  <div class="banner">
    <div class="banner-group">
      <div @click="redirectToHome()" class="button">
        Home
      </div>
      <div @click="redirectToPostCreation()" class="button">
        Create new post
      </div>
    </div>
    <div class="banner-group">
      <div>
        {{ userName }}
      </div>
      <img
        class="pointer"
        @click="redirectToUserProfile()"
        alt="user"
        width="25"
        height="25"
        src="../assets/user.svg"
      >
      <div @click="logout()" class="button">
        Logout
      </div>
    </div>

  </div>
</template>

<script>
import {logoutFromCurrentSession} from "@/api/auth.js";
import {clearUserData} from "@/helpers/auth.js";

export default {
  name: "Banner",
  props: {
    userName: {
      required: true,
      type: String,
    }
  },
  methods: {
    redirectToHome() {
      this.$router.push('/posts');
    },
    redirectToPostCreation() {
      this.$router.push('/posts/create');
    },
    redirectToUserProfile() {
      this.$router.push('/profile')
    },
    async logout() {
      try {
        await logoutFromCurrentSession();

        localStorage.token = null;
        clearUserData();

        this.$router.push('/login')
      } catch (e) {
        alert('Failed to logout from current session.')
      }
    }
  }
}
</script>

<style scoped>
.banner {
  width: 100%;
  height: 100px;
  background-color: #629f94;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
  gap: 12px;
  padding: 12px;
}

.banner-group {
  display: flex;
  align-items: center;
  gap: 12px;
}

.button {
  background-color: black;
  color: white;
  padding: 12px 16px;
  border-radius: 12px;
  cursor: pointer;
}

.pointer {
  cursor: pointer;
}
</style>
