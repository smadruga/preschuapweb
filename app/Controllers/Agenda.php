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
                'Data'          => '',
                'Especialidade' => '',
                'Sala'          => '',
                'Procedimento'  => '',
            ];
        }
        else {
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        #$v['data']['dtquery'] = $v['func']->mascara_data($v['data']['Data'], 'db');

        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        exit('fim');
        #*/

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

        if ($v['data']['Data'] && $v['data']['Especialidade'] && $v['data']['Sala'] && $v['data']['Procedimento']) {
            /*
            * Calcula, a partir da data ecolhida no filtro, as demais datas da semana, de domingo a sábado
            */
            $d = explode('-', $v['data']['Data']);
            $semana = intval(date('W', mktime(0,0,0,$d[1],$d[2],$d[0])));
            $dianum = date('w', mktime(0,0,0,$d[1],$d[2],$d[0]));
            $semana = ($dianum == 0) ? $semana+1 : $semana;
            $dt = date('Y-m-d', mktime(0,0,0,$d[1],$d[2],$d[0]));
            
            for($i=0; $i<=$dianum; $i++) {
                $v['cabecalho'][$i] = $v['func']->mascara_data(date('Y-m-d', strtotime($dt . ' - '.($dianum-$i).' day')),'barras');
                $v['cabecalho']['dt'][$i] = date('Y-m-d', strtotime($dt . ' - '.($dianum-$i).' day'));
            }
            for($i=6; $i>$dianum; $i--) {
                $v['cabecalho'][$i] = $v['func']->mascara_data(date('Y-m-d', strtotime($dt . ' + '.($i-$dianum).' day')),'barras');            
                $v['cabecalho']['dt'][$i] = date('Y-m-d', strtotime($dt . ' + '.($i-$dianum).' day'));
            }
                
            $v['agenda'] = $agenda->list_agenda($v['cabecalho'][0], $v['cabecalho'][6], $v['data']['Especialidade'], $v['data']['Sala'], $v['data']['Procedimento']);
                
        }
        else
            $v['agenda'] = 0;
            
        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        exit('fim');
        #*/
        return view('admin/agenda/list_agenda', $v);
    }

}
