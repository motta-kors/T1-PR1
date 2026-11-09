<?php
require_once __DIR__ . '/api/gateway-proxy.php';
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); echo json_encode(['message'=>'Solo GET']); exit;
}
[$code, $data] = gateway_request('/api/v1/products');
http_response_code($code);
echo json_encode($code === 200
    ? ['status'=>200,'message'=>'Productos obtenidos desde inventory','data'=>$data]
    : ['status'=>$code,'message'=>$data['detail'] ?? 'No disponible'], JSON_UNESCAPED_UNICODE);
