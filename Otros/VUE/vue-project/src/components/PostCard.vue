<script setup>
defineProps({
  titulo: String,
  contenido: String
})
</script>

<template>
  <section class="card">
    <article class="card-title">
      {{ titulo }}
    </article>
    <article class="card-content">
      {{ contenido }}
    </article>
  </section>
</template>

<style scoped>
.card {
  width: 380px;
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 4px black;
  margin: 10px auto;
}
</style>
