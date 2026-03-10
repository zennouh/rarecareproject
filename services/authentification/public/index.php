<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'authentification',
    'status' => 'ok',
    'message' => 'Welcome to Authentification Service'
]);
