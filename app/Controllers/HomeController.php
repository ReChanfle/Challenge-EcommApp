<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;
use Exception;


class HomeController extends BaseController
{

    /**
     * Displays the login view.
     *
     * @return string
     */
    public function index(): string
    {
        return view('index');
    }

    /**
     * Handles the user login process.
     * Validates user input and attempts to store the user in the JSON file.
     * Redirects to the products page on success.
     *
     * @return RedirectResponse|string Returns a redirect on success or the login view with validation errors.
     * @throws Exception If an error occurs during user storage.
     */
    public function login(): RedirectResponse|string
    {

        if (! $this->validate(UsersModel::$rules)) {
            return view('index', ['validation' => $this->validator]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        try {
            UsersModel::setToJson($username, $password);

            return redirect()->to('/products');
        }
        catch (\Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }


    }

}