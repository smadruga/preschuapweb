<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\HUAP_Functions;

class PacienteModel extends Model
{
    protected $DBGroup              = 'aghux';
    protected $table                = 'aip_pacientes';
    protected $primaryKey           = 'codigo';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'codigo',
                                        'nome',
                                        'nome_mae',
                                        'dt_nascimento',
                                        'sexo',
                                        'cpf',
                                        'prontuario',
                                        'prnt_ativo',
                                        'nro_cartao_saude',
                                        'id_sistema_legado',
                                        'email',
                                        'ddd_fone_residencial',
                                        'fone_residencial',
                                        'ddd_fone_recado',
                                        'fone_recado',
                                    ];

    /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function get_paciente_codigo($data)
    {

        $db = \Config\Database::connect('aghux');
        $query = $db->query('
            SELECT
                codigo
                , nome
                , nome_mae
                , to_char(dt_nascimento, \'DD/MM/YYYY\') as dt_nascimento
                , extract(year from age(dt_nascimento)) as idade
                , sexo
                , cpf
                , prontuario
                , prnt_ativo
                , nro_cartao_saude
                , id_sistema_legado
                , email
                , ddd_fone_residencial
                , fone_residencial
                , ddd_fone_recado
                , fone_recado
            FROM
                aip_pacientes
            WHERE
                codigo = '.$data.'
        ');
        $query = $query->getRowArray();

        $query2 = $db->query('
            SELECT
                ddd
                , nro_fone
            FROM
                aip_contatos_pacientes
            WHERE
                pac_codigo = '.$query['codigo'].'
        ');

        $query['telefone'] = NULL;
        foreach ($query2->getResultArray() as $val)
            $query['telefone'] .= $this->mascara_telefone($val['ddd'], $val['nro_fone']).' ';          
     

        #$query['telefone'] = ($query['ddd_fone_residencial'] || $query['fone_residencial']) ? $query['ddd_fone_residencial'].' '.$query['fone_residencial'].' (Residencial) ' : NULL;
        #$query['telefone'] .= ($query['ddd_fone_recado'] || $query['fone_recado']) ? $query['ddd_fone_recado'].' '.$query['fone_recado'].' (Recado) ' : NULL;



        /*
        #echo $db->getLastQuery();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit($data);
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        return $query;

    }

    /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function get_paciente_bd($data, $limit = NULL, $offset = NULL)
    {

        $func = new HUAP_Functions();

        if($func->check_cpf($data))
            $where = 'cpf = \''.$func->mascara_cpf($data, 'remover').'\'';
        elseif($func->check_date($data, 'regex'))
            $where = 'dt_nascimento = \''.$func->mascara_data($data, 'db').'\'';
        elseif($func->check_date($data, 'checkdate'))
            $where = 'dt_nascimento = \''.$func->mascara_data($data, 'inverter').'\'';
        elseif(is_numeric($data) && strlen($data) <= 9)
            $where = 'prontuario = \''.$data.'\'';
        else
            $where = 'nome ilike \'%'.$data.'%\' OR nome ilike \'%'.$func->remove_accents($data).'%\'';

        $limit = ($limit) ? ' LIMIT '.$limit : NULL;
        $offset = ($offset) ? ' OFFSET '.$offset : NULL;

        $db = \Config\Database::connect('aghux');
        $query = $db->query('
            SELECT
                codigo
                , nome
                , nome_mae
                , dt_nascimento
                , prontuario
            FROM
                aip_pacientes
            WHERE
                '.$where.'
            ORDER BY nome ASC
            '.$limit.'
            '.$offset.'
        ');
        /*
        echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getResultArray());
        echo "</pre>";
        exit($data);
        #*/
        #return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

        $q['count'] = $query->getNumRows();
        $q['array'] = $query->getResultArray();

        return ($query->getNumRows() > 0) ? $q : FALSE ;

    }

    function mascara_telefone($ddd, $telefone) {
        // Remove caracteres não numéricos do DDD e do telefone
        $ddd = preg_replace('/[^0-9]/', '', $ddd);
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
    
        // Aplica a máscara ao telefone (ex: (XX) XXXX-XXXX ou (XX) XXXXX-XXXX)
        if (strlen($telefone) == 8) {
            return preg_replace('/(\d{4})(\d{4})/', "($ddd) $1-$2", $telefone);
        } elseif (strlen($telefone) == 9) {
            return preg_replace('/(\d{5})(\d{4})/', "($ddd) $1-$2", $telefone);
        }
        
        // Retorna o telefone sem formatação caso tenha tamanho inesperado
        return "($ddd) $telefone";
    }

}
