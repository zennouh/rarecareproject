<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'traitement',
    'status' => 'ok',
    'message' => 'Welcome to Traitement Service'
]);
