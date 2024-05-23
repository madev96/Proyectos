import { defineStore } from 'pinia'
import { ref } from 'vue'
import posteos from '../data/posts.json'

export const usePostStore = defineStore('PostsStore', () => {
  const posts = ref(posteos)

  return { posts }
})
