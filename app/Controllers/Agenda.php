<?php

namespace App\Controllers;

use App\Models\AgendaModel;
use App\Models\TabelaModel;

use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;

class Agenda extends BaseController
{
    private $v;

    public function __construct()
    {

    }

    /**
    * Agenda cirúrgica
    *
    * @return void
    */
    public function index()
    {

        $tabela     = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $agenda     = new AgendaModel();
        #Inicia a classe de funções próprias
        $v['func']  = new HUAP_Functions();

        if(!$this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            $v['data'] = [
                'Data'          => date('d/m/Y', time()),
                'Especialidade' => '',
                'Sala'          => '',
                'Procedimento'  => '',
            ];
        }
        else {
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        $v['data']['dtquery'] = $v['func']->mascara_data($v['data']['Data'], 'db');

        $v['select'] = [
            'Especialidade' => $tabela->list_tabela_aghux('aae.seq, aae.nome_especialidade', 'agh.agh_especialidades aae', 'aae.clc_codigo in (1, 3)', 'nome_especialidade ASC'), #Carrega os itens da tabela selecionada
            'Procedimento'  => $tabela->list_tabela_aghux('ampc.seq, ampc.descricao', 'agh.MBC_PROCEDIMENTO_CIRURGICOS ampc', 'ampc.ind_situacao = \'A\'', 'ampc.descricao ASC'), #Carrega os itens da tabela selecionada
        ];

        /*
        $inputs = $this->validate([
            'Data'          => 'required|valid_date[d/m/Y]',
            'Especialidade' => 'required|integer',
            'Sala'          => 'required|integer',
            'Procedimento'  => 'required|integer',
        ]);
        $v['validation'] = $this->validator;
        */

        if ($v['data']['Data'] && $v['data']['Especialidade'] && $v['data']['Sala'] && $v['data']['Procedimento']) 
            $v['agenda'] = $agenda->list_agenda($v['data']['dtquery'], $v['data']['Especialidade'], $v['data']['Sala'], $v['data']['Procedimento']);
        else
            $v['agenda'] = 0;

        #return redirect()->to('prescricao/manage_medicamento/'.$v['id']);
        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        exit('fim');
        #*/
        return view('admin/agenda/list_agenda', $v);
    }

}
