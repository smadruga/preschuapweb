<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\HUAP_Functions;

class PrescricaoMedicamentoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Preschuap_Prescricao_Medicamento';
    protected $primaryKey           = 'idPreschuap_Prescricao_Medicamento';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'idPreschuap_Prescricao',
                                        'idTabPreschuap_Protocolo_Medicamento',
                                        'Ajuste',
                                        'Cálculo',
                                    ];

    /**
    * Retorna zero, um ou mais prescrições médicas registradas no banco de dados.
    *
    * @return void
    */
    public function read_medicamento($data)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                pm.idPreschuap_Prescricao_Medicamento
                , pm.idPreschuap_Prescricao
                , pm.idTabPreschuap_Protocolo_Medicamento
                , pm.Ajuste
                , pm.Calculo
                , tpm.idTabPreschuap_Protocolo
                , tpm.OrdemInfusao
                , tet.EtapaTerapia
                , tm.Medicamento
                , concat(tpm.Dose," ",tum.Representacao) as Dose
                , tva.ViaAdministracao
                , td.Diluente
                , tpm.Volume
                , tpm.TempoInfusao
                , tps.Posologia
            FROM
                preschuapweb.Preschuap_Prescricao_Medicamento as pm
                , preschuapweb.TabPreschuap_Protocolo_Medicamento as tpm
                , preschuapweb.TabPreschuap_EtapaTerapia as tet
                , preschuapweb.TabPreschuap_Medicamento as tm
                , preschuapweb.TabPreschuap_UnidadeMedida as tum
                , preschuapweb.TabPreschuap_ViaAdministracao as tva
                , preschuapweb.TabPreschuap_Diluente as td
                , preschuapweb.TabPreschuap_Posologia as tps
            WHERE
            	pm.idTabPreschuap_Protocolo_Medicamento = tpm.idTabPreschuap_Protocolo_Medicamento
                and tpm.idTabPreschuap_EtapaTerapia = tet.idTabPreschuap_EtapaTerapia
                and tpm.idTabPreschuap_Medicamento = tm.idTabPreschuap_Medicamento
                and tpm.idTabPreschuap_UnidadeMedida = tum.idTabPreschuap_UnidadeMedida
                and tpm.idTabPreschuap_ViaAdministracao = tva.idTabPreschuap_ViaAdministracao
                and tpm.idTabPreschuap_Diluente = td.idTabPreschuap_Diluente
                and tpm.idTabPreschuap_Posologia = tps.idTabPreschuap_Posologia

            	AND idPreschuap_Prescricao in ('.$data['where'].')

            ORDER BY pm.idPreschuap_Prescricao asc, tpm.OrdemInfusao asc
        ');

        foreach($query->getResultArray() as $val)
            $data['medicamento'][$val['idPreschuap_Prescricao']][] = $val;

        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getResultArray());
        echo "</pre>";
        echo "<pre>";
        print_r($data['medicamento']);
        echo "</pre>";
        exit('oi');
        #*/

        return $data['medicamento'];

    }

}
