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
        $medicamento = new PrescricaoMedicamentoModel();

        $v['pager'] = \Config\Services::pager();
        $request = \Config\Services::request();
        #Inicia a classe de funções próprias
        $v['func'] = new HUAP_Functions();

        $v['prescricao'] = $prescricao->read_prescricao($_SESSION['Paciente']['prontuario']);

        if($v['prescricao']['count'] > 0) {

            $m['where'] = null;
            foreach($v['prescricao']['array'] as $val) {
                $m['where'] .= $val['idPreschuap_Prescricao'].', ';
                $m['medicamento'][$val['idPreschuap_Prescricao']] = NULL;
            }
            $m['where'] = substr($m['where'], 0, -2);

            $v['medicamento'] = $medicamento->read_medicamento($m);

        }

        /*
        echo "<pre>";
        print_r($v['prescricao']);
        echo "</pre>";
        echo "<pre>";
        print_r($v['medicamento']);
        echo "</pre>";
        #exit('oi'.$_SESSION['Paciente']['prontuario']);
        #*/

        return view('admin/prescricao/list_prescricao', $v);

    }

    /**
    * Gera a versão para impressão da Prescrição Médica
    *
    * @return mixed
    */
    public function print_prescricao($data)
    {

        $prescricao = new PrescricaoModel();
        $medicamento = new PrescricaoMedicamentoModel();

        #Inicia a classe de funções próprias
        $v['func'] = new HUAP_Functions();

        $v['prescricao'] = $prescricao->read_prescricao($data, TRUE);

        if($v['prescricao']['count'] > 0) {

            $m['where'] = $data;
            $m['medicamento'][$data] = NULL;

            $v['medicamento'] = $medicamento->read_medicamento($m);

        }

        $v['prescricao']['conselho'] = $prescricao->get_conselho($v['prescricao']['array'][0]['Cpf']);

        /*
        echo "<pre>";
        print_r($v['prescricao']);
        echo "</pre>";
        echo "<pre>";
        print_r($v['medicamento']);
        echo "</pre>";
        #exit('oi'.$_SESSION['Paciente']['prontuario']);
        #*/

        return view('admin/prescricao/print_prescricao', $v);

    }

    /**
    * Direciona para a página onde o usuário escolhe entre criar uma nova prescrição
    * ou carregar a última prescrição do paciente.
    *
    * @return void
    */
    public function page_prescricao()
    {
        return view('admin/prescricao/page_prescricao');
    }

    /**
    * Cria uma nova prescrição
    *
    * @return void
    */
    public function create_prescricao()
    {



        return view('admin/prescricao/form_prescricao');
    }

}
