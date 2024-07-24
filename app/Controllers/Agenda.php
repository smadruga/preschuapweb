<?php

namespace App\Controllers;

use App\Models\PacienteModel;
use App\Models\PrescricaoModel;
use App\Models\AgendaModel;
use App\Models\TabelaModel;

use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;

use CodeIgniter\RESTful\ResourceController;
use DateTime;
use App\Libraries\HUAP_Functions;

class Agenda extends BaseController
{
    private $v;

    public function __construct()
    {

    }

    /**
    * Gera a versão para impressão da Prescrição Médica
    *
    * @return mixed
    */
    public function print_agenda($data)
    {

        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias do HUAP

        $v['agenda'] = $agenda->list_agenda($data);
        $v['agenda']['databd'] = $data;

        $dataptbr = date_create($data); // Cria um objeto DateTime a partir da string de data
        $v['agenda']['dataptbr'] = ($dataptbr) ?  date_format($dataptbr, 'd/m/Y') : date('d/m/Y');

        $v['agenda']['data'] = $v['agenda']['dataptbr'].' - '.$v['func']->dia_da_semana($v['agenda']['databd']); 

        /*
        echo "<pre>";
        print_r($v['medicamento']);
        echo "</pre>";
        exit('oi');
        #*/

        return view('admin/prescricao/print_prescricao', $v);

    }


    /**
    * Formulário para agendamento de prescrição
    *
    * @return void
    */
    public function agenda_prescricao($id = FALSE)
    {

        $tabela         = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao     = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria      = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog   = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias

        if(!$this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            $v['data'] = [
                'idPreschuap_Agenda'                => '',
                'DataAgendamento'                   => date('d/m/Y', time()),
                'Turno'                             => '',
                'Observacoes'                       => '',
                'idPreschuap_Prescricao'            => '',                

                'submit'                            => '',
            ];

            $v['data']['prescricao'] = $prescricao->read_prescricao($id, true, true);
            #exit('oi22');
        }
        else {
            #Captura os inputs do Formulário
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'DataAgendamento' => 'required|valid_date',
                'Turno' => 'required',
                'Observacoes' => 'max_length[15]',
            ]);

            if (!$valid) {
                return redirect()->back()->withInput()->with('validation', $validation);
            }

            $submit = $v['data']['submit'];
            $id     = $v['data']['idPreschuap_Prescricao'];
            unset($v['data']['csrf_test_name'],$v['data']['submit']);
            
            $v['id'] = $agenda->insert($v['data']);
            session()->setFlashdata('success', 'Agendamento realizado com sucesso!');
            
            if ($submit == 2) 
                return redirect()->to('agenda/agenda_prescricao/'.$id);
            else
                return redirect()->to('prescricao/list_prescricao');
        }

        if($v['data']['prescricao']['idTabPreschuap_TipoAgendamento'] == 1)
            $v['data']['prescricao']['badge'] = '<span class="badge bg-primary text-white"><i class="fa-solid fa-couch"></i></span>';
        elseif($v['data']['prescricao']['idTabPreschuap_TipoAgendamento'] == 2)
            $v['data']['prescricao']['badge'] = '<span class="badge bg-primary text-white"><i class="fa-solid fa-syringe"></i></span>';
        elseif($v['data']['prescricao']['idTabPreschuap_TipoAgendamento'] == 3)
            $v['data']['prescricao']['badge'] = '<span class="badge bg-primary text-white"><i class="fa-solid fa-pills"></i></span>';
        elseif($v['data']['prescricao']['idTabPreschuap_TipoAgendamento'] == 4)
            $v['data']['prescricao']['badge'] = '<span class="badge bg-primary text-white"><i class="fa-solid fa-bed"></i></span>';
        else
            $v['data']['prescricao']['badge'] = '<span class="badge bg-primary text-white"><i class="fa-solid fa-house-medical"></i></span>';

        $v['opt']['disabled'] = NULL;

        /*
        echo "<pre>";
        print_r($v['data']);
        echo "</pre>";
        exit('oi');
        #echo 'oi'.$submit;
        #*/

        return view('admin/agenda/form_agenda', $v);    

    }

    public function index($data = FALSE)
    {

        $tabela         = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao     = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias do HUAP

        $datapost = $this->request->getPost('data');
        if($datapost) 
            $data = $datapost;
        else
            $data = ($data) ? $data : date('Y-m-d');

        $v['agenda'] = $agenda->list_agenda($data);
        $v['agenda']['databd'] = $data;

        // Gerar URLs para navegação
        $prox = date('Y-m-d', strtotime($v['agenda']['databd'] . ' +1 day'));
        $ant = date('Y-m-d', strtotime($v['agenda']['databd'] . ' -1 day'));

        $v['agenda']['ProxUrl'] = site_url('agenda/index/' . $prox);
        $v['agenda']['AntUrl'] = site_url('agenda/index/' . $ant);

        $dataptbr = date_create($data); // Cria um objeto DateTime a partir da string de data
        $v['agenda']['dataptbr'] = ($dataptbr) ?  date_format($dataptbr, 'd/m/Y') : date('d/m/Y');

        $v['agenda']['data'] = $v['agenda']['dataptbr'].' - '.$v['func']->dia_da_semana($v['agenda']['databd']); 

        /*
        echo "<pre>";
        print_r($v['agenda']);
        echo "</pre>";
        exit('oi');
        #*/

        return view('admin/agenda/list_agenda', $v);

    }

}
