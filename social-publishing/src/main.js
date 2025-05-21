import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import { createMemoryHistory, createRouter } from 'vue-router'
import PostsPage from "@/PostsPage.vue";
import LoginPage from "@/LoginPage.vue";
import EmptyPage from "@/EmptyPage.vue";
import PostCreationPage from "@/PostCreationPage.vue";
import PostPage from "@/PostPage.vue";
import PostEditPage from "@/PostEditPage.vue";
import UserPostPage from "@/UserPostPage.vue";

const routes = [
  { path: '/', component: EmptyPage},
  { path: '/login', component: LoginPage },
  { path: '/profile', component: UserPostPage },
  { path: '/posts', component: PostsPage },
  { path: '/posts/:id', component: PostPage },
  { path: '/posts/:id/edit', component: PostEditPage },
  { path: '/posts/create', component: PostCreationPage },
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
})

createApp(App).use(router).mount('#app')
