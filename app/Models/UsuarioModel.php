<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_Usuario';
    protected $primaryKey           = 'idSishuap_Usuario';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'Usuario',
                                        'Nome',
                                        'Cpf',
                                        'EmailSecundario',
                                        ];

    /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function get_user_mysql($data)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                Usuario,
                Cpf
            FROM
                Sishuap_Usuario
            WHERE
                Usuario = "' . $data . '"
                OR Cpf = "' . $data . '"
            ORDER BY Nome
        ');
        return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

    }
}
