<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Delete Api
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $requestData = json_decode(file_get_contents('php://input'), true);
    $comment_id = $requestData['id'];
    $params = array('comment_id' => $comment_id);
    $deleteComment = $connect->prepare("DELETE FROM comments WHERE comment_id = :comment_id");

    try {
        $deleteComment->execute($params);
        $response = [
            'status' => true,
            'message' => 'Delete Success!'
        ];
        http_response_code(200);
        echo json_encode($response);
    } catch (PDOException $e){
        $response = [
            'status' => false,
            'message' => 'Delete Failed!'
        ];
        http_response_code(500);
        echo json_encode($response);
    }
} else {
    $response = [
        'status' => false,
        'message' => 'Delete Failed Request'
    ];
    http_response_code(405);
    echo json_encode($response);
}

?>