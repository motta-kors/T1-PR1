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
    } catch (error) {
        console.error("Error al obtener productos desde FastAPI:", error);
    }
}


async function agregarProducto() {
    const inputId = document.getElementById("txtId");
    const inputNombre = document.getElementById("txtNombre");
    const inputPrecio = document.getElementById("txtPrecio");

    if (!inputId || !inputNombre || !inputPrecio) return;

    const id = Number(inputId.value);
    const nombre = inputNombre.value.trim();
    const precio = Number(inputPrecio.value);

    if (!id || nombre === "" || !precio) {
        alert("Por favor completa todos los campos correctamente.");
        return;
    }

    try {
        const respuesta = await fetch(`${API_URL}/productos`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id: id,
                nombre: nombre,
                precio: precio
            })
        });

        if (!respuesta.ok) {
            throw new Error(`Error HTTP: ${respuesta.status}`);
        }

        await cargarProductos();

        inputId.value = "";
        inputNombre.value = "";
        inputPrecio.value = "";
    } catch (error) {
        console.error("Error al crear producto:", error);
        alert("No se pudo agregar el producto.");
    }
}


function insertarOpcionEnSelect(valor, texto) {
    const selectElement = document.getElementById("cmbProducto");
    if (!selectElement) return;

    const opt = document.createElement("option");
    opt.value = valor;
    opt.innerText = texto;

    selectElement.appendChild(opt);
}


document.addEventListener("DOMContentLoaded", cargarProductos);
