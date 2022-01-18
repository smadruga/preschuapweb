<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TesteController extends BaseController
{
    /**
     * constructor
     */
    public function __construct()
    {
        helper(['form', 'url']);
    }

    /**
     * User Registration form
     *
     * @return void
     */
    public function index()
    {
        return view('teste/form_teste');
    }

    /**
     * Register User
     *
     * @return void
     */
    public function create() {
        $inputs = $this->validate([
            'name' => 'required|min_length[5]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[5]|alpha_numeric',
            'confirm_password' => 'required|matches[password]',
            'phone' => 'required|numeric|regex_match[/^[0-9]{10}$/]',
            'address' => 'required|min_length[10]'
        ]);

        if (!$inputs) {
            return view('teste/form_teste', [
                'validation' => $this->validator
            ]);
        }
    }
}
