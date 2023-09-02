<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["imageId"])) {
    $imageId = $_POST["imageId"];

    $params = array('image_id' => $imageId);
    $delPic = $connect->prepare("SELECT image FROM pictures WHERE id = :image_id");
    $delPic->execute($params);
    $imageRow = $delPic->fetch(PDO::FETCH_ASSOC);

    if ($imageRow) {
        $imageFileName = $imageRow['image'];
        $imagePath = "../../../assets/pictures/" . $_SESSION['AD_BRANCH_NAME'] . "/images/" . $imageFileName;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $paramsDel = array('image_id' => $imageId);
        $deleteStmt = $connect->prepare("DELETE FROM pictures WHERE id = :image_id");
        $deleteStmt->execute($paramsDel);

        $response = [
            'status' => true,
            'message' => "Image Delete Success!",
        ];
        http_response_code(200);
        echo json_encode($response);

    } else {
        $response = [
            'status' => false,
            'message' => "Image not found.",
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