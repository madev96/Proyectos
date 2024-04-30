
window.addEventListener('DOMContentLoaded', event => {
    // Selecciona el botón por su ID
    const botonCalcular = document.getElementById('calcularBoton');

    // Agrega un event listener para el evento 'click'
    botonCalcular.addEventListener('click', function() {
        calcular();
    });
});

function calcular() {
const opcionSeleccionada = document.querySelector('input[name="opciones"]:checked');
const fechaEntrada = new Date(document.getElementById('fechaEntrada').value);
const fechaSalida = new Date(document.getElementById('fechaSalida').value);
const resultado = document.getElementById('resultado');
const resultado2 = document.getElementById('resultado2');
resultado.textContent = '';
resultado2.textContent = '';

if (!opcionSeleccionada) {
    resultado.textContent = "Por favor, selecciona tipo de vehículo.";
    return;
}

if (!fechaEntrada || !fechaSalida) {
    resultado2.textContent = "Por favor, ingresa fechas válidas.";
    return;
}

if (fechaEntrada >= fechaSalida) {
    resultado2.textContent = "La fecha de entrada no puede ser igual o posterior a la de salida.";
    return;
}

const vehiculo = opcionSeleccionada.value;
const diffTiempo = fechaSalida - fechaEntrada;
const diffDias = Math.floor(diffTiempo / (1000 * 60 * 60 * 24));
const diffHoras = Math.floor((diffTiempo % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
const diffMinutos = Math.floor((diffTiempo % (1000 * 60 * 60)) / (1000 * 60));

if (isNaN(diffDias) || isNaN(diffHoras)) {
    resultado2.textContent = "Por favor, introduzca fechas válidas.";
    return;
}
let textoMinutos = (diffMinutos === 1) ? 'minuto' : 'minutos';
let textoDias = (diffDias === 1) ? 'día' : 'días';
let textoHoras = (diffHoras === 1) ? 'hora' : 'horas';

if (diffDias !== 0) {
    textoDias = (diffDias === 1) ? 'día' : 'días';
}

if (diffHoras !== 0) {
    textoHoras = (diffHoras === 1) ? 'hora' : 'horas';
}

if (diffMinutos !== 0) {
    textoMinutos = (diffMinutos === 1) ? 'minuto' : 'minutos';
}


resultado2.innerHTML = 
`<p class="lead">
    ${diffDias !== 0 ? `<span class="badge bg-primary">${diffDias} ${textoDias}</span>` : ''}` + 
`${diffDias !== 0 && (diffHoras !== 0 || diffMinutos !== 0) ? ' ' : ''}` + 
`${diffHoras !== 0 ? `<span class="badge bg-secondary">${diffHoras} ${textoHoras}</span>` : ''}` + 
`${diffHoras !== 0 && diffMinutos !== 0 ? ' ' : ''}` + 
`${diffMinutos !== 0 ? `<span class="badge bg-info">${diffMinutos} ${textoMinutos}</span>` : ''}
</p>`;




if (diffDias > 65) {
    resultado.innerHTML = `
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="alert alert-info" role="alert" style="font-size: 17px;">
                    <p>El tiempo máximo permitido para que un vehículo permanezca en el depósito es de dos meses.</p>
                    <p>Transcurrido este período, el desguace <a href="#desguace">El Choque</a> asume la responsabilidad de su disposición y gestión conforme a los procedimientos establecidos.</p>
                    <hr>
                    <p>Ha intentado calcular...</p>
                </div>
            </div>
        </div>
    </div>
`;



        return;
}

let precioBase = 0;

switch (vehiculo) {
    case "coche":
        if (diffDias == 0 && diffHoras <= 7) {
            precioBase = 183.86 + (diffHoras * 1.63);
        } else if (diffDias == 0 && diffHoras >= 7){
            precioBase = 196.75;
        }
        else if (diffDias <= 29) {
            precioBase = 196.75 + (diffDias * 15.25);
        } else if (diffDias >= 30 && diffDias <= 65) {
            precioBase = 639 + ((diffDias - 29) * 30.86);
        }
        break;
    case "moto":
        if (diffDias == 0 && diffHoras <= 7) {
            precioBase = 84.76 + (diffHoras * 0.51);
        } else if (diffDias == 0 && diffHoras >= 7){
                precioBase == 87.12;
        }else if (diffDias <= 29) {
            precioBase = 87.12 + (diffDias * 3.63);
        } else if (diffDias >= 30 && diffDias <= 65) {
            precioBase = 192.39 + ((diffDias - 29) * 25.77);
        }
        break;
    default:
        break;
}

const precioFormateado = precioBase.toLocaleString('es-ES', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});

if (precioBase === 0) {
    resultado.textContent = "No se pudo calcular el precio. Por favor, verifica las fechas.";
} else {
resultado.innerHTML += `
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Precio</div>
                <div class="card-body">
                    <p class="card-text display-4">${precioFormateado} €</p>
                    <h5 class="card-title">(21% I.V.A incluido)</h5>

                </div>
            </div>
        </div>
    </div>
</div>
`;
}
}


