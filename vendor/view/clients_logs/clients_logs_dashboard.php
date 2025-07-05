<?php

/** Importação de classes */
use vendor\model\Files;
use vendor\model\Products;
use vendor\model\ClientsLogs;

/** Instânciamento de classes */
$Files = new Files();
$Products = new Products();
$ClientsLogs = new ClientsLogs();

/** Parâmetros de Entrada */
$dateStart = !empty($_POST['date_start']) ? date('Y-m-d', strtotime($_POST['date_start'])) : date('Y-m-d');
$dateEnd = !empty($_POST['date_end']) ? date('Y-m-d', strtotime($_POST['date_end'])) : date('Y-m-d');

/** Busco todos os produtos que recebem log */
$ProductsAllWhereSistemaIdIsNotNullResult = $Products->AllWhereSistemaIdIsNotNull()?>

    <h5 class="card-title">

        <i class="bi bi-speedometer me-1"></i>Analytics/

    </h5>

    <div class="col-md-12">

        <form id="ClientsLogsDashboardForm" class="input-group">

            <input type="date" class="form-control" name="date_start" id="date_start" value="<?php echo date('Y-m-d', strtotime($dateStart))?>">
            <input type="date" class="form-control" name="date_end" id="date_end" value="<?php echo date('Y-m-d', strtotime($dateEnd))?>">
            <button class="btn btn-outline-secondary" type="button" id="ClientsLogsDashboardButtonSearch" onclick="SendRequest('ClientsLogsDashboardForm', {target : null, loader : {create: true, type: 3, target : 'ClientsLogsDashboardButtonSearch', data : 'Aguarde...'}});">
                Pesquisar
            </button>

            <input type="hidden" name="FOLDER" value="VIEW" />
            <input type="hidden" name="TABLE" value="CLIENTS_LOGS" />
            <input type="hidden" name="ACTION" value="CLIENTS_LOGS_DASHBOARD" />

        </form>

    </div>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($ProductsAllWhereSistemaIdIsNotNullResult as $key => $result) {?>

        <div class="col-md-2">

            <div class="card">

                <div class="card-body">

                    <h5 class="text-truncate fw-normal">

                        <?php echo $result->name?>

                    </h5>

                    <h3>

                        <?php echo $ClientsLogs->CountByProductId($result->products_id, $dateStart, $dateEnd)->quantity?>

                    </h3>

                </div>

            </div>

        </div>

    <?php }?>

    <div class="col-md-8 d-flex">

        <div class="card w-100">

            <div class="card-body">

                <h4 class="card-title">

                    Eventos

                </h4>

                <!-- Prepare a DOM with a defined width and height for ECharts -->
                <div id="lineChart" class="w-100" style="height:400px;"></div>

            </div>

        </div>

        <script type="text/javascript">

            /** Defino a Requisição que sera enviada */
            var lineChartRequest = 'FOLDER=ACTION&TABLE=CLIENTS_LOGS&ACTION=CLIENTS_LOGS_ALL_GRAPH&DATE_START=<?php echo $dateStart?>&DATE_END=<?php echo $dateEnd?>';

            /** Envio da requisição */
            SendRequest(lineChartRequest, {target : null, loader : {create: false}});

            /** Inicialização do gráfico, informo que ele deve ser do tipo svg. Quando se usa svg, não some o gráfico quando a tela fica inativa */
            var lineChart = echarts.init(document.getElementById('lineChart'), null, { renderer: 'svg' });

            // Specify the configuration items and data for the chart
            var option = {
                grid: {
                    top:    '10%',
                    bottom: '10%',
                    left:   '5%',
                    right:  '5%',
                },
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {       // Ver dados
                            show: true,
                            readOnly: false
                        },
                        magicType: { type: ['line', 'bar'] },
                        restore: {},
                        saveAsImage: {
                            type: 'png'  // Salvar como imagem PNG
                        },
                    }
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    data: ['Exception']
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: []
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name : 'Exception',
                        type: 'line',
                        smooth: true,
                        data: [],
                    },
                ],
            };

            // Display the chart using the configuration items and data just specified.
            lineChart.setOption(option);

            /** Função Para Atualizar somente os dados do gráfico */
            function ClientsLogDashboardRefreshLine(options)
            {

                /** Defino os novos dados */
                lineChart.setOption({
                    xAxis :{
                        data : options.legends
                    },
                    series: [{
                        data: options.data
                    }]
                });

            }

            /** Defino a função para repetir */
            function DelayClientsLogDashboardRefreshLine() {

                /** Envio da requisição */
                SendRequest(lineChartRequest, {target : null, loader : {create: false}});

            }

            /** Defino o delay */
            setInterval(DelayClientsLogDashboardRefreshLine, 60000);

            /** Adiciono um evento para monitorar o redimensionamento da tela */
            window.addEventListener('resize', function() {

                /** Verifico se o gráfico existe */
                if (lineChart !== null && lineChart !== undefined) {

                    /** Redimensiono o gráfico */
                    lineChart.resize();

                }

            });

        </script>

    </div>

    <div class="col-md-4 d-flex">

        <div class="card w-100">

            <div class="card-body">

                <h4 class="card-title">

                    Produtos

                </h4>

                <div id="pieChart" class="w-100" style="height:500px;"></div>

                <script type="text/javascript">

                    /** Defino a Requisição que sera enviada */
                    var pieChartRequest = 'FOLDER=ACTION&TABLE=CLIENTS_LOGS&ACTION=CLIENTS_LOGS_BY_PRODUCT_ID&DATE_START=<?php echo $dateStart?>&DATE_END=<?php echo $dateEnd?>';

                    /** Envio da requisição */
                    SendRequest(pieChartRequest, {target : null, loader : {create: false}});

                    /** Inicialização do gráfico, informo que ele deve ser do tipo svg. Quando se usa svg, não some o gráfico quando a tela fica inativa */
                    var pieChart = echarts.init(document.getElementById('pieChart'), null, { renderer: 'svg' });

                    // Specify the configuration items and data for the chart
                    var pieOptions = {
                        grid: {
                            top:    '10%',
                            bottom: '10%',
                            left:   '5%',
                            right:  '5%',
                        },
                        toolbox: {
                            show: true,
                            feature: {
                                dataView: { readOnly: false },
                                saveAsImage: {
                                    type: 'png'  // Salvar como imagem PNG
                                },
                            }
                        },
                        tooltip: {
                            trigger: 'item'
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'left'
                        },
                        series: [
                            {
                                name: 'Erros por produto:',
                                type: 'pie',
                                radius: '50%',
                                data: [],
                                emphasis: {
                                    itemStyle: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }
                        ]
                    };

                    /** Exibição do Gráfico de acordo com os meus dados preenchidos */
                    pieChart.setOption(pieOptions);

                    /** Função Para Atualizar somente os dados do gráfico */
                    function ClientsLogDashboardRefreshPie(options)
                    {

                        /** Busco o gráfico e atualizo os dados */
                        pieChart.setOption({

                            series: [{

                                data: options.data

                            }]

                        });

                    }

                    /** Defino a função para repetir */
                    function DelayClientsLogDashboardRefreshPie() {

                        /** Envio da requisição */
                        SendRequest(pieChartRequest, {target : null, loader : {create: false}});

                    }

                    /** Defino o delay */
                    setInterval(DelayClientsLogDashboardRefreshPie, 60000);

                    /** Adiciono um evento para monitorar o redimensionamento da tela */
                    window.addEventListener('resize', function() {

                        /** Verifico se o gráfico existe */
                        if (pieChart !== null && pieChart !== undefined) {

                            /** Redimensiono o gráfico */
                            pieChart.resize();

                        }

                    });

                </script>

            </div>

        </div>

    </div>