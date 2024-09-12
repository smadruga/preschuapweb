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

    public function list_oculto($data)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder = $builder->whereIn('idPreschuap_Agenda', $data);

        $query = $builder->get();
        $results = $query->getResultArray();

        $q = array();
        foreach($results as $v) {           
            // Inicialize a chave no array antes de usá-la
            if (!isset($q[$v['idPreschuap_Agenda']]))
                $q[$v['idPreschuap_Agenda']] = array();
        
            // Inicialize o segundo nível da chave se necessário
            if (!isset($q[$v['idPreschuap_Agenda']][$v['idTabPreschuap_Medicamento']]))
                $q[$v['idPreschuap_Agenda']][$v['idTabPreschuap_Medicamento']] = true;  // Defina o valor que você deseja aqui

        }        

        return $q;

    }

}


