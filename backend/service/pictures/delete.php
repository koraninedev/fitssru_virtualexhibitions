<?php

header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $blog_id = $_POST['id'];

    $paramsDel = array('blog_id' => $blog_id);
    $deleteStmt = $connect->prepare("DELETE FROM blogs WHERE blog_id = :blog_id");

    try {
        $deleteStmt->execute($paramsDel);
        $response = [
            'status' => true,
            'message' => "Delete Success blog"
        ];
        http_response_code(204);
        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Delete Failed! " . $e->getMessage(),
        ];
        http_response_code(400);
        echo json_encode($response);
        exit;
    }
}



?>