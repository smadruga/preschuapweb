<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela HTML</title>
    <style>
        * {
            margin: 0;
            padding-left:2px;
            box-sizing: border-box;
        }
        table {
            width: 94mm; /* Define a largura exata */
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <div >

    <table style="margin-left:15px;margin-top:15px;font-size:">
        <tbody>
            <tr>
                <td style="text-align:center;">
                    <img src="<?= base_url('/logo-hu.png') ?>" width="50%" /><br />
                    <img src="<?= base_url('/logo-ebserh.png') ?>" width="50%" />
                </td>
                <td colspan="2" style="text-align:center;">
                    MEC/UFF/HUAP/EBSERH<br>
                    SETOR DE FARMÁCIA HOSPITALAR<br>
                    CENTRAL DE MANIPULAÇÃO DE QUIMIOTERÁPICOS
                </td>
            </tr>
            <tr>
                <td colspan="3">Paciente: TESTE TESTE TESTE TESTE</td>
            </tr>
            <tr>
                <td width="33%">Pront: 80080080</td>
                <td width="33%">DtNasc: 21/03/2025</td>
                <td width="33%">Unid: AMBULATÓRIO QT</td>
            </tr>
            <tr>
                <td colspan="3">Medicamento: DIPIRONA</td>
            </tr>
            <tr>
                <td>Dose(mg): 500</td>
                <td>Dose vol(ml): 5000</td>
                <td>Diluente: SIM</td>
            </tr>
            <tr>
                <td>Vol Diluente(ml): 300</td>
                <td>Vol Final(ml): 300</td>
                <td>Via Administ: 300</td>
            </tr>
            <tr>
                <td>Fotosensível: SIM</td>
                <td>Refrigerar: SIM</td>
                <td>Vesic/Irritante: SIM</td>
            </tr>
            <tr>
                <td>Infusão: 12min</td>
                <td>Equipo: teste</td>
                <td>Preparo: 21/03/2025</td>
            </tr>
            <tr>
                <td>Val tmp amb: 22/03/2025</td>
                <td>Val Refrig: 23/03/2025</td>
                <td>OBS: ficar atento</td>
            </tr>
        </tbody>
    </table>

    </div>

    <div class="container text-center">
        <div class="row">
            <div class="col">
            Column
            </div>
            <div class="col">
            Column
            </div>
            <div class="col">
            Column
            </div>
        </div>
    </div>

</body>
</html>
