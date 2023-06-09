<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once '../vendor/autoload.php';


require_once 'services/UserService.class.php';
require_once 'services/MembershipService.class.php';
require_once 'Dao/UserDao.class.php';
require_once 'services/EmployeService.class.php';
require_once 'Dao/MembershipDao.class.php';
require_once 'Dao/UserMembershipDao.class.php';
require_once 'services/UserMembershipService.class.php';

Flight::register('userDao', 'UserDao');
Flight::register('userService', 'UserService');
Flight::register('membershipService', 'MembershipService');
Flight::register('employeService', 'EmployeService');
Flight::register('membershipDao', 'MembershipDao');
Flight::register('userMembershipDao', 'UserMembershipDao');
Flight::register('userMembershipService', 'UserMembershipService');




/*
Flight::map('error', function(Exception $ex){
    // Handle error
    Flight::json(['message' => $ex->getMessage()], 500);
});
*/



// middleware method for login
Flight::route(
    '/*', function () {
        //return TRUE;
        //perform JWT decode
        $path = Flight::request()->url;
        if ($path == '/login' || $path == '/docs.json' || $path == '/membership' || $path == '/register' || $path == '/employereg' || $path == '/usermembership' ) { return true; // exclude login route from middleware
        }

        $headers = getallheaders();
        if (@!$headers['Authorization']) {
            Flight::json(["message" => "Authorization is missing"], 403);
            return false;
        }else{
            try {
                $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
                Flight::set('user', $decoded);
                return true;
            } catch (\Exception $e) {
                Flight::json(["message" => "Authorization token is not valid"], 403);
                return false;
            }
        }
    }
);


/* REST API documentation endpoint */
Flight::route(
    'GET /docs.json', function () {
        $openapi = \OpenApi\scan('routes');
        header('Content-Type: application/json');
        echo $openapi->toJson();
    }
);



require_once './routes/UserRoutes.php';
require_once 'routes/MembershipRoutes.php';
require_once 'routes/EmployeRoutes.php';
require_once 'routes/UserMembershipRoutes.php';


Flight::start();
?>
