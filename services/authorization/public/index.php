<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'autorisation',
    'status' => 'ok',
    'message' => 'Welcome to Autorisation Service'
]);
