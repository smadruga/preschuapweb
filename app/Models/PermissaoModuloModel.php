<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissaoModuloModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_PermissaoModulo';
    protected $primaryKey           = 'idSishuap_PermissaoModulo';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'idSishuap_PermissaoModulo',
                                        'idSishuap_Usuario',
                                        'idTab_Modulo',
                                        ];


    /**
    * Verifica se o usuário possui registro na tabela PermissaoModulo
    *
    * @return void
    */
    public function get_permissao($id, $modulo)
    {

    return $this->where([
                            'idSishuap_Usuario' => $id,
                            'idTab_Modulo'      => $modulo
                        ])->countAllResults() > 0;
        
    }

}    