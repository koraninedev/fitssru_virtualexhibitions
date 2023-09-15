<?php

header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $u_id = $_POST['id'];

    $paramsDel = array('u_id' => $u_id);
    $deleteStmt = $connect->prepare("DELETE FROM users WHERE u_id = :u_id");

    try {
        $deleteStmt->execute($paramsDel);
        $response = [
            'status' => true,
            'message' => "Delete User Success"
        ];
        http_response_code(204);
        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Delete User Failed! " . $e->getMessage(),
        ];
        http_response_code(400);
        echo json_encode($response);
        exit;
    }
}



?>