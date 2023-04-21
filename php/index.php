<?php

// Set headers to allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once('db.php');

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
    case 'auth':
        // Handle authentication requests
        require_once('auth.php');

        if($method == 'POST'){
            $auth = new Auth($_POST, $db);
            $auth->login();
        }

        break;
    case 'attendant':
        // Handle user-related requests
        require_once('attendant.php');

        if($method == 'POST'){
            $attendant = new MusicFestivalAttendant($_POST,$db);

            if($attendant->getAttendantByEmail()){
                http_response_code(500);
                echo json_encode(array('message' => 'You have already registered with this email!'));
                return;
            }

            try{
                $attendant->create();
                http_response_code(201);
                echo json_encode(array('message' => 'You have registered successfully'));
            } catch(Exception $e) {
                http_response_code(500);
                echo json_encode(array('message' => 'Unable to create attendant: ' . $e->getMessage()));
            }
        }
        if($method == 'PUT'){

        }
        if($method == 'GET'){
            
            $attendantId = $_GET['id'];
            
            if ($attendantId) {
                $attendant = new MusicFestivalAttendant($db);
                if ($attendant->getAttendantById($attendantId)) {
                    echo json_encode(array(
                        'id' => $attendant->getId(),
                        'name' => $attendant->getName(),
                        'email' => $attendant->getEmail(),
                        'age' => $attendant->getAge(),
                        'gender' => $attendant->getGender(),
                        'nationality' => $attendant->getNationality(),
                        'ticket_type' => $attendant->getTicketType()
                    ));
                } else {
                    http_response_code(404);
                    echo json_encode(array('message' => 'Attendant not found'));
                }
            }

            $attendant = new MusicFestivalAttendant([],$db);
            $attendants = $attendant->getAllAttendants();
            echo json_encode($attendants);
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
