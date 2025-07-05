<?php

/** Parametros de entrada */
$LogsValidate->setTable(@(string)filter_input(INPUT_POST, 'TABLE_LOG', FILTER_SANITIZE_SPECIAL_CHARS));
$LogsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'REGISTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Realizo a busca do histórico */
$LogsAllByGroupResult = $Logs->AllByHash(md5(strtolower($LogsValidate->getTable()) . $LogsValidate->getRegisterId()));?>

    <div class="card">

        <div class="card-body custom-scrollbar" style="max-height: 350px">

            <div class="timeline block">

                <?php

                /** Listo os acessos realizados */
                foreach ($LogsAllByGroupResult as $key => $result) {

                    /** Decodifico os dados do histórico */
                    $result->data = (object)json_decode($result->data);

                    /** Verifico se devo exibir a mensagem */
                    if (!empty($result->data->TITLE)){?>

                        <div class="tl-item">

                            <div class="tl-dot b-<?php echo $result->data->CLASS?>"></div>

                            <div class="tl-content">

                                <div class="">

                                    <b>

                                        <?php echo $Main->decryptData($result->name_first)?> <?php echo $Main->decryptData($result->name_last)?>:

                                    </b>

                                    -

                                    <span class="badge bg-<?php echo $result->data->CLASS?>">

                                        <?php echo $result->data->TITLE?>

                                    </span>

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