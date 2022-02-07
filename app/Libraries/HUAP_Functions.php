<?php

namespace App\Libraries;

#use CodeIgniter\RESTful\ResourceController;

#class HUAP_Functions extends ResourceController
class HUAP_Functions
{
    private $v;

    /*
    public function __construct()
    {

    }
    */

    /**
    * Função que aplica máscara de CPF
    *
    * @return varchar
    */
    function mascara_cpf($data) {

        if($data == 0)
            return '';

        $zeros = 11 - strlen($data);
        for ($i = 0; $i < $zeros; $i++)
            $data = '0' . $data;

        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $data);

    }

    /**
    * Função que prepara o insert de log para a tabela de auditoria
    *
    * @return array
    */
    function create_auditoria($tabela, $operacao, $id) {

        $request = \Config\Services::request();
        $agent = $request->getUserAgent();


        return [
            'Tabela'            => $tabela,
            'idSishuap_Usuario' => 1,

            'Operacao'          => $operacao,
            'ChavePrimaria'     => $id,
            'Ip'                => $request->getIPAddress(),
            'So'                => $agent->getPlatform(),
            'Navegador'         => $agent->getBrowser(),
            'NavegadorVersao'   => $agent->getVersion(),
        ];

    }

    /**
    * Função que prepara o insert de log para a tabela de auditoria
    *
    * @return array
    */
    function create_log($anterior = NULL, $atual, $campos, $iddata, $idauditoria, $update = NULL, $delete = NULL) {

        $query = array();

        $i = 0;
        #compara valores antigos com os novos e vê onde há mudanças
        if ($update === TRUE) {
            foreach ($campos as $novo) {
                #echo $novo.' <> '.$atual[$novo].' <> '.$anterior[$novo].'<br>';
                #if (isset($atual[$novo]) && isset($anterior[$novo]) && $atual[$novo] != $anterior[$novo]) {
                if (isset($atual[$novo]) && !isset($anterior[$novo])) {
                    $query[] = array(
                        'idSishuap_Auditoria' => $idauditoria,
                        'Campo' => $novo,
                        'ValorAnterior' => NULL,
                        'ValorAtual' => $atual[$novo],
                        'ChavePrimaria' => $iddata,
                    );
                }
                elseif (isset($atual[$novo]) && $atual[$novo] != $anterior[$novo]) {
                    $query[] = array(
                        'idSishuap_Auditoria' => $idauditoria,
                        'Campo' => $novo,
                        'ValorAnterior' => $anterior[$novo],
                        'ValorAtual' => $atual[$novo],
                        'ChavePrimaria' => $iddata,
                    );
                }
            }
        }
        #apenas monta o select para inserção de novos dados, sem fazer comparações
        else {
            if ($delete === TRUE) {
                foreach ($campos as $novo) {
                    if ($anterior[$novo]) {
                        $query[] = array(
                            'idSishuap_Auditoria' => $idauditoria,
                            'Campo' => $novo,
                            'ValorAnterior' => $anterior[$novo],
                            'ChavePrimaria' => $iddata,
                        );
                    }
                }
            }
            else {
                foreach ($campos as $novo) {
                    if ($atual[$novo]) {
                        $query[] = array(
                            'idSishuap_Auditoria' => $idauditoria,
                            'Campo' => $novo,
                            'ValorAtual' => $atual[$novo],
                            'ChavePrimaria' => $iddata,
                        );
                    }
                }
            }
        }

        #$query['PK'] = $id;

        /*
          echo $id;
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        #*/

        return ($query) ? $query : FALSE;

    }

    /**
    * Função que prepara o insert para a tabela de auditoria
    *
    * @return array
    */
    function set_auditoria($auditoriaitem, $tabela, $operacao, $data, $usuario = FALSE) {

        (isset($_SESSION['log']['id'])) ? $usuario = $_SESSION['log']['id'] : $usuario = 18;

        if(isset($auditoriaitem['PK']))
            $chaveprimaria = $auditoriaitem['PK'];
        elseif(isset($auditoriaitem[0]['ChavePrimaria']))
            $chaveprimaria = $auditoriaitem[0]['ChavePrimaria'];
        else
            $chaveprimaria = NULL;

        unset($auditoriaitem['PK']);
        $auditoria = array(
            'Tabela' => $tabela,
            'id_Usuario' => $usuario,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'ChavePrimaria' => $chaveprimaria,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        /*
        echo "<pre>";
        print_r($auditoria);
        echo "</pre>";
        echo "<pre>";
        print_r($auditoriaitem);
        echo "</pre>";
        exit();
        #*/

        if ($this->db->insert('Sishuap_Auditoria', $auditoria)) {
            $i = 0;

            for ($i=0; $i < count($auditoriaitem); $i++)
                $auditoriaitem[$i]['idSishuap_Auditoria'] = $this->db->insert_id();

            if(isset($auditoriaitem) && count($auditoriaitem) > 0)
                $this->db->insert_batch('Sishuap_AuditoriaItem', $auditoriaitem);
        }

    }

}
