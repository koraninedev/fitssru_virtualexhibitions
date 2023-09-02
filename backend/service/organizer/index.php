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

$params = array('roles' => 'admin');
$organizer = $connect->prepare("SELECT * FROM users_admin WHERE roles = :roles");
$organizer->execute($params);

$response = [
    'status' => true,
    'response' => [],
    'message' => 'Get Data Organizer Success'
];

foreach ($organizer as $row) {
    $response['response'][] = [
        'u_id' => $row['u_id'],
        'image' => $row['image'],
        'name' => $row['name'],
        'username' => $row['username'],
        'login_latest' => $row['login_latest'],
    ];
}

http_response_code(200);
echo json_encode($response);