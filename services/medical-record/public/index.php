<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'medical-dossier',
    'status' => 'ok',
    'message' => 'Welcome to Medical Dossier Service'
]);
