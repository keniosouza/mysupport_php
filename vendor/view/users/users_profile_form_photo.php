<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Tratamento dos dados de entrada */
$UsersValidate->setUsersId(@(int)filter_input(INPUT_POST, 'USERS_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($UsersValidate->getUsersId() > 0) {

    /** Busca de registro */
    $UsersGetResult = $Users->get($UsersValidate->getUsersId());

}?>

    <!-- Espaço reservado para construção do formulário de arquivo -->
    <div id="FilesFormWrapper">

        <script type="text/javascript">

            <?php

            /** Defino a opções de exibição do form */
            $options = new stdClass();
            /** Defino para aceitar apenas imagens */
            $options->accept = 'image/*';
            /** Defino para selecionar apenas um arquivo */
            $options->multiple = false;
            /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
            $options->preview = 2;
            /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
            $options->phrase = 'Solte sua foto aqui';

            ?>

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=FILES&ACTION=FILES_FORM&OPTIONS=<?php echo json_encode($options)?>', {target : 'FilesFormWrapper', block : {create : true, info : null, sec : null, target : 'FilesFormWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

    <form id="FilesFormHeader">

        <input type="hidden" name="FOLDER" value="ACTION" />
        <input type="hidden" name="TABLE" value="USERS_FILES" />
        <input type="hidden" name="ACTION" value="USERS_FILES_SAVE" />
        <input type="hidden" name="USERS_ID" value="<?php echo $UsersGetResult->users_id?>" />

    </form>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Foto de Perfil',
    'data' => $html,
    'size' => 'md',
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
