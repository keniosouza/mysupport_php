/** Classe Desejad */
class CustomEventListener {

    /** Método construtor */
    constructor(data) {

        /** Parâmetros da classe */
        this._data = data;

        /** Verificação de operação */
        if (this._data)
        {

            /** Crio o evento desejado */
            this.create()

        }

    }

    /** Criação do Modal */
    create() {

        /** Converto os dados para objeto */
        var _data = JSON.parse(this._data);

        /** Obtém o elemento HTML com base no atributo personalizado especificado */
        var element = GetCustomAttribute('target', _data.target);

        /** Adiciona um ouvinte de eventos para o evento blur */
        element.addEventListener(_data.event, function() {

            /** Obtenho o conteúdo */
            var value = element.innerHTML.trim();

            /** Removo as tags html */
            value = value.replace(/<[^>]*>/g, '');

            /** Obtenho o tamanho total do valor */
            var length = parseInt(element.dataset.mysupportLength)

            /** Verifico se os valores foram alterados */
            if (length !== value.length)
            {

                /** Verifico se existe o formulário para envio de requisição */
                if (element.dataset.mysupportForm)
                {

                    /** Verifico se devo adicionar um campo hidden */
                    if (element.dataset.mysupportName)
                    {

                        /** Defino os dados para serem criados */
                        var hidden = {

                            name : element.dataset.mysupportName,
                            value : value,
                            target : element.dataset.mysupportForm

                        };

                        /** Adiciono um campo dinamicamente */
                        AddInputHidden(JSON.stringify(hidden));

                    }

                    /** Envio de requisição */
                    SendRequest(element.dataset.mysupportForm, {target : null})

                    /** Atualizo o tamanho do campo */;
                    element.dataset.mysupportLength = value.length;

                }

            }

        });

    }

}