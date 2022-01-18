<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_Usuario';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = ['Usuario', 'Senha'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
}
