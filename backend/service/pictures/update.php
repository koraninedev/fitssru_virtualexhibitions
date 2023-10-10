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

    $blog_id = $_POST['blog_id'];
    $subject = $_POST['subject'];
    $subtitle = $_POST['subtitle'];
    $detail = $_POST['detail'];
    $url = $_POST['url'];
    $blog_status = $_POST['status'];
    $branch_name = $_POST['branch_name'];
    $origiThumbnail = $_POST['name_thumbnail'];
    $updated_at = date('Y-m-d H:i:s');

    define('BASE_PATH', 'C:/xampp/htdocs/fitssru_virtualexhibitions/');

    if (!empty($_FILES['thumbnail']['name']) && empty($_FILES['images']['name'][0])) {
        /* echo 'thumbnail not empty but images empty'; */
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
            $response = [
                'status' => true,
                'message' => "Update blog success !"
            ];
            http_response_code(200);
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'message' => "Create Failed!" . $e->getMessage()
            ];
            http_response_code(500);
            echo json_encode($response);
            exit;
        }

    } else if (!empty($_FILES['images']['name'][0]) && empty($_FILES['thumbnail']['name'])){
        /* echo 'images not empty but thumbnail empty'; */

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
        $params = array('blog_id' => $blog_id,
                        'subject' => $subject,
                        'subtitle' => $subtitle,
                        'detail' => $detail,
                        'url' => $url,
                        'blog_status' => $blog_status,
                        'updated_at' => $updated_at);
        $updatePic = $connect->prepare("UPDATE blogs SET subject = :subject,
                                                         subtitle = :subtitle,
                                                         detail = :detail,
                                                         url = :url,
                                                         blog_status = :blog_status,
                                                         updated_at = :updated_at
                                                         WHERE blog_id = :blog_id");
        try {
            $updatePic->execute($params);
            $response = [
                'status' => true,
                'message' => "Update blog success !"
            ];
            http_response_code(200);
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'message' => "Update blog failed !"
            ]; 
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
    } else if (!empty($_FILES['thumbnail']['name']) && (!empty($_FILES['images']['name'][0]))) {
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
            } else {
                $response = [
                    'status' => false,
                    'message' => "รองรับเฉพาะไฟล์ภาพนามสกุล png และ jpg เท่านั้น"
                ];
                http_response_code(405);
                echo json_encode($response);
                exit;
            }

            define('MIN_WIDTH', 640);
            define('MIN_HEIGHT', 480);
            define('MAX_WIDTH', 1920);
            define('MAX_HEIGHT', 1080);

            if ($width < MIN_WIDTH || $height < MIN_HEIGHT || $width > MAX_WIDTH || $height > MAX_HEIGHT) {
                $response = [
                    'status' => false,
                    'message' => 'ขนาดของรูปภาพรองรับตั้งแต่ ' . MIN_WIDTH . 'x' . MIN_HEIGHT . ' ถึง ' . MAX_WIDTH . 'x' . MAX_HEIGHT . ' พิกเซล'
                ];
                http_response_code(400);  // 400 Bad Request เพราะข้อมูลที่ส่งมาไม่ถูกต้อง
                echo json_encode($response);
                exit;
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
    } else if (empty($_FILES['thumbnail']['name']) && (empty($_FILES['images']['name'][0]))) {
        /* echo 'thumbnail and images empty'; */
        
        $params = array('blog_id' => $blog_id,
                        'subject' => $subject,
                        'subtitle' => $subtitle,
                        'detail' => $detail,
                        'url' => $url,
                        'blog_status' => $blog_status,
                        'updated_at' => $updated_at);
        $updatePic = $connect->prepare("UPDATE blogs SET subject = :subject,
                                                         subtitle = :subtitle,
                                                         detail = :detail,
                                                         url = :url,
                                                         blog_status = :blog_status,
                                                         updated_at = :updated_at
                                                         WHERE blog_id = :blog_id");
    
        try {
            $updatePic->execute($params);
            $response = [
                'status' => true,
                'message' => "Update blog success !"
            ];
            http_response_code(200);
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'message' => "Update blog failed !"
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