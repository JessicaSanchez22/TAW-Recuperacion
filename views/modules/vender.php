<?php $vender = new ProductosController();
 $idCompra=CrudProductos::obtenerIdCompra();
$idCompra["id"]+=1; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="padding: 40px;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3 class="card-title" style="display: inline-block;">Registrar venta</h3>
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
                                            $vender -> obtenerProductosController();
                                            ?>
                                        </select>
                                        <a href="index.php?action=registro"><button type="button" class="btn btn-success" style="color: white;">
                                                Agregar producto &nbsp&nbsp<i class="right fa fa-plus"></i></button></a>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Cantidad: </label><br/>
                                        <input type="number" name="cantidad" style="width: 50%;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Cliente:</label>
                                    <select name="cliente" class="form-control select2" style="width: 50%;">
                                        <?php
                                        $vender -> obtenerClientesController();
                                        ?>
                                    </select>
                                    <button type='submit' class='btn btn-primary' name="agregarP">Agregar producto</button>
                                </div>
                            <?php //$registroV= new ProductosController();
                            $vender->registrarProductoVController();
                            ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <td>Id venta</td>
                                <td>Id producto</td>
                                <td>Codigo producto</td>
                                <td>Nombre Producto</td>
                                <td>Cantidad</td>
                            </tr>
                                
                            </thead>
                        <tbody>
                        <?php
                        $vender->vistaProdVController();
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                  <button type="submit" class="btn btn-success" style="width: 150px;" name="guardar">Registrar Venta</button>                                       <!-- /.card-body -->
             </form>
                <?php
                //$venta=new ProductosController();
                $vender->registrarVentaController();
                ?>
            </div>
        </div>
    </section>
