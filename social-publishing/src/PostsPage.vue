<template>
  <div>
    <Banner :user-name="userName"/>
    <div class="posts-container">
      <div class="post" v-for="post in posts">
        <Post
          :id="post.id"
          :title="post.title"
          :content="post.content"
          :author="post.author"
          :categories="post.categories"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Post from "@/components/Post.vue";
import Banner from "@/components/Banner.vue";
import {getPosts} from "@/api/posts.js";

export default {
  name: "PostsPage",
  components: {Banner, Post},
  data() {
    return {
      userName: localStorage.userName,
      posts: [],
      currentPage: 1,
    };
  },
  async created() {
    await this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await getPosts()

        this.posts = response.data.posts;
      } catch (e) {
        alert('Could not fetch posts.')
      }
    }
  }
};
</script>

<style scoped>
.posts-container {
  margin: 12px 0;
  padding: 12px 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.post {
  border: gray solid 1px;
}
</style>
