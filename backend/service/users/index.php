<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Index Get ALL Manager
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

$users = $connect->prepare("SELECT * FROM users");
$users->execute();

$response = [
    'status' => true,
    'response' => [],
    'message' => 'Get Data Organizer Success'
];

foreach ($users as $row) {
    $response['response'][] = [
        'u_id' => $row['u_id'],
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'image' => $row['image'],
        'email' => $row['email']
    ];
}

http_response_code(200);
echo json_encode($response);