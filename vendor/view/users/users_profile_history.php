<?php

/** Importação de classes */
use \vendor\model\CallsMessages;

/** Instânciamento de classes */
$CallsMessages = new CallsMessages();

/** Busco a constribuição das atividades por usuário */
$CallsMessagesAllByUserResult = $CallsMessages->AllByUser((int)$_SESSION['USERSID']);?>

<h6 class="mt-1">

    Atividades Recentes

</h6>

<div class="card custom-scrollbar" style="max-height: 400px">

    <div class="card-body">

        <div class="timeline block">

            <?php

            /** Listo todos os registros de produtos */
            foreach ($CallsMessagesAllByUserResult as $key => $result) {

                if ($Main->CheckWord($result->text, 'encerrando'))
                {

                    $result->css = 'success';

                }elseif ($Main->CheckWord($result->text, 'iniciando')){

                    $result->css = 'primary';


                }else
                {

                    $result->css = 'info';

                }

                ?>

                <div class="tl-item <?php echo $key === 0 ? 'active' : null ?>">

                    <div class="tl-dot b-<?php echo $result->css?>"></div>

                    <div class="tl-content">

                        <div class="">

                            <b>

                                <?php echo $Main->decryptData($result->name_first)?>

                            </b>

                            - <?php echo $result->text?>

                        </div>

                        <div class="tl-date text-muted mt-1">

                            <?php echo date('d-m-Y h:s:i', strtotime($result->date))?>

                        </div>

                    </div>

                </div>

            <?php }?>

        </div>

    </div>

</div>