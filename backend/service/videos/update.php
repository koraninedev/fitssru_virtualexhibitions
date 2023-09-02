<?php

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
    $origiVideo = $_POST['name_video'];
    $updated_at = date('Y-m-d H:i:s');

    define('BASE_PATH', 'C:/xampp/htdocs/fitssru_virtualexhibitions/');

    if (!empty($_FILES['thumbnail']['name']) && empty($_FILES['video']['name'][0])) {
        /* echo 'thumbnail not empty but images empty'; */
        $thumbnailPath = BASE_PATH . 'assets/videos/' . $branch_name . '/thumbnails/';
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

    } else if (!empty($_FILES['video']['name'][0]) && empty($_FILES['thumbnail']['name'])){
        /* echo 'video not empty but thumbnail empty'; */

        $videoPath = BASE_PATH . 'assets/videos/' . $branch_name . '/videos/';
        $allowedVideoExtensions = ["mp4", "avi", "mov", "mkv"];
        $numVideos = count($_FILES['video']['tmp_name']);

        if (!empty($origiVideo)) {
            $existingVideoPath = $videoPath . $origiVideo;
            if (file_exists($existingVideoPath)) {
                unlink($existingVideoPath);
            }

            $params = array('origiVideo' => $origiVideo);
            $deleteVideo = $connect->prepare("DELETE FROM videos WHERE video = :origiVideo");
            $deleteVideo->execute($params);
        }
        
        for ($i = 0; $i < $numVideos; $i++) {
            $tmpName = $_FILES['video']['tmp_name'][$i];
            $extension = strtolower(pathinfo($_FILES['video']['name'][$i], PATHINFO_EXTENSION));
        
            if (in_array($extension, $allowedVideoExtensions)) {
                $randomNumber = mt_rand(100000, 999999);
                $filename = 'video-' . $randomNumber . '.' . $extension;
                $destination = $videoPath . $filename;
        
                if (move_uploaded_file($tmpName, $destination)) {
                    $params = array(
                        'video' => $filename,
                        'blog_id' => $blog_id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
        
                    $insertVideoQuery = $connect->prepare("INSERT INTO videos (video, blog_id, created_at)
                                                           VALUES (:video, :blog_id, :created_at)");
        
                    try {
                        $insertVideoQuery->execute($params);                
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
                    'message' => "Create failed file not supported!",
                ];
                http_response_code(400);
                echo json_encode($response);
                exit;
            }
        }
        $params = array('blog_id' => $blog_id,
                        'subject' => $subject,
                        'subtitle' => $subtitle,
                        'detail' => $detail,
                        'url' => $url,
                        'blog_status' => $blog_status,
                        'updated_at' => $updated_at);
        $updateVid = $connect->prepare("UPDATE blogs SET subject = :subject,
                                                         subtitle = :subtitle,
                                                         detail = :detail,
                                                         url = :url,
                                                         blog_status = :blog_status,
                                                         updated_at = :updated_at
                                                         WHERE blog_id = :blog_id");
        try {
            $updateVid->execute($params);
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
    } else if (!empty($_FILES['thumbnail']['name']) && (!empty($_FILES['video']['name'][0]))) {
        /* echo 'thumbnail and video not empty'; */

        /* THUMBNAIL */
        $thumbnailPath = BASE_PATH . 'assets/videos/' . $branch_name . '/thumbnails/';
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

        /* VIDEOS */
        $videoPath = BASE_PATH . 'assets/videos/' . $branch_name . '/videos/';
        $allowedVideoExtensions = ["mp4", "avi", "mov", "mkv"];
        $numVideos = count($_FILES['video']['tmp_name']);

        if (!empty($origiVideo)) {
            $existingVideoPath = $videoPath . $origiVideo;
            if (file_exists($existingVideoPath)) {
                unlink($existingVideoPath);
            }

            $params = array('origiVideo' => $origiVideo);
            $deleteVideo = $connect->prepare("DELETE FROM videos WHERE video = :origiVideo");
            $deleteVideo->execute($params);
        }
        
        for ($i = 0; $i < $numVideos; $i++) {
            $tmpName = $_FILES['video']['tmp_name'][$i];
            $extension = strtolower(pathinfo($_FILES['video']['name'][$i], PATHINFO_EXTENSION));
        
            if (in_array($extension, $allowedVideoExtensions)) {
                $randomNumber = mt_rand(100000, 999999);
                $filename = 'video-' . $randomNumber . '.' . $extension;
                $destination = $videoPath . $filename;
        
                if (move_uploaded_file($tmpName, $destination)) {
                    $params = array(
                        'video' => $filename,
                        'blog_id' => $blog_id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
        
                    $insertVideoQuery = $connect->prepare("INSERT INTO videos (video, blog_id, created_at)
                                                           VALUES (:video, :blog_id, :created_at)");
        
                    try {
                        $insertVideoQuery->execute($params);                
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
                    'message' => "Create failed file not supported!",
                ];
                http_response_code(400);
                echo json_encode($response);
                exit;
            }
        }
    } else if (empty($_FILES['thumbnail']['name']) && (empty($_FILES['video']['name'][0]))) {
        /* echo 'thumbnail and video empty'; */
        
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