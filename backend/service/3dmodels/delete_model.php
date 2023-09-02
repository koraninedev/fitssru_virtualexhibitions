<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modelId"])) {
    $modelId = $_POST["modelId"];

    $params = array('model_id' => $modelId);
    $del3D = $connect->prepare("SELECT model FROM 3dmodels WHERE id = :model_id");
    $del3D->execute($params);
    $modelRow = $del3D->fetch(PDO::FETCH_ASSOC);

    if ($modelRow) {
        $modelFileName = $modelRow['model'];
        $modelPath = "../../../assets/3dmodels/" . $_SESSION['AD_BRANCH_NAME'] . "/3dmodels/" . $modelFileName;
        
        if (file_exists($modelPath)) {
            unlink($modelPath);
        }

        $paramsDel = array('model_id' => $modelId);
        $deleteStmt = $connect->prepare("DELETE FROM 3dmodels WHERE id = :model_id");
        /* $deleteStmt->execute($paramsDel); */

        $response = [
            'status' => true,
            'message' => "Model Delete Success!",
        ];
        http_response_code(200);
        echo json_encode($response);
    } else {
        $response = [
            'status' => false,
            'message' => "Model not found.",
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