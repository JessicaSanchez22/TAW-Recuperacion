<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="padding: 40px;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3 class="card-title" style="display: inline-block;">Detalle del pedido</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codigo Producto</th>
                            <th>Nombre producto</th>
                            <th>Cantidad</th>
                            <th>Precio compra</th>
                            <th>Precio venta</th>
                            <th>Margen</th>
                            <th>Id proveedor</th>
                            <th>Fecha pedido</th>
                            <th>Fecha de entrega</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $vistaDetalle = new ProductosController();
                        $vistaDetalle -> detallePedidoController();
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
</div>
</section>
</div>