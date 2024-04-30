<script setup>
import { ref, reactive, computed } from 'vue'
const taller = 'Taller la tuerca 🛠️'
//ref, que necesita value para editar el valor.
const servicio1 = ref('Básico')
const servicio2 = ref('Especial')

//actualizado el servicio2
servicio2.value = 'Premium'

//reactive, que NO necesita value para editar el valor.
const repuesto1 = reactive({
  id: 1,
  nombre: 'Filtro de aceite',
  precio: 100,
  disponibilidad: true
})

//actualizado el repuesto1
repuesto1.disponibilidad = false //si se cambia aquí, cambia el icono

//propiedad conmutada (sñolo se evalua automáticamente cuando cambia algo))
const evaluaPrecio = computed(() => {
  return repuesto1.precio < 120 ? 'Oferta!!' : 'Precio regular'
})
//Evaluar la disponibilidad
const evaluarDisponibilidad = () => {
  return repuesto1.disponibilidad ? '👍' : '🤬'
}
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
    <p>{{ evaluarDisponibilidad() }}</p>
    <p>{{ repuesto1.nombre }} ... {{ repuesto1.precio }} Euros</p>
    <p>- {{ evaluaPrecio }}</p>
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
