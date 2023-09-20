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
} else if ($page === 'rbessru') {
    $branch_name = 'rbessru';
} else if ($page === 'messru') {
    $branch_name = 'messru';
} else if ($page === 'stohssru') {
    $branch_name = 'stohssru';
} else if ($page === 'ietssru') {
    $branch_name = 'ietssru';
} else if ($page === 'real-fmssru') {
    $branch_name = 'real-fmssru';
} else if ($page === 'gmdssru') {
    $branch_name = 'gmdssru';
} else if ($page === 'iedssru') {
    $branch_name = 'iedssru';
} else if ($page === 'idssru') {
    $branch_name = 'idssru';
} else if ($page === 'printingssru') {
    $branch_name = 'printingssru';
}

$params = array('branch_name' => $branch_name);
$comments = $connect->prepare("SELECT b.blog_id, b.subject, b.image, b.category, c.comment_id, c.message, c.created_at, u.firstname, u.lastname
                            FROM blogs b
                            JOIN comments c ON b.blog_id = c.blog_id
                            JOIN users u on c.u_id = u.u_id
                            WHERE b.branch_name = :branch_name");
$comments->execute($params); 

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

foreach ($comments as $row) {
    $response['response'][] = [
        'comment_id' => $row['comment_id'],
        'blog_id' => $row['blog_id'],
        'image' => $row['image'],
        'subject' => $row['subject'],
        'category' => $row['category'],
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'message' => $row['message'],
        'created_at' => $row['created_at']
    ];
}

http_response_code(200);
echo json_encode($response);
