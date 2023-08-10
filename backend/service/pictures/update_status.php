<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Update Admin
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $requestData = json_decode(file_get_contents('php://input'), true);
    $blogId = $requestData['blog_id'];
    $isChecked = $requestData['blog_status'];

    /* $enumValue = $isChecked ? 'true' : 'false'; */

    $params = array('blog_id' => $blogId,
                    'blog_status' => $isChecked);
    $updateStatus = $connect->prepare("UPDATE blogs SET blog_status = :blog_status WHERE blog_id = :blog_id");

    try {
        $updateStatus->execute($params);
        $response = [
            'status' => true,
            'message' => "Update Status Success!"
        ];
        http_response_code(200);
        echo json_encode($response);
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Update Status Failed!"
        ]; 
        http_response_code(500);
        echo json_encode($response);
    }
} else {
    $response = [
        'status' => false,
        'message' => "Update Status Failed! but wrong request"
    ]; 
    http_response_code(405);
    echo json_encode($response);
}

?>