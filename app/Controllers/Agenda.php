<?php

namespace App\Controllers;

use App\Models\AgendaModel;

use App\Models\AuditoriaModel;
use App\Models\AuditoriaLogModel;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;

class Agenda extends BaseController
{
    private $v;

    public function __construct()
    {

    }

    /**
    * Agenda cirúrgica
    *
    * @return void
    */
    public function index()
    {
        #exit('oi');
        return view('admin/agenda/list_agenda');
    }

}
