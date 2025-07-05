<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Relatório de atividades aguardando conclusão">
    <meta name="keywords" content="Atividades, aguardando">
    <meta name="author" content="Softwiki">
    <title>
        Atividades Aguardando Conclusão
    </title>
    <style>

        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even){background-color: #f2f2f2;}

        table tr:hover {background-color: #ddd;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #023047;
            color: white;
        }

    </style>
</head>
<body>
<table class="table table-bordered mb-0">

    <thead>

        <tr>

            <th scope="col">

                #

            </th>

            <th scope="col">

                Atividade

            </th>

            <th scope="col">

                Prioridade

            </th>

            <th scope="col">

                Previsão

            </th>

        </tr>

    </thead>

    <tbody>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($CallsActivitiesResult as $key => $result) {?>

        <tr>

            <td>

                <?php echo $result->call_activity_id ?>

            </td>

            <td>

                 <?php echo $result->name ?>

            </td>

            <td>

                <?php echo !empty($result->call_activity_priority) ? $result->call_activity_priority : 'Não Possui' ?>

            </td>

            <td>

                <?php echo !empty($result->date_expected) ? date('d/m/Y', strtotime($result->date_expected)) : 'Não Possui' ?>

                <?php

                /** Verifico o status do registro */
                if ((!empty($result->date_expected)) && ((strtotime(date('Y/m/d')) > strtotime($result->date_expected)))) { ?>

                        -

                    <span style="padding: 5px; background: #e63946; border-radius: 50%; color: white">

                        Em Atraso

                    </span>

                <?php } ?>

            </td>

        </tr>

        <tr>

            <td></td>
            <td colspan="3">

                <?php echo $result->description ?>

                <hr>

                Operadores:

                <?php

                /** Consulta os usuário cadastrados*/
                foreach ($CallsActivitiesUsers->AllByActivityId((int)$result->call_activity_id) as $keyUsers => $resultUsers) {

                    echo $Main->decryptData(@(string)$resultUsers->name_first) . ', ';

                } ?>

            </td>

        </tr>

    <?php } ?>

    </tbody>

</table>
</body>
</html>