/** Classe Desejad */
class Loader {

    /** Método construtor */
    constructor(options) {

        /** Parâmetros da classe */
        this._options = options;
        this._loader = null;

    }

    /** Criação do Modal */
    create() {

        this._loader = gerarNumeroAleatorioInclusivo(1,10);
        var LoaderHtml = null;

        // Obtenha uma referência ao elemento DOM com o ID 'wrapper-modal'
        var element = document.getElementById(this._options.target);

        /**
         * Montagem da estrutura HTML para exibição do loader.
         * O loader é composto por um spinner e o conteúdo dinâmico definido em this._options.data.
         */
        switch (this._options.type){

            case 1:

                LoaderHtml = `<span id="${this._loader}" class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">${this._options.data}</span>`;
                break;

            case 2:

                LoaderHtml = `<p class="card-text placeholder-wave" style="padding:${this._options.padding}">
                                  <span class="placeholder col-7"></span>
                                  <span class="placeholder col-4"></span>
                                  <span class="placeholder col-4"></span>
                                  <span class="placeholder col-6"></span>
                                  <span class="placeholder col-8"></span>
                                </p>`;
                break;

            case 3:

                /**
                 * Montagem da estrutura HTML para exibição do loader.
                 * O loader é composto por um spinner e o conteúdo dinâmico definido em this._options.data.
                 */
                LoaderHtml = `<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">${this._options.data}</span>`;

                /**
                 * Guarda o valor antigo do conteúdo do elemento.
                 * Isso é feito para poder restaurar o conteúdo original após a remoção do loader.
                 * O conteúdo original é armazenado em um elemento oculto com o ID igual ao alvo do loader mais 'Bkp'.
                 */
                LoaderHtml += `<span id="${this._options.target}Bkp" class="display-none">${element.innerHTML.trim()}</span>`;
                break;

            default:

                LoaderHtml = `<span id="${this._loader}" class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">${this._options.data}</span>`;
                break;

        }

        // Verifica se o elemento com o ID armazenado em this._options.target foi encontrado
        if (element) {

            // Define o conteúdo HTML da div como o LoaderHtml, exibindo assim o loader na interface do usuário
            element.innerHTML = LoaderHtml;

        }

    }

    /** Remoção do loader */
    destroy()
    {

        //Verifico se o tipo de visualização deve recuperar a informação anterior
        if (this._options.type === 3)
        {

            // Seleciona o elemento com o ID 'targetBkp' concatenado com 'Bkp' e armazena-o em elementBkp.
            var elementBkp = document.getElementById(this._options.target + 'Bkp');

            // Seleciona o elemento com o ID armazenado em this._options.target e armazena-o em element.
            var element = document.getElementById(this._options.target);

            // Define o conteúdo HTML do elemento element como o conteúdo HTML do elemento elementBkp, removendo espaços em branco do início e do final.
            element.innerHTML = elementBkp.innerHTML.trim();

        }
        else
        {

            // Busco o laoder Criado
            let loader = document.getElementById(this._loader);

            //Verifico se existe loader para remover
            if (loader)
            {

                // Removo o elemento desejado
                loader.remove();

            }

        }

    }

}