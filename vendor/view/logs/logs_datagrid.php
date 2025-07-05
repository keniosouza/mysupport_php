<?php

/** Parametros de entrada */
$LogsValidate->setTable(@(string)filter_input(INPUT_POST, 'TABLE_LOG', FILTER_SANITIZE_SPECIAL_CHARS));
$LogsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'REGISTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Realizo a busca do histórico */
$LogsAllFilteredResult = $Logs->AllFiltered(['calls', 'calls_activities'], [177, 508]);

?>

    <div class="card">

        <div class="card-body">

            <div class="timeline block">

                <?php

                /** Listo os acessos realizados */
                foreach ($LogsAllFilteredResult as $key => $result) {

                    /** Decodifico os dados do histórico */
                    $result->data = (object)json_decode($result->data);

                    /** Verifico se devo exibir a mensagem */
                    if (!empty($result->data->TITLE))
                    {?>

                        <div class="tl-item <?php echo $key === 0 ? 'active' : null ?>">

                            <div class="tl-dot b-<?php echo $result->data->CLASS?>"></div>

                            <div class="tl-content">

                                <div class="">

                                    <?php echo $Main->decryptData($result->name_first)?> <?php echo $Main->decryptData($result->name_last)?>:

                                    <b>

                                        <?php echo $result->data->TITLE?>

                                    </b>

                                    - <?php echo $result->data->MESSAGE?>

                                </div>

                                <div class="tl-date text-muted mt-1">

                                    <?php echo date('d/m/Y H:i:s', strtotime($result->date_register)) ?>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                <?php } ?>

            </div>

        </div>

    </div>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamados / Detalhes / Histórico',
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
