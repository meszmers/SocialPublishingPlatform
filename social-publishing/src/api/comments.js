import axios from "axios";

export async function submitComment(postId, comment) {
  return await axios.post(`http://localhost/api/posts/${postId}/comments`, {
    comment: comment,
  }, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}

export async function deleteComment(postId, commentId) {
  return await axios.delete(`http://localhost/api/posts/${postId}/comments/${commentId}`, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}
