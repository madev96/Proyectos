window.addEventListener('DOMContentLoaded', event => {
    const btnComprobar = document.getElementById('comprobar');
    
    // Agrega un event listener para el evento 'click'
    btnComprobar.addEventListener('click', function() {
        validarMatricula();
    });

    function validarMatricula() {
        // Obtener el valor del campo de la matrícula
        var matricula = document.getElementById('matricula').value.trim();
        
        // Verificar si la matrícula está vacía
        if (matricula === '') {
            // Mostrar un mensaje de error o realizar alguna acción indicando que la matrícula está vacía
            console.log('La matrícula está vacía');
            return false;
        }

        // Verificar si la matrícula tiene un formato válido (aquí puedes usar expresiones regulares)
        // Por ejemplo, si quieres una matrícula en el formato '1234ABC', podrías usar la siguiente expresión regular:
        var regexMatricula = /^[0-9]{4}[A-Z]{3}$/;
        if (!regexMatricula.test(matricula)) {
            // Mostrar un mensaje de error o realizar alguna acción indicando que la matrícula no tiene el formato correcto
            console.log('La matrícula no tiene el formato correcto');
            return false;
        }

        // Si la matrícula pasa todas las validaciones, puedes permitir el envío del formulario
        console.log('Matrícula válida. Enviar formulario...');
        return true;
    }
});
