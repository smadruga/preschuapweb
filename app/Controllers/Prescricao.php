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
    public function manage_prescricao($action = FALSE, $id = FALSE)
    {

        $tabela = new TabelaModel(); #Inicia o objeto baseado na TabelaModel
        $prescricao = new PrescricaoModel(); #Inicia o objeto baseado na TabelaModel
        $auditoria = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func'] = new HUAP_Functions(); #Inicia a classe de funções próprias

        $action = (!$action) ? $this->request->getVar('action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $action;

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

                'submit'                            => '',
            ];
        }
        else {
            #Captura os inputs do Formulário
            $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        if($action == 'editar' && !$v['data']['submit']) {

            $v['idPreschuap_Prescricao'] = $id;
            $v['data'] = $prescricao->find($v['idPreschuap_Prescricao']); #Carrega os itens da tabela selecionada
            $v['data']['submit'] = '';

            $v['data']['ClearanceCreatinina']   = (!$v['data']['ClearanceCreatinina']) ? $v['func']->calc_ClearanceCreatinina($v['data']['Peso'], $_SESSION['Paciente']['idade'], $_SESSION['Paciente']['sexo'], $v['data']['CreatininaSerica']) : $v['data']['ClearanceCreatinina'];
            $v['data']['IndiceMassaCorporal']   = (!$v['data']['IndiceMassaCorporal']) ? $v['func']->calc_IndiceMassaCorporal($v['data']['Peso'], $v['data']['Altura']) : $v['data']['IndiceMassaCorporal'];
            $v['data']['SuperficieCorporal']   = (!$v['data']['SuperficieCorporal']) ? $v['func']->calc_SuperficieCorporal($v['data']['Peso'], $v['data']['Altura']) : $v['data']['SuperficieCorporal'];

            $v['data']['DataPrescricao']        = date("d/m/Y", strtotime($v['data']['DataPrescricao']));

            $v['data']['Peso']                  = str_replace(".",",",$v['data']['Peso']);
            $v['data']['CreatininaSerica']      = str_replace(".",",",$v['data']['CreatininaSerica']);
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

            if($action == 'editar')
                $v['opt'] = [
                    'bg'        => 'bg-warning',
                    'button'    => '<button class="btn btn-info" id="submit" name="submit" value="1" type="submit"><i class="fa-solid fa-save"></i> Salvar</button>',
                    'title'     => 'Editar Prescrição',
                    'disabled'  => '',
                    'action'    => 'editar',
                ];

        }
        else {
            #$v['lista'] = $tabela->list_tabela_bd($v['tabela']); #Carrega os itens da tabela selecionada

            $v['opt'] = [
                'bg'        => 'bg-secondary',
                'button'    => '<button class="btn btn-info" id="submit" name="submit" value="1" type="submit"><i class="fa-solid fa-plus"></i> Cadastrar</button>',
                'title'     => 'Cadastrar Prescrição',
                'disabled'  => '',
                'action'    => 'cadastrar',
            ];

        }

        if($v['data']['submit']) {
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

                $v['data']['DataPrescricao']        = date("Y-m-d", strtotime($v['data']['DataPrescricao']));

                $v['data']['Peso']                  = str_replace(",",".",$v['data']['Peso']);
                $v['data']['CreatininaSerica']      = str_replace(",",".",$v['data']['CreatininaSerica']);
                $v['data']['ClearanceCreatinina']   = str_replace(",",".",$v['data']['ClearanceCreatinina']);
                $v['data']['IndiceMassaCorporal']   = str_replace(",",".",$v['data']['IndiceMassaCorporal']);
                $v['data']['SuperficieCorporal']    = str_replace(",",".",$v['data']['SuperficieCorporal']);

                $v['data']['idSishuap_Usuario']     = $_SESSION['Sessao']['idSishuap_Usuario'];
                $v['data']['Prontuario']            = $_SESSION['Paciente']['prontuario'];

                unset(
                    $v['data']['csrf_test_name'],
                    $v['data']['Idade'],
                    $v['data']['Sexo'],
                    $v['data']['submit'],
                );

                $v['campos'] = array_keys($v['data']);

                /*
                echo "<pre>";
                print_r($_SESSION['Paciente']);
                echo "</pre>";
                echo "<pre>";
                print_r($v['data']);
                echo "</pre>";
                #exit('oi');
                #*/

                if($action == 'editar') {

                    $v['id'] = $v['data']['idPreschuap_Prescricao'];
                    $v['anterior'] = $prescricao->find($v['id']);

                    /*
                    echo "<pre>";
                    print_r($v['anterior']);
                    echo "</pre>";
                    echo "<pre>";
                    print_r($v['data']);
                    echo "</pre>";
                    exit('oi1');
                    */

                    if($prescricao->update($v['id'], $v['data']) ) {

                        $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('Preschuap_Prescricao', 'UPDATE', $v['id']), TRUE);
                        $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $v['id'], $v['auditoria'], TRUE), TRUE);

                        session()->setFlashdata('success', 'Item atualizado com sucesso!');

                    }
                    else
                        session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');

                }
                else {
exit('oi2');
                    $v['anterior'] = array();

                    $v['id'] = $prescricao->insert($v['data']);

                    if($v['id']) {

                        $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('Preschuap_Prescricao', 'CREATE', $v['id']), TRUE);
                        $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $v['id'], $v['auditoria']), TRUE);

                        session()->setFlashdata('success', 'Item adicionado com sucesso!');

                    }
                    else
                        session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');

                }

                return redirect()->to('prescricao/list_prescricao');

            }

        }

        /*
        echo "<pre>";
        print_r($_SESSION['Paciente']);
        echo "</pre>";
        echo "<pre>";
        print_r($v['data']);
        echo "</pre>";
        exit('oi');
        #*/

        return view('admin/prescricao/form_prescricao', $v);
    }

}
