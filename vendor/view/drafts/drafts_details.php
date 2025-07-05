<?php

/** Importação de classes */
use \vendor\model\Drafts;
use \vendor\controller\drafts\DraftsValidate;

/** Instânciamento de classes */
$Drafts = new Drafts();
$DraftsValidate = new DraftsValidate();

/** Tratamento dos dados de entrada */
$DraftsValidate->setDraftId(@(int)filter_input(INPUT_POST, 'DRAFT_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($DraftsValidate->getDraftId() > 0) {

    /** Busca de registro */
    $resultDraft = $Drafts->Get($DraftsValidate->getDraftId());

    /** Decodifico o texto */
    $resultDraft->text = utf8_decode(base64_decode($resultDraft->text));

}

?>
 <div class="col-md-6">

        <h5 class="card-title">

            <b>

                <i class="fas fa-building me-1"></i>Minutas

            </b>

            /Detalhes/

            <button type="button" class="btn btn-primary btn-sm mb-0" onclick="request('FOLDER=VIEW&TABLE=DRAFTS&ACTION=DRAFTS_DATAGRID', '#loadContent', true, '', 0, '', 'Carregando registros', 'random', 'circle', 'sm', true);">

                <i class="bi bi-arrow-left-short me-1"></i>Voltar

            </button>

        </h5>

    </div>

    <div class="col-md-12">

        <div class="card shadow-sm animate slideIn">

            <div class="card-body">

                <ul class="nav nav-pills nav-fill mb-2" id="pills-tab">

                    <li class="nav-item">

                        <a class="nav-link active" id="pills-texto-tab" data-bs-toggle="pill" href="#pills-texto" aria-controls="pills-texto">

                            <i class="far fa-file-alt me-1"></i>Texto

                        </a>

                    </li>

                    <li class="nav-item mx-1">

                        <a class="nav-link" id="pills-historico-tab" data-bs-toggle="pill" href="#pills-historico" aria-controls="pills-historico" aria-selected="false">

                            <i class="bi bi-clock-history me-1"></i>Histórico

                        </a>

                    </li>

                </ul>

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade active show" id="pills-texto" aria-labelledby="pills-texto-tab">

                        <div class="card-text border p-2 shadow-sm rounded text-break">

                            <?php echo utf8_encode(@(string)$resultDraft->text)?>

                        </div>

                    </div>

                    <div class="tab-pane fade show" id="pills-historico" aria-labelledby="pills-historico-tab">

                        <div class="main-card card shadow-sm">

                            <div class="card-body">

                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                                    <?php

                                    /** Pego o histórico existente */
                                    $history = json_decode($resultDraftUsers->history, TRUE);

                                    /** Listo os acessos realizados */
                                    foreach ($history as $keyResultHistory => $resultHistory)
                                    { ?>

                                        <div class="vertical-timeline-item vertical-timeline-element">

                                            <div>

                                                <span class="vertical-timeline-element-icon bounce-in">

                                                    <i class="badge badge-dot badge-dot-xl <?php echo @(string)$resultHistory['class']?>"> </i>

                                                </span>

                                                <div class="vertical-timeline-element-content bounce-in">

                                                    <h4 class="timeline-title">

                                                        <?php echo @(string)$resultHistory['title']?> - <?php echo @(string)$resultHistory['user']?>

                                                    </h4>

                                                    <p>

                                                        <?php echo @(string)$resultHistory['description']?>

                                                        <a href="javascript:void(0);" data-abc="true">

                                                            <?php echo @(string)$resultHistory['date']?>

                                                        </a>

                                                    </p>

                                                    <span class="vertical-timeline-element-date">

                                                        <?php echo @(string)$resultHistory['time']?>

                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    <?php }?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>