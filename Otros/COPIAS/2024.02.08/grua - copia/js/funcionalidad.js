// Función para alternar el modo claro y oscuro
function toggleDarkMode() {
    const body = document.querySelector('body');
    const header = document.querySelector('header');
    
    // Alternar la clase 'dark-mode' en el body y header
    body.classList.toggle('dark-mode');
    header.classList.toggle('dark-mode');
    
    // Puedes agregar más elementos aquí para cambiar al modo nocturno
    
    // Guardar la preferencia del modo en localStorage
    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
}

// Verificar la preferencia del modo al cargar la página
window.onload = function() {
    const isDarkMode = localStorage.getItem('darkMode');
    const body = document.querySelector('body');
    const header = document.querySelector('header');

    // Si la preferencia existe, aplicar el modo correspondiente
    if (isDarkMode === 'true') {
        body.classList.add('dark-mode');
        header.classList.add('dark-mode');
    }
};


