<?php

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
    $thumbnailPath = BASE_PATH . 'assets/3dmodels/' . $branch_name . '/thumbnails/';
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

    $createVid = $connect->prepare("INSERT INTO blogs (branch_name, subject, subtitle, detail, image, url, blog_status, tags, category, created_at, updated_at)
                                        VALUES (:branch_name, :subject, :subtitle, :detail, :image, :url, :blog_status, :tags, :category, :created_at, :updated_at)");

    try {
        $createVid->execute($params);
        $blogId = $connect->lastInsertId();
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'message' => "Create Failed!" . $e->getMessage()
        ];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    if (!empty($_FILES['model']['tmp_name'][0])) {
        $uploadedFile = $_FILES['model']['tmp_name'][0];
        
        $randomNumber = mt_rand(100000, 999999);
        $filename = 'model-' . $randomNumber . '.' . 'obj';

        $modelPath = BASE_PATH . 'assets/3dmodels/' . $branch_name . '/3dmodels/';

        $target3dPath = $modelPath . $filename;
        
        if (move_uploaded_file($uploadedFile, $target3dPath)) {
            $params = array(
                'model' => $filename,
                'blog_id' => $blogId,
                'created_at' => date('Y-m-d H:i:s')
            );

            $insertModelQuery = $connect->prepare("INSERT INTO 3dmodels (model, blog_id, created_at)
                                                   VALUES (:model, :blog_id, :created_at)");

            try {
                $insertModelQuery->execute($params);                
                $response = [
                    'status' => true,
                    'message' => "Create Success!",
                ];
                http_response_code(200);
                echo json_encode($response);
                exit;
            } catch (PDOException $e) {
                $response = [
                    'status' => false,
                    'message' => "Create Failed SQL Not Working!",
                ];
                http_response_code(400);
                echo json_encode($response);
                exit;
            }
        } else {
            $response = [
                'status' => false,
                'message' => "Create failed file error!",
            ];
            http_response_code(400);
            echo json_encode($response);
            exit;
        }

    } else {
        $response = [
            'status' => false,
            'message' => "Create filed! No Model uploaded."
        ];
        http_response_code(404);
        echo json_encode($response);
    }
} else {
        $response = [
            'status' => false,
            'message' => "Create Failed Request Wrong!"
        ];
        http_response_code(405);
        echo json_encode($response);
}

?>