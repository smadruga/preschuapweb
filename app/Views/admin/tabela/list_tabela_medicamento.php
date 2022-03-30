<hr>

<table class="table table-hover table-bordered" id="table"
    data-toggle="table"
    data-locale="pt-BR"
    data-id-field="Id"
    data-sortable="true"
    data-search="true"
    data-pagination="true"
    >
    <thead>
        <tr>
            <th scope="col" colspan="13" class="bg-light text-center">Tabela: <?= $tabela ?></th>
        </tr>
        <tr>
            <th scope="col" class="col-1" data-field="Id" data-sortable="true">Id</th>
            <th scope="col" data-field="Medicamento" data-sortable="true">Medicamento</th>
            <th scope="col" data-field="OrdemInfusao" data-sortable="true">OrdemInfusao</th>
            <th scope="col" data-field="EtapaTerapia" data-sortable="true">Etapa Terapia</th>
            <th scope="col" data-field="Dose" data-sortable="true">Dose</th>
            <th scope="col" data-field="Via Administração" data-sortable="true">Via Administração</th>
            <th scope="col" data-field="Diluente" data-sortable="true">Diluente</th>
            <th scope="col" data-field="Volume" data-sortable="true">Volume</th>
            <th scope="col" data-field="TempoInfusao" data-sortable="true">TempoInfusao</th>
            <th scope="col" data-field="Posologia" data-sortable="true">Posologia</th>
            <th scope="col" data-field="Status" data-sortable="true">Status</th>
            <th scope="col" data-field="Data Cadastro" data-sortable="true">Data Cadastro</th>
            <th scope="col" class="col-2"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($lista->getResultArray() as $v) {

            if (!$v['Inativo']) {
                $v['Inativo'] = '<span class="badge rounded-pill bg-success">ATIVO</span>';
                $manage = '<a href="'.base_url('tabela/list_tabela/'.$tabela.'/desabilitar/'.$v['idTabPreschuap_'.$tabela]).'" type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Desabilitar"><i class="fa-solid fa-ban"></i></a>';
            }
            else {
                $v['Inativo'] = '<span class="badge rounded-pill bg-danger">INATIVO</span>';
                $manage = '<a href="'.base_url('tabela/list_tabela/'.$tabela.'/habilitar/'.$v['idTabPreschuap_'.$tabela]).'" type="button" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar"><i class="fa-solid fa-circle-exclamation"></i></a>';
            }

            $diff = ($func->dateDifference($v['DataCadastro'], date('Y-m-d H:i')) < 7 ) ? '<a href="'.base_url('tabela/list_tabela/'.$tabela.'/editar/'.$v['idTabPreschuap_'.$tabela]).'" type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" ><i class="fa-solid fa-pen-to-square"></i></a>' : NULL;

            echo '
                <tr>
                    <td>'.$v['idTabPreschuap_Protocolo_Medicamento'].'</td>
                    <td>'.$v['Medicamento'].'</td>
                    <td>'.$v['OrdemInfusao'].'</td>
                    <td>'.$v['EtapaTerapia'].'</td>
                    <td>'.$v['Dose'].'</td>
                    <td>'.$v['ViaAdministracao'].'</td>
                    <td>'.$v['Diluente'].'</td>
                    <td>'.$v['Volume'].'</td>
                    <td>'.$v['TempoInfusao'].'</td>
                    <td>'.$v['Posologia'].'</td>
                    <td>'.$v['Inativo'].'</td>
                    <td>'.$v['Cadastro'].'</td>
                    <td class="text-center">
                        '.$diff.'
                        '.$manage.'
                    </td>
                </tr>
            ';
        }
        ?>
    </tbody>
</table>
