<?php

namespace App\Models;

use CodeIgniter\Model;

class TabelaModel extends Model
{
    protected $DBGroup              = 'default';

    /**
    * Lista os itens da tabela Protocolo_Medicamentos
    *
    * @return array
    */
    public function list_medicamento_bd($data)
    {

        $db = \Config\Database::connect();
        return $db->query('
            SELECT
            	tpm.idTabPreschuap_Protocolo_Medicamento
                , tpm.idTabPreschuap_Protocolo
                , tpm.OrdemInfusao
                , tet.EtapaTerapia
                , tm.Medicamento
                , concat(format(tpm.Dose, 2, "pt_BR"), " ", tum.Representacao) AS Dose
                , tva.ViaAdministracao
                , td.Diluente
                , format(tpm.Volume, 2, "pt_BR") AS Volume
                , tpm.TempoInfusao
                , tpo.Posologia
                , tpm.DataCadastro
                , date_format(tpm.DataCadastro, "%d/%m/%Y %H:%i") as Cadastro
                , tpm.Inativo
            FROM
            	TabPreschuap_Protocolo_Medicamento 		AS tpm
                , TabPreschuap_EtapaTerapia 			AS tet
                , TabPreschuap_Medicamento 				AS tm
                , TabPreschuap_UnidadeMedida 			AS tum
                , TabPreschuap_ViaAdministracao 		AS tva
                , TabPreschuap_Diluente 				AS td
                , TabPreschuap_Posologia 				AS tpo
            WHERE
            	tpm.idTabPreschuap_EtapaTerapia 		= tet.idTabPreschuap_EtapaTerapia
                and tpm.idTabPreschuap_Medicamento 		= tm.idTabPreschuap_Medicamento
                and tpm.idTabPreschuap_UnidadeMedida 	= tum.idTabPreschuap_UnidadeMedida
                and tpm.idTabPreschuap_ViaAdministracao = tva.idTabPreschuap_ViaAdministracao
                and tpm.idTabPreschuap_Diluente 		= td.idTabPreschuap_Diluente
                and tpm.idTabPreschuap_Posologia 		= tpo.idTabPreschuap_Posologia

                and tpm.idTabPreschuap_Protocolo = '.$data.'
            ORDER BY tpm.idTabPreschuap_Protocolo ASC, tpm.OrdemInfusao ASC
        ');

    }

    /**
    * Lista os itens registrados na tabela selecionada
    *
    * @return array
    */
    public function list_tabela_bd($data, $limit = NULL, $offset = NULL, $queryfields = NULL, $order = NULL, $notinativo = NULL )
    {

        $limit = $offset = NULL;
        if ($queryfields === NULL || $queryfields === FALSE) {
            $limit = ($limit) ? ' LIMIT '.$limit : NULL;
            $offset = ($offset) ? ' OFFSET '.$offset : NULL;
            $select = '*, date_format(DataCadastro, "%d/%m/%Y %H:%i") as Cadastro';
        }
        else {
            $limit = $offset = NULL;
            $select = $queryfields;
        }

        $order = ($order) ? $order : $data;

        $where = ($notinativo) ? ' WHERE Inativo = 0 OR Inativo is null ' : NULL;

        $db = \Config\Database::connect();
        return $db->query(
            'SELECT
                '.$select.'
            FROM
                TabPreschuap_'.$data.'
                '.$where.'
            ORDER BY '.$order.' ASC
                '.$limit.'
                '.$offset
        );

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
    * Atualiza a ordem de infusão no banco de dados
    *
    * @return array
    */
    public function update_item_sort($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('TabPreschuap_Protocolo_Medicamento');

        return $builder->updateBatch($data, 'idTabPreschuap_Protocolo_Medicamento');

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

        $builder->insert($data);
        return $db->insertID();

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

    /**
    * Retorna o item no banco de dados de acordo com seu id
    *
    * @return array
    */
    public function get_item_sort($id, $ordem = FALSE)
    {

        $where = ($ordem) ? 'AND OrdemInfusao IN ('.$ordem.')' : NULL;

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                idTabPreschuap_Protocolo_Medicamento
                , OrdemInfusao
            FROM
                TabPreschuap_Protocolo_Medicamento
            WHERE
                idTabPreschuap_Protocolo = '.$id.'
                '.$where.'
            ORDER BY OrdemInfusao ASC, idTabPreschuap_Protocolo_Medicamento ASC
        ');

        return $query->getResultArray();

    }

    /**
    * Deleta um medicamento de acordo com seu id
    *
    * @return array
    */
    public function remove_medicamento($id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('TabPreschuap_Protocolo_Medicamento');

        return $builder->delete(['idTabPreschuap_Protocolo_Medicamento' => $id]);

    }

}
