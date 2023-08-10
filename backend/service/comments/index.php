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

$params = array('branch_name' => $_SESSION['AD_BRANCH_NAME']);
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
