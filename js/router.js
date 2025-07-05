/** Método Principal */
function SendRequest(data, options) {

    /** Instânciamento da classe da Requisição */
    new Request(data, options);

}

/** Classe desejada */
class Request {

    /** Método construtor */
    constructor(data, options) {

        /** Parâmetros da classe */
        this._data = data;
        this._options = options;

        /** Instânciamento da classe de Loader */
        this._loader = new Loader(options.loader);

        /** Verifico se devo realizar o envio da requisição */
        if (this._data){

            /** Realizo a requisição desejada */
            this.send()

        }

    }

    /** Função para definir o cabeçalho da requisição */
    setHeader(data) {

        /** Defino o cabeçalho padrão de requisição */
        var header = {

            /** Formato de envio */
            method: 'post',

            /** Modo de envio */
            mode: 'cors',

            /** Defino o cabeçalho da requisição */
            headers: {

                /** Converto a string para parâmetros de url */
                "Content-Type": "application/x-www-form-urlencoded",

                /** Envio a contagem de caracteres */
                "Content-Length": data.length,

                /** Defino o a prioridade */
                "X-Custom-Header": "ProcessThisImmediately"

            },

            /** Definição do cache */
            cache: 'no-store',

            /** Dados para envio */
            body: data,

        };

        /** Retorno da informação */
        return header;

    }

    /** Listagem de todos os campos */
    serializeForm(form) {

        /** Obtenho todos os dados do formulario */
        var tempForm = document.getElementById(form);

        /** Obtenho apenas os campos do formulário */
        var tempData = new FormData(tempForm);

        /** Transform os campos do formulário em parâmetros de URL */
        tempData = new URLSearchParams(tempData).toString();

        /** Busco o elemetno desejado */
        var editorElements = document.getElementsByClassName('editor');

        /** Verifica se o editor está ativo */
        if(editorElements.length > 0){

            /** List todos os editores */
            for (let i = 0; i < editorElements.length; i++)
            {

                /** Obtenho os dados do editor */
                tempData = tempData + '&' + editorElements[i].id + '=' + encodeURIComponent(editorElements[i].innerHTML);

            }

        }

        /** Retorno da informação */
        return tempData;

    }

    /** Função para remover o html existente e preenchimento de um novo */
    putHtml(target, data) {

        /** Preenchimento da div desejada **/
        $('#' + target).html(data);

    }

    /** Função para executar mudanças de páginas */
    send() {

        try {

            /** Verifico se devo colocar Loader em algum lugar */
            if (this._options.loader)
            {

                /** Realizo a construção do loader */
                this._loader.create();

            }

            /** Verifico se devo desabilitar os botões */
            if (this._options.disable)
            {

                /** Desabilito os botões da Tela */
                DisableButtons();

                /** Adiciono classe em todas as tags determinadas */
                AddClassInList('a', 'disabled-link');

            }

            /** Expressão regular para verificar a presença do sinal de igualdade */
            var regularExpression = /=/;

            /** Verifico se devo realizar o Serialize */
            if (!regularExpression.test(this._data)) {

                /** guardo o serialize */
                this._data = this.serializeForm(this._data);

            }

            /** Url para envio */
            fetch('router.php', this.setHeader(this._data))

                /** Fetch do objeto */
                .then(response => response.json())

                /** Resultado da requisição BEM SUCEDIDA */
                .then((response) => {

                    /** Execução de operações de SUCESSO */
                    this.success(response, this._options);

                })

                /** Resultado da requisição MAL SUCEDIDA */
                .catch(error => {

                    /** Execução de operações de ERRO */
                    this.error(error, this._options);

                })

        } catch (erro){

            /** Verifico se devo exibir o Toast */
            ToastConstruct({create: true, background: 'danger', text: 'Router: ' + erro.message});

        } finally {

            /** Carrego os tooltips */
            LoadTooltip();

            /** Verifico se devo colocar Loader em algum lugar */
            if (this._options.disable)
            {

                /** Habilito os botões da Tela */
                EnableButtons();

                /** Removo classe em todas as tags determinadas */
                RemoveClassInList('a', 'disabled-link');

            }

        }

    }

    /** Tratamento da resposta */
    success(response)
    {

        /** Verifico se existe código de retorno */
        if (response !== null && response !== undefined)
        {

            /** Verifico se devo colocar Loader em algum lugar */
            if (this._options.loader)
            {

                //Defino para remover o loader
                this._options.loader.create = false;

                /** Realizo a construção do loader */
                this._loader.destroy();

            }

            /** Legendas
             * 0 -> erro Capturado
             * 100 -> Redirecionamento de Página
             * 202 -> Login
             * 201 -> Html em Modal
             * 403 -> Forbidden -> Usuário não autenticado/sem permissão
             * 733  -> Pdf -> Visualização do PDF em popup
             */
            /** Verifico o código da resposta */
            switch (parseInt(response.code)) {

                /** Erro na operação */
                case 0:

                    /** Verifico se devo redirecionar a página */
                    if (response.create)
                    {

                        /** Notificação de erro */
                        modalConstruct(true, response.title, response.data, response.size, response.color_modal, response.color_border, response.type, response.procedure, response.tipe);

                    }

                    /** Verifico se devo redirecionar a página */
                    if (response.toast)
                    {

                        /** Verifico se devo exibir o Toast */
                        ToastConstruct({create: response.toast.create, background: response.toast.background, text: response.toast.data});

                    }
                    break;

                /** Essa resposta provisória indica que tudo ocorreu bem até agora e que o cliente deve continuar com a requisição ou ignorar se já concluiu o que gostaria. */
                case 100:

                    /** Verifico se existe um alvo a ser preenchido, senão houver, preencho no alvo padrão */
                    this._options.target ? this.putHtml(this._options.target, response.data) : this.putHtml('wrapper', response.data);
                    break;

                /** Estas requisição foi bem sucedida. O significado do sucesso varia de acordo com o método HTTP: */
                case 200:

                    /** Verifico se devo redirecionar a página */
                    if (response.redirect)
                    {

                        /** Percorro a lista de requisições a serem executadas */
                        for (let i = 0; i < response.redirect.length; i++) {

                            /** Envio de requisição */
                            SendRequest(response.redirect[i].url, {target : response.redirect[i].target});

                        }

                    }

                    /** Verifico se devo realizar funções JavaScript */
                    if (response.procedure)
                    {

                        /** Percorro a lista de funções JavaScript a serem executadas */
                        for (let i = 0; i < response.procedure.length; i++) {

                            /** Realizo as funções JavaScript */
                            window[response.procedure[i].name](response.procedure[i].options);

                        }

                    }

                    /** Verifico se devo redirecionar a página */
                    if (response.toast)
                    {

                        /** Verifico se devo exibir o Toast */
                        ToastConstruct({create: response.toast.create, background: response.toast.background, text: response.toast.data});

                    }
                    break;

                /** Code 201 created/popup/form */
                case 201:

                    /** Remoção de Modal Anterior */
                    modalConstruct(false);

                    /** Carrego o conteúdo **/
                    modalConstruct(true, response.title, response.data, response.size, response.color_modal, response.color_border, response.type, response.procedure, response.time);
                    break;

                /** Code 201 created/popup/form */
                case 202:

                    /** Redirecionamento de url */
                    window.location.href = response.url;
                    break;

                /** Exibição de pdf */
                case 203:

                    /** Remoção de Modal Anterior */
                    modalConstruct(false);

                    /** Carrego o conteúdo **/
                    modalConstruct(true, response.title, response.data, response.size, response.color_modal, response.color_border, response.type, response.procedure, response.time, response.document);
                    break;

            }

        }

    }

    /** Operações para quando ocorrer erro */
    error(error)
    {

        /** Notificação de erro */
        modalConstruct(true, 'Atenção', error, 'lg', null, null, 'error', null, null);

    }

}