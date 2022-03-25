<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main>

    <form method="post" action="<?= base_url('tabela/list_tabela/'.$tabela) ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            <div class="card-header">
                <b>Cadastrar novo item</b>
            </div>
            <div class="card-body has-validation">
                <label for="Item" class="form-label"><b>Item</b></label>
                <div class="input-group mb-3">
                    <input type="text" id="Item" class="form-control <?php if($validation->getError('Item')): ?>is-invalid<?php endif ?>" autofocus name="Item" value="<?php echo set_value('Item'); ?>"/>
                    <button class="btn btn-info" type="submit"><i class="fa-solid fa-plus"></i> Cadastrar</button>
                    <?php if ($validation->getError('Item')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Item') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-text">
                    Faça uma breve descrição sobre o item.
                </div>
            </div>
        </div>
    </form>

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
                <th scope="col" colspan="5" class="bg-light text-center">Tabela: <?= $tabela ?></th>
            </tr>
            <tr>
                <th scope="col" class="col-1" data-field="Id" data-sortable="true">Id</th>
                <th scope="col" data-field="Descrição" data-sortable="true">Descrição</th>
                <th scope="col" data-field="Status" data-sortable="true">Status</th>
                <th scope="col" data-field="DataCadastro" data-sortable="true">Data Cadastro</th>
                <th scope="col" class="col-2"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($lista->getResultArray() as $v) {
                if (!$v['Inativo']) {
                    $v['Inativo'] = '<span class="badge rounded-pill bg-success">ATIVO</span>';
                    $manage = '<a href="'.base_url('tabela/manage_item/'.$tabela.'/'.$v['idTabPreschuap_'.$tabela].'/1').'" type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Desabilitar"><i class="fa-solid fa-ban"></i></a>';
                }
                else {
                    $v['Inativo'] = '<span class="badge rounded-pill bg-danger">INATIVO</span>';
                    $manage = '<a href="'.base_url('tabela/manage_item/'.$tabela.'/'.$v['idTabPreschuap_'.$tabela].'/0').'" type="button" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar"><i class="fa-solid fa-circle-exclamation"></i></a>';
                }

                $diff = ($func->dateDifference($v['DataCadastro'], date('Y-m-d H:i')) < 7 ) ? '<a href="'.base_url('tabela/edit_item/'.$tabela.'/'.$v['idTabPreschuap_'.$tabela]).'" type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" ><i class="fa-solid fa-pen-to-square"></i></a>' : NULL;

                echo '
                <tr>
                    <td>'.$v['idTabPreschuap_'.$tabela].'</td>
                    <td>'.$v[$tabela].'</td>
                    <td>'.$v['Inativo'].'</d>
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

</main>

<?= $this->endSection() ?>
