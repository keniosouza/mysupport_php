<?php

/** Importação de classes */
use vendor\model\Products;

/** Instânciamento de classes */
$Products = new Products();

/** Consulta os usuário cadastrados*/
$ProductsResult = $Products->All();?>

<div class="p-3 shadow-sm border-bottom bg-glass sticky-top">

    <div class="btn-group btn-sm w-100" role="group" aria-label="Basic example">

        <button type="button" id="ProductFormButton" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_FORM', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'ProductFormButton', data : 'Aguarde...'}});">

            <i class="bi bi-plus me-1"></i>Produto

        </button>

    </div>

</div>

<?php

/** Consulta os usuário cadastrados*/
foreach ($ProductsResult as $key => $product) {?>

    <div id="ProductId<?php echo $key?>" class="px-2 py-3 chat-item" onclick="BeforeSendRequest<?php echo $key?>()">

        <h5 class="mb-1 text-break d-flex align-items-center">

            #<?php echo $product->products_id; ?> - <?php echo $product->name; ?>

        </h5>

    </div>

    <script type="text/javascript">

        /** Procedimentos para serem realizados antes da requisição */
        function BeforeSendRequest<?php echo $key?>()
        {

            /** Executo a função quando a página for carregada */
            RemoveAndAddClass('ProductId<?php echo $key?>');

            function RemoveAndAddClass(target) {

                /** Obtenho a div que possui os itens */
                var wrapper = document.getElementById("ProdcutsDatagrid");

                /** Busco os itens existentes dentro do objeto encapsulador */
                var itens = wrapper.getElementsByClassName("chat-item-active");

                /** Percorro todos o itens localizados */
                for (var i = 0; i < itens.length; i++) {

                    /** Removo a classe desejada */
                    itens[i].classList.remove("chat-item-active");

                }

                /** Obtenho o item desejado */
                var item = document.getElementById(target);

                /** Adiciono a classe desejada */
                item.classList.toggle("chat-item-active");

            }

            /** Envio de requisição */
            SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID_COL_2&products_id=<?php echo $product->products_id?>', {target : 'ProdcutsDatagridItem', loader : {create: true, padding: '5px', type: 2, target : 'ProdcutsDatagridItem', data : 'Aguarde...'}});

        }

    </script>

<?php } ?>
