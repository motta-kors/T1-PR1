const respuestaAPI = {
    "status": 200,
    "message": "Productos obtenidos correctamente",
    "data": [
        { "id": 1, "nombre": "Teclado", "precio": 4590 },
        { "id": 2, "nombre": "Mouse", "precio": 6000 }
    ]
};

const cmb = document.getElementById("cmbProducto");
if (cmb) {
    respuestaAPI.data.forEach((producto) => {
        insertarOpcionEnSelect(producto.id, `${producto.nombre} - $${producto.precio}`);
    });
}


function agregarProducto() {
    const inputId = document.getElementById("txtId");
    const inputNombre = document.getElementById("txtNombre");

    if (!inputId || !inputNombre) return;

    const id = inputId.value.trim();
    const nombre = inputNombre.value.trim();

    if (id === "" || nombre === "") {
        alert("Por favor completa todos los campos.");
        return;
    }

    insertarOpcionEnSelect(id, nombre);


    inputId.value = "";
    inputNombre.value = "";
}


function insertarOpcionEnSelect(valor, texto) {
    const selectElement = document.getElementById("cmbProducto");
    if (!selectElement) return;

    const opt = document.createElement("option");
    opt.setAttribute("value", valor);
    opt.innerText = texto;

    selectElement.appendChild(opt);
}