<?php

require_once __DIR__ . '/../dtos/ErrorResultDto.php';


class BaseController {
    private const MODEL_FOLDER_PATH = "models/";
    private const VIEWS_FOLDER_PATH = "views/";

    protected function loadModels($modelName) {
        require_once self::MODEL_FOLDER_PATH . $modelName . '.php';
    }

    protected function layout_view($path, $params = [], $isClient=false) {
        // Nhúng vào layout
        extract($params);
        ob_start();
        require_once self::VIEWS_FOLDER_PATH . $path . '.php';
        $content = ob_get_clean();

        $layout_file_path= $isClient? "layout/client" : "layout/admin";
        require_once self::VIEWS_FOLDER_PATH . $layout_file_path . '.php';
    }

    protected function view($path, $params = []) {
        extract($params);
        require_once self::VIEWS_FOLDER_PATH . $path . '.php';
    }

    protected function get_json() {
        $rawData = file_get_contents('php://input');
        return json_decode($rawData, true);
    }

    protected function return_success($message, $data=null) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ]);
    }

    protected function return_failure($message) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $message
        ]);
    }
}