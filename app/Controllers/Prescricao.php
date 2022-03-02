<?php

namespace App\Controllers;

use App\Models\PrescricaoModel;
use App\Models\PrescricaoMedicamentoModel;

use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;

class Prescricao extends BaseController
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
    public function list_prescricao()
    {

        $prescricao = new PrescricaoModel();
        $v['pager'] = \Config\Services::pager();
        $request = \Config\Services::request();
        #Inicia a classe de funções próprias
        $v['func'] = new HUAP_Functions();

        $v['prescricao'] = $prescricao->where('Prontuario', $_SESSION['Paciente']['prontuario'])->findAll();;

        #/*
        echo "<pre>";
        print_r($v['prescricao']);
        echo "</pre>";
        exit('oi'.$_SESSION['Paciente']['prontuario']);
        #*/

        return view('admin/paciente/list_paciente', $v);

    }

}
