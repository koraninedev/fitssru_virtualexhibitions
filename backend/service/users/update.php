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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $u_id = $_POST['u_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $params = array('u_id' => $u_id,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'email' => $email);

    if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $params['password'] = $hashedPassword;
    }

    $updateUser = $connect->prepare("UPDATE users SET firstname = :firstname,
                                                                lastname = :lastname,
                                                                email = :email
                                                                " . (!empty($password) ? ", password = :password" : "") . "
                                                                WHERE u_id = :u_id");

    try {
        $updateUser->execute($params);
        $response = [
            'status' => true,
            'message' => "Update User success !"
        ];
        http_response_code(200);
        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Update User failed !" . $e->getMessage()
        ]; 
        http_response_code(500);
        echo json_encode($response);
        exit;
    }
    
}
?>