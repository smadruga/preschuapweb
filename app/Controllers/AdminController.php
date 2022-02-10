<?php

namespace App\Controllers;

use App\Libraries\HUAP_Functions;
use App\Models\UsuarioModel;
use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController
{
    private $v;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->session = \Config\Services::session();

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
    {/*
        $data = 'campos.rodrigo';
        $usuario = new UsuarioModel();

        $v['data'] = $usuario->get_user_mysql('campos.rodrigo');
        echo ($v['data']) ? '1' : '0';
        echo "<pre>";/^[0-9]{3}.?[0-9]{3}.?[0-9]{3}-?[0-9]{2}/
        print_r($v['data']);
        echo "</pre>";
/^[0-9]{3}.?[0-9]{3}.?[0-9]{3}-?[0-9]{2}/
/((\w+).(\w+))(\b@ebserh.gov.br)/
*/
#echo 'oi >> '. preg_replace('/^([0-9]{3})\.?([0-9]{3})\.?([0-9]{3})\-?([0-9]{2})$/i', '$1$2$3$4', '098.507.017-06');;
        return view('admin/usuario/form_pesquisa_usuario');
    }

    /**
    * Valida o formulário de busca e retorna um ou mais resultados
    *
    * @return mixed
    */
    public function get_user($user = false)
    {

        $func = new HUAP_Functions();

        if(!$user) {

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

        }
        else
            $v['Pesquisar'] = $user;

        #caso a pesquisa seja um cpf verifica se há pontos e traços e os elimina
        $v['Pesquisar'] = preg_replace('/^([0-9]{3})\.?([0-9]{3})\.?([0-9]{3})\-?([0-9]{2})$/i', '$1$2$3$4', $v['Pesquisar']);


        $usuario = new UsuarioModel();
        $v['mysql'] = $usuario->get_user_mysql($v['Pesquisar']);

        #se encontrar o usuário já cadastrado na base do mysql já encaminha direto para a página dele
        if ($v['mysql']) {
            return redirect()->to('admin/show_user/'.$v['mysql']['Usuario']);
        }

        #Inicia a classe de funções próprias
        $v['func'] = new HUAP_Functions();
        #Função que remove qualquer acentuação da palavra
        $v['Pesquisar'] = $v['func']->remove_accents($v['Pesquisar']);

        #Pesquisa no AD pela palavra inserida no campo de pesquisa.
        $v['ad'] = $this->get_user_ad($v['Pesquisar']);

        /*
        echo "<pre>";
        print_r($v['ad']);
        echo "</pre>";
        #*/

        #se o resultado for zero retorna erro
        if (!$v['ad']) {
            session()->setFlashdata('failed', 'Nenhum usuário encontrado. Tente novamente.');
            return redirect()->to('admin/find_user');
        }
        #se o resultado for um vai direto para a página de importação
        elseif ($v['ad']['entries']['count'] == 1) {
            return view('admin/usuario/form_confirma_importacao', $v);
        }
        #se o resultado for mais que um vai para uma lista de opções
        else {
            return view('admin/usuario/list_usuarios', $v);
        }

        #exit($v['Pesquisar']);

        return view('admin/usuario/form_pesquisa_usuario');
    }

    /**
    * Importa o usuário do AD/EBSERH e salva os dados básicos no BD PRESCHUAP
    *
    * @return mixed
    */
    public function import_user()
    {

        $usuario = new UsuarioModel();
        $auditoria = new AuditoriaModel();
        $auditorialog = new AuditoriaLogModel();

        $func = new HUAP_Functions();

        $agent = $this->request->getUserAgent();
        $request = \Config\Services::request();

        #Captura usuário a ser immportado
        $v = $this->request->getVar(['Usuario']);
        $v['ad'] = $this->get_user_ad($v['Usuario']);

        $v['data'] = [
            'Usuario'           => (isset($v['ad']['entries'][0]['samaccountname'][0])) ? esc($v['ad']['entries'][0]['samaccountname'][0]) : '',
            'Nome'              => (isset($v['ad']['entries'][0]['cn'][0])) ? esc(mb_convert_encoding($v['ad']['entries'][0]['cn'][0], "UTF-8", "ASCII")) : '',
            'Cpf'               => (isset($v['ad']['entries'][0]['employeeid'][0])) ? esc($v['ad']['entries'][0]['employeeid'][0]) : '',
            'EmailSecundario'   => (isset($v['ad']['entries'][0]['othermailbox'][0])) ? esc($v['ad']['entries'][0]['othermailbox'][0]) : '',
        ];

        $v['campos'] = array_keys($v['data']);
        $v['anterior'] = array();

        $id = $usuario->insert($v['data'], TRUE);

        $v['auditoria'] = $auditoria->insert($func->create_auditoria('Sishuap_Usuario', 'CREATE', $id), TRUE);
        $v['auditoriaitem'] = $auditorialog->insertBatch($func->create_log($v['anterior'], $v['data'], $v['campos'], $id, $v['auditoria']), TRUE);

        session()->setFlashdata('success', 'Usuário importado com sucesso!');
        return redirect()->to('admin/show_user/'.$v['data']['Usuario']);

        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        exit($v['Usuario']);
        */

    }

    /**
    * Importa o usuário do AD/EBSERH e salva os dados básicos no BD PRESCHUAP
    *
    * @return mixed
    */
    public function show_user($data)
    {

        $usuario = new UsuarioModel();

        $func = new HUAP_Functions();

        #Captura usuário a ser immportado
        #$v['data'] = $usuario->get_user_ad($user);
        $v['data'] = $usuario->getWhere(['Usuario' => $data])->getRow();

        return view('admin/usuario/main_usuario', $v);

        /*
        echo "<pre>";
        print_r($v['data']);
        echo "</pre>";
        #exit($v['data']['Usuario']);
        #*/

    }

    /**
    * Valida o formulário de busca e retorna um ou mais resultados baseado no AD/EBSERH
    *
    * @return mixed
    */
    function get_user_ad($data)
    {
        #Tenta se conectar com o servidor LDAP Master
        if (FALSE !== $v['ldap']['ldap1']=@ldap_connect(env('srv.ldap1')))
            $v['ldap']['ldap_conn'] = $v['ldap']['ldap1'];
        #Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
        elseif (FALSE !== $v['ldap']['ldap2']=@ldap_connect(env('srv.ldap2')))
            $v['ldap']['ldap_conn'] = $v['ldap']['ldap2'];
        #Se nenhuma conexão acontecer é retornado false
        else
            return FALSE;

        #conexão com o usuário adm do ldap
        @ldap_bind($v['ldap']['ldap_conn'], env('ldap.usr'), env('ldap.pwd'));

        #filtros (campos de busca NOME, USUÁRIO e CPF)
        $v['ldap']['ldap_filter'] = "(|(cn=*$data*)(samaccountname=$data)(employeeID=$data))";
        #campos que serão retornados após pesquisa
        $v['ldap']['ldap_att'] = array("cn", "samaccountname", "employeeID", "othermailbox");
        #resultado da pesquisa
        $v['ldap']['result'] = ldap_search($v['ldap']['ldap_conn'], env('ldap.dn'), $v['ldap']['ldap_filter'], $v['ldap']['ldap_att']);
        #organização do resultado da pesquisa
        $v['ldap']['entries'] = ldap_get_entries($v['ldap']['ldap_conn'], $v['ldap']['result']);

        /*
        echo "<pre>";
        print_r($v['ldap']);
        echo "</pre>";
        #*/

        #se o resultado for zero retorna FALSE
        if ($v['ldap']['entries']['count'] == 0)
            return FALSE;
        #se o resultado for 1 ou mais encaminha o array com todas as informações
        else
            return $v['ldap'];

    }
}
