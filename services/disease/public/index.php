<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'maladie',
    'status' => 'ok',
    'message' => 'Welcome to Maladie Service'
]);
