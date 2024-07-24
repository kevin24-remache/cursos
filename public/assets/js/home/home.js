document.addEventListener("DOMContentLoaded", function () {
  function showPreloader() {
    document.getElementById("preloader").style.display = "flex";
  }

  function hidePreloader() {
    document.getElementById("preloader").style.display = "none";
  }

  async function obtenerUsuario(userId) {
    try {
      showPreloader();
      const response = await fetch('validar_cedula', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ cedula: userId }),
      });
      const data = await response.json();
      hidePreloader();
      return data.exists ? data.persona : null;
    } catch (error) {
      hidePreloader();
      console.log("Error getting document:", error);
      return null;
    }
  }

  validar_cedula(document.getElementById("numeroCedulaRegistro"));
  validar_cedula(document.getElementById("numeroCedula"));

  function validar_cedula(numeroCedulaInput) {
    numeroCedulaInput.addEventListener("keypress", function (event) {
      const allowedChars = "0123456789";
      const inputValue = event.key;

      if (
        !allowedChars.includes(inputValue) ||
        (inputValue === "0" && numeroCedulaInput.value.length === 0)
      ) {
        event.preventDefault();
      }

      if (numeroCedulaInput.value.length === 15 && inputValue !== "Backspace") {
        event.preventDefault();
      }
    });
  }

  function llenarCamposPersona(persona) {
    document.getElementById("id_user").value = persona.id;
    document.getElementById("nombresPersona").textContent = persona.nombres;
    document.getElementById("apellidosPersona").textContent = persona.apellidos;
    document.getElementById("emailPersona").textContent = persona.email;
  }
  document.getElementById("formRegistroUsuario").addEventListener("submit", async function (event) {
    event.preventDefault();
    showPreloader();
    let formData = new FormData(this);
    let jsonData = {};
    formData.forEach((value, key) => (jsonData[key] = value));

    try {
      const response = await fetch("registrar_usuario", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(jsonData),
      });
      const data = await response.json();
      hidePreloader();
      if (data.success) {
        $("#modalRegistroUsuario").modal("hide");
        $("#modalInscripcion").modal("show");
        Swal.fire({
          title: "<strong>Usuario registrado correctamente!</strong>",
          icon: "success",
          html: `
                    <p>Ahora puede inscribirse al evento.</p>
                `,
          showCloseButton: true,
          confirmButtonText: 'Ok',
        });
      } else {
        let errorMessage = "Error al registrar el usuario.";
        if (typeof data.message === 'object') {
          errorMessage = '<div class="alert alert-danger" role="alert"><ul class="list-unstyled">';
          for (let key in data.message) {
            errorMessage += `<li>${data.message[key]}</li>`;
          }
          errorMessage += '</ul></div>';
        } else {
          errorMessage = `<div class="alert alert-danger" role="alert"><p>${data.message}</p></div>`;
        }

        Swal.fire({
          title: "<strong>Error</strong>",
          icon: "error",
          html: errorMessage,
          showCloseButton: true,
          confirmButtonText: 'Ok',
        });
      }
    } catch (error) {
      hidePreloader();
      console.error("Error:", error);
      Swal.fire({
        title: "<strong>Error</strong>",
        icon: "error",
        html: `
                <div class="alert alert-danger" role="alert">
                    <p>Ocurrió un error al registrar el usuario. Por favor, intente nuevamente más tarde.</p>
                </div>
            `,
        showCloseButton: true,
        confirmButtonText: 'Ok',
      });
    }
  });

  document.getElementById("numeroCedula").value = "0250072444";

  document
    .getElementById("formInscripcion")
    .addEventListener("submit", async function (event) {
      event.preventDefault();
      let numeroCedula = document.getElementById("numeroCedula").value;
      let eventoId = document.getElementById("eventoId").value;

      const user = await obtenerUsuario(numeroCedula);
      if (user) {
        llenarCamposPersona(user);
        try {
          const response = await fetch("obtener_datos_evento", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ eventoId: eventoId }),
          });
          const eventData = await response.json();
          if (eventData) {
            document.getElementById("titleEvent").textContent = eventData.event_name;
            document.getElementById("descripcionEvento").value = eventData.short_description;

            if (eventData.category_ids) {
              let categoryIds = eventData.category_ids.split(",");
              let categoryNames = eventData.categories.split(",");
              let categoryPagos = eventData.cantidad_dinero.split(",");

              let categoriaHtml = "";
              for (let i = 0; i < categoryIds.length; i++) {
                categoriaHtml += `
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="categoria" value="${categoryIds[i]}" id="categoria${categoryIds[i]}" required>
                    <label class="form-check-label" for="categoria${categoryIds[i]}">
                      ${categoryNames[i]} - $${categoryPagos[i]}
                    </label>
                  </div>`;
              }

              document.getElementById("categoria").innerHTML = categoriaHtml;
            } else {
              document.getElementById("categoria").innerHTML = `
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="categoria" value="0" id="sinCategorias" checked required>
                  <label class="form-check-label" for="sinCategorias">Sin categorías</label>
                </div>`;
            }

            $("#modalInscripcion").modal("hide");
            $("#modalDetallesEvento").modal("show");
          } else {
            swal("Ocurrió un error", "No se encontraron datos del evento", "warning");
          }
        } catch (error) {
          console.error("Error:", error);
        }
      } else {
        if (eventoId) {
          document.getElementById("numeroCedulaRegistro").value = numeroCedula;
          $("#modalInscripcion").modal("hide");
          $("#modalRegistroUsuario").modal("show");
        } else {
          swal("Ocurrió un error", "El evento seleccionado no existe", "warning");
        }
      }
    });

  document
    .getElementById("formDetallesEvento")
    .addEventListener("submit", async function (event) {
      event.preventDefault();
      showPreloader();

      let numeroCedula = document.getElementById("numeroCedula").value;
      let eventoId = document.getElementById("eventoId").value;
      let catId = document.querySelector('input[name="categoria"]:checked').value;

      let jsonData = {
        cedula: numeroCedula,
        eventoId: eventoId,
        catId: catId,
      };

      try {
        const response = await fetch("guardar_inscripcion", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(jsonData),
        });
        const data = await response.json();
        hidePreloader();

        if (data.error) {
          swal("Ups! Algo salió mal!", data.message, "warning");
        } else if (data.success) {
          const fechaLimitePago = new Date(data.payment_time_limit);
          const hoy = new Date();
          const diferenciaMilisegundos = fechaLimitePago - hoy;
          const diasRestantes = Math.ceil(diferenciaMilisegundos / (1000 * 60 * 60 * 24));

          Swal.fire({
            title: "<strong>Registro Exitoso!</strong>",
            icon: "success",
            html: `
              <p>Bien, te registraste para el evento.</p>
              <p>Tu código de pago es: <b>${data.codigoPago}</b></p>
              <p>Tienes <b>${diasRestantes}</b> días para realizar el pago</p>
              <p>Comprobante de registro enviado a : <b>${data.email}</b></p>
            `,
            showCloseButton: true,
            confirmButtonText: 'Ok',
          });
          $("#modalDetallesEvento").modal("hide");
        } else {
          swal("Ups! Algo salió mal!", "La acción no se pudo realizar correctamente!", "error");
        }
      } catch (error) {
        hidePreloader();
        console.error("Error:", error);
        swal("Ups! Algo salió mal!", "Error al comunicarse con el servidor", "error");
      }
    });

  document.getElementById('depositoCedula').addEventListener('change', fetchMontoDeposito);
  document.getElementById('codigoPago').addEventListener('change', fetchMontoDeposito);

  function fetchMontoDeposito() {
    const cedula = document.getElementById('depositoCedula').value;
    const codigoPago = document.getElementById('codigoPago').value;
    const montoDeposito = document.getElementById('montoDeposito');

    if (cedula && codigoPago) {
      fetch('monto_pago', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cedula: cedula, codigoPago: codigoPago })
      })
        .then(response => response.json())
        .then(data => {
          const mensajeEstado = document.querySelector('#mensaje_estado');
          const mensajeEstadoSpan = mensajeEstado.querySelector('span');
          const mensajeOriginal = document.querySelector('#mensaje_original');
          const mensajeOriginalSpan = mensajeOriginal.querySelector('span');
          const mensajePagado = document.querySelector('#mensaje_pagado');
          const mensajePagadoSpan = mensajePagado.querySelector('span');
          const mensajeNuevo = document.querySelector('#mensaje_nuevo');
          const mensajeNuevoSpan = mensajeNuevo.querySelector('span');
          const tablaDepositos = document.querySelector('#tabla_depositos');

          if (data.error) {
            montoDeposito.value = '';
            mensajeEstadoSpan.textContent = data.error;
            mensajeEstado.style.display = 'block';
            [mensajeOriginal, mensajePagado, mensajeNuevo, tablaDepositos].forEach(elem => elem.style.display = 'none');
          } else if (data.cancelado) {
            montoDeposito.value = `$ ${data.nuevoMonto}`;
            mensajeEstadoSpan.textContent = 'El pago anterior fue cancelado.';
            mensajeOriginalSpan.textContent = `$ ${data.montoOriginal}`;
            mensajePagadoSpan.textContent = `$ ${data.montoPagado}`;
            mensajeNuevoSpan.textContent = `$ ${data.nuevoMonto}`;
            [mensajeEstado, mensajeOriginal, mensajePagado, mensajeNuevo].forEach(elem => elem.style.display = 'block');
            mostrarTablaDepositos(data.deposits);
          } else {
            montoDeposito.value = `$ ${data.monto}`;
            [mensajeEstado, mensajeOriginal, mensajePagado, mensajeNuevo].forEach(elem => {
              elem.querySelector('span').textContent = '';
              elem.style.display = 'none';
            });
            mostrarTablaDepositos(data.deposits);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          montoDeposito.value = '';
          const mensajeEstado = document.querySelector('#mensaje_estado');
          mensajeEstado.querySelector('span').textContent = 'Error al obtener el monto';
          mensajeEstado.style.display = 'block';
          [mensajeOriginal, mensajePagado, mensajeNuevo, tablaDepositos].forEach(elem => elem.style.display = 'none');
        });
    } else {
      montoDeposito.value = '';
      const mensajeEstado = document.querySelector('#mensaje_estado');
      const mensajeOriginal = document.querySelector('#mensaje_original');
      const mensajePagado = document.querySelector('#mensaje_pagado');
      const mensajeNuevo = document.querySelector('#mensaje_nuevo');
      const tablaDepositos = document.querySelector('#tabla_depositos');
      [mensajeEstado, mensajeOriginal, mensajePagado, mensajeNuevo, tablaDepositos].forEach(elem => {
        if (elem.querySelector('span')) {
          elem.querySelector('span').textContent = '';
        }
        elem.style.display = 'none';
      });
    }
  }

  function mostrarTablaDepositos(deposits) {
    const tablaDepositos = document.querySelector('#tabla_depositos');
    tablaDepositos.innerHTML = ''; // Limpiar la tabla existente

    if (deposits && deposits.length > 0) {
      const tablaResponsiva = document.createElement('div');
      tablaResponsiva.classList.add('table-responsive');

      const tabla = document.createElement('table');
      tabla.classList.add('table', 'table-striped', 'table-hover', 'table-bordered');

      // Crear encabezado
      const thead = document.createElement('thead');
      thead.innerHTML = `
            <tr>
                <th>N° Comprobante</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        `;
      tabla.appendChild(thead);

      // Crear cuerpo de la tabla
      const tbody = document.createElement('tbody');
      deposits.forEach(deposit => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
                <td>${deposit.num_comprobante}</td>
                <td>$ ${deposit.monto_deposito}</td>
                <td>${deposit.date_deposito}</td>
                <td>${deposit.status}</td>
            `;
        tbody.appendChild(tr);
      });
      tabla.appendChild(tbody);

      tablaResponsiva.appendChild(tabla);
      tablaDepositos.appendChild(tablaResponsiva);
      tablaDepositos.style.display = 'block';
    } else {
      tablaDepositos.innerHTML = '<p class="text-muted">No hay depósitos registrados.</p>';
      tablaDepositos.style.display = 'block';
    }
  }
});
