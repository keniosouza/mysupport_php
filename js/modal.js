var modalId = null;

class Modal {

    /** Método construtor */
    constructor(create, title, data, size, color_modal, color_border, type, procedure, time, document) {

        /** Parâmetros da classe */
        this._create = create;
        this._title = title;
        this._data = data;
        this._size = size;
        this._color_modal = color_modal;
        this._color_border = color_border;
        this._type = type;
        this._procedure = procedure;
        this._time = time;
        this._document = document;

        /** Verificação de operação */
        this._create ? this.create() : this.destroy();

    }

    /** Defino a cor do Modal */
    setColorModal(color_modal) {

        /** Temas disponíveis */
        const availableThemes = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];

        /** Verificação de informação */
        switch (color_modal) {

            /** Defino um valor aleatório */
            case 'random':
                color_modal = 'bg-' + shuffle(availableThemes)[0];
                break;

            /** Defino um valor próprio */
            case color_modal !== null:
                color_modal = 'bg-' + color_modal;
                break;

            /** Defino um valor padrão */
            default:
                color_modal = 'bg-light';
                break;
        }

        /** Retorno da informação */
        return color_modal;
    }


    /** Defino a cor da borda do Modal */
    setColorBorder(color_border) {

        /** Temas disponíveis */
        const availableThemes = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];

        /** Verificação de informação */
        switch (color_border) {

            /** Defino um valor aleatório */
            case 'random':
                color_border = 'border-' + shuffle(availableThemes)[0];
                break;

            /** Defino um valor próprio */
            case color_border !== null:
                color_border = 'border-' + color_border;
                break;

            /** Defino um valor padrão */
            default:
                color_border = 'border-light';
                break;
        }

        /** Retorno da informação */
        return color_border;

    }

    /** Define o tipo do Modal */
    setType(type) {

        /** Verifica se está preenchido */
        return type !== null ? 'image/default/' + type + '.png' : null;

    }

    /** Define o tamanho do modal */
    setSize(size) {

        /** Retorna o valor do Modal ou null se não estiver preenchido */
        return size !== null ? 'modal-' + size : null;

    }

    /** Criação do Modal */
    create() {

        /** Montagem do ID */
        const modalId = 'modal_' + Math.floor(Math.random() * 100) + 1;

        /** Montagem da estrutura HTML */
        const html = `<div class="modal fade" id="${modalId}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable ${this.setSize(this._size)}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    ${this._title !== '' ? '<h4 class="modal-title text-center"><b>' + this._title + '</b></h4>' : ''} 
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-break">
                                    ${this._document ? `
                                        <div class="card">
                                            <div class="card-body">
                                                <iframe src="${this._document}" data-bs-title="Iframe Example" class="w-100" height=500px></iframe>
                                            </div>
                                        </div>
                                    ` : `
                                        ${this.setType(this._type) !== null ? `
                                            <div class="text-center mb-2">
                                                <img class="img-fluid" src="${this.setType(this._type)}" width="60px" />
                                            </div>
                                        ` : ''}
                                        <div>${this._data}</div>
                                    `}
                                </div>
                                ${this._procedure ? `
                                    <div class="modal-footer flex-column border-top-0">
                                        <button type="button" class="btn btn-lg btn-outline-danger w-100 mx-0" data-bs-dismiss="modal"><i class="bi bi-x me-1"></i>Fechar</button>
                                        <button type="button" class="btn btn-lg btn-primary w-100 mx-0 mb-2" data-bs-dismiss="modal" onclick="${this._procedure}" id="btnModalPage"><i class="bi bi-check me-1"></i>Continuar</button>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>`;

        // Obtenha uma referência ao elemento DOM com o ID 'wrapper-modal'
        var wrapperModal = document.getElementById('wrapper-modal');

        // Verifique se o elemento foi encontrado
        if (wrapperModal) {

            // Use um loop while para remover todos os filhos do elemento (limpar o conteúdo da div)
            while (wrapperModal.firstChild) {

                wrapperModal.removeChild(wrapperModal.firstChild);

            }

        }

        // Verifique se o elemento foi encontrado
        if (wrapperModal) {

            // Utilize o método innerHTML para definir o conteúdo HTML da div
            // O conteúdo é definido com base no valor da variável 'html'

            // wrapperModal.innerHTML = html;

            /** Preenchimento da div desejada **/
            $('#wrapper-modal').html(html);

        }

        /** Exibição do Modal */
        $('#' + modalId).modal('show');

        // Verifica se o tempo de execução foi definido e é maior que zero
        if (parseInt(this._time) > 0) {

            // Define um tempo de execução e realiza a remoção do MODAL após o tempo especificado
            window.setTimeout(() => modalConstruct(false), this._time);

        }

    }

    /** Remoção do Modal */
    destroy() {

        /** Remoção do Modal */
        $('#' + modalId).modal('hide');
        // $('div').remove('.modal-backdrop');

    }

}

/** Consturção do Modal Desejado */
function modalConstruct(create, title, data, size, color_modal, color_border, type, procedure, time, document) {

    /** Instânciamento do Modal */
    new Modal(create, title, data, size, color_modal, color_border, type, procedure, time, document);

}