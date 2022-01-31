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
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function index()
    {
        #$session = \Config\Services::session();
        return view('admin/tela_admin');
    }

    /**
    * Formulário para busca de usuário a ser importado do AD/EBSERH
    *
    * @return void
    */
    public function find_user()
    {
        $v['form_open'] = 'admin/encontrar';
        return view('admin/usuario/form_pesquisa_usuario', $v);
    }

    /**
    * Valida o formulário de busca e retorna um ou mais resultados
    *
    * @return mixed
    */
    public function get_user()
    {

        #Captura os inputs do Formulário
        $v = $this->request->getVar(['Pesquisar']);

        #Critérios de validação
        $inputs = $this->validate([
            'Pesquisar' => 'required',
        ]);

        #Realiza a validação e retorna ao formulário de false
        if (!$inputs) {
            return view('admin/usuario/form_pesquisa_usuario', [
                'validation' => $this->validator
            ]);
        }


        $v['ad'] = $this->get_user_ad($v['Pesquisar']);


        exit($v['Pesquisar']);

        return view('admin/usuario/form_pesquisa_usuario');
    }

    /**
    * Valida o formulário de busca e retorna um ou mais resultados
    *
    * @return mixed
    */
    function get_user_ad($data)
    {
        //Tenta se conectar com o servidor LDAP Master
        if (FALSE !== $v['ldap']['ldap1']=@ldap_connect(env('srv.ldap1')))
            $v['ldap']['ldap_conn'] = $v['ldap']['ldap1'];
        //Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
        elseif (FALSE !== $v['ldap']['ldap2']=@ldap_connect(env('srv.ldap2')))
            $v['ldap']['ldap_conn'] = $v['ldap']['ldap2'];
        //Se nenhuma conexão acontecer é retornado false
        else
            return FALSE;

        //conexão com o usuário adm do ldap
        @ldap_bind($v['ldap']['ldap_conn'], env('ldap.usr'), env('ldap.pwd'));

        //filtros (campos de busca NOME, USUÁRIO e CPF)
        $v['ldap']['ldap_filter'] = "(|(cn=*$data*)(samaccountname=$data)(employeeID=$data))";
        //campos que serão retornados após pesquisa
        $v['ldap']['ldap_att'] = array("cn", "samaccountname", "employeeID", "othermailbox");
        //resultado da pesquisa
        $v['ldap']['result'] = ldap_search($v['ldap']['ldap_conn'], env('ldap.dn'), $v['ldap']['ldap_filter'], $v['ldap']['ldap_att']);
        //organização do resultado da pesquisa
        $v['ldap']['entries'] = ldap_get_entries($v['ldap']['ldap_conn'], $v['ldap']['result']);

        /*
        echo "<pre>";
        print_r($v['ldap']);
        echo "</pre>";
        */

        //se o resultado for zero retorna FALSE
        if ($v['ldap']['entries'] == 0)
            return FALSE;
        //se o resultado for um realiza a importação no banco e vai direto pra página de sucesso/perfil
        elseif ($v['ldap']['entries'] == 1) {

        }
        //se o resultado for mais de 1 encaminha para página com a lista de usuários
        else


exit('<br />que?');

    }
}
