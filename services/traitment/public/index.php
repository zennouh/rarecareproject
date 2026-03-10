<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'traitment',
    'status' => 'ok',
    'message' => 'Welcome to Traitment Service'
]);
