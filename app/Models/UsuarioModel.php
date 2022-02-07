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
                                        'EmailSecundario
                                    '];
}
