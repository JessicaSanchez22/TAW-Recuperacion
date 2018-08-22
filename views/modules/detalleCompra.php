<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="padding: 40px;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3 class="card-title" style="display: inline-block;">Detalle de la compra</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Id Producto</th>
                            <th>Codigo Producto</th>
                            <th>Nombre producto</th>
                            <th>Cantidad</th>
                            <th>Precio compra</th>
                            <th>Precio venta</th>
                            <th>Margen</th>
                            <th>Id proveedor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $vistaDetalle = new ProductosController();
                        $vistaDetalle -> detalleCompraController();
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