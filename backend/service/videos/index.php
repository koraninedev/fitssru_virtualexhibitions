<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Index Get ALL Products
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

$page = isset($_GET['page']) ? $_GET['page'] : '';

$branch_name = $_SESSION['AD_BRANCH_NAME'];

if ($page === 'cessru') {
    $branch_name = 'cessru';
}

$params = array('branch_name' => $branch_name, 'category' => 'video');
$video = $connect->prepare("SELECT * FROM blogs WHERE branch_name = :branch_name AND category = :category");
$video->execute($params);

/** 
 * กำหนดข้อมูลสำหรับการ Response ไปยังฝั่ง Client
 * 
 * @return array 
 */
$response = [
    'status' => true,
    'response' => [],
    'message' => 'Get Data Success'
];

foreach ($video as $row) {
    $response['response'][] = [
        'blog_id' => $row['blog_id'],
        'image' => $row['image'],
        'subject' => $row['subject'],
        'subtitle' => $row['subtitle'],
        'blog_status' => $row['blog_status'],
    ];
}

http_response_code(200);
echo json_encode($response);
