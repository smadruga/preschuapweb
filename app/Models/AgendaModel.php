<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Preschuap_Agenda';
    protected $primaryKey           = 'idPreschuap_Agenda';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                    'idPreschuap_Agenda',
                                    'DataAgendamento',
                                    'Turno',
                                    'Observacoes',
                                    'idPreschuap_Prescricao'
                                    ];

}
