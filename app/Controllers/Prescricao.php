<?php

namespace App\Controllers;

use App\Models\TabelaModel;
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
    public function manage_prescricao()
    {

        $tabela = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func'] = new HUAP_Functions(); #Inicia a classe de funções próprias

        #$action = (!$action) ? $this->request->getVar('action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $action;
        $action = 'cadastrar';

        if(!$this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            $v['data'] = [
                'idPreschuap_Prescricao'            => '',
                'Prontuario'                        => '',
                'DataMarcacao'                      => '',
                'DataPrescricao'                    => date('d/m/Y', time()),
                'Dia'                               => '',
                'Ciclo'                             => '',
                'Aplicabilidade'                    => '',
                'idTabPreschuap_Categoria'          => '',
                'idTabPreschuap_Subcategoria'       => '',
                'idTabPreschuap_Protocolo'          => '',
                'idTabPreschuap_TipoTerapia'        => '',
                'CiclosTotais'                      => '',
                'EntreCiclos'                       => '',

                'Peso'                              => '',
                'CreatininaSerica'                  => '',
                'Altura'                            => '',
                'ClearanceCreatinina'               => '',
                'IndiceMassaCorporal'               => '',
                'SuperficieCorporal'                => '',

                'DescricaoServico'                  => '',
                'InformacaoComplementar'            => '',
                'ReacaoAdversa'                     => '',
                'idTabPreschuap_Alergia'            => '',
                'ClearanceCreatinina'               => '',
                'IndiceMassaCorporal'               => '',
                'SuperficieCorporal'                => '',
            ];
        }
        else {
            #Captura os inputs do Formulário
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        $v['select'] = [
            'Categoria'         => $tabela->list_tabela_bd('Categoria', FALSE, FALSE, '*', 'idTabPreschuap_Categoria', TRUE), #Carrega os itens da tabela selecionada
            'Subcategoria'      => $tabela->list_tabela_bd('Subcategoria', FALSE, FALSE, '*', 'idTabPreschuap_Subcategoria', TRUE), #Carrega os itens da tabela selecionada
            'Protocolo'         => $tabela->list_tabela_bd('Protocolo', FALSE, FALSE, '*', FALSE, TRUE), #Carrega os itens da tabela selecionada
            'TipoTerapia'       => $tabela->list_tabela_bd('TipoTerapia', FALSE, FALSE, '*', FALSE, TRUE), #Carrega os itens da tabela selecionada
            'Alergia'           => $tabela->list_tabela_bd('Alergia', FALSE, FALSE, '*', FALSE, TRUE), #Carrega os itens da tabela selecionada
            'Aplicabilidade'    => ['CANCEROLOGIA', 'HEMATOLOGIA'],
        ];

        if($action == 'editar') {

            $v['id'] = $data;

            if($action == 'editar')
                $v['opt'] = [
                    'bg'        => 'bg-warning',
                    'button'    => '<button class="btn btn-warning" id="submit" type="submit"><i class="fa-solid fa-save"></i> Salvar</button>',
                    'title'     => 'Editar item - Tabela: '.$v['tabela'],
                    'disabled'  => '',
                    'action'    => 'editar',
                ];

        }
        else {
            #$v['lista'] = $tabela->list_tabela_bd($v['tabela']); #Carrega os itens da tabela selecionada

            $v['opt'] = [
                'bg'        => 'bg-secondary',
                'button'    => '<button class="btn btn-info" id="submit" type="submit"><i class="fa-solid fa-plus"></i> Cadastrar</button>',
                'title'     => 'Cadastrar item',
                'disabled'  => '',
                'action'    => 'cadastrar',
            ];

        }

        #Critérios de validação
        $inputs = $this->validate([
            'DataPrescricao'                    => ['label' => 'Data da Prescrição', 'rules' => 'required|valid_date[d/m/Y]'],
            'Dia'                               => 'required|integer',
            'Ciclo'                             => 'required|integer',
            'Aplicabilidade'                    => 'required',
            'idTabPreschuap_Categoria'          => ['label' => 'CID Categoria', 'rules' => 'required'],
            'idTabPreschuap_Subcategoria'       => ['label' => 'CID Subcategoria', 'rules' => 'required'],
            'idTabPreschuap_Protocolo'          => ['label' => 'Protocolo', 'rules' => 'required'],
            'idTabPreschuap_TipoTerapia'        => ['label' => 'Tipo de Terapia', 'rules' => 'required'],
            'CiclosTotais'                      => ['label' => 'Total de Ciclos', 'rules' => 'required|integer'],
            'EntreCiclos'                       => ['label' => 'Entre Ciclos', 'rules' => 'required|integer'],

            'Peso'                              => 'required|regex_match[/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:(\.|,)\d+)?$/]',
            'CreatininaSerica'                  => ['label' => 'Creatinina Sérica', 'rules' => 'required|regex_match[/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:(\.|,)\d+)?$/]'],
            'Altura'                            => 'required|integer',
            #'ClearanceCreatinina'               => ['label' => 'Clearance Creatinina', 'rules' => 'required|regex_match[/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:(\.|,)\d+)?$/]'],
            #'IndiceMassaCorporal'               => ['label' => 'Índice de Massa Corporal', 'rules' => 'required|regex_match[/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:(\.|,)\d+)?$/]'],
            #'SuperficieCorporal'                => ['label' => 'Superfície Corporal', 'rules' => 'required|regex_match[/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:(\.|,)\d+)?$/]'],

            'DescricaoServico'                  => ['label' => 'Serviço', 'rules' => 'required'],
            'InformacaoComplementar'            => ['label' => 'Informação Complementar', 'rules' => 'required'],
            'ReacaoAdversa'                     => ['label' => 'Reação Adversa', 'rules' => 'required'],
            'idTabPreschuap_Alergia'            => ['label' => 'Alergia', 'rules' => 'required'],
        ]);

        #Realiza a validação e retorna ao formulário se false
        if (!$inputs)
            $v['validation'] = $this->validator;
        else {
            exit('cheguei');
        }


        return view('admin/prescricao/form_prescricao', $v);
    }

}
