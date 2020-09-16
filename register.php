<?php
// required headers
header("Access-Control-Allow-Origin: http://spadecontactmanager.com/test/rest-api-authentication/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$user->username = $data->username;
$user->password = $data->password;
$user->password2 = $data->password2;
 
// create the user
if(
    !empty($user->username) &&
    !empty($user->password) &&
	($user->password == $user->password2) &&
	
    $user->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
	
	// display if reason was because passwords don't match
	if(
		!($user->password == $user->password2)
	){
		//set response code
		http_response_code(401);
		
		//display message: passwords do not match
		echo json_encode(array("message" => "Passwords do not match."));
	}
	
	// display if reason was because username already in use
	if(
		$user->usernameExists()
	){
		//set response code
		http_response_code(402);
		
		//display message: username already in use
		echo json_encode(array("message" => "Username already in use."));
	}
}
?>