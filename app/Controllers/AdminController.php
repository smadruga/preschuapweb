<?php

namespace App\Controllers;

use App\Models\Post;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController
{
    private $var;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->session = \Config\Services::session();
        #$this->var = new Usuario;
    }

    /**
    * Return an array of resource objects, themselves in array format
    *
    * @return mixed
    */
    public function index()
    {
        $session = \Config\Services::session();
        return view('admin/tela_admin');
    }

}
