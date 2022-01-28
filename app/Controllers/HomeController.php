<?php

namespace App\Controllers;

use App\Models\Usuario;
use CodeIgniter\RESTful\ResourceController;

class HomeController extends ResourceController
{
    private $usuario;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
    }

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
        $session = \Config\Services::session();

        $v = $this->request->getVar(['Usuario', 'Senha']);
        $v['Usuario'] = preg_replace('/((\w+).(\w+))(\b@ebserh.gov.br)/i', '$1', $v['Usuario']);

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
        elseif (!$this->valida_ldap($v['Usuario'], $v['Senha'])) {
            session()->setFlashdata('failed', 'Erro ao autenticar. <br> Verifique seu <b>usuário</b> e <b>senha</b> e tente novamente.');
            return view('home/form_login');
        }

        /*
        $this->usuario->save([
        'Usuario' => $this->request->getVar('Usuario'),
        'Senha'  => $this->request->getVar('Senha')
        ]);
        session()->setFlashdata('success', 'Success! post created.');
        env('CI_ENVIRONMENT')
        */

        $session->set($v);
        return redirect()->to('/admin');

    }

    /**
    * Formulário de Acesso a aplicação web, com validação e registro no Banco
    * de dados (POST)
    *
    * @return void
    */
    public function logout()
    {

        return redirect()->to('/');

    }

    /**
    * Função de validação no AD via protocolo LDAP
    * como usar:
    * valida_ldap("servidor", "domíniousuário", "senha");
    *
    * @return bool
    *
    */
    public function valida_ldap($usr, $pwd){

        //Tenta se conectar com o servidor LDAP Master
        if (FALSE !== $ldap2=@ldap_connect(env('srv.ldap2')))
            $ldap_connection = $ldap2;
        //Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
        elseif (FALSE !== $ldap1=@ldap_connect(env('srv.ldap1')))
            $ldap_connection = $ldap1;
        else
            return FALSE;

        // Tenta autenticar no servidor
        return (!@ldap_bind($ldap_connection, $usr.'@ebserh.gov.br', $pwd)) ? FALSE : TRUE;

    }

}
