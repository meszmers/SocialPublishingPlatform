<template>
  <div @click="redirectToPost(id)" class="post">
    <div>
      <span>{{ title }}</span>
      <p>{{ getContentPreview(content) }}</p>
    </div>

    <div>
      <span>Author: {{ author }}</span>
      <p>Categories: {{ getCategoriesText(categories) }}</p>
    </div>

  </div>
</template>

<script>
export default {
  name: "Post",
  props: {
    id: {
      required: true,
      type: Number,
    },
    title: {
      required: true,
      type: String,
    },
    content: {
      required: true,
      type: String,
    },
    author: {
      required: true,
      type: String,
    },
    categories: {
      type: Array,
      default: () => [],
    }
  },
  data() {
    return {};
  },
  methods: {
    redirectToPost(id) {
      this.$router.push(`/posts/${id}`)
    },
    getContentPreview(content) {
      return content.substring(0, 120) + (content.length > 60 ? '...' : '');
    },
    getCategoriesText(categories) {
      if (categories.length === 0) {
        return 'none'
      }

      return categories.map((category) => category.title).join(', ');
    }
  }
}
</script>

<style scoped>
.post {
  padding: 12px 12px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 24px;
}

.post:hover {
  cursor: pointer;
  background-color: #c7caca;
}

p {
  font-size: 16px;
}

</style>
