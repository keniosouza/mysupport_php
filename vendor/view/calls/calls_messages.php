<?php

/** Parametros de entrada */
$LogsValidate->setTable(@(string)filter_input(INPUT_POST, 'TABLE_LOG', FILTER_SANITIZE_SPECIAL_CHARS));
$LogsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'REGISTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Realizo a busca do histórico */
$LogsAllByGroupResult = $Logs->AllByHash(md5(strtolower($LogsValidate->getTable()) . $LogsValidate->getRegisterId()));

?>

<?php

/** Verifico se existem mensagens */
if (count($LogsAllByGroupResult) > 0){?>

    <div class="card">

        <div id="CallsActivitiesChatMessages" class="card-body custom-scrollbar" style="max-height: 350px">

            <div class="timeline block">

                <?php

                /** Listo os acessos realizados */
                foreach ($LogsAllByGroupResult as $key => $result) {

                    /** Decodifico os dados do histórico */
                    $result->data = (object)json_decode($result->data);

                    ?>

                    <div class="tl-item <?php echo (int)$result->user_id === (int)$_SESSION['USERSID'] ? 'active' : null; ?>">

                        <div class="tl-dot b-light"></div>

                        <div class="tl-content">

                            <div class="">

                                <b>

                                    <?php echo $Main->decryptData($result->name_first)?> <?php echo $Main->decryptData($result->name_last)?>

                                </b>

                                comentou:

                                <div class="card-text">

                                    <?php echo $result->data->MESSAGE?>

                                </div>

                            </div>

                            <div class="tl-date text-muted mt-1">

                                <?php echo date('d/m/Y H:i:s', strtotime($result->date_register)) ?>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <script type="text/javascript">

        /** Envio o Scrool para o final */
        ScrollToBottom("CallsActivitiesChatMessages");

    </script>

<?php }?>
