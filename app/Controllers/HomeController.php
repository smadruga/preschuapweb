<?php

namespace App\Controllers;

use App\Models\Usuario;
use CodeIgniter\RESTful\ResourceController;

class HomeController extends ResourceController
{
    private $var;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->session = \Config\Services::session();
        $this->var = new Usuario;
    }

    /**
    * Formulário de Acesso a aplicação web (GET)
    *
    * @return void
    */
    public function index()
    {

        return view('home/form_login');

    }

    /**
    * Formulário de Acesso a aplicação web, com validação e registro no Banco
    * de dados (POST)
    *
    * @return void
    */
    public function login()
    {

        $inputs = $this->validate([
            'Usuario' => 'required',
            'Senha' => 'required'
        ]);

        if (!$inputs) {
            session()->setFlashdata('failed', 'ERRO! <br> Atenção, verifique os campos abaixo.');
            return view('home/form_login', [
                'validation' => $this->validator
            ]);
        }

        /*
        $this->var->save([
            'Usuario' => $this->request->getVar('Usuario'),
            'Senha'  => $this->request->getVar('Senha')
        ]);
        session()->setFlashdata('success', 'Success! post created.');
        */
        return redirect()->to('/admin');

    }

}
