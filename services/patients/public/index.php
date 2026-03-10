<?php
header('Content-Type: application/json');
echo json_encode([
    'service' => 'patients',
    'status' => 'ok',
    'message' => 'Welcome to Patients Service'
]);
