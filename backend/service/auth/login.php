<?php
/**
 **** AppzStory Back Office Management System Template ****
 * PHP Login API
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        http_response_code(400);
        echo json_encode($response = [
            'status' => false,
            'message' => 'กรุณากรอกชื่อผู้ใช้งาน'
        ]);
        exit;
    } else if (empty($password)) {
        http_response_code(400);
        echo json_encode($response = [
            'status' => false,
            'message' => 'กรุณากรอกรหัสผ่าน'
        ]);
        exit;
    } else {

        try {

            $params = array('username' => $username);
            $check_data = $connect->prepare("SELECT * FROM users_admin WHERE username = :username");
            $check_data->execute($params);
            $user = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($username == $user['username']) {
                    if ($user && custom_password_verify($password, $user['password'])) {

                        $_SESSION['AD_ID'] = $user['u_id'];
                        $_SESSION['AD_NAME'] = $user['name'];
                        $_SESSION['AD_BRANCH_NAME'] = $user['branch_name'];
                        $_SESSION['AD_IMAGE'] = $user['image'];
                        $_SESSION['AD_STATUS'] = $user['roles'];

                        $params = array('u_id' => $user['u_id']);
                        $stmt = $connect->prepare("SELECT login_latest FROM users_admin WHERE u_id = :u_id");
                        $stmt->execute($params);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($stmt->rowCount() > 0) {
                            $formattedDate = date("D, j M Y H:i:s", strtotime($row["login_latest"]));
                            $_SESSION['AD_LOGIN'] = $formattedDate;
                        } else {
                            $_SESSION['AD_LOGIN'] = 'N/A';
                        }
                        $stmt2 = $connect->prepare("UPDATE users_admin SET login_latest = NOW() WHERE u_id = :u_id");
                        $stmt2->execute($params);
                        
                        http_response_code(200);
                        echo json_encode($response = [
                            'status' => true,
                            'message' => 'เข้าสู่สำเร็จ'
                        ]);
                    } else {
                        http_response_code(400);
                        echo json_encode($response = [
                            'status' => false,
                            'message' => 'รหัสผ่านผิด กรุณากรอกใหม่อีกครั้ง'
                        ]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode($response = [
                        'status' => false,
                        'message' => 'ชื่อผู้ใช้งานผิด กรุณากรอกใหม่อีกครั้ง'
                    ]);
                }
            } else {
                http_response_code(400);
                echo json_encode($response = [
                    'status' => false,
                    'message' => 'ไม่มีข้อมูลในระบบ กรุณาลองอีกครั้ง'
                ]);
            }

        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode($response = [
                'status' => false,
                'message' => 'Login Failed' . $e->getMessage()
            ]);
        }
    }

    function custom_password_verify($password, $hashedPassword) {
        $hashedInputPassword = hash('sha256', $password);
        return $hashedInputPassword === $hashedPassword;
    }