<?php
header('Content-Type: application/json');
require_once '../connect.php';

try {
    $namehall = $connect->prepare("SELECT * FROM namehall");
    $namehall->execute(); 

    $data = $namehall->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'status' => true,
        'response' => $data,
        'message' => 'Get Data Success'
    ];
    
    http_response_code(200);
    echo json_encode($response);

} catch (PDOException $e) {
    $response = [
        'status' => false,
        'response' => [],
        'message' => 'Get Data Failed: ' . $e->getMessage()
    ];
    
    http_response_code(500);
    echo json_encode($response);
}

