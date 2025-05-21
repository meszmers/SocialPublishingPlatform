<template>
  <div class="post-input-container">
    <h3>Title</h3>
    <input v-model="title" type="text">

    <h3>Content</h3>
    <textarea v-model="content" />

    <h3>Categories</h3>
    <div class="category" v-for="category in categories" :key="category.id">
      <label :for="'category-' + category.id">{{ category.title }}</label>
      <input
        v-model="selectedCategories"
        type="checkbox"
        :value="Number(category.id)"
      >
    </div>
  </div>
</template>

<script>
import {getCategories} from "@/api/categories.js";

export default {
  name: 'PostInput',
  props: {
    defaultTitle: {
      type: String,
      default: null
    },
    defaultContent: {
      type: String,
      default: null
    },
    defaultSelectedCategories: {
      type: Array,
      default: () => []
    },
  },
  data() {
    return {
      title: null,
      content: null,
      userName: localStorage.userName,
      categories: [],
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
  watch: {
    title: function(value) {
      this.$emit('title', value);
    },
    content: function(value) {
      this.$emit('content', value);
    },
    selectedCategories: function(value) {
      this.$emit('selectedCategories', value);
    },
    defaultTitle: {
      handler(title) {
        if (this.title === title) {
          return;
        }

        this.title = title;
      },
      immediate: true
    },
    defaultContent: {
      handler(content) {
        if (this.content === content) {
          return;
        }

        this.content = content;
      },
      immediate: true
    },
    defaultSelectedCategories: {
      handler(categories) {
        if (this.selectedCategories === categories) {
          return;
        }

        this.selectedCategories = [...categories];
      },
      immediate: true
    },
  }
}
</script>

<style scoped>
.post-input-container {
  padding: 12px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

textarea {
  height: 200px;
}

.category {
  display: flex;
  align-items: center;
  gap: 6px;
}
</style>
