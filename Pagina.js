const API_URL = "http://127.0.0.1:8000";

async function cargarProductos() {
    try {
        const respuesta = await fetch(`${API_URL}/productos`);

        if (!respuesta.ok) {
            throw new Error(`Error HTTP: ${respuesta.status}`);
        }

        const respuestaAPI = await respuesta.json();
        const cmb = document.getElementById("cmbProducto");

        if (!cmb) return;

        cmb.innerHTML = "";

        respuestaAPI.data.forEach((producto) => {
            insertarOpcionEnSelect(
                producto.id,
                `${producto.nombre} - $${producto.precio}`
            );
        });

        if (respuestaAPI.data.length === 0) {
            insertarOpcionEnSelect("", "No hay productos registrados");
        }
    } catch (error) {
        console.error("Error al obtener productos desde FastAPI:", error);
        alert("No se pudo conectar con la API o MongoDB.");
    }
}

async function agregarProducto() {
    const producto = leerFormularioProducto();
    if (!producto) return;

    try {
        const respuesta = await fetch(`${API_URL}/productos`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(producto)
        });

        await procesarRespuesta(respuesta, "Producto agregado correctamente.");
        limpiarFormulario();
        await cargarProductos();
    } catch (error) {
        mostrarError(error);
    }
}

async function actualizarProducto() {
    const producto = leerFormularioProducto();
    if (!producto) return;

    try {
        const respuesta = await fetch(`${API_URL}/productos/${producto.id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(producto)
        });

        await procesarRespuesta(respuesta, "Producto actualizado correctamente.");
        limpiarFormulario();
        await cargarProductos();
    } catch (error) {
        mostrarError(error);
    }
}

async function eliminarProducto() {
    const inputId = document.getElementById("txtId");
    if (!inputId) return;

    const id = Number(inputId.value);

    if (!id) {
        alert("Ingresa el ID del producto que quieres eliminar.");
        return;
    }

    if (!confirm(`¿Eliminar el producto con ID ${id}?`)) {
        return;
    }

    try {
        const respuesta = await fetch(`${API_URL}/productos/${id}`, {
            method: "DELETE"
        });

        await procesarRespuesta(respuesta, "Producto eliminado correctamente.");
        limpiarFormulario();
        await cargarProductos();
    } catch (error) {
        mostrarError(error);
    }
}

async function cargarProductoSeleccionado() {
    const cmb = document.getElementById("cmbProducto");
    if (!cmb || !cmb.value) return;

    try {
        const respuesta = await fetch(`${API_URL}/productos/${cmb.value}`);

        if (!respuesta.ok) {
            throw new Error(`Error HTTP: ${respuesta.status}`);
        }

        const producto = await respuesta.json();

        document.getElementById("txtId").value = producto.id;
        document.getElementById("txtNombre").value = producto.nombre;
        document.getElementById("txtPrecio").value = producto.precio;
    } catch (error) {
        mostrarError(error);
    }
}

function leerFormularioProducto() {
    const inputId = document.getElementById("txtId");
    const inputNombre = document.getElementById("txtNombre");
    const inputPrecio = document.getElementById("txtPrecio");

    if (!inputId || !inputNombre || !inputPrecio) return null;

    const id = Number(inputId.value);
    const nombre = inputNombre.value.trim();
    const precio = Number(inputPrecio.value);

    if (!id || nombre === "" || !precio) {
        alert("Por favor completa ID, nombre y precio correctamente.");
        return null;
    }

    return { id, nombre, precio };
}

async function procesarRespuesta(respuesta, mensajeExito) {
    const datos = await respuesta.json();

    if (!respuesta.ok) {
        const detalle = datos.detail || datos.message || "Ocurrió un error.";
        throw new Error(detalle);
    }

    alert(mensajeExito);
    return datos;
}

function mostrarError(error) {
    console.error(error);
    alert(error.message || "No se pudo completar la operación.");
}

function limpiarFormulario() {
    document.getElementById("txtId").value = "";
    document.getElementById("txtNombre").value = "";
    document.getElementById("txtPrecio").value = "";
}

function insertarOpcionEnSelect(valor, texto) {
    const selectElement = document.getElementById("cmbProducto");
    if (!selectElement) return;

    const opt = document.createElement("option");
    opt.value = valor;
    opt.innerText = texto;
    selectElement.appendChild(opt);
}

document.addEventListener("DOMContentLoaded", () => {
    cargarProductos();

    const cmb = document.getElementById("cmbProducto");
    if (cmb) {
        cmb.addEventListener("change", cargarProductoSeleccionado);
    }
});
