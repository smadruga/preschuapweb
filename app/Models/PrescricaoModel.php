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
    public function read_prescricao($data, $buscaid = FALSE)
    {

        $where = ($buscaid) ? 'p.idPreschuap_Prescricao = '.$data : 'p.Prontuario = '.$data;

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                p.idPreschuap_Prescricao
                , p.Prontuario
                , date_format(p.DataMarcacao, "%d/%m/%Y") as DataMarcacao
                , date_format(p.DataPrescricao, "%d/%m/%Y") as DataPrescricao
                , concat("D",p.Dia) as Dia
                , p.Ciclo
                , p.Aplicabilidade
                , concat(tc.idTabPreschuap_Categoria, " - ", tc.Categoria) as Categoria
                , concat(ts.idTabPreschuap_Subcategoria, " - ", ts.Subcategoria) as Subcategoria
                , tp.Protocolo
                , tp.Observacoes
                , ttt.TipoTerapia
                , p.CiclosTotais
                , p.EntreCiclos
                , format(p.Peso, 2, "pt_BR") as Peso
                , format(p.CreatininaSerica, 2, "pt_BR") as CreatininaSerica
                , Altura
                , u.Nome
                , u.Cpf
                , p.Status
                , p.Leito
                , p.DescricaoServico
                , tmc.MotivoCancelamento
                , p.InformacaoComplementar
                , p.ReacaoAdversa
                , ta.Alergia
            FROM
                preschuapweb.Preschuap_Prescricao as p
                    left join TabPreschuap_Categoria as tc on p.idTabPreschuap_Categoria = tc.idTabPreschuap_Categoria
                    left join TabPreschuap_Subcategoria as ts on p.idTabPreschuap_Subcategoria = ts.idTabPreschuap_Subcategoria
                    left join TabPreschuap_Protocolo as tp on p.idTabPreschuap_Protocolo = tp.idTabPreschuap_Protocolo
                    left join TabPreschuap_TipoTerapia as ttt on p.idTabPreschuap_TipoTerapia = ttt.idTabPreschuap_TipoTerapia
                    left join Sishuap_Usuario as u on p.idSishuap_Usuario = u.idSishuap_Usuario
                    left join TabPreschuap_MotivoCancelamento as tmc on p.idTabPreschuap_Subcategoria = tmc.idTabPreschuap_MotivoCancelamento
                    left join TabPreschuap_Alergia as ta on p.idTabPreschuap_Subcategoria = ta.idTabPreschuap_Alergia
            WHERE
                '.$where.'
        ');
        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getResultArray());
        echo "</pre>";
        exit($data.' <> '.$query->getNumRows());
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        $r['array'] = $query->getResultArray();
        $r['count'] = $query->getNumRows();

        return $r;

    }

    /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function get_conselho($data)
    {

        $db = \Config\Database::connect('aghux');
        $query = $db->query('
            SELECT
                concat(cpr_sigla, \'-\',nro_reg_conselho) as conselho
            FROM
                agh.v_rap_servidor_conselho
            WHERE
                cpf = '.$data.'
        ');

        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit($data);
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;
        $query = $query->getRowArray();
        return $query['conselho'];

    }

}