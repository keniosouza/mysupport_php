<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_NUMBER_INT));

/** Busco o registro desejado */
$CallsLoadResult = $Calls->load($CallsValidate->getCallId());

/** Validação da informação */
if ($CallsLoadResult->call_id === 0){?>

    <div class="card animate slideIn">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CF-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há o chamado para vincular as imagens

            </h4>

        </div>

    </div>

<?php }else{?>

    <!-- Espaço reservado para construção do formulário de arquivo -->
    <div id="CallsFilesFormWrapper">

        <script type="text/javascript">

            <?php

            /** Defino a opções de exibição do form */
            $options = new stdClass();
            /** Defino para aceitar apenas imagens */
            $options->accept = null;
            /** Defino para selecionar apenas um arquivo */
            $options->multiple = true;
            /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
            $options->preview = 1;
            /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
            $options->phrase = 'Solte seus arquivos aqui';

            ?>

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=FILES&ACTION=FILES_FORM&OPTIONS=<?php echo json_encode($options)?>', {target : 'CallsFilesFormWrapper', block : {create : true, info : null, sec : null, target : 'CallsFilesFormWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

    <form id="FilesFormHeader">

        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_FILES"/>
        <input type="hidden" name="ACTION" value="CALLS_FILES_SAVE"/>
        <input type="hidden" name="call_id" value="<?php echo @(int)$CallsLoadResult->call_id ?>"/>

    </form>

<?php }?>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamados / Arquivos /',
    'data' => $html,
    'size' => 'lg',
    'color_modal' => null,
    'color_border' => null,
    'type' => null,
    'procedure' => null,
    'time' => null

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

