<?php

namespace App\Controllers;

use App\Models\TabelaModel;

use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;

class Tabela extends BaseController
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
    public function list_tabela($tab = FALSE, $action = FALSE, $data = FALSE)
    {

        $tabela = new TabelaModel(); #Inicia o objeto baseado na TabelaModel

        $auditoria = new AuditoriaModel(); #Inicia o objeto baseado na AuditoriaModel
        $auditorialog = new AuditoriaLogModel(); #Inicia o objeto baseado na AuditoriaLogModel
        $v['func'] = new HUAP_Functions(); #Inicia a classe de funções próprias

        $v['tabela'] = $tab;
        $action = (!$action) ? $this->request->getVar('action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $action;

        /*
        $opt = $this->get_opt($tab, $action, $data);
        $v['opt'] = $opt['opt'];
        $v['lista'] = (isset($opt['lista'])) ? $opt['lista'] : NULL;
        */
        if($action == 'editar' || $action == 'habilitar' || $action == 'desabilitar') {

            $v['id'] = $data;

            if($action == 'editar')
                $v['opt'] = [
                    'bg'        => 'bg-warning',
                    'button'    => '<button class="btn btn-warning" type="submit"><i class="fa-solid fa-save"></i> Salvar</button>',
                    'title'     => 'Editar item - Tabela: '.$v['tabela'],
                    'disabled'  => '',
                    'action'    => 'editar',
                ];
            if($action == 'desabilitar')
                $v['opt'] = [
                    'bg'        => 'bg-danger',
                    'button'    => '<button class="btn btn-danger" type="submit"><i class="fa-solid fa-ban"></i> Desabilitar</button>',
                    'title'     => 'Desabilitar item - Tabela: '.$v['tabela'].' - Tem certeza que deseja desabilitar o item abaixo?',
                    'disabled'  => 'disabled',
                    'action'    => 'desabilitar',
                ];
            if($action == 'habilitar')
                $v['opt'] = [
                    'bg'        => 'bg-info',
                    'button'    => '<button class="btn btn-info" type="submit"><i class="fa-solid fa-circle-exclamation"></i> Habilitar</button>',
                    'title'     => 'Habilitar item - Tabela: '.$v['tabela'],
                    'disabled'  => 'disabled',
                    'action'    => 'habilitar',
                ];

        }
        else {

            if($v['tabela'] == 'Protocolo_Medicamento')
                $v['lista'] = $tabela->list_medicamento_bd($data); #Carrega os itens da tabela Medicamentos
            else
                $v['lista'] = $tabela->list_tabela_bd($v['tabela']); #Carrega os itens da tabela selecionada
                /*
                #echo $db->getLastQuery();
                echo "<pre>";
                print_r($v['lista']);
                echo "</pre>";
                #exit('oi');
                #*/
            $v['opt'] = [
                'bg'        => 'bg-secondary',
                'button'    => '<button class="btn btn-info" type="submit"><i class="fa-solid fa-plus"></i> Cadastrar</button>',
                'title'     => 'Cadastrar item - Tabela: '.$v['tabela'],
                'disabled'  => '',
                'action'    => 'cadastrar',
            ];

        }

        #Captura os inputs do Formulário
        $v['data'] = array_map('trim', $this->request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if($v['tabela'] == 'Protocolo')
            $v['data']['Aplicabilidade'] = (isset($v['data']['Aplicabilidade'])) ? $v['data']['Aplicabilidade'] : NULL;

        if($v['tabela'] == 'ViaAdministracao')
            $v['tab']['colspan'] = 6;
        else
            $v['tab']['colspan'] = 5;

        if($v['tabela'] == 'Protocolo') {
            $v['select']['TipoTerapia'] = $tabela->list_tabela_bd('TipoTerapia', FALSE, FALSE, '*'); #Carrega os itens da tabela selecionada
            $v['select']['Categoria'] = $tabela->list_tabela_bd('Categoria', FALSE, FALSE, '*', 'idTabPreschuap_Categoria'); #Carrega os itens da tabela selecionada
            $v['select']['Aplicabilidade'] = ['CANCEROLOGIA', 'HEMATOLOGIA'];

        }

        if($action == 'habilitar' || $action == 'desabilitar') {

            if(isset($v['data']['idTabPreschuap_'.$v['tabela']])) {

                $v['id'] = $v['data']['idTabPreschuap_'.$v['tabela']];
                $v['data']['Inativo'] = ($v['data']['action'] == 'desabilitar') ? 1 : 0;
                unset(
                    $v['data']['csrf_test_name'],
                    $v['data']['Item'],
                    $v['data']['idTabPreschuap_'.$v['tabela']],
                    $v['data']['action']
                );

                $v['campos'] = array_keys($v['data']);
                $v['anterior'] = $tabela->get_item($v['id'], $v['tabela']);

                /*
                echo "<pre>";
                print_r($v);
                echo "</pre>";
                echo "<pre>";
                print_r($v['data']);
                echo "</pre>";
                exit('oi');
                #*/

                if($tabela->update_item($v['data'], $v['tabela'], $v['id']) ) {

                    $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('TabPreschuap_'.$v['tabela'], 'UPDATE', $v['id']), TRUE);
                    $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $v['id'], $v['auditoria'], TRUE), TRUE);

                    session()->setFlashdata('success', 'Item atualizado com sucesso!');
                    return redirect()->to('tabela/list_tabela/'.$v['tabela']);

                }
                else {

                    session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');
                    return redirect()->to('tabela/list_tabela/'.$v['tabela']);

                }

            }
            else {

                $v['data'] = $tabela->get_item($data, $v['tabela']);
                $v['data']['Item'] = $v['data'][$v['tabela']];

            }
        }
        else {

            if(isset($v['data']['Item'])) {

                if($v['tabela'] == 'ViaAdministracao')
                    #Critérios de validação
                    $inputs = $this->validate([
                        'Item'      => 'required',
                        'Codigo'    => ['label' => 'Abreviação', 'rules' => 'required'],
                    ]);
                elseif($v['tabela'] == 'Protocolo')
                    #Critérios de validação
                    $inputs = $this->validate([
                        'Item'                          => ['label' => 'Protocolo', 'rules' => 'required'],
                        'Aplicabilidade'                => 'required',
                        'idTabPreschuap_TipoTerapia'    => ['label' => 'Tipo de Terapia', 'rules' => 'required'],
                        'idTabPreschuap_Categoria'      => ['label' => 'Categoria', 'rules' => 'required'],
                        'Observacoes'                   => ['label' => 'Observações', 'rules' => 'required'],
                    ]);
                else
                    #Critérios de validação
                    $inputs = $this->validate([
                        'Item' => 'required',
                    ]);

                #Realiza a validação e retorna ao formulário se false
                if (!$inputs)
                    $v['validation'] = $this->validator;
                else {

                    $action = $v['data']['action'];

                    $v['data'][$v['tabela']] = $v['data']['Item'];
                    if($v['tabela'] == 'ViaAdministracao')
                        $v['data']['Codigo'] = mb_strtoupper($v['data']['Codigo']);
                    if($v['tabela'] == 'Protocolo')
                        $v['data']['Protocolo'] = mb_strtoupper($v['data']['Item']);

                    unset(
                        $v['data']['csrf_test_name'],
                        $v['data']['Item'],
                        $v['data']['action']
                    );
                    /*
                    echo "<pre>";
                    print_r($v);
                    echo "</pre>";
                    echo "<pre>";
                    print_r($v['data']);
                    echo "</pre>";
                    exit('oi');
                    #*/
                    $v['campos'] = array_keys($v['data']);

                    if($action == 'editar') {

                        $v['id'] = $v['data']['idTabPreschuap_'.$v['tabela']];
                        $v['anterior'] = $tabela->get_item($v['id'], $v['tabela']);

                        if($tabela->update_item($v['data'], $v['tabela'], $v['id']) ) {

                            $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('TabPreschuap_'.$v['tabela'], 'UPDATE', $v['id']), TRUE);
                            $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $v['id'], $v['auditoria'], TRUE), TRUE);

                            session()->setFlashdata('success', 'Item atualizado com sucesso!');
                            return redirect()->to('tabela/list_tabela/'.$v['tabela']);

                        }
                        else {

                            session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');
                            return redirect()->to('tabela/list_tabela/'.$v['tabela']);

                        }

                    }
                    else {
                        $v['anterior'] = array();

                        $v['id'] = $tabela->insert_item($v['data'], $v['tabela']);

                        if($v['id']) {

                            $v['auditoria'] = $auditoria->insert($v['func']->create_auditoria('TabPreschuap_'.$v['tabela'], 'CREATE', $v['id']), TRUE);
                            $v['auditoriaitem'] = $auditorialog->insertBatch($v['func']->create_log($v['anterior'], $v['data'], $v['campos'], $v['id'], $v['auditoria']), TRUE);

                            session()->setFlashdata('success', 'Item adicionado com sucesso!');
                            return redirect()->to('tabela/list_tabela/'.$v['tabela']);

                        }
                        else {

                            session()->setFlashdata('failed', 'Não foi possível concluir a operação. Tente novamente ou procure o setor de Tecnologia da Informação.');
                            return redirect()->to('tabela/list_tabela/'.$v['tabela']);

                        }

                    }

                }

            }
            else {

                if($action == 'editar') {
                    $v['data'] = $tabela->get_item($data, $v['tabela']);
                    $v['data']['Item'] = $v['data'][$v['tabela']];
                }
                else
                    $v['data'] = [
                        'Item'                          =>  '',
                        'Codigo'                        =>  '',
                        'Aplicabilidade'                =>  '',
                        'idTabPreschuap_TipoTerapia'    =>  '',
                        'idTabPreschuap_Categoria'      =>  '',
                        'Observacoes'                   =>  '',
                    ]; #iniciando as variávies para serem carregadas corretamente na página de lista de itens de tabela

            }

        }

        /*
        echo "<pre>";
        #print_r($v);
        echo "</pre>";
        echo "<pre>";
        print_r($v['data']);
        echo "</pre>";
        #exit('oi');
        #*/

        return view('admin/tabela/form_tabela', $v);

    }

}
