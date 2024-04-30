<script setup>
import { ref, reactive } from 'vue'
const taller = 'Taller la tuerca 🛠️'
//ref, que necesita value para editar el valor.
const servicio1 = ref('Básico')
const servicio2 = ref('Especial')

//actualiziao el servicio2
servicio2.value = 'Premium'

//reactive, que NO necesita value para editar el valor.
const repuesto1 = reactive({
  id: 1,
  nombre: 'filtro de aceite',
  precio: 100,
  disponibilidad: true
})

//actualiziao el respuesto1
repuesto1.disponibilidad = false
</script>

<template>
  <h1>{{ taller }}</h1>
  <h3>Servicios disponibles</h3>
  <ul>
    <li>{{ servicio1 }}</li>
    <li>{{ servicio2 }}</li>
  </ul>
  <hr />
  <h3>Repuestos</h3>
  <section>
    <p>{{ respuesto1.nombre }} ... {{ respuesto1.precio }} Euros</p>
  </section>
</template>

<style scoped>
h1,
h3,
p,
li {
  font-family: monospace;
}
section {
  display: flex;
}
</style>
