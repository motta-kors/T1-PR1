const mongoose = require('mongoose');

const productoSchema = new mongoose.Schema({
    nombre: { type: String, required: true },      // Ej: "Cono Doble Barquillo", "Pote Familiar 1000ml"
    descripcion: { type: String },                 // Ej: "Elige tus 2 sabores", "Hasta 4 sabores"
    precio: { type: Number, required: true },       // Ej: 4500, 9900, 5900, 6500
    formato: { type: String },                     // Ej: "Cono", "Pote"
    imagenUrl: { type: String }
});

module.exports = mongoose.model('Producto', productoSchema);