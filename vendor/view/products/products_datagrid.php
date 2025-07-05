<div class="rounded border shadow-sm bg-white animate slideIn p-0">

    <div class="row g-0">

        <div class="col-md border-end custom-scrollbar" id="ProdcutsDatagrid" style="min-height: 600px; max-height: 600px">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID_COL_1', {target : 'ProdcutsDatagrid', loader : {create: true, padding: '5px', type: 2, target : 'ProdcutsDatagrid', data : 'Aguarde...'}});

            </script>

        </div>

        <div class="col-md-9 border-end custom-scrollbar p-3 bg-light" id="ProdcutsDatagridItem" style="min-height: 600px; max-height: 600px"></div>

    </div>

</div>