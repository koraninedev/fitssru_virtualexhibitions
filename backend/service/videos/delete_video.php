<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["videoId"])) {
    $videoId = $_POST["videoId"];

    $params = array('video_id' => $videoId);
    $delVid = $connect->prepare("SELECT video FROM videos WHERE id = :video_id");
    $delVid->execute($params);
    $vidRow = $delVid->fetch(PDO::FETCH_ASSOC);

    if ($vidRow) {
        $videoFileName = $vidRow['video'];
        $videoPath = "../../../assets/videos/" . $_SESSION['AD_BRANCH_NAME'] . "/videos/" . $videoFileName;
        
        if (file_exists($videoPath)) {
            unlink($videoPath);
        }

        $paramsDel = array('video_id' => $videoId);
        $deleteStmt = $connect->prepare("DELETE FROM videos WHERE id = :video_id");
        $deleteStmt->execute($paramsDel);

        $response = [
            'status' => true,
            'message' => "Video Delete Success!",
        ];
        http_response_code(200);
        echo json_encode($response);
    } else {
        $response = [
            'status' => false,
            'message' => "Video not found.",
        ];
        http_response_code(404);
        echo json_encode($response);
    }
} else {
    $response = [
        'status' => false,
        'message' => "Invalid request.",
    ];
    http_response_code(400);
    echo json_encode($response);
}

?>