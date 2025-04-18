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
    * Atualiza o item no banco de dados
    *
    * @return array
    */
    public function update_agendamento($data)
    {

        $db = \Config\Database::connect();

        $builder = $db->table($this->table);
        $builder->where(['idPreschuap_Agenda' => $data['idPreschuap_Agenda']]);

        return $builder->update($data);

    }

    /**
    *
    * @return void
    */    
    public function get_agendamento($data)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                *
            FROM
                Preschuap_Agenda
            WHERE
                idPreschuap_Agenda = '.$data.'
            ;
        ');
        #$query = $query->getRowArray();

        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit($data.'<><>');
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        
        return $query->getRowArray();

    }
                                    
    /**
    * Captura o id da prescrição concluída mais recente.
    *
    * @return void
    */
    public function list_agenda_prontuario($q) {
        
        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT 
                pa.idPreschuap_Prescricao 
                , pa.idPreschuap_Agenda 
                , CASE
                    WHEN pa.Turno = "T" THEN "TARDE"
                    WHEN pa.Turno = "N" THEN "NOITE"
                    ELSE "MANHÃ"
                END as Turno
                , date_format(pa.DataAgendamento, "%d/%m/%Y") as DataAgendamento
                , pa.Observacoes 
            FROM 
                Preschuap_Agenda pa  
            WHERE 
                pa.idPreschuap_Prescricao in ('.$q.')
            ORDER BY
                pa.idPreschuap_Agenda ASC
            ;
        ');

        foreach($query->getResultArray() as $val)
            $data['agendamento'][$val['idPreschuap_Prescricao']][] = $val;

        /*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit('oi');
        #*/
        return (isset($data['agendamento'])) ? $data['agendamento'] : false;

    }
    
    
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

        $q = array();
        foreach ($query->getResultArray() as $v) {
            
            if(!isset($q[$v['DataAgendamento']]['Dia'])) 
                $q[$v['DataAgendamento']]['Dia'] = 0;
            if(!isset($q[$v['DataAgendamento']][$v['idTabPreschuap_TipoAgendamento']])) 
                $q[$v['DataAgendamento']][$v['idTabPreschuap_TipoAgendamento']] = 0;
            

            $q[$v['DataAgendamento']]['Dia']++;
            $q[$v['DataAgendamento']][$v['idTabPreschuap_TipoAgendamento']]++;
            
        }
        $q['Total'] = $query->getNumRows();

        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        #exit('e<><>eas42423asfsd');
        #*/

        #$query = $query->getRowArray();
        return $q;

    }

    /**
    * Captura o id da prescrição concluída mais recente.
    *
    * @return void
    */
    public function list_agenda($data, $print = null)
    {

        #$data = ($data) ? $data : date('Y-m-d'); 

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT 
                tpp.idTabPreschuap_TipoAgendamento 	
                , pa.Turno 
                , ppm.idTabPreschuap_EtapaTerapia 
                , ppm.idTabPreschuap_ViaAdministracao 
                , ppm.idTabPreschuap_Medicamento 
                , pp.Prontuario
                , pp.idTabPreschuap_Dieta
                , tpp.idTabPreschuap_Protocolo
                , tpp.Protocolo
                , ppm.idTabPreschuap_Medicamento 
                , tpm.Medicamento 
                , ppm.idTabPreschuap_ViaAdministracao 
                , tpva.Codigo 
                , format(ppm.Calculo, 2, "pt_BR") as Dose
                , pp.idPreschuap_Prescricao
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
        $wherein_agenda = array();
        foreach($query as $v) {
        
            $v['badge'] = $this->badge($v['idTabPreschuap_TipoAgendamento'], $print);
            $v['dieta'] = $this->dieta($v['idTabPreschuap_Dieta'], $print);
            $wherein_agenda[] = $v['idPreschuap_Agenda'];

            if($v['idTabPreschuap_TipoAgendamento'] == 1 && $v['idTabPreschuap_EtapaTerapia'] == 2 && $v['idTabPreschuap_ViaAdministracao'] == 2) 
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
            elseif ($v['idTabPreschuap_TipoAgendamento'] == 2 && ($v['idTabPreschuap_ViaAdministracao'] == 3 || $v['idTabPreschuap_ViaAdministracao'] == 4))
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
            elseif ($v['idTabPreschuap_TipoAgendamento'] == 3 || $v['idTabPreschuap_TipoAgendamento'] == 4 || $v['idTabPreschuap_TipoAgendamento'] == 5)
                $agenda[$v['Turno']][$v['idTabPreschuap_TipoAgendamento']][] = $v;
         
        }
        $wherein_agenda = array_unique($wherein_agenda);

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
        foreach ($paciente->getResultArray() as $v) {
            $pacarray[$v['prontuario']]['nome']         = $v['nome'];
            $pacarray[$v['prontuario']]['codigo']       = $v['codigo'];
            $pacarray[$v['prontuario']]['prontuario']   = $v['prontuario'];
        }


        $q['agendamento']   = $agenda;
        $q['paciente']      = $pacarray;
        $q['wherein_agenda']= $wherein_agenda;


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
                , ap.codigo
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
    public function badge($data, $print = null)
    {
        if($print){

            /*
            if($data == 1)
                $badge = 'SQ';
            elseif($data == 2)
                $badge = 'INJ';
            elseif($data == 3)
                $badge = 'MS';
            elseif($data == 4)
                $badge = 'INTER';
            else
                $badge = 'INTRA';
            */

            if($data == 1)
                $badge = '<img src="'. base_url('/assets/img/agendamentos/sq.png') . '" />';
            elseif($data == 2)
                $badge = '<img src="'. base_url('/assets/img/agendamentos/inj.png') . '" />';
            elseif($data == 3)
                $badge = '<img src="'. base_url('/assets/img/agendamentos/ms.png') . '" />';
            elseif($data == 4)
                $badge = '<img src="'. base_url('/assets/img/agendamentos/int.png') . '" />';
            else
                $badge = '<img src="'. base_url('/assets/img/agendamentos/inc.png') . '" />';

        }
        else{   
            
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

        }
        /*
        echo "<pre>";
        #print_r($v['data']);
        echo "</pre>";
        exit($badge.'oi'.$data);
        #*/

        return $badge;

    }

    /**
    * Função que adciona um badge de acordo com o tipo de agendamento.
    *
    * @return text
    */    
    public function dieta($data, $print = null)
    {
       
        if($print){

            /*
            if($data == 1)
                $badge = 'B';
            elseif($data == 2)
                $badge = 'P';
            elseif($data == 3)
                $badge = 'L';
            elseif($data == 4)
                $badge = 'SL';
            elseif($data == 5)
                $badge = 'ES';  
            elseif($data == 6)
                $badge = 'EG';
            else
                $badge = '--';
            */

            if($data == 1)
                $badge = '<img src="'. base_url('/assets/img/dietas/b.png') . '" />';
            elseif($data == 2)
                $badge = '<img src="'. base_url('/assets/img/dietas/p.png') . '" />';
            elseif($data == 3)
                $badge = '<img src="'. base_url('/assets/img/dietas/l.png') . '" />';
            elseif($data == 4)
                $badge = '<img src="'. base_url('/assets/img/dietas/sl.png') . '" />';
            elseif($data == 5)
                $badge = '<img src="'. base_url('/assets/img/dietas/es.png') . '" />';
            elseif($data == 6)
                $badge = '<img src="'. base_url('/assets/img/dietas/eg.png') . '" />';
            else
                $badge = '<img src="'. base_url('/assets/img/dietas/vazio.png') . '" />';

        }
        else {

            if($data == 1)
                $badge = '<span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dieta Branda">B</span>';
            elseif($data == 2)
                $badge = '<span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dieta Pastosa">P</span>';
            elseif($data == 3)
                $badge = '<span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dieta Líquida">L</span>';
            elseif($data == 4)
                $badge = '<span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dieta Semi-líquida">SL</span>';
            elseif($data == 5)
                $badge = '<span class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dieta Enteral por Sonda">ES</span>';  
            elseif($data == 6)
                $badge = '<span class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dieta Enteral por Gastrostomia">EG</span>';
            else
                $badge = '<h4><span class="badge bg-secondary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Não informado"><i class="fa-solid fa-utensils"></i></span></h4>';


        }

        /*
        echo "<pre>";
        #print_r($v['data']);
        echo "</pre>";
        exit($badge.'oi'.$data);
        #*/

        return $badge;

    }    

}
