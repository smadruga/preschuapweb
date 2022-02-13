<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuarioModel;

class Home extends ResourceController
{
    #private $v;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
    }

    public function index()
    {
        \Config\Services::session();
        session_write_close();
        unset($v,$_SESSION);
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
        $usuario = new UsuarioModel();

        $v = $this->request->getVar(['Usuario', 'Senha']);
        $v['Usuario'] = preg_replace('/((\w+).(\w+))(\b@ebserh.gov.br)/i', '$1', $v['Usuario']);

        $inputs = $this->validate([
            'Usuario' => 'required',
            'Senha' => 'required'
        ]);

        if (!$inputs) {
            session()->setFlashdata('failed', HUAP_MSG_ERROR);
            return view('home/form_login', [
                'validation' => $this->validator
            ]);
        }
        elseif (!$this->valida_ldap($v['Usuario'], $v['Senha'])) {
            session()->setFlashdata('failed', 'Erro ao autenticar. <br> Verifique seu <b>usuário</b> e <b>senha</b> e tente novamente.');
            return view('home/form_login');
        }

        unset($v['Senha']);
        #$_SESSION['Sessao'] = $usuario->getwhere(['Usuario' => $v['Usuario']])->getRowArray();
        $_SESSION['Sessao'] = $usuario->get_user_mysql($v['Usuario']);
        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        exit('oi');
        #*/
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
        session_write_close();
        unset($v,$_SESSION);
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
    private function valida_ldap($usr, $pwd){

        #Apenas para testar o sistema sem a necessidade de consultar o AD - APAGAR
        return TRUE;

        #Tenta se conectar com o servidor LDAP Master
        if (FALSE !== $ldap1=@ldap_connect(env('srv.ldap1')))
            $ldap_conn = $ldap1;
        #Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
        elseif (FALSE !== $ldap2=@ldap_connect(env('srv.ldap2')))
            $ldap_conn = $ldap2;
        else
            return FALSE;

        # Tenta autenticar no servidor
        return (!@ldap_bind($ldap_conn, $usr.'@ebserh.gov.br', $pwd)) ? FALSE : TRUE;

    }

}
