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
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $branch_name = $_POST['branch_name'];
    $origiImage = $_POST['name_image'];

    define('BASE_PATH', 'C:/xampp/htdocs/fitssru_virtualexhibitions/');

    if (!empty($_FILES['image']['name'])) {
        /* echo 'image not empty'; */
        $imagePath = BASE_PATH . 'backend/assets/images/';
        $width;
        $height;

        list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
        $newWidth = $width < 1280 ? $width : 1280;
        $newHeight = ($height / $width) * $newWidth;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if ($extension == "jpg" || $extension == "jpeg") {
            $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
        } elseif ($extension == "png") {
            $image = imagecreatefrompng($_FILES['image']['tmp_name']);
        } elseif ($extension == "gif") {
            $image = imagecreatefromgif($_FILES['image']['tmp_name']);
        } else {
            $response = [
                'status' => false,
                'message' => "File Image Not Suported"
            ];
            http_response_code(405);
            echo json_encode($response);
        }

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        if (!empty($origiImage)) {
            $existingImagePath = $imagePath . $origiImage;
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
        }
        
        $filename = $branch_name . '.' . $extension;

        imagejpeg($resizedImage, $imagePath . $filename);
        imagedestroy($resizedImage);
        $params = array('u_id' => $u_id,
                        'name' => $name,
                        'username' => $username,
                        'image' => $filename);

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $params['password'] = $hashedPassword;
        }

        $updateUser = $connect->prepare("UPDATE users_admin SET name = :name,
                                                        username = :username,
                                                        " . (!empty($password) ? "password = :password," : "") . "
                                                        image = :image
                                                        WHERE u_id = :u_id");
        try {
            $updateUser->execute($params);
            $response = [
                'status' => true,
                'message' => "Update Organizer success !"
            ];
            http_response_code(200);
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'message' => "Update Failed!" . $e->getMessage()
            ];
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
        /* echo 'thumbnail and images not empty'; */

        /* THUMBNAIL */
        $thumbnailPath = BASE_PATH . 'assets/pictures/' . $branch_name . '/thumbnails/';
        $width;
        $height;

        list($width, $height) = getimagesize($_FILES['thumbnail']['tmp_name']);
        $newWidth = $width < 1280 ? $width : 1280;
        $newHeight = ($height / $width) * $newWidth;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        $extension = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
        if ($extension == "jpg" || $extension == "jpeg") {
            $image = imagecreatefromjpeg($_FILES['thumbnail']['tmp_name']);
        } elseif ($extension == "png") {
            $image = imagecreatefrompng($_FILES['thumbnail']['tmp_name']);
        } elseif ($extension == "gif") {
            $image = imagecreatefromgif($_FILES['thumbnail']['tmp_name']);
        } else {
            $response = [
                'status' => false,
                'message' => "File Image Not Suported"
            ];
            http_response_code(405);
            echo json_encode($response);
        }

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        if (!empty($origiThumbnail)) {
            $existingThumbnailPath = $thumbnailPath . $origiThumbnail;
            if (file_exists($existingThumbnailPath)) {
                unlink($existingThumbnailPath);
            }
        }

        $randomNumber = mt_rand(100000, 999999);
        $filename = 'thumbnail-' . $randomNumber . '.' . $extension;

        imagejpeg($resizedImage, $thumbnailPath . $filename);
        imagedestroy($resizedImage);
        $params = array('blog_id' => $blog_id,
                        'subject' => $subject,
                        'subtitle' => $subtitle,
                        'detail' => $detail,
                        'image' => $filename,
                        'url' => $url,
                        'blog_status' => $blog_status,
                        'updated_at' => $updated_at);

        $updatePic = $connect->prepare("UPDATE blogs SET subject = :subject,
                                                        subtitle = :subtitle,
                                                        detail = :detail,
                                                        image = :image,
                                                        url = :url,
                                                        blog_status = :blog_status,
                                                        updated_at = :updated_at
                                                        WHERE blog_id = :blog_id");
        try {
            $updatePic->execute($params);
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'message' => "Create Failed!" . $e->getMessage()
            ];
            http_response_code(500);
            echo json_encode($response);
            exit;
        }

        /* IMAGES */
        $imagePath = BASE_PATH . 'assets/pictures/' . $branch_name . '/images/';
        $width;
        $height;
        $numImages = count($_FILES['images']['tmp_name']);
        $insertedImages = [];

        for ($i = 0; $i < $numImages; $i++) {
            $tmpName = $_FILES['images']['tmp_name'][$i];

            list($width, $height) = getimagesize($_FILES['images']['tmp_name'][$i]);
            $newWidth = $width < 1280 ? $width : 1280;
            $newHeight = ($height / $width) * $newWidth;

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            $extension = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
            if ($extension == "jpg" || $extension == "jpeg") {
                $image = imagecreatefromjpeg($_FILES['images']['tmp_name'][$i]);
            } elseif ($extension == "png") {
                $image = imagecreatefrompng($_FILES['images']['tmp_name'][$i]);
            } elseif ($extension == "gif") {
                $image = imagecreatefromgif($_FILES['images']['tmp_name'][$i]);
            } else {
                $response = [
                    'status' => false,
                    'message' => "File Image Not Suported"
                ];
                http_response_code(405);
                echo json_encode($response);
            }

            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);

            $randomNumber = mt_rand(100000, 999999);
            $filename = 'image-' . $randomNumber . '.' . $extension;

            imagejpeg($resizedImage, $imagePath . $filename);
            imagedestroy($resizedImage);

            $params = array(
                'image' => $filename,
                'blog_id' => $blog_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $insertImageQuery = $connect->prepare("INSERT INTO pictures (image, blog_id, created_at)
                                                   VALUES (:image, :blog_id, :created_at)");

            try {
                $insertImageQuery->execute($params);
                $insertedImages[] = [
                    'image' => $filename,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } catch (PDOException $e) {
                $response = [
                    'status' => false,
                    'message' => "Create Failed! " . $e->getMessage(),
                ];
                http_response_code(400);
                echo json_encode($response);
            }
        }
        $response = [
            'status' => true,
            'message' => "Update blog success !"
        ];
        http_response_code(200);
        echo json_encode($response);
    } else if (empty($_FILES['image']['name'])) {
        /* echo 'images empty'; */
        
        $params = array('u_id' => $u_id,
                        'name' => $name,
                        'username' => $username);

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $params['password'] = $hashedPassword;
        }

        $updateUser = $connect->prepare("UPDATE users_admin SET name = :name,
                                                                username = :username" . (!empty($password) ? ", password = :password" : "") . "
                                                                WHERE u_id = :u_id");
    
        try {
            $updateUser->execute($params);
            $response = [
                'status' => true,
                'message' => "Update Organizer success !"
            ];
            http_response_code(200);
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'message' => "Update Organizer failed !" . $e->getMessage()
            ]; 
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
    } else {
        $response = [
            'status' => false,
            'message' => "File Not Supported"
        ]; 
        http_response_code(500);
        echo json_encode($response);
    }   
}

?>