<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $DBGroup              = 'aghux';
    protected $table                = '';
    protected $primaryKey           = 'idSishuap_Perfil';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [];

   /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function list_agenda($dtinicio, $dtfim, $esp, $sala, $proc)
    {

        #echo '>>><br>'.$data.'<br>'.$esp.'<br>'.$sala.'<br>'.$proc;
        #exit();
        $db = \Config\Database::connect('aghux');
       
        $query = $db->query('

            select
                agd.seq
                , agd.sci_seqp sala
                , to_char(agd.dt_agenda, \'yyyy-mm-dd\') dataAgenda
                , agd.dthr_prev_inicio
                , agd.dthr_prev_fim
                , pac.prontuario prontuario
                , pac.nome nome
                , esp.seq 
                , esp.NOME_ESPECIALIDADE especialidade
                , pci.descricao procedimento
                , pef.nome equipe
                , uni_func.descricao
            from
                agh.mbc_agendas agd
                    join agh.MBC_PROCEDIMENTO_CIRURGICOS pci on (pci.seq = agd.EPR_PCI_SEQ)
                    join agh.mbc_horario_turno_cirgs htc on (agd.unf_seq = htc.unf_seq)
                    join agh.aip_pacientes pac on (agd.pac_codigo = pac.codigo)
                    join agh.agh_especialidades esp on (agd.ESP_SEQ = esp.seq)
                    left join agh.MBC_PROF_ATUA_UNID_CIRGS prof on (agd.PUC_SER_MATRICULA = prof.SER_MATRICULA
                        and agd.PUC_SER_VIN_CODIGO = prof.SER_VIN_CODIGO
                        and agd.PUC_UNF_SEQ = prof.UNF_SEQ
                        and agd.PUC_IND_FUNCAO_PROF = prof.IND_FUNCAO_PROF)
                    left join agh.RAP_SERVIDORES rap on (prof.SER_MATRICULA = rap.matricula
                        and prof.SER_VIN_CODIGO = rap.vin_codigo)
                    left join agh.RAP_PESSOAS_FISICAS pef on (rap.pes_codigo = pef.codigo)
                    left join agh.RAP_SERVIDORES rapAgd on (agd.SER_MATRICULA = rapAgd.matricula
                        and agd.SER_VIN_CODIGO = rapAgd.vin_codigo)
                    left join agh.RAP_PESSOAS_FISICAS pefAgd on (rapAgd.pes_codigo = pefAgd.codigo)
                    inner join agh.agh_unidades_funcionais uni_func on uni_func.seq = agd.unf_seq
            where
                (
                    (agd.dthr_prev_inicio is null and agd.ordem_overbooking is not null)
                        or (
                            to_number(to_char(agd.dthr_prev_inicio,\'hh24mi\'),\'9999\') >= to_number(to_char(htc.horario_inicial,\'hh24mi\'),\'9999\')
                            and to_number(to_char(agd.dthr_prev_inicio,	\'hh24mi\'), \'9999\') <
                                case
                                    to_number(to_char(htc.horario_final, \'hh24mi\'),	\'9999\')
                                when 0
                                    then to_number(\'2359\', \'9999\')
                                else
                                    to_number(to_char(htc.horario_final, \'hh24mi\'), \'9999\')
                                end
                        )
                        or (to_number(to_char(agd.dthr_prev_inicio,	\'hh24mi\'),\'9999\') <= to_number(to_char(htc.horario_inicial,	\'hh24mi\'), \'9999\')			
                            and to_number(to_char(agd.dthr_prev_fim, \'hh24mi\'), \'9999\') > to_number(to_char(htc.horario_inicial, \'hh24mi\'),	\'9999\'))
                )
                and agd.ind_exclusao = \'N\'
                and agd.ind_situacao in (\'AG\', \'ES\')
                and agd.unf_seq = 229
                and htc.unf_seq = 229
                and agd.dt_agenda between \'' . $dtinicio . ' 00:00\' and \'' . $dtfim . ' 23:59\'
                and esp.seq = ' . $esp . '
                and agd.sci_seqp = ' . $sala . '
                and pci.seq = ' . $proc . '
            group by
                agd.seq
                , agd.sci_seqp
                , htc.turno
                , agd.dt_agenda
                , esp.NOME_ESPECIALIDADE
                , pci.descricao
                , pef.nome
                , pac.prontuario
                , pac.nome
                , agd.dthr_prev_inicio
                , agd.dthr_prev_fim
                , agd.tempo_sala
                , intervalo_escala
                , agd.DTHR_INCLUSAO
                , pefAgd.nome
                , agd.regime
                , agd.ind_gerado_sistema
                , uni_func.descricao
                , esp.seq 
            order by
                agd.dthr_prev_inicio asc	
                , agd.sci_seqp
                , agd.dt_agenda
                , htc.turno
        ');

        #$query = $query->getRowArray();
        $q['count'] = $query->getNumRows();
        $q['array'] = $query->getResultArray();
         
        #Detalhar os horários a cada 10 minutos e criar um array multidimensional
        #onde cada data será um nível e as horas subníveis, com as informações do paciente.
        $q['marcacoes'] = array();
        foreach ($q['array'] as $val) {
           
            #$q['marcacoes'][$val['dataagenda']][$val['dthr_prev_inicio']] = $val;
            #/*
            $hr         = date('H:i:s', strtotime($val['dthr_prev_inicio']));
            $hrinicio   = date('H:i:s', strtotime($val['dthr_prev_inicio']));
            $hrfim      = date('H:i:s', strtotime($val['dthr_prev_fim']));
            #echo '<br>>>origem: '.$val['prontuario'].' <> '.$hr.' <> '.$hrfim;
            
            for($i=0; $hr<$hrfim; $i+=10){
                $q['marcacoes'][$val['dataagenda']][$hr] = $val;
                $hr = date('H:i:s', strtotime($hrinicio . ' + ' . $i . ' minute'));
                #echo '<br>>>>>derivado: '.$val['prontuario'].' <> '.$hr.' <> '.$hrfim;
            }
            #*/

        }
        
        /*
        #echo $db->getLastQuery();
        echo "<pre>";
        #print_r($q['array']);
        echo "</pre>";
        echo "<pre>";
        print_r($q['marcacoes']);
        echo "</pre>";
        exit();
        #*/
        
        return $q;

    }
}
