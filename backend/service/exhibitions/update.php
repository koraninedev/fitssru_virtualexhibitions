<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $namehall = $_POST['namehall'];

    $params = array('id' => $id,
                    'namehall' => $namehall,);

    $updateNamehall = $connect->prepare("UPDATE namehall SET name_hall = :namehall WHERE id = :id");

    try {
        $updateNamehall->execute($params);
        $response = [
            'status' => true,
            'message' => "Update NameHall success !"
        ];
        http_response_code(200);
        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Update NameHall failed !" . $e->getMessage()
        ]; 
        http_response_code(500);
        echo json_encode($response);
        exit;
    }
    
}
?>