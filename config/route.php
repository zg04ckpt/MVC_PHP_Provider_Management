<?php
$uri = $_SERVER['REQUEST_URI'];
$uri = strtok($uri, '?');
$segments = explode('/', trim($uri, '/'));
// print_r($segments);
if ($segments[0] === 'manage') {
    $controller = !empty($segments[1]) ? ucfirst($segments[1]) : 'Overview';
    $action = !empty($segments[2])? $segments[2] : 'index';
} else {
    $controller = !empty($segments[0]) ? ucfirst($segments[0]) : 'Home';
    $action = !empty($segments[1])? $segments[1] : 'index';
}

// Check and call controller -> action
$controller_name = ucfirst($controller) . 'Controller';
$controller_file_path = 'controllers/' . $controller_name . '.php';
if (!file_exists($controller_file_path)) {
    echo 'Chuyển hướng đến 404';
    return;
}

require_once $controller_file_path;
if (
    !class_exists($controller_name) || 
    !method_exists($controller_name, $action)
) {
    echo 'Chuyển hướng đến 404';
    return;
}
// echo $action;
try {
    (new $controller_name())->$action();
} catch (Exception $ex) {
    // print_r($ex);
    // echo 'Chuyển hướng đến trang lỗi';
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $ex->getMessage()
    ]);
}

