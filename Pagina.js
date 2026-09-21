document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const sabor = params.get("sabor");
  const precio = params.get("precio");

  const seleccion = document.getElementById("seleccionActual");
  const continuar = document.getElementById("continuarPedido");

  if (seleccion && sabor) {
    seleccion.classList.remove("d-none");
    seleccion.textContent = `Seleccionaste: ${sabor}${precio ? " · $" + Number(precio).toLocaleString("es-CL") : ""}`;
  }

  if (continuar && sabor) {
    continuar.href = `contactos.php?sabor=${encodeURIComponent(sabor)}&precio=${encodeURIComponent(precio || "")}`;
  }

  const resumen = document.getElementById("resumenPedido");
  if (resumen) {
    resumen.innerHTML = sabor
      ? `<strong>Sabor elegido:</strong> ${escapeHtml(sabor)}${precio ? `<br><strong>Precio:</strong> $${Number(precio).toLocaleString("es-CL")}` : ""}`
      : "Todavía no has seleccionado un sabor.";
  }

  const form = document.getElementById("formPedido");
  const confirmacion = document.getElementById("confirmacionPedido");
  const erroresFormulario = document.getElementById("erroresFormulario");
  const nombreInput = document.getElementById("nombre");
  const emailInput = document.getElementById("email");
  const mensajeInput = document.getElementById("mensaje");
  const contadorMensaje = document.getElementById("contadorMensaje");

  if (mensajeInput && contadorMensaje) {
    const actualizarContador = () => {
      contadorMensaje.textContent = `${mensajeInput.value.length} / 250 caracteres`;
    };

    mensajeInput.addEventListener("input", actualizarContador);
    actualizarContador();
  }

  if (nombreInput) {
    nombreInput.addEventListener("input", () => {
      validarNombre(nombreInput);
    });
  }

  if (emailInput) {
    emailInput.addEventListener("input", () => {
      validarEmail(emailInput);
    });

    emailInput.addEventListener("blur", () => {
      validarEmail(emailInput);
    });
  }

  if (form) {
    form.addEventListener("submit", (event) => {
      event.preventDefault();

      const nombreValido = validarNombre(nombreInput);
      const emailValido = validarEmail(emailInput);

      if (!nombreValido || !emailValido) {
        if (confirmacion) {
          confirmacion.classList.add("d-none");
          confirmacion.textContent = "";
        }

        if (erroresFormulario) {
          erroresFormulario.classList.remove("d-none");
          erroresFormulario.textContent = "Revisa los campos marcados antes de continuar.";
        }

        const primerInvalido = form.querySelector(".is-invalid");
        if (primerInvalido) {
          primerInvalido.focus();
        }
        return;
      }

      if (erroresFormulario) {
        erroresFormulario.classList.add("d-none");
        erroresFormulario.textContent = "";
      }

      const nombre = nombreInput.value.trim();
      const email = emailInput.value.trim();
      const mensaje = mensajeInput ? mensajeInput.value.trim() : "";

      const nuevaUrl = new URL(window.location.href);
      nuevaUrl.searchParams.set("nombre", nombre);
      nuevaUrl.searchParams.set("email", email);

      if (mensaje) {
        nuevaUrl.searchParams.set("mensaje", mensaje);
      } else {
        nuevaUrl.searchParams.delete("mensaje");
      }

      history.replaceState({}, "", nuevaUrl);

      if (confirmacion) {
        confirmacion.classList.remove("d-none");
        confirmacion.innerHTML = `<strong>Pedido simulado correctamente.</strong><br>Gracias, ${escapeHtml(nombre)}. Usaremos ${escapeHtml(email)} como correo de contacto. No se enviaron datos a un backend.`;
      }
    });
  }
});

function validarNombre(input) {
  if (!input) return false;

  const nombre = input.value.trim();
  const valido = nombre.length >= 2;

  marcarEstado(input, valido);
  return valido;
}

function validarEmail(input) {
  if (!input) return false;

  const email = input.value.trim();
  const patronEmail = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  const valido = patronEmail.test(email);

  marcarEstado(input, valido);
  return valido;
}

function marcarEstado(input, valido) {
  input.classList.toggle("is-valid", valido);
  input.classList.toggle("is-invalid", !valido);
  input.setAttribute("aria-invalid", String(!valido));
}

function escapeHtml(texto) {
  return String(texto).replace(/[&<>"']/g, (c) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;"
  })[c]);
}