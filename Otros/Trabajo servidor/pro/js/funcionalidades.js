document.addEventListener('DOMContentLoaded', function() {
    const productos = document.querySelectorAll('.product');

    productos.forEach(producto => {
        const aumentarBtn = producto.querySelector('.aumentar');
        const disminuirBtn = producto.querySelector('.disminuir');
        const cantidadInput = producto.querySelector('.cantidad-input');

        aumentarBtn.addEventListener('click', function() {
            let cantidad = parseInt(cantidadInput.value) || 0;
            cantidad++;
            cantidadInput.value = cantidad;

            // Debugging statement
            console.log('Cantidad aumentada:', cantidad);
        });

        disminuirBtn.addEventListener('click', function() {
            let cantidad = parseInt(cantidadInput.value) || 0;
            if (cantidad > 0) {
                cantidad--;
                cantidadInput.value = cantidad;

                // Debugging statement
                console.log('Cantidad disminuida:', cantidad);
            }
        });
    });
});


