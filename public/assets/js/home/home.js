document.addEventListener("DOMContentLoaded", function () {
  function showPreloader() {
    document.getElementById("preloader").style.display = "flex";
  }

  function hidePreloader() {
    document.getElementById("preloader").style.display = "none";
  }

  firebase.initializeApp(firebaseConfig);
  const db = firebase.firestore();

  async function obtenerUsuario(userId) {
    try {
      showPreloader();
      const doc = await db.collection("Usuarios").doc(userId).get();
      hidePreloader();
      if (doc.exists) {
        //console.log(doc.data());
        return doc.data();
      } else {
        return null;
      }
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

      // Check if the input value is not a valid number or is outside the range
      if (
        !allowedChars.includes(inputValue) ||
        (inputValue === "0" && numeroCedulaInput.value.length === 0)
      ) {
        event.preventDefault(); // Prevent character insertion
      }

      // Check if the input value exceeds the maximum length (15)
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
  document
    .getElementById("formRegistroUsuario")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      showPreloader();
      let cedula = document.getElementById("numeroCedula").value;
      let nombres = document.getElementById("nombres").value;
      let apellidos = document.getElementById("apellidos").value;
      let telefono = document.getElementById("telefono").value;
      let email = document.getElementById("email").value;
      let direccion = document.getElementById("direccion").value;

      // Datos del usuario
      const usuarioData = {
        cedula,
        nombres,
        apellidos,
        telefono,
        email,
        direccion,
        timestamp: firebase.firestore.FieldValue.serverTimestamp(), // Marca de tiempo opcional
      };

      insertarUsuario(cedula, usuarioData);
    });
  async function insertarUsuario(userId, data) {
    try {
      await db.collection("Usuarios").doc(userId).set(data);
      console.log("Document successfully written with ID: ", userId);
    } catch (error) {
      console.error("Error adding document: ", error);
    }
  }
  document.getElementById("numeroCedula").value = "0250072444";

  document
    .getElementById("formInscripcion")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      let numeroCedula = document.getElementById("numeroCedula").value;
      let eventoId = document.getElementById("eventoId").value;
      obtenerUsuario(numeroCedula)
        .then((user) => {
          if (user != null) {
            fetch("validar_cedula", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({ user: user }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.exists) {
                  if (data.persona) {
                    console.log(data.persona);
                    llenarCamposPersona(data.persona);
                    fetch("obtener_datos_evento", {
                      method: "POST",
                      headers: {
                        "Content-Type": "application/json",
                      },
                      body: JSON.stringify({ eventoId: eventoId }),
                    })
                      .then((response) => response.json())
                      .then((eventData) => {
                        if (eventData) {
                          // Llenar el segundo modal con datos del evento
                          document.getElementById("titleEvent").textContent =
                            eventData.event_name;
                          document.getElementById("descripcionEvento").value =
                            eventData.short_description;

                          // Verificar si hay categorías disponibles
                          if (eventData.category_ids) {
                            // Convertir las cadenas de categorías en arrays
                            let categoryIds = eventData.category_ids.split(",");
                            let categoryNames = eventData.categories.split(",");
                            let categoryPagos = eventData.cantidad_dinero.split(",");

                            // Construir HTML para los radio botones de categorías
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

                            // Insertar HTML generado en el documento
                            document.getElementById("categoria").innerHTML = categoriaHtml;
                          } else {
                            // Agregar un radio button para indicar que no hay categorías disponibles
                            document.getElementById("categoria").innerHTML = `
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="categoria" value="0" id="sinCategorias" checked required>
                                                  <label class="form-check-label" for="sinCategorias">Sin categorías</label>
                                              </div>`;
                          }

                          // Mostrar el segundo modal
                          $("#modalInscripcion").modal("hide");
                          $("#modalDetallesEvento").modal("show");
                        } else {
                          swal(
                            "Ocurrió un error",
                            "No se encontraron datos del evento",
                            "warning"
                          );
                        }
                      });
                  } else {
                    swal(
                      "Ocurrió un error",
                      "No se encontraron datos de la persona",
                      "warning"
                    );
                  }
                }
              })
              .catch((error) => console.error("Error:", error));
          } else {
            // Verificar si el eventoId existe
            if (eventoId) {
              // Mostrar el modal de registro de usuario
              document.getElementById("numeroCedulaRegistro").value =
                numeroCedula;
              $("#modalInscripcion").modal("hide");
              $("#modalRegistroUsuario").modal("show");
            } else {
              swal(
                "Ocurrió un error",
                "El evento seleccionado no existe",
                "warning"
              );
            }
          }
        })
        .catch((error) => {
          swal("Ocurrió un error", data.message, "warning");
          console.error("Error al obtener el usuario:", error);
        });
    });

  document
    .getElementById("formRegistroUsuario")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      let formData = new FormData(this);
      let jsonData = {};
      formData.forEach((value, key) => (jsonData[key] = value));

      // Registrar el usuario en el controlador
      fetch("registrar_usuario", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(jsonData),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Usuario registrado, ahora se puede inscribir al evento
            $("#modalRegistroUsuario").modal("hide");
            $("#modalInscripcion").modal("show");
            alert(
              "Usuario registrado correctamente. Ahora puede inscribirse al evento."
            );
          } else {
            alert("Error al registrar el usuario");
          }
        })
        .catch((error) => console.error("Error:", error));
    });

  document
    .getElementById("formDetallesEvento")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      showPreloader();

      // Obtener el id del usuario y el id del evento
      let idUser = document.getElementById("id_user").value;
      let eventoId = document.getElementById("eventoId").value;
      let catId = document.querySelector(
        'input[name="categoria"]:checked'
      ).value;

      // Crear el objeto JSON con solo los datos necesarios
      let jsonData = {
        id_user: idUser,
        eventoId: eventoId,
        catId: catId,
      };
      fetch("guardar_inscripcion", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(jsonData),
      })
        .then((response) => response.json())
        .then((data) => {
          hidePreloader();
          if (data.error) {
            // Mostrar el mensaje de error
            swal("Ups! Algo salio mal!", data.message, "warning");
          } else if (data.success) {
            // Calcular los días restantes para el pago
            const fechaLimitePago = new Date(data.payment_time_limit);
            const hoy = new Date();
            const diferenciaMilisegundos = fechaLimitePago - hoy;
            const diasRestantes = Math.ceil(
              diferenciaMilisegundos / (1000 * 60 * 60 * 24)
            );
            // Mostrar el mensaje de confirmación y código de pago
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
            swal(
              "Ups! Algo salio mal!",
              "La acción no se pudo realizar correctamente!",
              "error"
            );
          }
        })
        .catch((error) => {
          hidePreloader();
          console.error("Error:", error);
          swal(
            "Ups! Algo salio mal!",
            "Error al comunicarse con el servidor",
            "error"
          );
        });
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
