<?php

namespace App\Models;

use CodeIgniter\Model;

class TesteModel extends Model
{
    protected $DBGroup              = 'default';
    #protected $table                = 'posts';
    #protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    #protected $allowedFields        = ['title', 'description'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';


    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'name',
      'email'
    ];

}
