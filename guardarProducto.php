<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Leer los datos JSON enviados desde fetch()
$datosRecibidos = json_decode(file_get_contents('php://input'), true);

if (!$datosRecibidos || empty($datosRecibidos['id']) || empty($datosRecibidos['nombre'])) {
    http_response_code(400);
    echo json_encode([
        "status" => 400,
        "message" => "Faltan datos obligatorios (id o nombre)"
    ]);
    exit;
}

$id = $datosRecibidos['id'];
$nombre = $datosRecibidos['nombre'];

// Aquí se ejecutaría la inserción (INSERT INTO ...) en base de datos.
// Respondemos con éxito confirmando el nuevo elemento:
http_response_code(201);
echo json_encode([
    "status" => 201,
    "message" => "Producto agregado con éxito",
    "data" => [
        "id" => $id,
        "nombre" => $nombre
    ]
]);
