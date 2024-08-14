<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('home', function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('index', 'Home::index');

    $routes->post('login', 'Home::login');
    
    $routes->get('logout/(:any)', 'Home::logout/$1');
    $routes->get('logout', 'Home::logout');
});

$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('find_user', 'Admin::find_user');
    
    $routes->post('get_user', 'Admin::get_user');
    $routes->get('get_user/(:any)', 'Admin::get_user/$1');
    
    $routes->post('import_user', 'Admin::import_user');
    $routes->get('show_user/(:any)', 'Admin::show_user/$1');
    $routes->get('list_perfil/(:any)', 'Admin::list_perfil/$1');
    $routes->post('set_perfil', 'Admin::set_perfil');
    $routes->get('del_perfil/(:any)', 'Admin::del_perfil/$1');
    $routes->match(['get', 'post'], 'disable_user/(:any)', 'Admin::disable_user/$1');
    $routes->match(['get', 'post'], 'enable_user/(:any)', 'Admin::enable_user/$1');
    $routes->add('teste', 'Admin::teste');
});

$routes->group('tabela', function ($routes) {
    $routes->match(['get', 'post'], 'list_tabela/(:any)', 'Tabela::list_tabela/$1');
    #$routes->get('edit_item', 'Tabela::edit_item');
    #$routes->post('manage_item', 'Tabela::manage_item');
    $routes->get('sort_item/(:any)/(:any)/(:any)', 'Tabela::sort_item/$1/$2/$3');
    $routes->get('sort_medicamento/(:any)', 'Tabela::sort_medicamento/$1');
});

$routes->group('paciente', function ($routes) {
    $routes->add('/', 'Paciente::find_paciente');
    $routes->get('find_paciente', 'Paciente::find_paciente');
    
    $routes->post('get_paciente/(:any)', 'Paciente::get_paciente/$1');
    $routes->post('get_paciente', 'Paciente::get_paciente');
    
    $routes->get('show_paciente/(:any)', 'Paciente::show_paciente/$1');
    $routes->get('list_paciente', 'Paciente::list_paciente');
});

$routes->group('prescricao', function ($routes) {
    $routes->get('list_prescricao', 'Prescricao::list_prescricao');
    $routes->get('print_prescricao/(:any)', 'Prescricao::print_prescricao/$1');
    $routes->get('page_prescricao', 'Prescricao::page_prescricao');

    $routes->get('manage_prescricao/(:any)/(:any)', 'Prescricao::manage_prescricao/$1/$2');
    $routes->get('manage_prescricao/(:any)', 'Prescricao::manage_prescricao/$1');
    $routes->get('manage_prescricao', 'Prescricao::manage_prescricao');

    $routes->get('manage_medicamento/(:any)', 'Prescricao::manage_medicamento/$1');
    $routes->get('manage_medicamento', 'Prescricao::manage_medicamento');

    $routes->get('copy_prescricao/(:any)/(:any)', 'Prescricao::copy_prescricao/$1/$2');
    $routes->get('copy_prescricao/(:any)', 'Prescricao::copy_prescricao/$1');
    $routes->get('copy_prescricao', 'Prescricao::copy_prescricao');
});

$routes->group('agenda', function ($routes) {
    $routes->get('/',                               'Agenda::index');
    $routes->get('index/(:any)',                    'Agenda::index/$1');
    $routes->match(['get', 'post'], 'index',        'Agenda::index');
    
    $routes->get('show_agenda_mes/(:any)/(:any)',   'Agenda::show_agenda_mes/$1/$2');
    $routes->get('show_agenda_mes/(:any)',          'Agenda::show_agenda_mes/$1');
    $routes->get('show_agenda_mes',                 'Agenda::show_agenda_mes');

    $routes->get('del_agendamento/(:any)/(:any)',   'Agenda::del_agendamento/$1/$2');
    $routes->get('del_agendamento/(:any)',          'Agenda::del_agendamento/$1');
    $routes->get('del_agendamento',                 'Agenda::del_agendamento');

    $routes->get('print_agenda/(:any)',             'Agenda::print_agenda/$1');
    $routes->get('print_agenda',                    'Agenda::print_agenda');

    $routes->get('agenda_prescricao/(:any)',        'Agenda::agenda_prescricao/$1');
    $routes->get('agenda_prescricao',               'Agenda::agenda_prescricao');
    
});

$routes->group('migracao', function ($routes) {
    $routes->get('completa_tabela', 'Migracao::completa_tabela');
    $routes->get('calcula_tabela', 'Migracao::calcula_tabela');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
