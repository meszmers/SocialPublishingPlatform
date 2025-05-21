import axios from "axios";

export async function getPost(id) {
  return await axios.get(`http://localhost/api/posts/${id}`, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}

export async function getPosts() {
  return await axios.get(`http://localhost/api/posts`, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}

export async function getUserPosts() {
  return await axios.get(`http://localhost/api/user/posts`, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}

export async function createPost(title, content, categories = []) {
  return await axios.post(`http://localhost/api/posts`, {
    title: title,
    content: content,
    categories: categories,
  }, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}

export async function editPost(id, title, content, categories = []) {
  console.log(content)

  return await axios.post(`http://localhost/api/posts/${id}`, {
    title: title,
    content: content,
    categories: categories,
  }, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}
