<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UsersModel extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'id';

    public static $rules = [
        'username' => 'required|min_length[3]',
        'password' => 'required|min_length[6]'
    ];

    /**
     * Creates a new user and stores it in a JSON file
     *
     * @param string $username The username for the new user
     * @param string $password The password for the new user (will be hashed)
     * @return string|null Returns the username on success, an error message if username exists,
     *                     or null if the users file doesn't exist
     * @throws Exception If any error occurs during the user creation process
     */
    public static function setToJson(string $username, string $password): string|null
    {
        $path = WRITEPATH . 'users.json';
        $logFile = WRITEPATH . 'logs/user_creations.log';


        if (!file_exists($path)) {
            return null;
        }

        try {
            $users = file_exists($path)
                ? json_decode(file_get_contents($path), true)
                : [];


            $users[] = [
                'id' => uniqid(),
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT));
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - User created: id-> {$users[0]['id']}, username-> {$users[0]['username'] }\n", FILE_APPEND);
            return $username;

        }
        catch(Exception $e) {
            throw  new Exception(($e->getMessage()));
        }

    }


}