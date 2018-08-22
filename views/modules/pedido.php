<?php $pedido = new ProductosController();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="padding: 40px;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3 class="card-title" style="display: inline-block;">Registrar nuevo pedido a proveedor</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Producto:</label>
                                <select name="producto" class="form-control select2" style="width: 50%;" required>
                                    <?php
                                    $pedido -> obtenerProductosController();
                                    ?>
                                </select>
                                <a href="index.php?action=registro"><button type="button" class="btn btn-success" style="color: white;">
                                        Agregar producto nuevo &nbsp&nbsp<i class="right fa fa-plus"></i></button></a>
                            </div>
                            <div class="col-md-12">
                                <label>Precio de venta: </label><br/>
                                <input type="number" name="precioVenta" style="width: 50%;" required>
                            </div>
                            <div class="col-md-12">
                                <label>Cantidad: </label><br/>
                                <input type="number" name="cantidad" style="width: 50%;" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Proveedor:</label>
                            <select name="proveedor" class="form-control select2" style="width: 50%;" required>
                                <?php
                                $pedido-> obtenerProveedoresController();
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Fecha del pedido: </label><br/>
                            <input type="date" name="fechaPedido" style="width: 50%;" required>
                        </div>
                        <div class="col-md-12">
                            <label>Fecha de entrega: </label><br/>
                            <input type="date" name="fechaEntrega" style="width: 50%;" required>
                        </div>
                        <button type='submit' class='btn btn-primary' name="agregarPedido">Agregar producto</button>
                    </form>
                        <?php
                        $pedido->registrarProductoPedidoController();
                        ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <td>Id pedido</td>
                                <td>Codigo producto</td>
                                <td>Nombre Producto</td>
                                <td>Cantidad</td>
                                <td>Precio compra</td>
                                <td>Precio venta</td>
                                <td>Margen</td>
                                <td>Proveedor</td>
                                <td>Fecha pedido</td>
                                <td>Fecha entrega</td>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $pedido->vistaProdPedidoController();
                            ?>
                            </tbody>
                        </table>
                </div>
            </div>
            <form method="post">
            <button type="submit" class="btn btn-success" style="width: 150px;" name="guardarPedido">Registrar pedido</button>                                       <!-- /.card-body -->
            </form>
            <?php
            $pedido->registrarPedidoController();
            ?>
        </div>
</div>
</section>
