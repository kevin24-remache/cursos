// main.js

document.addEventListener('DOMContentLoaded', function() {
    // Código para manejar las imágenes
    const imagenes = document.querySelectorAll('.imagen-pequena');
    const imagenAmpliada = document.getElementById('imagen-ampliada');
    const imagenAmpliadaImg = imagenAmpliada.querySelector('img');

    imagenes.forEach(imagen => {
        imagen.addEventListener('click', () => {
            imagenAmpliadaImg.src = imagen.src;
            imagenAmpliada.style.display = 'flex';
        });
    });

    imagenAmpliada.addEventListener('click', () => {
        imagenAmpliada.style.display = 'none';
    });

    // Código para manejar el modal de inscripción
    var myModal = document.getElementById('modalInscripcion');
    myModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var evento = button.getAttribute('data-evento');
        var eventId = button.getAttribute('data-event-id');

        var modalEvento = myModal.querySelector('#nombreEvento');
        modalEvento.value = evento;

        var hiddenEventoId = myModal.querySelector('#eventoId');
        hiddenEventoId.value = eventId;
    });

     // Función para limpiar el modal
     function LimpiarModal() {
        document.getElementById("formDeposito").reset();
        document.getElementById("montoDeposito").value = '';
        ['mensaje_estado', 'mensaje_original', 'mensaje_pagado', 'mensaje_nuevo'].forEach(id => {
            const elemento = document.getElementById(id);
            elemento.style.display = 'none';
            elemento.querySelector('span').textContent = '';
        });
    }

    // Evento para limpiar el modal al cerrarse
    var modalDeposito = document.getElementById('modalDeposito');
    modalDeposito.addEventListener('hidden.bs.modal', LimpiarModal);

    // Agregar un evento para cuando se abre el modal
    modalDeposito.addEventListener('show.bs.modal', function() {
        // Agregar event listeners a los campos de entrada
        document.getElementById('depositoCedula').addEventListener('input', fetchMontoDeposito);
        document.getElementById('codigoPago').addEventListener('input', fetchMontoDeposito);
    });
});