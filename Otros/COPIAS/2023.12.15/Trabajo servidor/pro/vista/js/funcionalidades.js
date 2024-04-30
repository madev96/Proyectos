document.addEventListener('DOMContentLoaded', function() {
    const aumentarBtns = document.querySelectorAll('.aumentar');
    const disminuirBtns = document.querySelectorAll('.disminuir');
    
    aumentarBtns.forEach(aumentarBtn => {
        aumentarBtn.addEventListener('click', function() {
            const cantidadInput = this.parentElement.querySelector('.cantidad-input');
            let cantidad = parseInt(cantidadInput.value) || 0;
            cantidad++;
            cantidadInput.value = cantidad;
        });
    });
    
    disminuirBtns.forEach(disminuirBtn => {
        disminuirBtn.addEventListener('click', function() {
            const cantidadInput = this.parentElement.querySelector('.cantidad-input');
            let cantidad = parseInt(cantidadInput.value) || 0;
            if (cantidad > 0) {
                cantidad--;
                cantidadInput.value = cantidad;
            }
        });
    });
});
