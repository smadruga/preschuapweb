<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\HUAP_Functions;

class PrescricaoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Preschuap_Prescricao';
    protected $primaryKey           = 'idPreschuap_Prescricao';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'Prontuario',
                                        'DataMarcacao',
                                        'DataPrescricao',
                                        'Dia',
                                        'Ciclo',
                                        'Aplicabilidade',
                                        'idTabPreschuap_Categoria',
                                        'idTabPreschuap_Subcategoria',
                                        'idTabPreschuap_Protocolo',
                                        'idTabPreschuap_TipoTerapia',
                                        'CiclosTotais',
                                        'EntreCiclos',
                                        'Peso',
                                        'CreatininaSerica',
                                        'Altura',
                                        'idSishuap_Usuario',
                                        'Status',
                                        'Leito',
                                        'DescricaoServico',
                                        'idTabPreschuap_MotivoCancelamento',
                                        'InformacaoComplementar',
                                        'ReacaoAdversa',
                                        'idTabPreschuap_Alergia',
                                    ];

    /**
    * Retorna zero, um ou mais prescrições médicas registradas no banco de dados.
    *
    * @return void
    */
    public function get_prescricao($data)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT

            FROM
                aip_pacientes
            WHERE
                codigo = '.$data.'
        ');
        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getResultArray());
        echo "</pre>";
        exit($data);
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        return $query->getRowArray();

    }

}
