<?php
$idPedido=CrudProductos::obtenerUltimo("pedidos");
$idP = (int)$idPedido["id"]+1;
$_SESSION["idPedido"]=$idP;
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="padding: 40px;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3 class="card-title" style="display: inline-block;">Pedidos a proveedor</h3>
                        </div>
                        <a href=<?php echo "index.php?action=pedido&idPedido=".$_SESSION["idPedido"];?>><button type="button" class="btn btn-success" style="color: white;">
                                Nuevo pedido &nbsp&nbsp<i class="right fa fa-plus"></i></button></a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped"  name="datos">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Total pedido</th>
                            <th>Id proveedor</th>
                            <th>Fecha pedido</th>
                            <th>Fecha entrega</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $vistaVentas = new ProductosController();
                        $vistaVentas -> vistaPedidosController();
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
</section>
</div>