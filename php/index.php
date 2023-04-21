<?php

// Set headers to allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if the request method is valid
$method = $_SERVER['REQUEST_METHOD'];
if ($method != 'GET' && $method != 'POST' && $method != 'PUT' && $method != 'DELETE') {
    http_response_code(405);
    die('Method Not Allowed');
}

// Get the endpoint from the request URL
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

// Define the routes
switch ($endpoint) {
    case 'attendant':
        // Handle user-related requests
        require_once('attendant.php');

        if($method == 'POST'){
            
        }
        if($method == 'PUT'){

        }
        if($method == 'GET'){

        }
        if($method == 'DELETE'){

        }

        break;
    default:
        // Handle invalid endpoint requests
        http_response_code(404);
        echo json_encode(array('message' => 'Endpoint Not Found'));
        break;
}
