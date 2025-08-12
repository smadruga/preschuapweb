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
                                        'TipoAjuste',
                                        'idTabPreschuap_MotivoAjusteDose',
                                        'Calculo',
                                        'idTabPreschuap_Protocolo',
                                        'OrdemInfusao',
                                        'idTabPreschuap_EtapaTerapia',
                                        'idTabPreschuap_Medicamento',
                                        'Dose',
                                        'idTabPreschuap_UnidadeMedida',
                                        'idTabPreschuap_ViaAdministracao',
                                        'idTabPreschuap_Codigo',
                                        'idTabPreschuap_Diluente',
                                        'Volume',
                                        'TempoInfusao',
                                        'idTabPreschuap_Posologia',
                                    ];

    /**
    * Retorna os dados do medicamento e paciente associados ao medicamento em questão, 
    * para elaboração de etiqueta de bolsa de quimioterapia.
    *
    * @return void
    */
    public function read_medicamento_etiqueta($data)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                pp.idPreschuap_Prescricao 
                , pp.Prontuario 
                , tpm.Medicamento 
                , ppm.Dose 
                , tpum.Representacao 
                , tpd.Diluente 
                , tpva.Codigo 
                , tpva.ViaAdministracao 
                , ppm.TempoInfusao 
            FROM
                Preschuap_Prescricao_Medicamento ppm
                    LEFT JOIN Preschuap_Prescricao pp 				ON ppm.idPreschuap_Prescricao 			= pp.idPreschuap_Prescricao 
                    LEFT JOIN TabPreschuap_Medicamento tpm 			ON ppm.idTabPreschuap_Medicamento 		= tpm.idTabPreschuap_Medicamento 
                    LEFT JOIN TabPreschuap_UnidadeMedida tpum 		ON ppm.idTabPreschuap_UnidadeMedida 	= tpum.idTabPreschuap_UnidadeMedida 
                    LEFT JOIN TabPreschuap_Diluente tpd 			ON ppm.idTabPreschuap_Diluente 			= tpd.idTabPreschuap_Diluente 
                    LEFT JOIN TabPreschuap_ViaAdministracao tpva 	ON ppm.idTabPreschuap_ViaAdministracao 	= tpva.idTabPreschuap_ViaAdministracao 
            WHERE
                ppm.idPreschuap_Prescricao_Medicamento = '.$data.'
        ');

        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getResultArray());
        echo "</pre>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit('oi222');
        #*/

        return $query->getRowArray();
        

    }

    /**
    * Retorna os medicamentos associados a prescrição indicada
    *
    * @return void
    */
    public function read_medicamento($data)
    {

        $id = (isset($data['where'])) ? $data['where'] : $data;

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                pm.idPreschuap_Prescricao_Medicamento
                , pm.idPreschuap_Prescricao
                , pm.idTabPreschuap_Protocolo_Medicamento
                , if(pm.Ajuste is not null, format(pm.Ajuste, 2, "pt_BR"), "") as Ajuste
                , pm.Ajuste as Ajuste2
                , pm.TipoAjuste
                , CASE WHEN pm.TipoAjuste = "substituicao" THEN "Substituição" ELSE "Porcentagem" END as TipoAjusteDescricao
                , pm.idTabPreschuap_MotivoAjusteDose
                , tmad.MotivoAjusteDose
                , format(pm.Calculo, 2, "pt_BR") as Calculo
                , format(pm.Calculo, 2, "pt_BR") as Calculo2
                , tpm.idTabPreschuap_Protocolo
                , tpm.OrdemInfusao
                , tet.EtapaTerapia
                , tm.Medicamento
                , format(tm.CalculoLimiteMinimo, 2, "pt_BR") as CalculoLimiteMinimo
                , format(tm.CalculoLimiteMaximo, 2, "pt_BR") as CalculoLimiteMaximo
                , concat(format(tpm.Dose, 2, "pt_BR")," ",tum.Representacao) as Dose
                , tva.ViaAdministracao
                , tva.Codigo
                , td.Diluente
                , format(tpm.Volume, 2, "pt_BR") as Volume
                , tpm.TempoInfusao
                , tps.Posologia
                , tum.Representacao as Unidade
                , tum.idTabPreschuap_Formula
            FROM
                Preschuap_Prescricao_Medicamento as pm
                    LEFT JOIN TabPreschuap_MotivoAjusteDose as tmad ON pm.idTabPreschuap_MotivoAjusteDose = tmad.idTabPreschuap_MotivoAjusteDose
                , TabPreschuap_Protocolo_Medicamento as tpm
                    LEFT JOIN TabPreschuap_Diluente AS td ON tpm.idTabPreschuap_Diluente = td.idTabPreschuap_Diluente
                , TabPreschuap_EtapaTerapia as tet
                , TabPreschuap_Medicamento as tm
                , TabPreschuap_UnidadeMedida as tum
                , TabPreschuap_ViaAdministracao as tva
                /*, TabPreschuap_Diluente as td*/
                , TabPreschuap_Posologia as tps
                /*, TabPreschuap_MotivoAjusteDose as tmad*/
            WHERE
            	pm.idTabPreschuap_Protocolo_Medicamento = tpm.idTabPreschuap_Protocolo_Medicamento
                and tpm.idTabPreschuap_EtapaTerapia = tet.idTabPreschuap_EtapaTerapia
                and tpm.idTabPreschuap_Medicamento = tm.idTabPreschuap_Medicamento
                and tpm.idTabPreschuap_UnidadeMedida = tum.idTabPreschuap_UnidadeMedida
                and tpm.idTabPreschuap_ViaAdministracao = tva.idTabPreschuap_ViaAdministracao
                /*and tpm.idTabPreschuap_Diluente = td.idTabPreschuap_Diluente*/
                and tpm.idTabPreschuap_Posologia = tps.idTabPreschuap_Posologia
                /*and pm.idTabPreschuap_MotivoAjusteDose = tmad.idTabPreschuap_MotivoAjusteDose*/

            	AND idPreschuap_Prescricao in ('.$id.')

            ORDER BY pm.idPreschuap_Prescricao asc, tpm.OrdemInfusao asc
        ');

           /*
            echo $db->getLastQuery();
            echo "<pre>";
            print_r($query->getResultArray());
            echo "</pre>";
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            #exit('oi222');
            #*/

        if(isset($data['where'])) {
            foreach($query->getResultArray() as $val) {

                if($val['Ajuste2'] == 0 || !$val['Ajuste2'])
                    $val['Ajuste2'] = NULL;
                elseif($val['TipoAjuste'] == "porcentagem")
                    $val['Ajuste2'] = intval($val['Ajuste2']).'%';
                else
                    $val['Ajuste2'] = $val['Ajuste'];

                if($val['idTabPreschuap_Formula'] == 2 || $val['idTabPreschuap_Formula'] == 3) {
                    $u = explode("/", $val['Unidade']);
                    $u[0] = ($u[0] == 'auc') ? 'mg' : $u[0];
                    $val['Calculo'] = $val['Calculo'].' '.$u[0];
                }
                else {
                    $val['Unidade'] = ($val['Unidade'] == 'auc') ? 'mg' : $val['Unidade'];
                    $val['Calculo'] = $val['Calculo'].' '.$val['Unidade'];
                }

                $data['medicamento'][$val['idPreschuap_Prescricao']][] = $val;

            }

            /*
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            exit('oi');
            #*/
            return $data['medicamento'];
        }
        else
            return $query->getResultArray();

            /*
            echo $db->getLastQuery();
            echo "<pre>";
            print_r($query->getResultArray());
            echo "</pre>";
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            exit('oi');
            #*/

    }

}
