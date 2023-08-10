<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Create Admin
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $blogId = null;
    $branch_name = $_POST['branch_name'];
    $subject = $_POST['subject'];
    $subtitle = $_POST['subtitle'];
    $detail = $_POST['detail'];
    $url = $_POST['url'];
    $blog_status = $_POST['status'];
    $category = $_POST['category'];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
 
    define('BASE_PATH', 'C:/xampp/htdocs/fitssru_virtualexhibitions/');
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

    $randomNumber = mt_rand(100000, 999999);
    $filename = 'thumbnail-' . $randomNumber . '.' . $extension;

    imagejpeg($resizedImage, $thumbnailPath . $filename);
    imagedestroy($resizedImage);
    $params = array(
        'branch_name' => $branch_name,
        'subject' => $subject,
        'subtitle' => $subtitle,
        'detail' => $detail,
        'image' => $filename,
        'url' => $url,
        'blog_status' => $blog_status,
        'tags' => 1,
        'category' => $category,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    );

    $createPic = $connect->prepare("INSERT INTO blogs (branch_name, subject, subtitle, detail, image, url, blog_status, tags, category, created_at, updated_at)
                                        VALUES (:branch_name, :subject, :subtitle, :detail, :image, :url, :blog_status, :tags, :category, :created_at, :updated_at)");

    try {
        /* $createPic->execute($params);
        $blogId = $connect->lastInsertId(); */
        $response = [
            'status' => true,
            'message' => "Create Success!"
        ];
        http_response_code(200);
        echo json_encode($response);
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Create Failed!" . $e->getMessage()
        ];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    if (!empty($_FILES['images']['tmp_name'][0])) {
        var_dump($_FILES['images']);
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
                'blog_id' => $blogId,
                'created_at' => date('Y-m-d H:i:s')
            );
            // Insert the image details into the pictures table
            $insertImageQuery = $connect->prepare("INSERT INTO pictures (image, blog_id, created_at)
                                                   VALUES (:image, :blog_id, :created_at)");

            try {
                /* $insertImageQuery->execute($params); */
                $insertedImages[] = [
                    'image' => $filename,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } catch (PDOException $e) {
                $response = [
                    'status' => false,
                    'message' => "Create Failed! " . $e->getMessage(),
                ];
                http_response_code(200);
                echo json_encode($response);
            }
        }
        $response = [
            'status' => true,
            'message' => "Create Success!",
        ];
        http_response_code(200);
        echo json_encode($response);
    } else {
        $response = [
            'status' => true,
            'message' => "Create Success! No images uploaded."
        ];
        http_response_code(200);
        echo json_encode($response);
    }
} else {
        $response = [
            'status' => false,
            'message' => "Create Failed RequestWrong!"
        ];
        http_response_code(405);
        echo json_encode($response);
}

?>