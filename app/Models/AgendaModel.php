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
                tpp.idTabPreschuap_TipoAgendamento 	
                , pp.Prontuario
                , tpp.Protocolo
                , ppm.idTabPreschuap_Medicamento 
                , tpm.Medicamento 
                , ppm.idTabPreschuap_ViaAdministracao 
                , tpva.Codigo 
                , ppm.Dose
                , pa.*
            FROM 
                Preschuap_Agenda pa
                    JOIN Preschuap_Prescricao pp				ON pa.idPreschuap_Prescricao 		= pp.idPreschuap_Prescricao
                    JOIN TabPreschuap_Protocolo tpp 			ON pp.idTabPreschuap_Protocolo 		= tpp.idTabPreschuap_Protocolo 
                    JOIN Preschuap_Prescricao_Medicamento ppm 	ON pp.idPreschuap_Prescricao 		= ppm.idPreschuap_Prescricao 
                        JOIN TabPreschuap_ViaAdministracao tpva 	ON ppm.idTabPreschuap_ViaAdministracao 	= tpva.idTabPreschuap_ViaAdministracao 
                        JOIN TabPreschuap_Medicamento tpm 			ON ppm.idTabPreschuap_Medicamento 		= tpm.idTabPreschuap_Medicamento 
            WHERE 
                pa.DataAgendamento = \'2024-07-12\'
            ORDER BY 
                pa.Turno ASC 
                , tpp.idTabPreschuap_TipoAgendamento ASC 
                , pa.idPreschuap_Agenda ASC
            ;
        ');
        $query = $query->getResultArray();

        $agenda = array();
        foreach($query as $v) {
            #$agenda[$v['Turno']][] = $v;
            echo "<pre>";
            print_r($v);
            echo "</pre>";            
            /*foreach($v as $x) {
                #echo '<br>'.$x['idPreschuap_Agenda'];
                echo "<pre>";
                print_r($x);
                echo "</pre>";
            }*/
        }
            

        $wherein = '(';
        foreach($query as $v)
            $wherein .= $v['Prontuario'].',';

        $wherein = substr($wherein, 0, -1).')';

        $paciente = $this->list_paciente_aghux($wherein);
        $pacarray = array();
        foreach ($paciente->getResultArray() as $v) 
            $pacarray[$v['prontuario']] = $v['nome'];


        $q['agenda']    = $agenda;
        $q['paciente']  = $pacarray;


        #/*
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
