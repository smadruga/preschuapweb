<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_Perfil';
    protected $primaryKey           = 'idSishuap_Perfil';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'idSishuap_Usuario',
                                        'idTab_Perfil',
                                    ];

}
