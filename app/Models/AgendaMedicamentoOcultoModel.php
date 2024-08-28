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
                                    'idPreschuap_Prescricao_Medicamento',
                                    ];  
    
}
