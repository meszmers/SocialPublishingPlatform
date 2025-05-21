<template>
  <div>
    <Banner :user-name="userName"/>
    <PostInput
      @title="updateTitle"
      @content="updateContent"
      @selectedCategories="updateSelectedCategories"
    />
    <button @click="createPost()" :disabled="!canSubmitForm">Submit</button>
  </div>
</template>
<script>
import Banner from "@/components/Banner.vue";
import {getCategories} from "@/api/categories.js";
import {createPost} from "@/api/posts.js";
import PostInput from "@/components/PostInput.vue";

export default {
  name: "PostCreationPage",
  components: {PostInput, Banner},
  data() {
    return {
      title: null,
      content: null,
      userName: localStorage.userName,
      selectedCategories: [],
    };
  },
  async created() {
    try {
      const response = await getCategories();

      this.categories = response.data;
    } catch (e) {
      alert('Could not fetch categories.')
    }

  },
  methods: {
    updateTitle(value) {
      this.title = value;
    },
    updateContent(value) {
      this.content = value;
    },
    updateSelectedCategories(value) {
      this.selectedCategories = value;
    },
    canSubmitForm() {
      return this.title && this.content
    },
    async createPost() {
      try {
        await createPost(this.title, this.content, this.selectedCategories);

        this.$router.push('/posts')
      } catch (e) {
        alert('Could not create a new post.')
      }
    }
  }
}
</script>
<style scoped>
</style>
