function validarFormulario(formulario) {
    // Obtener el valor de la cantidad específica del formulario
    var cantidadInput = formulario.querySelector('.cantidad-input');
    var cantidad = parseInt(cantidadInput.value);

    // Verificar que la cantidad sea mayor que cero
    if (cantidad <= 0) {
        mostrarMensaje('La cantidad debe ser mayor que cero', 'error');
        return false; // Evita que el formulario se envíe
    }

    // Otra lógica de validación si es necesario...

    return true; // Permite que el formulario se envíe si ha pasado todas las validaciones
}