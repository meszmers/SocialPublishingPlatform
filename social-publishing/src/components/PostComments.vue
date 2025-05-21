<template>
  <div class="comments">
    <div class="comments-container">
      <h2>Comments</h2>
      <div class="comment" v-for="comment in comments">
        <div>
          <h2>{{ comment.author }}</h2>
          <span>{{ comment.comment }}</span>
        </div>
        {{ comment.created_at }}
        <button class="button-red" v-if="isCurrentUsersComment(comment)" @click="deleteComment(comment)">Delete</button>
      </div>
    </div>

    <div class="new-comment">
      Create a comment
      <textarea v-model="newComment"/>
      <button @click="submitComment" :disabled="!newComment">Submit</button>
    </div>
  </div>
</template>

<script>
import {deleteComment, submitComment} from "@/api/comments.js";

export default {
  name: "PostComments",
  props: {
    comments: {
      required: true,
      default: () => []
    }
  },
  data() {
    return {
      newComment: null,
    }
  },
  methods: {
    isCurrentUsersComment(comment) {
      return Number(localStorage.userId) === Number(comment.user_id);
    },
    async submitComment() {
      try {
        await submitComment(this.$route.params.id, this.newComment)
        this.$emit('afterAction');
      } catch (e) {
        alert('Could not submit a comment.')
      }
    },
    async deleteComment(comment) {
      try {
        await deleteComment(this.$route.params.id, comment.id)

        this.$emit('afterAction');
      } catch (e) {
        alert('Could not delete a comment.')
      }
    }
  }
}
</script>

<style scoped>
.comments-container {
  margin-bottom: 12px;
}

.comment {
  display: flex;
  justify-content: space-between;
  border: 1px solid gray;
  padding: 12px;
  gap: 12px;
}

.new-comment {
  display: flex;
  flex-direction: column;
}

.button-red {
  background-color: red;
}
</style>
