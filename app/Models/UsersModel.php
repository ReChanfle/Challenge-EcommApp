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

    public static function setToJson(string $username, string $password): string|null
    {
        $path = WRITEPATH . '../app/Database/users.json';
        if (!file_exists($path)) {
            return null;
        }

        try {
            $users = file_exists($path)
                ? json_decode(file_get_contents($path), true)
                : [];


            foreach ($users as $user) {
                if ($user['username'] === $username) {
                    return 'Error: El nombre de usuario ya existe.';
                }
            }

            $users[] = [
                'id' => uniqid(),
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT));

            return $username;

        }
        catch(Exception $e) {
            throw  new Exception(($e->getMessage()));
        }

    }


}