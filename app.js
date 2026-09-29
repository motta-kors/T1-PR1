document.addEventListener("DOMContentLoaded", () => {
    const cmb = document.getElementById("cmbProducto");
    if (cmb) {
        cargarProductosDesdeAPI();
    }
});

// Función GET: consulta los productos a PHP
async function cargarProductosDesdeAPI() {
    try {
        const respuesta = await fetch("api/getProductos.php");
        const resultado = await respuesta.json();

        if (resultado.status === 200) {
            resultado.data.forEach((prod) => {
                insertarOpcionEnSelect(prod.id, `${prod.nombre} - $${prod.precio ?? 0}`);
            });
        }
    } catch (error) {
        console.error("Error al cargar productos:", error);
    }
}

// Función POST: envía el nuevo producto a la API
async function agregarProducto() {
    const inputId = document.getElementById("txtId");
    const inputNombre = document.getElementById("txtNombre");

    if (!inputId || !inputNombre) return;

    const id = inputId.value.trim();
    const nombre = inputNombre.value.trim();

    if (id === "" || nombre === "") {
        alert("Por favor completa todos los campos.");
        return;
    }

    try {
        const respuesta = await fetch("api/guardarProducto.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: id, nombre: nombre })
        });

        const resultado = await respuesta.json();

        if (respuesta.ok) {
            insertarOpcionEnSelect(resultado.data.id, resultado.data.nombre);
            inputId.value = "";
            inputNombre.value = "";
        } else {
            alert(resultado.message || "Error al guardar el producto");
        }
    } catch (error) {
        console.error("Error al enviar el producto:", error);
    }
}

function insertarOpcionEnSelect(valor, texto) {
    const selectElement = document.getElementById("cmbProducto");
    if (!selectElement) return;

    const opt = document.createElement("option");
    opt.setAttribute("value", valor);
    opt.innerText = texto;
    selectElement.appendChild(opt);
}