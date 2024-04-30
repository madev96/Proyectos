
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
        resultado2.textContent = "La hora de entrada no puede ser igual o posterior a la de salida.";
        return;
    }

    const vehiculo = opcionSeleccionada.value;
    const diffTiempo = fechaSalida - fechaEntrada;
    const diffDias = Math.floor(diffTiempo / (1000 * 60 * 60 * 24));
    const diffHoras = Math.floor((diffTiempo % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    if (isNaN(diffDias) || isNaN(diffHoras)) {
        resultado2.textContent = "Por favor, introduce fechas válidas.";
        return;
    }

    let textoDias = (diffDias === 1) ? 'día' : 'días';
    let textoHoras = (diffHoras === 1) ? 'hora' : 'horas';
    resultado2.textContent = `${diffDias} ${textoDias} y ${diffHoras} ${textoHoras}`;
    
    if (diffDias > 65) {
        resultado.innerHTML = `
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="alert alert-info" role="alert" style="font-size: 17px;">
                        <p>El tiempo máximo permitido para que un vehículo permanezca en el depósito es de dos meses.</p>
                        <p>Transcurrido este período, el desguace <a href="https://www.elchoque.com" target="_blank">El Choque</a> asume la responsabilidad de su disposición y gestión conforme a los procedimientos establecidos.</p>
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
        resultado.textContent = `Precio: ${precioFormateado} €`;
    }
}


