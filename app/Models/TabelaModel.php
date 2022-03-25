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
                , date_format(DataCadastro, "%d/%m/%Y %H:%i") as Cadastro
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

    /**
    * Atualiza o item no banco de dados
    *
    * @return array
    */
    public function update_item($data, $tabela, $id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('TabPreschuap_'.$tabela);

        $builder->where(['idTabPreschuap_'.$tabela => $id]);
        return $builder->update($data);

    }

    /**
    * Registra o item no banco de dados
    *
    * @return array
    */
    public function insert_item($data, $tabela)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('TabPreschuap_'.$tabela);

        return $builder->insert($data);

    }

    /**
    * Retorna o item no banco de dados de acordo com seu id
    *
    * @return array
    */
    public function get_item($data, $tabela)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('TabPreschuap_'.$tabela);

        return $builder->getWhere(['idTabPreschuap_'.$tabela => $data])->getRowArray();

    }

}
