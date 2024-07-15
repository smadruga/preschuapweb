<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Preschuap_Agenda';
    protected $primaryKey           = 'idPreschuap_Agenda';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                    'idPreschuap_Agenda',
                                    'DataAgendamento',
                                    'Turno',
                                    'Observacoes',
                                    'idPreschuap_Prescricao'
                                    ];

/**
    * Captura o id da prescrição concluída mais recente.
    *
    * @return void
    */
    public function list_agenda($agenda)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT 
                pa.*
                , pp.Prontuario 
                , tpp.Protocolo 
                , tpp.idTabPreschuap_TipoAgendamento 
            FROM 
                Preschuap_Agenda pa
                    JOIN Preschuap_Prescricao pp on pa.idPreschuap_Prescricao = pp.idPreschuap_Prescricao
                    JOIN TabPreschuap_Protocolo tpp on pp.idTabPreschuap_Protocolo = tpp.idTabPreschuap_Protocolo 
            WHERE 
                pa.DataAgendamento = \'2024-07-12\'
            ORDER BY 
                pa.Turno ASC 
                , tpp.idTabPreschuap_TipoAgendamento ASC 
                , pa.idPreschuap_Agenda ASC
            ;
        ');
        $query = $query->getResultArray();

        $wherein = '(';
        foreach($query as $v)
            $wherein .= $v['Prontuario'].',';

        $wherein = substr($wherein, 0, -1).')';

        $paciente = $this->list_paciente_aghux($wherein);
        $i=0;
        $pacarray = [];
        foreach ($paciente->getResultArray() as $v) {
            $pacarray[$v['prontuario']] = $v['nome'];
        }


        $q['agenda']    = $query;
        $q['paciente']  = $pacarray;


        /*
        #echo $db->getLastQuery();
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        exit('<><>');
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        #$query = $query->getRowArray();
        return $q;

    }

    /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    private function list_paciente_aghux($data)
    {

        $db = \Config\Database::connect('aghux');
        $query = $db->query('
            select 
                ap.prontuario 
                , ap.nome 
            from 
                aip_pacientes ap 
            where 
                ap.prontuario in '.$data.'
        ');

        #$query = $query->getRowArray();

        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getResultArray());
        echo "</pre>";
        exit($data);
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        return $query;

    }

}
