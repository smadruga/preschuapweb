<?php

namespace App\Controllers;

use App\Models\PacienteModel;
use App\Models\PrescricaoModel;
use App\Models\AgendaModel;
use App\Models\TabelaModel;
use App\Models\AgendaMedicamentoOcultoModel;

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


    public function hide_medicamento($data, $idagenda, $show, $medicamento = NULL)
    {

        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $oculto         = new AgendaMedicamentoOcultoModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria      = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog   = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias 

        /*
        echo "<pre>";
        print_r($v['agenda']);
        echo "</pre>";
        exit('oi');
        #*/

        if ($show == 1) {
            #exit($idagenda.' del '.$medicamento);

            $v['agenda'] = [
                'idPreschuap_Agenda' => $idagenda,
            ];

            if($oculto->show($v['agenda'])) {
                session()->setFlashdata('success', 'Operação realizada com sucesso!');
            }
            else
                session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');
            
        }
        else {
            #exit($idagenda.' ins '.$medicamento.' >> agenda/index/'.$data);
            
            $v['agenda'] = [
                'idPreschuap_AgendaMedicamentoOculto'   => '',
                'idPreschuap_Agenda'                    => $idagenda,
                'idTabPreschuap_Medicamento'            => $medicamento,
            ];


            $v['id']        = $oculto->hide($v['agenda']);
            $v['campos']    = array_keys($v['agenda']);
            $v['anterior']  = array();

            if($v['id']) {

                $v['auditoria']     = $auditoria->insert($v['func']->create_auditoria('AgendaMedicamentoOcultoModel', 'CREATE', $v['id']), TRUE);
                $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['agenda'], $v['campos'], $v['id'], $v['auditoria']), TRUE);

                session()->setFlashdata('success', 'Operação realizada com sucesso!');

            }
            else
                session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');
        }


        return redirect()->to('agenda/index/'.$data);

    }
    

    public function show_agenda_mes($mes = null, $ano = null)
    {

        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias do HUAP

        $datapost = $this->request->getPost('month');
        if($datapost) {
            $data = explode('-', $datapost);
            $mes = $data[1];
            $ano = $data[0];
        }
        elseif(!$mes || !$ano || $mes < 0 || $mes > 12){
            $mes = date('m');
            $ano = date('Y');
        }

        $v['agenda'] = $agenda->list_agenda_mes($mes, $ano);

        // Gerar URLs para navegação
        $v['agenda']['month'] = $ano.'-'.$mes;
        $v['agenda']['databd'] = $ano.'-'.$mes.'-1';
        $prox   = date('m/Y', strtotime($v['agenda']['databd'] . ' +1 month'));
        $ant    = date('m/Y', strtotime($v['agenda']['databd'] . ' -1 month'));

        $v['agenda']['ProxUrl'] = site_url('agenda/show_agenda_mes/' . $prox);
        $v['agenda']['AntUrl']  = site_url('agenda/show_agenda_mes/' . $ant);     

        $v['mes'] = $mes;
        $v['ano'] = $ano;

        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        exit('e<><>eas42423asfsd');
        #*/
        
        return view('admin/agenda/list_agenda_mes', $v);
    }
    
    /**
    * Gera a versão para impressão da Prescrição Médica
    *
    * @return mixed
    */
    public function del_agendamento($id = FALSE, $data = FALSE) {

        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $oculto         = new AgendaMedicamentoOcultoModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria      = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog   = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias do HUAP

        $v['anterior'] = $agenda->find($id);
        $v['campos'] = array_keys($v['anterior']);
        $v['data'] = array();

        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        exit('DEL = '.$id.' data = '.$data);
        #*/

        if($oculto->where('idPreschuap_Agenda', $id)->delete() && $agenda->where('idPreschuap_Agenda', $id)->delete()) {

            $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('Preschuap_Agenda', 'DELETE', $id), TRUE);
            $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $id, $v['auditoria'], FALSE, TRUE), TRUE);

            session()->setFlashdata('success', 'Item excluído com sucesso!');

        }
        else
            session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');

        return redirect()->to('agenda/index/'.$data);

    }

    /**
    * Gera a versão para impressão da Prescrição Médica
    *
    * @return mixed
    */
    public function print_agenda($data = FALSE)
    {

        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $oculto         = new AgendaMedicamentoOcultoModel(); #Inicia o objeto baseado na TabelaModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias do HUAP

        $data = ($data) ? $data : date('Y-m-d');

        $v['agenda'] = $agenda->list_agenda($data, true);
        $v['agenda']['databd'] = $data;

        $v['agenda']['oculto'] = $oculto->list_oculto($v['agenda']['wherein_agenda']);

        $dataptbr = date_create($data); // Cria um objeto DateTime a partir da string de data
        $v['agenda']['dataptbr'] = ($dataptbr) ?  date_format($dataptbr, 'd/m/Y') : date('d/m/Y');

        $v['agenda']['data'] = $v['agenda']['dataptbr'].' - '.$v['func']->dia_da_semana($v['agenda']['databd']); 

        /*
        echo "<pre>";
        print_r($v['medicamento']);
        echo "</pre>";
        exit('oi');
        #*/

        return view('admin/agenda/print_agenda', $v);

    }


    /**
    * Formulário para agendamento de prescrição
    *
    * @return void
    */
    public function agenda_prescricao($id = FALSE, $agendamento = FALSE, $prontuario = FALSE)
    {

        $tabela         = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao     = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria      = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog   = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $paciente       = new PacienteModel();
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias

        if(!$this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {         

            $v['data'] = [
                'idPreschuap_Agenda'                => '',
                'DataAgendamento'                   => '',
                'Turno'                             => '',
                'Observacoes'                       => '',
                'idPreschuap_Prescricao'            => '',                

                'submit'                            => '',
            ];

            if($prontuario) {
                $_SESSION['Paciente']   = $paciente->get_paciente_codigo($prontuario);
                $v['data']              = $agenda->get_agendamento($agendamento);
                #exit('oi333');
                /*
                echo "<pre>";
                print_r($v['data']);
                echo "</pre>";
                exit('<><>');
                #*/
            }

            $v['data']['prescricao'] = $prescricao->read_prescricao($id, true, true);

            $v['radio'] = array(
                'Turno' => $v['func']->radio_checked($v['data']['Turno'], 'Turno', 'M|T|N', FALSE, TRUE, TRUE),
            );

            #exit('oi11');
        }
        else {
            #exit('oi22');
            #Captura os inputs do Formulário
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            /*$v['data'] = array( 
            [
                'DataAgendamento' => $this->request->getVar('DataAgendamento', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'Turno' => $this->request->getVar('Turno', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'Observacoes' => $this->request->getVar('Observacoes', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ]);*/
        
            $v['data']['DataAgendamento'] = $v['func']->mascara_data($v['data']['DataAgendamento'], 'bd');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'DataAgendamento'   => ['label' => 'Data do Agendamento', 'rules' => 'required|valid_date'],
                'Turno'             => 'required',
                'Observacoes'       => ['label' => 'Observações', 'rules' => 'max_length[15]'],
            ]);    
            
            /*echo "<br><br><br><br><br><br><pre>";
            print_r($v['data']);
            echo "</pre>";
            exit('asrfa');*/    

            if (!$valid) {
                return redirect()->back()->withInput()->with('validation', $validation);
            }

            $submit = $v['data']['submit'];
            $id     = $v['data']['idPreschuap_Prescricao'];
            unset($v['data']['csrf_test_name'],$v['data']['submit']);
            

            if($v['data']['idPreschuap_Agenda']) {
                unset($v['data']['idPreschuap_Prescricao']);

                if($agenda->update_agendamento($v['data']))
                    session()->setFlashdata('success', 'Agendamento atualizado com sucesso!');
                else
                    session()->setFlashdata('danger', 'Erro ao atualizar agendamento');
            }
            else {
                $v['id'] = $agenda->insert($v['data']);
                session()->setFlashdata('success', 'Agendamento realizado com sucesso!');
            }

     
            /*
            echo "<pre>";
            print_r($v['data']);
            echo "</pre>";
            exit('oi333');
            #echo 'oi'.$submit;
            #*/
            
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
        exit('oi1111');
        #echo 'oi'.$submit;
        #*/

        return view('admin/agenda/form_agenda', $v);    

    }

    public function index($data = FALSE)
    {

        $tabela         = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao     = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $agenda         = new AgendaModel(); #Inicia o objeto baseado na TabelaModel
        $oculto         = new AgendaMedicamentoOcultoModel(); #Inicia o objeto baseado na TabelaModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias do HUAP

        $datapost = $this->request->getPost('data');
        if($datapost) 
            $data = $datapost;
        else
            $data = ($data) ? $data : date('Y-m-d');

        $v['agenda'] = $agenda->list_agenda($data);
        $v['agenda']['databd'] = $data;

        $v['agenda']['oculto'] = (isset($v['agenda']['wherein_agenda'])) ? $oculto->list_oculto($v['agenda']['wherein_agenda']) : NULL;

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
        #exit('oi');
        #*/

        return view('admin/agenda/list_agenda', $v);

    }

}
