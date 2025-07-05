<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($CallsValidate->getCallId() > 0) {

    /** Busca de registro */
    $CallsGetResult = $Calls->get($CallsValidate->getCallId());

    /** Decodifico as preferencias do chamado */
    $CallsGetResult->preferences = (object)json_decode($CallsGetResult->preferences);

}?>

    <form id="CallsForm">

        <div class="card">

            <div class="card-body" role="form" id="CallsForm">

                <div class="row g-2">

                    <div class="col-md-12">

                        <div class="form-group">

                            <div class="bg-light border p-2 rounded text-center">

                                <img src="<?php echo $Main->SetIcon($CallsGetResult->preferences->image, 'default/files/default.png'); ?>" id="Destiny1" alt="<?php echo $CallsGetResult->name; ?>" name="<?php echo $CallsGetResult->name; ?>" class="img-fluid" width="50px" onchange="teste()">

                            </div>

                        </div>

                    </div>

                    <?php

                    // Diretório onde estão os arquivos PNG
                    $dir = 'image/default/calls';

                    // Lista todos os arquivos no diretório
                    $files = scandir($dir);

                    // Loop pelos arquivos
                    foreach ($files as $key => $file) {

                        // Verifica se o arquivo é um arquivo PNG
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'png') { ?>

                            <div class="col-md-3 cursor-pointer" onclick="ChangeImage('<?php echo $dir . '/' . $file?>', 'Destiny1', 'image')">

                                <div class="bg-light border p-2 rounded text-center">

                                    <img src="<?php echo $dir . '/' . $file?>" id="Origin<?php echo $key?>" class="img-fluid">

                                </div>

                            </div>

                        <?php } ?>

                    <?php } ?>

                </div>

                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="CALLS" />
                <input type="hidden" name="ACTION" value="CALLS_sAVE_PREFERENCES" />
                <input type="hidden" name="call_id" value="<?php echo @(int)$CallsGetResult->call_id ?>" />
                <input type="hidden" name="image" id="image" value="" />

            </div>

        </div>

        <div class="col-md-12 pt-2" id="CallsMessages"></div>

    </form>

    <script type="text/javascript">

        /**
         * Função para trocar a origem de uma imagem pela origem de outra imagem e atualizar o valor de um campo de entrada.
         * @param {string} src - A origem da nova imagem.
         * @param {string} destiny - O ID do elemento de imagem de destino.
         * @param {string} input - O ID do campo de entrada que será atualizado com a nova origem da imagem.
         */
        function ChangeImage(src, destiny, input){

            // Obtém o elemento de imagem de destino pelo ID
            var _destiny = document.getElementById(destiny);

            // Obtém o elemento de campo de entrada pelo ID
            var _input = document.getElementById(input);

            // Define a origem da imagem de destino como a origem fornecida
            _destiny.src = src;

            // Define o valor do campo de entrada como a nova origem da imagem
            _input.value = src;

        }

        // Função para observar mudanças no atributo src de uma imagem
        function observarMudancaSrc() {

            // Seleciona a imagem que você deseja observar
            var imagem = document.querySelector('#Destiny1');

            // Cria um MutationObserver para observar mudanças no atributo src
            var observer = new MutationObserver(function(mutations) {

                mutations.forEach(function(mutation) {

                    // Verifica se a mutação foi no atributo src da imagem
                    if (mutation.attributeName === 'src') {

                        // Emite um alerta quando o atributo src for alterado
                        SendRequest('CallsForm', {target : 'CallsMessages', block : {create : false, info : null, sec : null, target : null, data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});

                    }

                });

            });

            // Configura o MutationObserver para observar mudanças no atributo src
            observer.observe(imagem, { attributes: true });

        }

        // Chama a função para começar a observar mudanças no atributo src
        observarMudancaSrc();

    </script>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamados / Perfil /',
    'data' => $html,
    'size' => 'sm',
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
