<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;
use mysql_xdevapi\Exception;

class HomeController extends BaseController
{

    public function index(): string
    {
        return view('index');
    }

    public function login(): RedirectResponse|string
    {

        if (! $this->validate(UsersModel::$rules)) {
            return view('index', ['validation' => $this->validator]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        try {
            $user = UsersModel::setToJson( $username, $password);

            return redirect()->to('/products');
        }
        catch (\Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }


    }

}