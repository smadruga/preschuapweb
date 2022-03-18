<?php

namespace App\Models;

use CodeIgniter\Model;

class TabelaModel extends Model
{
    protected $DBGroup              = 'default';

    /**
    * Lista os itens registrados na tabela selecionada
    *
    * @return array
    */
    public function list_tabela_bd($data, $limit = NULL, $offset = NULL)
    {

        $limit = ($limit) ? ' LIMIT '.$limit : NULL;
        $offset = ($offset) ? ' OFFSET '.$offset : NULL;

        $db = \Config\Database::connect();
        return $db->query('
            SELECT
                *
            FROM
                TabPreschuap_'.$data.'
            ORDER BY '.$data.' ASC
            '.$limit.'
            '.$offset.'
        ');

        #return ($query->getNumRows() > 0) ? $query->getResultArray() : FALSE ;

    }

    /**
    * Lista os itens registrados na tabela selecionada
    *
    * @return array
    */
    public function count_tabela_bd($data)
    {

        $db = \Config\Database::connect();
        return $db->table('TabPreschuap_'.$data)->countAll();;

    }

}
