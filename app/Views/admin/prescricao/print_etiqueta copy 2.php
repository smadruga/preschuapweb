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
            text-align: center;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <div >

    <table style="margin-left:15px;margin-top:15px;text-align: center;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Cidade</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>João</td><td>25</td><td>São Paulo</td></tr>
            <tr><td>Maria</td><td>30</td><td>Rio de Janeiro</td></tr>
            <tr><td>Carlos</td><td>22</td><td>Belo Horizonte</td></tr>
            <tr><td>Ana</td><td>27</td><td>Curitiba</td></tr>
            <tr><td>Pedro</td><td>35</td><td>Porto Alegre</td></tr>
            <tr><td>Fernanda</td><td>29</td><td>Brasília</td></tr>
            <tr><td>Lucas</td><td>21</td><td>Salvador</td></tr>
            <tr><td>Juliana</td><td>26</td><td>Recife</td></tr>
            <tr><td>Rafael</td><td>32</td><td>Fortaleza</td></tr>
            <tr><td>Carla</td><td>28</td><td>Manaus</td></tr>
        </tbody>
    </table>

    </div>

</body>
</html>
