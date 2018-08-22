<?php $compra = new ProductosController();
$idCompra=CrudProductos::obtenerIdCompra();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="padding: 40px;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3 class="card-title" style="display: inline-block;">Registrar nueva compra</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Producto:</label>
                                <select name="producto" class="form-control select2" style="width: 50%;">
                                    <?php
                                    $compra -> obtenerProductosController();
                                    ?>
                                </select>
                                <a href="index.php?action=registro"><button type="button" class="btn btn-success" style="color: white;">
                                        Agregar producto &nbsp&nbsp<i class="right fa fa-plus"></i></button></a>
                            </div>
                            <div class="col-md-12">
                                <label>Precio de venta: </label><br/>
                                <input type="number" name="precioVenta" style="width: 50%;">
                            </div>
                            <div class="col-md-12">
                                <label>Cantidad: </label><br/>
                                <input type="number" name="cantidad" style="width: 50%;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Proveedor:</label>
                            <select name="proveedor" class="form-control select2" style="width: 50%;">
                                <?php
                                $compra -> obtenerProveedoresController();
                                ?>
                            </select>
                            <button type='submit' class='btn btn-primary' name="agregarP">Agregar producto</button>
                        </div>
                        <?php
                        $compra->registrarProductoCompraController();
                        ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <td>Id compra</td>
                                <td>Id producto</td>
                                <td>Codigo producto</td>
                                <td>Nombre Producto</td>
                                <td>Cantidad</td>
                                <td>Precio compra</td>
                                <td>Precio venta</td>
                                <td>Margen</td>
                                <td>Proveedor</td>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $compra->vistaProdCompraController();
                            ?>
                            </tbody>
                        </table>
                </div>
            </div>
            <button type="submit" class="btn btn-success" style="width: 150px;" name="guardarCompra">Registrar compra</button>                                       <!-- /.card-body -->
            </form>
            <?php
            $compra->registrarCompraController();
            ?>
        </div>
</div>
</section>
