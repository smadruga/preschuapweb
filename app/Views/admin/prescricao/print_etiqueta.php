<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela HTML</title>
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
                <td colspan="3">Paciente: TESTE TESTE TESTE TESTE</td>
            </tr>
            <tr>
                <td width="33%">Pront:<br> 80080080</td>
                <td width="33%">DtNasc:<br> 21/03/2025</td>
                <td width="33%">AMBULATÓRIO QT</td>
            </tr>
            <tr>
                <td colspan="3">Medicamento: DIPIRONA</td>
            </tr>
            <tr>
                <td>Dose(mg): 500</td>
                <td>DoseVol(ml): 5000</td>
                <td>Diluente: SIM</td>
            </tr>
            <tr>
                <td>VolDiluente(ml): 300</td>
                <td>VolFinal(ml): 300</td>
                <td>ViaAdminist: 300</td>
            </tr>
            <tr>
                <td>Fotosensível: SIM</td>
                <td>Refrigerar: SIM</td>
                <td>Equipo: teste</td>
            </tr>
            <tr>
                <td>Vesicante: SIM</td>
                <td>Irritante: SIM</td>
                <td>Infusão: 12min</td>
            </tr>
            <tr>
                <td>Preparo:<br> 21/03/2025</td>
                <td>ValTmpAmb:<br> 22/03/2025</td>
                <td>ValRefrig:<br> 23/03/2025</td>
            </tr>            
            <tr>
                <td colspan="3">OBS: ficar atento</td>
            </tr>
        </tbody>
    </table>

    </div>

</body>
</html>
