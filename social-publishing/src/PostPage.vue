<template>
  <div v-if="post" class="post-page">
    <Banner :user-name="userName"/>
    <h1>{{ post.title }}</h1>
    <h2>Author: {{ post.author }}</h2>
    <p>{{ post.content }}</p>
    <div>
      Categories: {{ getCategoriesDisplayText(post.categories) }}
    </div>
    <button class="edit-button" v-if="Number(userId) === Number(post.user_id)" @click="redirectToEditPage()">Edit
    </button>

    <PostComments @afterAction="fetchPost" :comments="post.comments" />
  </div>
</template>

<script>
import Banner from "@/components/Banner.vue";
import {getPost} from "@/api/posts.js";
import PostComments from "@/components/PostComments.vue";

export default {
  name: 'PostPage',
  components: {PostComments, Banner},
  data() {
    return {
      userId: localStorage.userId,
      userName: localStorage.userName,
      post: null,
    }
  },
  async created() {
    await this.fetchPost();
  },
  methods: {
    async fetchPost() {
      try {
        const response = await getPost(this.$route.params.id);

        this.post = response.data;
      } catch (e) {
        alert('Could not fetch post.')
      }
    },
    redirectToEditPage() {
      this.$router.push(`/posts/${this.$route.params.id}/edit`)
    },
    getCategoriesDisplayText(categories) {
      return categories.map((category) => category.title).join(', ');
    }
  }
}
</script>

<style scoped>
.post-page {
  padding: 12px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.edit-button {
  width: 100px;
}
</style>
