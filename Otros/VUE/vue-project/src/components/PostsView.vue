<script setup>
import { usePostsStore } from '../stores/PostsStore'
import PostCard from './PostCard.vue'

const postsStore = usePostsStore()
</script>

<template>
  <PostCard
    v-for="post in postsStore.post"
    :key="post.id"
    :titulo="post.titulo"
    :contenido="post.body"
  />
</template>

<style scoped></style>
