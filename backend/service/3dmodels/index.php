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

$params = array('branch_name' => $_SESSION['AD_BRANCH_NAME'], 'category' => '3dmodel');
$blogs3d = $connect->prepare("SELECT * FROM blogs WHERE branch_name = :branch_name AND category = :category");
$blogs3d->execute($params);

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

foreach ($blogs3d as $row) {
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
