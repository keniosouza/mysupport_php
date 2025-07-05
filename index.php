<?php

/** Importação autoload */
include_once './vendor/autoload.php';

/** Importação de classes */
use \vendor\controller\main\Main;

/** Instânciamento de classes */
$Main = new Main();

/** Operações */
$Main->SessionStart();

/** Variaveis padrão */
$Config = $Main->LoadConfigPublic();

/** Busco a permissão do usuário */
$resultUserAcl = $Main->LoadUserAcl();?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <base href="<?php echo $Config->app->url_aplication ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br, en, fr, it">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-language" content="PT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="resource-types" content="document" />
    <meta name="revisit-after" content="1" />
    <meta name="classification" content="Internet" />
    <meta name="robots" content="index,follow" />
    <meta name="distribution" content="Global" />
    <meta name="rating" content="General" />
    <meta name="audience" content="all" />
    <meta name="language" content="pt-br" />
    <meta name="doc-class" content="Completed" />
    <meta name="doc-rights" content="Public" />
    <meta name="revisit-after" content="1 days" />

    <title>

        <?php echo $Config->app->title ?> | <?php echo $Config->app->version ?>.<?php echo $Config->app->release ?> | <?php echo $Config->app->name ?>

    </title>

    <link rel="icon" type="image/x-icon" href="image/favicon.png">

    <!-- Importação de arquivos de estilo -->
    <link rel="stylesheet" href="css/1-normalize.css">
    <link rel="stylesheet" href="css/2-bootstrap.min.css">
    <link rel="stylesheet" href="fonts/BootStrap/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/3-main.css">
    <link rel="stylesheet" href="css/9-ckeditor.css">
    <link rel="stylesheet" href="css/13-avatar-group.css">
    <link rel="stylesheet" href="css/17-timeline.css">
    <link rel="stylesheet" href="css/18-chat.css">
    <link rel="stylesheet" href="css/19-context-menu.css">
    <link rel="stylesheet" href="css/20-editor.css">
    <link rel="stylesheet" href="css/22-dropzone.css">
    <link rel="stylesheet" href="css/croppr.min.css">

    <!-- Importação de arquivos javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/ckeditor.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/loader.js"></script>
    <script src="js/toast.js"></script>
    <script src="js/file.js"></script>
    <script src="js/context-menu.js"></script>
    <script src="js/context-form.js"></script>
    <script src="js/custom-event.js"></script>
    <script src="js/main.js"></script>
    <script src="js/croppr.min.js"></script>
    <script src="js/echart.js"></script>

    <!--  Importação dos arquivos do calendário  -->
    <script src="js/fullcalendar/index.global.min.js"></script>
    <script src="js/fullcalendar/bootstrap5/index.global.min.js"></script>
    <script src="js/fullcalendar/core/locales-all.global.min.js"></script>

    <script src="js/router.js"></script>
    
</head>

<body data-bs-theme="light">

<?php

/** Verifico se devo mostrar o menu */
if (@(int)$_SESSION['USERSID'] > 0) {

    /** Importação do menu superior */
    include_once 'vendor/view/geral/geral_header.php';
    include_once 'vendor/view/notifications/notifications_send.php';

}

?>

<!--  Espaço reservado para construção do MODAL  -->
<div id="wrapper-modal"></div>

<div class="container">

    <!--  Espaço reservado para construção da PÁGINA  -->
    <div class="row g-1" id="wrapper"></div>

</div>

<!--  Espaço reservado para construção do TOAST  -->
<div id="wrapper-toast"></div>

<script type="text/javascript">

    <?php

    /** Guardo o redirecionamento */
    $request = null;

    /** Obtenho o hash de redefinição de senha */
    $hash = @(string)filter_input(INPUT_GET, 'hash', FILTER_SANITIZE_SPECIAL_CHARS);
    $highlighter = @(string)filter_input(INPUT_GET, 'highlighter', FILTER_SANITIZE_SPECIAL_CHARS);

    /** Verifico se existe hash para ser validado */
    if (!empty($hash))
    {

        /** Decodifico o hash */
        $hash = (object)json_decode(base64_decode($hash));

        /** Verifico se existe redefinição de senha */
        if ((bool)$hash->reset)
        {

            /** Redirecionamento para o Launcher */
            $request = 'FOLDER=VIEW&TABLE=USERS&ACTION=USERS_REGISTER_NEW_PASSWORD&USER_ID=' . $hash->user_id;

        }
        else
        {

            /** Redirecionamento para o Login */
            $request = 'FOLDER=VIEW&TABLE=USERS&ACTION=USERS_LOGIN';

        }

    }
    else
    {

        /** Verifico se devo usar a página de download */
        if($highlighter === 'download_release')
        {

            /** Obtenho os dados enviados */
            $data = @(string)filter_input(INPUT_GET, 'data', FILTER_SANITIZE_SPECIAL_CHARS);

            /** Redirecionamento para o Launcher */
            $request = 'FOLDER=VIEW&TABLE=PRODUCTS_VERSIONS_RELEASES&ACTION=PRODUCTS_VERSIONS_RELEASES_DOWNLOAD&TOKEN=' . $data;

        }
        else
        {

            /** Verificação de redirecionamento */
            if (@(int)$_SESSION['USERSID'] > 0) {

                /** Redirecionamento para o Launcher */
                $request = 'FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE';

            } else {

                /** Redirecionamento para o Login */
                $request = 'FOLDER=VIEW&TABLE=USERS&ACTION=USERS_LOGIN';

            }

        }

    }

    ?>

    /** Carrego a página atual */
    SendRequest('<?php echo $request?>', {target : 'wrapper', loader : {create: true, padding: '0px', type: 2,target : 'pills-opened', data : 'Aguarde...'}});

</script>

<script src="js/editor.js"></script>

<?php

/** Verifico se devo mostrar o menu */
if (@(int)$_SESSION['USERSID'] > 0) {

    /** Importação do menu superior */
    include_once 'vendor/view/geral/geral_footer.php';

}

?>

</body>
</html>