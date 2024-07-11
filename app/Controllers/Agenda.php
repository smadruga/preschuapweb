<?php

namespace App\Controllers;

use App\Models\PacienteModel;
use App\Models\PrescricaoModel;
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
    * Formulário para agendamento de prescrição
    *
    * @return void
    */
    public function agenda_prescricao($id = FALSE)
    {

        $tabela         = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao     = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria      = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog   = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias

        if(!$this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            $v['data'] = [
                'idPreschuap_Agenda'                => '',
                'Prontuario'                        => '',
                'DataAgendamento'                   => date('d/m/Y', time()),
                'Turno'                             => '',
                'Observacoes'                       => '',
                'idPreschuap_Prescricao'            => '',                

                'submit'                            => '',
            ];

            $v['data']['prescricao'] = $prescricao->read_prescricao($id, true, true);
        }
        else {
            #Captura os inputs do Formulário
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            #echo '111111111oi';
        }

        /*
        echo "<pre>";
        print_r($v['data']);
        echo "</pre>";
        exit('oi');
        #*/

        return view('admin/agenda/form_agenda', $v);

    }
}
