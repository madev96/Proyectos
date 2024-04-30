document.addEventListener('DOMContentLoaded', function() {

    /*PARA MOSTRAR /OCULTAR PREGUNTAS*/
    var toggleButton = document.getElementById('toggleButton');
    var collapseFAQ = document.getElementById('collapseFAQ');

    collapseFAQ.addEventListener('show.bs.collapse', function(event) {
        if (event.target.id === "collapseFAQ") {
            toggleButton.textContent = 'Ocultar';
        }
    });

    collapseFAQ.addEventListener('hide.bs.collapse', function(event) {
        if (event.target.id === "collapseFAQ") {
            toggleButton.textContent = 'Mostrar';
        }
    });

  
    
});
