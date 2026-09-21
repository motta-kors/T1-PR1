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
  if (form) {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const nombre = document.getElementById("nombre").value.trim();
      const email = document.getElementById("email").value.trim();
      const mensaje = document.getElementById("mensaje").value.trim();

      const nuevaUrl = new URL(window.location.href);
      nuevaUrl.searchParams.set("nombre", nombre);
      nuevaUrl.searchParams.set("email", email);
      if (mensaje) nuevaUrl.searchParams.set("mensaje", mensaje);
      history.replaceState({}, "", nuevaUrl);

      if (confirmacion) {
        confirmacion.classList.remove("d-none");
        confirmacion.textContent = `Pedido simulado para ${nombre}. No se enviaron datos a un backend.`;
      }
    });
  }
});

function escapeHtml(texto) {
  return texto.replace(/[&<>"']/g, (c) => ({
    "&":"&amp;", "<":"&lt;", ">":"&gt;", '"':"&quot;", "'":"&#039;"
  })[c]);
}