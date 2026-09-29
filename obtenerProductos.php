<?php
// Indicar que la respuesta es JSON
header('Content-Type: application/json; charset=utf-8');

// Cabeceras CORS (útil si pruebas en entornos locales distintos)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Simulación de datos (más adelante los puedes traer de una base de datos MySQL)
$productos = [
    ["id" => 1, "nombre" => "Teclado", "precio" => 4590],
    ["id" => 2, "nombre" => "Mouse", "precio" => 6000],
    ["id" => 3, "nombre" => "Monitor", "precio" => 120000]
];

// Estructura de respuesta uniforme
$respuesta = [
    "status" => 200,
    "message" => "Productos obtenidos correctamente",
    "data" => $productos
];

echo json_encode($respuesta);