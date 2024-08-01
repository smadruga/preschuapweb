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
    public function list_agenda_mes($mes, $ano)
    {
        
        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT 
                pa.idPreschuap_Agenda
                , pa.DataAgendamento
                , tpp.idTabPreschuap_TipoAgendamento 	
            FROM 
                Preschuap_Agenda pa
                    JOIN Preschuap_Prescricao pp				ON pa.idPreschuap_Prescricao 		= pp.idPreschuap_Prescricao
                    JOIN TabPreschuap_Protocolo tpp 			ON pp.idTabPreschuap_Protocolo 		= tpp.idTabPreschuap_Protocolo 
            WHERE 
                MONTH(pa.DataAgendamento) = '.$mes.' AND YEAR(pa.DataAgendamento) = '.$ano.'
            ORDER BY 
                pa.DataAgendamento ASC 
                , pa.idPreschuap_Agenda ASC 
            ;
        ');
        $query = $query->getResultArray();
        $qnr = count($query);

        #/*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit('e<><>eas42423asfsd'.$qnr);
        #*/

        if (!$query || ($mes && $ano)) {
            $q = array();
            return $q;
        }
            
        
        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit('e<><>eas42423asfsd'.$qnr);
        #*/

        $agenda = array();
        foreach($query as $v) {
            
            $v['badge'] = $this->badge($v['idTabPreschuap_TipoAgendamento']);

            if($v['idTabPreschuap_TipoAgendamento'] == 1 && $v['idTabPreschuap_EtapaTerapia'] == 2 && $v['idTabPreschuap_ViaAdministracao'] == 2) 
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
            elseif ($v['idTabPreschuap_TipoAgendamento'] == 2 && $v['idTabPreschuap_ViaAdministracao'] == 4)
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
            elseif ($v['idTabPreschuap_TipoAgendamento'] == 3 || $v['idTabPreschuap_TipoAgendamento'] == 4 || $v['idTabPreschuap_TipoAgendamento'] == 5)
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
                
        }
            

        /*
        echo "<pre>";
        print_r($agenda);
        echo "</pre>";
        exit('e<><>e');
        #*/

        $wherein = '(';
        foreach($query as $v)
            $wherein .= $v['Prontuario'].',';

        $wherein = substr($wherein, 0, -1).')';
#exit($wherein);
        $paciente = $this->list_paciente_aghux($wherein);
        $pacarray = array();
        foreach ($paciente->getResultArray() as $v) 
            $pacarray[$v['prontuario']] = $v['nome'];


        $q['agendamento']   = $agenda;
        $q['paciente']      = $pacarray;


        /*
        echo $db->getLastQuery();
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
    * Captura o id da prescrição concluída mais recente.
    *
    * @return void
    */
    public function list_agenda($data)
    {

        #$data = ($data) ? $data : date('Y-m-d'); 

#exit('>>>'.$data);

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT 
                tpp.idTabPreschuap_TipoAgendamento 	
                , pa.Turno 
                , ppm.idTabPreschuap_EtapaTerapia 
                , ppm.idTabPreschuap_ViaAdministracao 
                , ppm.idTabPreschuap_Medicamento 
                , pp.Prontuario
                , tpp.idTabPreschuap_Protocolo
                , tpp.Protocolo
                , ppm.idTabPreschuap_Medicamento 
                , tpm.Medicamento 
                , ppm.idTabPreschuap_ViaAdministracao 
                , tpva.Codigo 
                , format(ppm.Calculo, 2, "pt_BR") as Dose
                , pa.*
            FROM 
                Preschuap_Agenda pa
                    JOIN Preschuap_Prescricao pp				ON pa.idPreschuap_Prescricao 		= pp.idPreschuap_Prescricao
                    JOIN TabPreschuap_Protocolo tpp 			ON pp.idTabPreschuap_Protocolo 		= tpp.idTabPreschuap_Protocolo 
                    JOIN Preschuap_Prescricao_Medicamento ppm 	ON pp.idPreschuap_Prescricao 		= ppm.idPreschuap_Prescricao 
                        JOIN TabPreschuap_ViaAdministracao tpva 	ON ppm.idTabPreschuap_ViaAdministracao 	= tpva.idTabPreschuap_ViaAdministracao 
                        JOIN TabPreschuap_Medicamento tpm 			ON ppm.idTabPreschuap_Medicamento 		= tpm.idTabPreschuap_Medicamento 
            WHERE 
                pa.DataAgendamento = \''.$data.'\'
            ORDER BY 
                pa.Turno ASC 
                , tpp.idTabPreschuap_TipoAgendamento ASC 
                , pa.idPreschuap_Agenda ASC
                , ppm.idTabPreschuap_Medicamento ASC
            ;
        ');
        $query = $query->getResultArray();
        $qnr = count($query);
//pa.DataAgendamento = '.$data.'
//pa.DataAgendamento = \'2024-07-25\'
        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit('e<><>eas42423asfsd'.$qnr);
        #*/

        if (!$query) {
            $q = array();
            return $q;
        }
            
        
        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit('e<><>eas42423asfsd'.$qnr);
        #*/

        $agenda = array();
        foreach($query as $v) {
            
            $v['badge'] = $this->badge($v['idTabPreschuap_TipoAgendamento']);

            if($v['idTabPreschuap_TipoAgendamento'] == 1 && $v['idTabPreschuap_EtapaTerapia'] == 2 && $v['idTabPreschuap_ViaAdministracao'] == 2) 
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
            elseif ($v['idTabPreschuap_TipoAgendamento'] == 2 && $v['idTabPreschuap_ViaAdministracao'] == 4)
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
            elseif ($v['idTabPreschuap_TipoAgendamento'] == 3 || $v['idTabPreschuap_TipoAgendamento'] == 4 || $v['idTabPreschuap_TipoAgendamento'] == 5)
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
                
        }
            
        /*
        echo "<pre>";
        print_r($agenda);
        echo "</pre>";
        exit('e<><>e');
        #*/

        $wherein = '(';
        foreach($query as $v)
            $wherein .= $v['Prontuario'].',';

        $wherein = substr($wherein, 0, -1).')';
#exit($wherein);
        $paciente = $this->list_paciente_aghux($wherein);
        $pacarray = array();
        foreach ($paciente->getResultArray() as $v) 
            $pacarray[$v['prontuario']] = $v['nome'];


        $q['agendamento']   = $agenda;
        $q['paciente']      = $pacarray;


        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        #exit('<><>');
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

    /**
    * Função que adciona um badge de acordo com o tipo de agendamento.
    *
    * @return text
    */    
    public function badge($data)
    {

        if($data == 1)
            $badge = '<span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Salão de Quimioterapia"><i class="fa-solid fa-couch"></i></span>';
        elseif($data == 2)
            $badge = '<span class="badge bg-success text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Injeção"><i class="fa-solid fa-syringe"></i></span>';
        elseif($data == 3)
            $badge = '<span class="badge bg-warning text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Medicação de Suporte"><i class="fa-solid fa-pills"></i></span>';
        elseif($data == 4)
            $badge = '<span class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Internação"><i class="fa-solid fa-bed"></i></span>';
        else
            $badge = '<span class="badge bg-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Intratecal"><i class="fa-solid fa-house-medical"></i></span>';

        /*
        echo "<pre>";
        #print_r($v['data']);
        echo "</pre>";
        exit($badge.'oi'.$data);
        #*/

        return $badge;

    }

}
