<?php

namespace App\Controllers;

use App\Models\Post;
use CodeIgniter\RESTful\ResourceController;

class HomeController extends ResourceController
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
        return view('home/form_login');
    }

    /**
    * Return an array of resource objects, themselves in array format
    *
    * @return mixed
    */
    public function login()
    {
        #exit(base_url('admin'));
        /*
        $inputs = $this->validate([
            'Usuario' => 'required',
            'Senha' => 'required'
        ]);

        if (!$inputs) {
            return view('home/index', [
                'validation' => $this->validator
            ]);
        }

        /*
        $this->post->save([
            'title' => $this->request->getVar('title'),
            'description'  => $this->request->getVar('description')
        ]);
        session()->setFlashdata('success', 'Success! post created.');
        */
#echo 'oioioi';
        return redirect()->to('/admin');
        #return redirect()->route(base_url('admin'));


    }

}
