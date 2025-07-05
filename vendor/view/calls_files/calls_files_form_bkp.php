<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Users;
use \vendor\model\CallsUsers;
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Main = new Main();
$Users = new Users();
$CallsUsers = new CallsUsers();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesUsersValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesUsersValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

?>

    <form id="ProductsVersionsForm">

        <div class="row">

            <div class="col-md">

                <div class="form-group">

                    <label for="name">

                        Nome:

                    </label>

                    <input type="text" class="form-control form-control-solid" id="name" name="name"/>

                </div>

            </div>

            <div class="col-md">

                <div class="form-group">

                    <label for="file" class="text-semi-bold">

                        Arquivo

                    </label>

                    <div class="custom-file">

                        <input type="file" class="custom-file-input" id="file" name="file" onchange="prepareUploadFile('#file')">
                        <label class="custom-file-label" for="customFile">

                            Escolha o arquivo

                        </label>

                    </div>

                </div>

            </div>

            <div class="col-md-12 display-none" id="tableFiles">

                <table class="table bg-white table-bordered table-borderless">

                    <thead>

                    <tr>

                        <th scope="col">

                            Nome

                        </th>

                        <th scope="col" class="text-center">

                            Extensão

                        </th>

                        <th scope="col" class="text-center">

                            Remover

                        </th>

                    </tr>

                    </thead>

                    <tbody id="fileSelected">

                    <!-- Html montado dinamicamente com Jquery-->

                    </tbody>

                </table>

            </div>

            <div class="col-md-12">

                <button type="button" class="btn btn-primary w-100" onclick="sendForm('#ProductsVersionsForm', 'N', true, '', 0, '', '', 'random', 'circle', 'md', true)">

                    <i class="bi bi-check me-1"></i>Salvar

                </button>

            </div>

        </div>

        <input type="hidden" name="call_id" value="<?php echo @(string)$CallsActivitiesUsersValidate->getCallId() ?>"/>
        <input type="hidden" name="call_activity_id" value="<?php echo @(string)$CallsActivitiesUsersValidate->getCallActivityId() ?>"/>
        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_FILES"/>
        <input type="hidden" name="ACTION" value="CALLS_FILES_SAVE"/>
        <input type="hidden" name="base64" value="" id="base64"/>
        <input type="hidden" name="extension" value="" id="extension"/>

    </form>

    <script type="text/javascript">

        /** Limpo os dados anteriores definidos */
        function clearData() {

            /** Limpo os valores do arquivo */
            $('#file').val(null);

            /** Limpo o Base64 informado */
            $('#base64').val(null);

            /** Limpo a extensão informado */
            $('#extension').val(null);

            /** Remoção da linha da tabela */
            $('#lineFile').remove();

            /** Remoção da linha da tabela */
            $('#tableFiles').addClass('display-none');

        }

        /** Preparo o arquivo para envio */
        function prepareUploadFile(origin) {

            /** Inicio o Bloqueio de tela */
            blockPage(true, '', 0, '', 'Preparando arquivo', 'blue', 'circle', 'sm', true);

            try {

                /** Preparo o envio de múltiplos arquivos */
                for (let i = 0; i < $(origin)[0].files.length; i++) {

                    /** Instâncimento de objeto para ler o conteúdo do arquivo */
                    let fileReader = new FileReader();

                    /** Leio o conteúdo do arquivo **/
                    fileReader.readAsDataURL($(origin)[0].files[i]);

                    /** Trasnformar o arquivo em base64 */
                    fileReader.onload = (e) => {

                        /** Particionar o base64 em Array **/
                        $('#base64').val(e.target.result.split(',')[1]);

                    };

                    /** Pego a extensão do arquivo o base64 em Array **/
                    $('#extension').val((/[.]/.exec($(origin)[0].files[i].name)) ? /[^.]+$/.exec($(origin)[0].files[i].name)[0] : undefined);

                    /** Montagem da linha da tabela */
                    let div = '<tr class="border-top" id="lineFile">';
                        div += '    <td>' + $(origin)[0].files[i].name + '</td>';
                        div += '    <td class="text-center">' + ((/[.]/.exec($(origin)[0].files[i].name)) ? /[^.]+$/.exec($(origin)[0].files[i].name)[0] : undefined) + '</td>';
                        div += '    <td class="text-center"><button class="btn btn-danger-soft" onclick="clearData()" type="button"><i class="bi bi-fire me-1"></i>Remover</button></td>';
                        div += '</tr>';

                    /** Preencho o HTML dentro da DIV desejada **/
                    $('#fileSelected').append(div);

                }

            }
            catch (error) {

                /** Escrevo o erro */
                console.log('Erro::' + error);

            }
            finally {

                /** Ativo a exibição da tabela */
                $('#tableFiles').removeClass('display-none');

                /** Defino um delay */
                window.setTimeout(() => {

                    /** Encerro o Bloqueio de tela */
                    blockPage(false);

                }, 2000);

            }

        }

    </script>

<?php

/** Pego a estrutura do arquivo */
$div = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'data' => $div,
    'title' => 'Postagem de Arquivos',
    'width' => '880',

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

?>