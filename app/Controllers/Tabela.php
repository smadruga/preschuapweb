<?php

namespace App\Controllers;

use App\Models\TabelaModel;

use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;

class Tabela extends BaseController
{
    private $v;

    public function __construct()
    {

    }

    /**
    * Lista as prescrições associadas ao paciente
    *
    * @return mixed
    */
    public function list_tabela($data)
    {

        $tabela = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func'] = new HUAP_Functions(); #Inicia a classe de funções próprias

        $v['lista'] = $tabela->list_tabela_bd($data); #Carrega os itens da tabela selecionada
        $v['tabela'] = $data;

        #Captura os inputs do Formulário
        $v['data'] = $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($v['data']['Item'])) {

            #Critérios de validação
            $inputs = $this->validate([
                'Item' => 'required',
            ]);

            #Realiza a validação e retorna ao formulário se false
            if (!$inputs)
                $v['validation'] = $this->validator;
            else {

                $v['data'][$v['tabela']] = trim($v['data']['Item']);
                unset($v['data']['csrf_test_name'],$v['data']['Item']);

                $v['campos'] = array_keys($v['data']);
                $v['anterior'] = array();

                $v['id'] = $tabela->insert_item($v['data'], $v['tabela']);

                $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('TabPreschuap_'.$v['tabela'], 'CREATE', $v['id']), TRUE);
                $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $v['id'], $v['auditoria']), TRUE);

                session()->setFlashdata('success', 'Item adicionado com sucesso!');
                return redirect()->to('tabela/list_tabela/'.$v['tabela']);

            }

        }

        /*
        echo "<pre>";
        print_r($v['lista']);
        echo "</pre>";
        echo "<pre>";
        print_r($v['lista']->getResultArray());
        echo "</pre>";
        echo "<pre>";
        print_r($v['lista']->getResultObject());
        echo "</pre>";
        exit('oi');
        #*/

        return view('admin/tabela/list_tabela', $v);

    }

}
