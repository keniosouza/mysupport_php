var GetConfigResult = null;

// Exemplo de uso da função
(async () => {

    try {

        GetConfigResult = await GetConfig('config.json');

    } catch (error) {

        // Tratamento de erro, caso a função falhe
        console.error('Erro ao processar os dados do JSON:', error);

    }

})();

function loadCKEditor() {

    // Lista todos os editores de texto
    document.querySelectorAll('.editor').forEach(function (editorElement) {

        // Pega o nome do campo
        let id = editorElement.id;

        DecoupledDocumentEditor

            .create(editorElement, {

                licenseKey: ''

            })

            .then(function (editor) {

                // Define a variável global ckeditor como editor
                window.ckeditor = editor;

                // Define a variável global editor como editor
                window.editor = editor;

                // Configura um contêiner personalizado para a barra de ferramentas.
                document.querySelector('#' + id + '_toolbar').appendChild(editor.ui.view.toolbar.element);

                // Adiciona uma classe ao elemento da barra de ferramentas do CKEditor
                document.querySelector('.ck-toolbar').classList.add('ck-reset_all');

            })

            .catch(function (error) {

                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: dkasx7tnds3a-wj71rljiu9we');
                console.error(error);

            });

    });

}


/**
 * Format bytes as human-readable text.
 *
 * @param bytes Number of bytes.
 * @param si True to use metric (SI) units, aka powers of 1000. False to use
 *           binary (IEC), aka powers of 1024.
 * @param dp Number of decimal places to display.
 *
 * @return Formatted string.
 * @url https://stackoverflow.com/questions/10420352/converting-file-size-in-bytes-to-human-readable-string
 */
function humanFileSize(bytes, si=false, dp=1) {

    // Define o limiar de conversão para base 10 ou base 2
    const thresh = si ? 1000 : 1024;

    // Retorna diretamente se o valor absoluto dos bytes é menor que o limiar
    if (Math.abs(bytes) < thresh) {

        return bytes + ' B';

    }

    // Define as unidades com base na escolha do sistema internacional ou binário
    const units = si
        ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
        : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];

    // Inicializa o índice da unidade e o fator de arredondamento
    let u = -1;
    const r = 10**dp;

    // Itera até encontrar a unidade apropriada ou alcançar o final da lista de unidades
    do {

        bytes /= thresh;
        ++u;

    } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);

    // Retorna o valor formatado com o número de casas decimais especificado e a unidade correspondente
    return bytes.toFixed(dp) + ' ' + units[u];

}

/**
 * Copia o texto para a área de transferência.
 * @param {string} text - O texto a ser copiado.
 */
function copyToClipboard(text) {

    // Cria um elemento de texto temporário
    var tempTextarea = document.createElement("textarea");

    // Adiciona o elemento ao corpo do documento
    document.body.appendChild(tempTextarea);

    // Define o valor do texto no elemento temporário
    tempTextarea.value = text;

    // Seleciona o conteúdo do elemento temporário
    tempTextarea.select();

    // Executa o comando de cópia para copiar o texto selecionado
    document.execCommand("copy");

    // Remove o elemento temporário do corpo do documento
    document.body.removeChild(tempTextarea);

    /** Configurações do Toast */
    var ToastOptions = {

        create: true,
        background: 'primary',
        text: 'Link Copiado!',

    };

    /** Construção do toast */
    ToastConstruct(ToastOptions);
    
}

/**
 * Copia o conteúdo de um elemento HTML identificado pelo ID para a área de transferência.
 * @param {string} id - O ID do elemento HTML.
 */
function copyContentToClipboard(id) {

    // Obtém o elemento pelo ID fornecido
    var elementToCopy = document.getElementById(id);

    // Verifica se o elemento foi encontrado
    if (elementToCopy) {

        // Chama a função para copiar o conteúdo para a área de transferência
        copyToClipboard(elementToCopy.value);

    } else {

        console.error("Elemento não encontrado com o ID fornecido: " + id);

    }

}

/**
 * Habilita todos os botões na página, removendo o atributo 'disabled'.
 * @returns {void}
 */
function EnableButtons() {

    /**
     * Obtém uma lista de todos os elementos de botão na página.
     * @type {HTMLCollectionOf<HTMLButtonElement>} - Coleção de elementos de botão na página.
     */
    var buttons = document.getElementsByTagName('button');

    // Itera pela lista de botões e remove o atributo 'disabled' de cada botão.
    for (var i = 0; i < buttons.length; i++) {

        buttons[i].removeAttribute('disabled');

    }

}

/**
 * Desabilita todos os botões na página, definindo o atributo 'disabled' como 'true'.
 * @returns {void}
 */
function DisableButtons() {

    /**
     * Obtém uma lista de todos os elementos de botão na página.
     * @type {HTMLCollectionOf<HTMLButtonElement>} - Coleção de elementos de botão na página.
     */
    var buttons = document.getElementsByTagName('button');

    // Itera pela lista de botões e define o atributo 'disabled' como 'true' para cada botão.
    for (var i = 0; i < buttons.length; i++) {

        buttons[i].setAttribute('disabled', 'true');

    }

}

/**
 * Habilita todos os botões na página, removendo o atributo 'disabled'.
 * @returns {void}
 */
function EnableInputs() {

    /**
     * Obtém uma lista de todos os elementos de botão na página.
     * @type {HTMLCollectionOf<HTMLButtonElement>} - Coleção de elementos de botão na página.
     */
    var inputs = document.getElementsByTagName('input');

    // Itera pela lista de botões e remove o atributo 'disabled' de cada botão.
    for (var i = 0; i < inputs.length; i++) {

        inputs[i].removeAttribute('disabled');

    }

}

/**
 * Desabilita todos os botões na página, definindo o atributo 'disabled' como 'true'.
 * @returns {void}
 */
function DisableInputs() {

    /**
     * Obtém uma lista de todos os elementos de botão na página.
     * @type {HTMLCollectionOf<HTMLButtonElement>} - Coleção de elementos de botão na página.
     */
    var inputs = document.getElementsByTagName('input');

    // Itera pela lista de botões e define o atributo 'disabled' como 'true' para cada botão.
    for (var i = 0; i < inputs.length; i++) {

        inputs[i].setAttribute('disabled', 'true');

    }

}

/**
 * Adiciona uma classe CSS a todos os elementos com a tag especificada.
 * @param {string} tag - A tag dos elementos HTML aos quais adicionar a classe CSS.
 * @param {string} classCss - A classe CSS a ser adicionada aos elementos.
 * @returns {void}
 */
function AddClassInList(tag, classCss) {

    /**
     * Obtém uma lista de todos os elementos com a tag especificada.
     * @type {HTMLCollectionOf<HTMLElement>} - Coleção de elementos HTML com a tag especificada.
     */
    var anchorElements = document.getElementsByTagName(tag);

    // Itera pela lista de elementos e adiciona a classe CSS a cada um deles.
    for (var i = 0; i < anchorElements.length; i++) {

        anchorElements[i].classList.add(classCss);

    }

}

/**
 * Remove uma classe CSS de todos os elementos com a tag especificada.
 * @param {string} tag - A tag dos elementos HTML dos quais remover a classe CSS.
 * @param {string} classCss - A classe CSS a ser removida dos elementos.
 * @returns {void}
 */
function RemoveClassInList(tag, classCss) {

    /**
     * Obtém uma lista de todos os elementos com a tag especificada.
     * @type {HTMLCollectionOf<HTMLElement>} - Coleção de elementos HTML com a tag especificada.
     */
    var anchorElements = document.getElementsByTagName(tag);

    // Itera pela lista de elementos e remove a classe CSS de cada um deles.
    for (var i = 0; i < anchorElements.length; i++) {

        anchorElements[i].classList.remove(classCss);

    }

}

/**
 * Adiciona uma classe CSS a um elemento HTML especificado pelo seu ID.
 * @param {string} tag - O ID do elemento HTML ao qual adicionar a classe CSS.
 * @param {string} classCss - A classe CSS a ser adicionada ao elemento.
 * @returns {void}
 */
function AddClass(tag, classCss) {

    /**
     * Obtém o elemento HTML com o ID especificado.
     * @type {HTMLElement} - Elemento HTML alvo.
     */
    var anchorElements = document.getElementById(tag);

    // Adiciona a classe CSS ao elemento HTML.
    anchorElements.classList.add(classCss);

}

/**
 * Remove uma classe CSS de um elemento HTML especificado pelo seu ID.
 * @param {string} tag - O ID do elemento HTML do qual remover a classe CSS.
 * @param {string} classCss - A classe CSS a ser removida do elemento.
 * @returns {void}
 */
function RemoveClass(tag, classCss) {

    /**
     * Obtém o elemento HTML com o ID especificado.
     * @type {HTMLElement} - Elemento HTML alvo.
     */
    var anchorElements = document.getElementById(tag);

    // Remove a classe CSS do elemento HTML.
    anchorElements.classList.remove(classCss);

}

/**
 * Função para alternar o estado de marcação/desmarcação de todos os checkboxes dentro de uma div.
 * @param {string} divId - O ID da div contendo os checkboxes.
 */
function ToggleCheckboxes(divId) {

    // Obtém a referência para a div usando o ID fornecido
    var div = document.getElementById(divId);

    // Verifica se a div foi encontrada
    if (div) {

        // Obtém todos os elementos de input dentro da div que são checkboxes
        var checkboxes = div.querySelectorAll('input[type="checkbox"]');

        // Itera sobre cada checkbox encontrado na div
        checkboxes.forEach(function (checkbox) {

            // Alterna o estado de marcação/desmarcação do checkbox
            checkbox.checked = !checkbox.checked;

        });

    } else {

        // Se a div não for encontrada, exibe uma mensagem de erro no console
        console.error('Div não encontrada com o ID:', divId);

    }

}

/**
 * Faz o scroll até o final de uma div especificada.
 * @param {string} target - O ID da div para a qual fazer o scroll.
 * @returns {void}
 */
function ScrollToBottom(target) {

    /**
     * Obtém o elemento HTML da div alvo usando o ID especificado.
     * @type {HTMLElement} - Elemento HTML da div alvo.
     */
    var div = document.getElementById(target);

    /**
     * Define a posição de scroll da div para o seu valor máximo, fazendo o scroll até o final da div.
     */
    div.scrollTop = div.scrollHeight;

}

/**
 * Carrega tooltips em elementos HTML que possuem o atributo 'data-bs-toggle' definido como 'tooltip'.
 * Os tooltips são baseados na biblioteca Bootstrap.
 * @returns {void}
 */
function LoadTooltip() {

    /**
     * Obtém todos os elementos HTML que possuem o atributo 'data-bs-toggle' definido como 'tooltip'.
     * @type {NodeListOf<HTMLElement>} - Lista de elementos HTML que ativam tooltips.
     */
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');

    /**
     * Cria uma lista de objetos Tooltip do Bootstrap com base na lista de elementos que ativam tooltips.
     * @type {Array<bootstrap.Tooltip>} - Lista de objetos Tooltip do Bootstrap.
     */
    var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

}

/**
 * Busca um elemento HTML através de um atributo personalizado.
 * @param {string} _data - Uma string JSON contendo os dados do atributo personalizado a ser procurado.
 * @returns {Element|null} - O elemento HTML encontrado ou null se nenhum elemento corresponder ao atributo personalizado.
 */
function GetCustomAttribute(_target, _value) {

    /**
     * Retorna os dados do elemento HTML que possui o atributo personalizado especificado.
     * @type {Element|null} - O elemento HTML encontrado ou null se nenhum elemento corresponder ao atributo personalizado.
     */
    return document.querySelector(`[data-mysupport-${_target}="${_value}"]`);

}

/**
 * Busca um elemento HTML através de um atributo personalizado.
 * @param {string} _data - Uma string JSON contendo os dados do atributo personalizado a ser procurado.
 * @returns {Element|null} - O elemento HTML encontrado ou null se nenhum elemento corresponder ao atributo personalizado.
 */
function AddInputHidden(_options) {

    //Decodifico os dados
    _options = JSON.parse(_options);

    // Cria um novo elemento input do tipo hidden
    var hidden = document.createElement('input');
    
    // Defino que o campo é hidden
    hidden.type = 'hidden';
    
    // Define um nome para o campo hidden (opcional)
    hidden.name = _options.name;

    // Expressão regular para encontrar todas as tags HTML
    var regex = /<[^>]*>/g;

    // Remove todas as tags HTML da string usando a expressão regular
    var html = _options.value;

    //Removo todas as tags html
    html.replace(regex, '');

    // Define um valor para o campo hidden (opcional)
    hidden.value = html;

    // Obtém a div onde deseja inserir o campo hidden
    var target = document.getElementById(_options.target);

    // Insere o campo hidden dentro da div
    target.appendChild(hidden);

}

/** Função para remover o html existente e preenchimento de um novo */
function PrependHtml(_options) {

    /** Preenchimento da div desejada **/
    $('#' + _options.target).prepend(_options.data);

}

/** Função para remover o html existente e preenchimento de um novo */
function PutHtml(_options) {

    /** Preenchimento da div desejada **/
    $('#' + _options.target).html(_options.data);

}

/** Função para remover o html existente e preenchimento de um novo */
function RemoveHtml(_options){

    /** Localizo o elemento pelo ID */
    var element = document.getElementById(_options.target);

    /** Verifico se o elemento existe */
    if (element)
    {

        /** Removo o elemento desejado */
        element.remove();

    }

}

async function Hash256(string) {
    const encoder = new TextEncoder();
    const data = encoder.encode(string);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
    return hashHex;
}


/**
 * Função que recebe um nome de arquivo e retorna a extensão do arquivo.
 * @param {string} data - O nome do arquivo ou caminho completo do arquivo.
 * @returns {string|null} - A extensão do arquivo, ou null se nenhum ponto for encontrado no nome do arquivo.
 */
function getExtension(data) {

    // Verifica se o nome do arquivo possui uma extensão
    if (data.lastIndexOf('.') !== -1) {

        // Obtém a posição do último ponto no nome do arquivo
        var point = data.lastIndexOf('.');

        // Extrai a extensão usando substr
        var extension = data.substr(point + 1);

        //Retorno o tipo da extensão
        return extension;

    }

    // Se não houver extensão, retorna null
    return null;

}

async function GetConfig(url) {

    try {

        const response = await fetch(url);  // Realiza a solicitação HTTP

        if (!response.ok) {  // Verifica se a resposta é bem-sucedida

            throw new Error('Falha ao carregar o arquivo JSON: ' + response.statusText);

        }

        const data = await response.json(); // Converte a resposta para JSON

        return data;  // Retorna o objeto JSON

    } catch (error) {

        console.error('Erro ao carregar dados:', error);

        throw error;  // Re-lança o erro para ser tratado por quem chama a função

    }
}

function gerarNumeroAleatorioInclusivo(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}