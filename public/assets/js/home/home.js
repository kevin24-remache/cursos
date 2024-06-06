document.addEventListener("DOMContentLoaded", function () {
  firebase.initializeApp(firebaseConfig);
  const db = firebase.firestore();

  async function obtenerUsuario(userId) {
    try {
      const doc = await db.collection("Usuarios").doc(userId).get();
      if (doc.exists) {
        //console.log(doc.data());
        return doc.data();
      } else {
        return null;
      }
    } catch (error) {
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
  }
  document
    .getElementById("formRegistroUsuario")
    .addEventListener("submit", function (event) {
      event.preventDefault();
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
  document.getElementById("numeroCedula").value = "0202433918";

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

                            // Construir HTML para los radio botones de categorías
                            let categoriaHtml = "";
                            for (let i = 0; i < categoryIds.length; i++) {
                              categoriaHtml += `
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="categoria" value="${categoryIds[i]}" id="categoria${categoryIds[i]}" required>
                                                      <label class="form-check-label" for="categoria${categoryIds[i]}">${categoryNames[i]}</label>
                                                  </div>`;
                            }

                            // Insertar HTML generado en el documento
                            document.getElementById("categoria").innerHTML =
                              categoriaHtml;
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
            swal(
              "Bien, te registraste para el evento",
              "Tu código de pago es: ${ data.codigoPago }\nTienes ${ diasRestantes } días para realizar el pago.",
              "success"
            );
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
          console.error("Error:", error);
          swal(
            "Ups! Algo salio mal!",
            "Error al comunicarse con el servidor",
            "error"
          );
        });
    });
});
