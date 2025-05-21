<template>
  <div>
    <Banner :user-name="userName"/>
    <PostInput
      :default-title="this.title"
      :default-content="this.content"
      :default-selected-categories="this.selectedCategories"
      @title="updateTitle"
      @content="updateContent"
      @selectedCategories="updateSelectedCategories"
    />
    <button @click="editPost()" :disabled="!canSubmitForm">Submit</button>
  </div>
</template>
<script>
import Banner from "@/components/Banner.vue";
import {getCategories} from "@/api/categories.js";
import {editPost, getPost} from "@/api/posts.js";
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

    try {
      const postResponse = await getPost(this.$route.params.id)

      this.title = postResponse.data.title;
      this.content = postResponse.data.content;
      this.selectedCategories = postResponse.data.categories.map(function (category) {
        return Number(category.id);
      });

    } catch (e) {
      alert('Could not fetch post for an edit.')
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
    async editPost() {
      try {
        await editPost(this.$route.params.id, this.title, this.content, this.selectedCategories);

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
