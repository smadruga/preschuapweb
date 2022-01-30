<?php

namespace App\Controllers;

use App\Models\Post;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController
{
    private $v;

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
        #$session = \Config\Services::session();
        return view('admin/tela_admin');
    }

    public function find_user()
    {
        $v['form_open'] = 'admin/encontrar';
        return view('admin/usuario/form_pesquisa_usuario', $v);
    }

    public function get_user()
    {

        #$session = \Config\Services::session();

        $v = $this->request->getVar(['Pesquisar']);

        $inputs = $this->validate([
            'Pesquisar' => 'required',
        ]);

        if (!$inputs) {
            return view('admin/usuario/form_pesquisa_usuario', [
                'validation' => $this->validator
            ]);
        }
exit('oioioi');

        return view('admin/usuario/form_pesquisa_usuario');
    }
}
