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

    $blog_id = $_POST['blog_id'];
    
    $params = array('blog_id' => $blog_id,
                    'branch_name' => $_SESSION['AD_BRANCH_NAME'], 
                    'category' => 'picture');
    $updatePic = $connect->prepare("SELECT * FROM blogs WHERE blog_id = :blog_id AND branch_name = :branch_name AND category = :category");
    $updatePic->execute($params);

    foreach ($updatePic as $row) {
        $response['response'][] = [
            'blog_id' => $row['blog_id'],
            'image' => $row['image'],
            'subject' => $row['subject'],
            'subtitle' => $row['subtitle'],
            'blog_status' => $row['blog_status'],
        ];
    }
}


$response = [
    'status' => true,
    'message' => 'Update Success'
];
http_response_code(200);
echo json_encode($response);

?>