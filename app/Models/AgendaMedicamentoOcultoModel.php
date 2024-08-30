<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaMedicamentoOcultoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Preschuap_AgendaMedicamentoOculto';
    protected $primaryKey           = 'idPreschuap_AgendaMedicamentoOculto';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                    'idPreschuap_AgendaMedicamentoOculto',
                                    'idPreschuap_Agenda',
                                    'idTabPreschuap_Medicamento',
                                    ];  
    
    public function hide($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        $builder->insert($data);
        return $db->insertID();

    }

    public function show($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        return $builder->delete($data);        

    }

}


