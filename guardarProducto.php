<?php
require_once __DIR__ . '/api/gateway-proxy.php';
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); echo json_encode(['message'=>'Solo POST']); exit;
}
$payload=json_decode(file_get_contents('php://input'),true);
if (!is_array($payload) || empty($payload['nombre']) || !isset($payload['precio']) || !isset($payload['stock'])) {
    http_response_code(422);
    echo json_encode(['status'=>422,'message'=>'Se requiere nombre, precio y stock']); exit;
}
[$code,$data]=gateway_request('/api/v1/products','POST',[
    'name'=>$payload['nombre'], 'price'=>(int)$payload['precio'],
    'stock'=>(int)$payload['stock'], 'active'=>true
]);
http_response_code($code);
echo json_encode($code===201
    ? ['status'=>201,'message'=>'Producto persistido en inventory','data'=>$data]
    : ['status'=>$code,'message'=>$data['detail'] ?? 'Error al guardar'],JSON_UNESCAPED_UNICODE);
