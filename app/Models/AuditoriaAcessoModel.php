<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaAcessoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'AuditoriaAcesso';
    protected $primaryKey           = 'idSishuap_AuditoriaAcesso';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'Tabela',
                                        'idSishuap_Usuario',

                                        'Operacao',
                                        'ChavePrimaria',
                                        'Ip',
                                        'So',
                                        'Navegador',
                                        'NavegadorVersao',
                                    ];

}
