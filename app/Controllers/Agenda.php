<?php

namespace App\Controllers;

use App\Models\PacienteModel;
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
        $paciente       = new PacienteModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria      = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog   = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func']      = new HUAP_Functions(); #Inicia a classe de funções próprias

        return view('admin/agenda/form_agenda', $v);

        /*
        echo "<pre>";
        print_r($val);
        echo "</pre>";
        echo "<pre>";
        print_r($v['campos']);
        echo "</pre>";
        #exit('oi');
        #*/

    }
}
