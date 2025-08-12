<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta | PreschuapWeb</title>
    <style>
        * {
            margin: 0px;
            padding-left:0px;
            box-sizing: border-box;
        }
        table {
            width: 92mm; /* Define a largura exata */
            border-collapse: collapse;
            margin-left:0px;
            margin-top:0px;
        }
        th, td {
            border: 1px solid black;
            padding: 3px;
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

    <div >

        <table>
            <tbody>
                <tr>
                    <td style="text-align:center;">
                        <img src="<?= base_url('assets/img/huap.png'); ?>" width="40%" /><br />
                        <img src="<?= base_url('assets/img/ebserh.png'); ?>" width="50%" />
                    </td>
                    <td colspan="2" style="text-align:center;">
                        MEC/UFF/HUAP/EBSERH<br>
                        SETOR DE FARMÁCIA HOSPITALAR<br>
                        CENTRAL DE MANIPULAÇÃO DE QUIMIOTERÁPICOS
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Paciente: <?= $data['Nome'] ?></td>
                </tr>
                <tr>
                    <td width="33%">Pront:<br> <?= $data['Prontuario'] ?></td>
                    <td width="33%">DtNasc:<br> <?= $data['DtNasc'] ?></td>
                    <td width="33%">Unidade:<br> <?= $data['Unidade'] ?></td>
                </tr>
                <tr>
                    <td colspan="2">Medicamento: <?= $data['Medicamento'] ?></td>
                    <td colspan="1">Protocolo: #<?= $data['Prescricao'] ?></td>
                </tr>
                <tr>
                    <td>Dose: <?= $data['Dose'] ?></td>
                    <td>DoseVol(ml): <?= $data['DoseVol'] ?></td>
                    <td>Diluente: <?= $data['Diluente'] ?></td>
                </tr>
                <tr>
                    <td>VolDiluente(ml): <?= $data['VolDiluente'] ?></td>
                    <td>VolFinal(ml): <?= $data['VolFinal'] ?></td>
                    <td>ViaAdminist: <?= $data['ViaAdminist'] ?></td>
                </tr>
                <tr>
                    <td>Fotosensível: <?= $data['Fotosensivel'] ?></td>
                    <td>Refrigerar: <?= $data['Refrigerar'] ?></td>
                    <td>Equipo: <?= $data['Equipo'] ?></td>
                </tr>
                <tr>
                    <td>Vesicante: <?= $data['Vesicante'] ?></td>
                    <td>Irritante: <?= $data['Irritante'] ?></td>
                    <td>Infusão: <?= $data['Infusao'] ?></td>
                </tr>
                <tr>
                    <td>Preparo:<br> <?= $data['Preparo'] ?></td>
                    <td>ValTmpAmb:<br> <?= $data['ValTmpAmb'] ?></td>
                    <td>ValRefrig:<br> <?= $data['ValRefrig'] ?></td>
                </tr>            
                <tr>
                    <td colspan="3">OBS: <?= $data['Obs'] ?></td>
                </tr>
            </tbody>
        </table>

    </div>

</body>
</html>