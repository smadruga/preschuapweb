<?php

namespace App\Models;

use CodeIgniter\Model;

class MigracaoModel extends Model
{
    protected $DBGroup              = 'default';


    ################################################################################
    # ATUALIZAÇÃO DA TABELA, COMPLEMENTO DOS DADOS
    ################################################################################

    /**
    * Atualiza a tabela Prescricao_Medicamento, completando com os dados faltantes da tabela TabPreschuap_Protocolo_Medicamento
    *
    * @return array
    */
    public function update_pm($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('Preschuap_Prescricao_Medicamento');

        return $builder->updateBatch($data, 'idPreschuap_Prescricao_Medicamento');

    }

    /**
    * Lista todos os medicamentos cadastrados na tabela TabPreschuap_Protocolo_Medicamento
    *
    * @return array
    */
    public function list_tab_protocolo_medicamento()
    {

        $db = \Config\Database::connect();

        $q = $db->query('
            SELECT
                idTabPreschuap_Protocolo_Medicamento
                , idTabPreschuap_Protocolo
                , OrdemInfusao
                , idTabPreschuap_EtapaTerapia
                , idTabPreschuap_Medicamento
                , Dose
                , idTabPreschuap_UnidadeMedida
                , idTabPreschuap_ViaAdministracao
                , idTabPreschuap_Diluente
                , Volume
                , TempoInfusao
                , idTabPreschuap_Posologia
            FROM
                TabPreschuap_Protocolo_Medicamento
            ORDER BY
                idTabPreschuap_Protocolo_Medicamento ASC
        ');
        $q = $q->getResultArray();

        $a = array();
        foreach ($q as $v) {
            #echo $k.' <> '.$v['OrdemInfusao'].'<br /><br />';
            $a[$v['idTabPreschuap_Protocolo_Medicamento']] = $v;
        }

        /*
        echo "<pre>";
        print_r($a);
        echo "</pre>";
        #*/

        return $a;

    }

    /**
    * Lista todos os medicamentos cadastrados na tabela Prescricao_Medicamento
    *
    * @return array
    */
    public function list_prescricao_medicamento()
    {

        $db = \Config\Database::connect();

        $q = $db->query('
            SELECT
                *
            FROM
                Preschuap_Prescricao_Medicamento
            ORDER BY
                idPreschuap_Prescricao_Medicamento ASC
        ');

        /*
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        #*/

        return $q->getResultArray();

    }

    ################################################################################
    # CÁLCULO DAS DOSES AJUSTADAS
    ################################################################################

    /**
    * Lista todos os prontuários únicos existentes na aplicação
    *
    * @return array
    */
    public function list_prontuario()
    {

        $db = \Config\Database::connect();

        $q = $db->query('
            SELECT
                Prontuario
            FROM
                Preschuap_Prescricao
            GROUP BY Prontuario
            ORDER BY Prontuario ASC;
        ');

        /*
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        #*/

        return $q->getResultArray();

    }

}
