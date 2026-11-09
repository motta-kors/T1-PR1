<?php
// Adaptador PHP legado: no tiene base de datos propia ni secretos internos.
function gateway_request(string $path, string $method = 'GET', ?array $body = null): array {
    $origin = rtrim(getenv('API_GATEWAY_URL') ?: 'http://127.0.0.1:8000', '/');
    $headers = "Accept: application/json\r\n";
    $bearer = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/^Bearer [A-Za-z0-9_\\-\\.]+$/', $bearer)) {
        $headers .= "Authorization: " . $bearer . "\r\n";
    }
    if ($body !== null) $headers .= "Content-Type: application/json\r\n";
    $context = stream_context_create(['http' => [
        'method' => $method, 'header' => $headers,
        'content' => $body === null ? '' : json_encode($body, JSON_UNESCAPED_UNICODE),
        'ignore_errors' => true, 'timeout' => 8
    ]]);
    $response = @file_get_contents($origin . $path, false, $context);
    if ($response === false) return [503, ['detail' => 'Servicio temporalmente no disponible']];
    $http_code = 502;
    foreach ($http_response_header ?? [] as $line) {
        if (preg_match('/^HTTP\/\S+\s+(\d{3})/', $line, $match)) {
            $http_code = (int)$match[1]; break;
        }
    }
    $parsed = json_decode($response, true);
    return [$http_code, is_array($parsed) ? $parsed : ['detail' => 'Respuesta inválida']];
}
