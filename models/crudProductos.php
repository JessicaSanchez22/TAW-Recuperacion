<?php
	require_once("conexion.php");

	class CrudProductos extends Conexion
    {

        public static function registrarProductoModel($table, $datos)
        { //Funcion que registra los producto en la base de datos
            $statement = Conexion::conectar()->prepare("INSERT INTO $table(codigo_producto, nombre, precio_producto, cantidad_stock, id_categoria) 
                                                        VALUES (:codigo,:nombre,:precio,:stock, :categoria)");
            //toma los datos que el controller le pasa como parámetros y los manda a la tabla por medio del archivo de conexion.
            $statement->bindParam(":codigo", $datos["codigo_producto"], PDO::PARAM_STR);
            $statement->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $statement->bindParam(":precio", $datos["precio_producto"], PDO::PARAM_INT);
            $statement->bindParam(":stock", $datos["cantidad_stock"], PDO::PARAM_INT);
            $statement->bindParam(":categoria", $datos["categoria"], PDO::PARAM_INT);
            
            if ($statement->execute()) { //Si la consulta se ejecuto,
                //la funcion devuelve un true o de o contrario, devuelve un false.
                return true;
            } else {
                return false;
            }
        }

        /*public static function editarProductoModel($datos, $table){
            //Funcion del modelo que srive para rellenar los datos que el usuario va a editar en la vista
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id = :id");
            $statement->bindParam(":id", $datos, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch();
        }

        public static function actualizarProductoModel($datos, $table){
            $idC = CrudProductos::obtenerIdCategoriaModel("categoria", $datos["nombre_categoria"]);
            $stmt = Conexion::conectar()->prepare("UPDATE $table SET codigo_producto=:codigo, nombre = :nombre,
            date_added = :date_added, precio_producto = :precio, cantidad_stock = :stock, id_categoria=:categoria WHERE id = :id");

            $stmt->bindParam(":codigo", $datos["codigo_producto"], PDO::PARAM_STR);
            $stmt->bindParam(":date_added", $datos["date_added"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":precio", $datos["precio_producto"], PDO::PARAM_STR);
            $stmt->bindParam(":stock", $datos["cantidad_stock"], PDO::PARAM_STR);
            $stmt->bindParam(":categoria", $idC["id"], PDO::PARAM_STR);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

            if ($stmt->execute()) {

                return "success";

            } else {

                return "error";

            }
        }*/


        public static function registrarClienteModel($table, $datos)
        {//Funcion que registra un cliente en la base de datos
            $statement = Conexion::conectar()->prepare(
                    "INSERT INTO $table(nombre,apellido,email,direccion,telefono) 
                                VALUES (:nombre,:apellido,:email,:direccion,:telefono)");
            //Se pasan los componentes del array asociativo para que se registren en la tabla de clientes
            $statement->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $statement->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
            $statement->bindParam(":email", $datos["email"], PDO::PARAM_STR);
            $statement->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $statement->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);

            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }

        /*public static function registrarCategoriaModel($table, $datos)
        {
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(nombre_categoria,descripcion_categoria,date_added) 
                                VALUES (:nombre,:descripcion,:date_add)");
            $statement->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $statement->bindParam(":date_add", $datos["date"], PDO::PARAM_STR);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }*/

        public static function obtenerStockModel($idP)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM productos WHERE id = :id");
            $statement->bindParam(":id", $idP, PDO::PARAM_STR);
            $statement->execute();
            #fetch(): Obtiene una fila de un conjunto de resultados asociado al objeto PDOStatement.
            return $statement->fetch();
        }


        public static function agregarStockModel($table, $stock, $idP)
        { //Esta funcion se encarga de incremenetar el stock de un producto, segun la tabla en la que se encuentra
            //Los tres parametros que recibe son: la tabla donde se encuentra, el stock que se le va a agregar, y el id del producto al que
            //se le va a agregar dicho stock
            $currentStock = self::obtenerStockModel($idP); //Se obtiene el stock correspondiente que tiene en ese entonces
            $newStock = (int)$stock + (int)$currentStock["cantidad_stock"]; //Se hace el agregadi del stock

            //SE actualiza la tabla para que el stock cambie
            $statement = Conexion::conectar()->prepare("UPDATE $table SET cantidad_stock = :newStock WHERE id = :id");
            $statement->bindParam(":id", $idP, PDO::PARAM_STR);
            $statement->bindParam(":newStock", $newStock, PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }


        public static function eliminarStockModel($table, $stock, $idP)
        {
            //Se obtiene el stock que tiene en ese entonces el producto
            $currentStock = self::obtenerStockModel($idP);
            $newStock = (int)$currentStock["cantidad_stock"] - (int)$stock; //Se decrementa el stock, segun el que se obtuvo como parametro
            $statement = Conexion::conectar()->prepare("UPDATE $table SET cantidad_stock = :newStock WHERE id = :id");
            //Y se actualiza en la tabla para que el producto pierda stock.
            $statement->bindParam(":id", $idP, PDO::PARAM_STR);
            $statement->bindParam(":newStock", $newStock, PDO::PARAM_STR);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public static function obtenerProdPorNombre($table, $nombre)
        {
            //Esta funcion obtiene todos los datos de un producto, al recibir el nombre del producto que se desea buscar.
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE nombre = :nom");
            $statement->bindParam(":nom", $nombre, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetch();
        }

         public static function vistaClientesModel($table)
        {
            //Funcion que muestra todas los registros de la tabla clientes
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table");
            $statement->execute();

            return $statement->fetchAll();
        }


        public static function vistaCategoriasModel($table)
        {
            //Funcion que muestra todas los registros de la tabla categoria
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table");
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function vistaProductosModel($table)
        {
            //Funcion que muestra todas los registros de la tabla productos
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table");
            $statement->execute();

            return $statement->fetchAll();
        }


        public static function obtenerCategoriaModel($table, $id)
        {
            //Funcion que obtiene las cateogorias segun el id que le es proporcionado como parametro
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();
        }

        public static function obtenerIdCategoriaModel($table, $nombreCategoria)
        {
            //Se obtiene el id de la categoria que se esta buscando a traves del nombre
            //el cual es proporcionado por el controlador.
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $table WHERE nombre = :nombre");
            $stmt->bindParam(":nombre", $nombreCategoria, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        }

        public static function obtenerIdClienteModel($table, $nombreCliente)
        {
            //SE btiene el id del cliente a traves del nombre del cliente
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $table WHERE nombre = :nombre");
            $stmt->bindParam(":nombre", $nombreCliente, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        }


        public static function editarClienteModel($datos, $table)
        {
            //Funcion que trae todos los datos del cliente para que se puedan editar y actualizar posteriormente.
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id = :id");
            $statement->bindParam(":id", $datos, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch();
        }

        public static function actualizarClienteModel($datos, $table)
        {
            //Funcion que actualiza el cliente segun los datos que le son proporcionados por el controlador
            //y que el usuario ingreso a traves del formulario
            $stmt = Conexion::conectar()->prepare("UPDATE $table SET nombre = :nombre, apellido = :apellido, direccion = :direccion, email = :email, telefono=:telefono WHERE id = :id");
            //Se hace el update en la tabla para que se pueda actualizar el registro.
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
            $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
        }


        /*public static function borrarProductoModel($id, $tabla)
        {

            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
        }*/

         public static function borrarClienteModel($id, $tabla)
        {
            //Funcion que permite borrar un cliente de la tabla que se le pasa como parametro (que por obviedad, es la tabla clientes)
            //Se ejecuta la consulta de DELETE FROM para que se borre el registro y se retorna un success o un error.
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
        }

       /* public static function editarCategoriaModel($datos, $table)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id = :id");
            $statement->bindParam(":id", $datos, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch();
        }


        public static function actualizarCategoriaModel($datos, $table)
        {
            $stmt = Conexion::conectar()->prepare("UPDATE $table SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":id", $datos["id_categoria"], PDO::PARAM_INT);

            if ($stmt->execute()) {

                return "success";

            } else {

                return "error";

            }
        }

        public static function vistaTiendasModel($table)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table");

            $statement->execute();

            return $statement->fetchAll();
        }*/

        #####################   VENTAS  ############################################
        public static function borrarVentaModel($id, $tabla)
        {
            //Funcion que permite borrar una ventade la tabla que se le pasa como parametro (que por obviedad, es la tabla ventas)
            //Se ejecuta la consulta de DELETE FROM para que se borre el registro y se retorna un success o un error.
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
        }

        public static function vistaVentasModel($table)
        {
            //Funcion que se encarga de obtener todos los datos de la tabla que se le pasa como parametro
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table");
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function detalleVentaModel($id, $table)
        {
            //Funcion que obtiene todo de la tabla donde el id que se le pasa como parametro correponde al id de la venta
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id_venta=:id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();
        }


        public static function registrarVentaModel($table, $datos)
        {
            //Funcion que registra una venta nueva, donde se pasa a la tabla el id del cliente y el total de
            //precio de los articulos que fueron comprados por el cliente
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(total_venta, id_cliente) 
                                VALUES (:total, :idCliente)");
            $statement->bindParam(":total", $datos["total_venta"], PDO::PARAM_STR);
            $statement->bindParam(":idCliente", $datos["cliente"], PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public static function registrarProductoVModel($table, $datos)
        { //Funcion que sirva para registrar un producto a la vez en la vista de ventas, agregarlos al "carrito".
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(id_venta, id_producto,nombre_producto,codigo_producto, cantidad, total) 
                                VALUES (:idV,:idP,:nomP,:codP, :cant, :total)");
            $statement->bindParam(":idV", $datos["id_venta"], PDO::PARAM_INT);
            $statement->bindParam(":idP", $datos["id_producto"], PDO::PARAM_INT);
            $statement->bindParam(":nomP", $datos["nombre_producto"], PDO::PARAM_STR);
            $statement->bindParam(":codP", $datos["codigo_producto"], PDO::PARAM_STR);
            $statement->bindParam(":cant", $datos["cantidad"], PDO::PARAM_INT);
             $statement->bindParam(":total", $datos["total"], PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public static function vistaProdVModel($table)
        {
            //Esta funcion crea una vista de los productos que han sido agregados al carrito
            //y los obtiene por medio del id de la venta a la que corresponden.
            $idVenta=self::obtenerIdVenta();
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id_venta = :idVenta");
            $statement->bindParam(":idVenta", $idVenta["id"], PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function sumarTotal($table)
        {
            
            $idVenta=self::obtenerIdVenta();
            $statement = Conexion::conectar()->prepare("SELECT sum(total) as total FROM $table WHERE id_venta=:idVenta");
            $statement->bindParam(":idVenta", $idVenta["id"], PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch();
        }

        public static function obtenerIdVenta(){
            $statement= Conexion::conectar()->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1");
            $statement->execute();

            return $statement->fetch();

        }

        ######## COMPRAS ########
        public static function vistaModel($table)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table");
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function detalleCompraModel($id, $table)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id=:id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function registrarCompraModel($table, $datos)
        {
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(total_compra, id_proveedor) 
                                VALUES (:total, :idP)");
            $statement->bindParam(":total", $datos["total_compra"], PDO::PARAM_STR);
            $statement->bindParam(":idP", $datos["proveedor"], PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public static function registrarProductoCompraModel($table, $datos)
        {
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(id,id_producto,nombre_producto,codigo_producto, cantidad, precio_compra, precio_venta, margen, id_proveedor) 
                                VALUES (:id,:idP,:nomP,:codP, :cant, :total, :totalVenta, :ganancia, :id_proveedor)");
            $statement->bindParam(":id", $datos["id_compra"], PDO::PARAM_INT);
            $statement->bindParam(":idP", $datos["id_producto"], PDO::PARAM_INT);
            $statement->bindParam(":nomP", $datos["nombre_producto"], PDO::PARAM_STR);
            $statement->bindParam(":codP", $datos["codigo_producto"], PDO::PARAM_INT);
            $statement->bindParam(":cant", $datos["cantidad"], PDO::PARAM_INT);
            $statement->bindParam(":total", $datos["totalCompra"], PDO::PARAM_INT);
            $statement->bindParam(":totalVenta", $datos["totalVenta"], PDO::PARAM_INT);
            $statement->bindParam(":ganancia", $datos["ganancia"], PDO::PARAM_INT);
            $statement->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public static function vistaProdCompraModel($table)
        {
            $idCompra=self::obtenerIdCompra();
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id = :id");
            $statement->bindParam(":id", $idCompra["id"], PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function sumarTotalCompra($table)
        {
            $idCompra=self::obtenerIdCompra();
            $statement = Conexion::conectar()->prepare("SELECT sum(precio_compra) as total FROM $table WHERE id=:id");
            $statement->bindParam(":id", $idCompra["id"], PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch();
        }

        public static function obtenerIdCompra(){
            $statement= Conexion::conectar()->prepare("SELECT id FROM compras ORDER BY id DESC LIMIT 1");
            $statement->execute();

            return $statement->fetch();

        }

        /*public static function totalProductos(){
            $statement=Conexion::conectar()->prepare("SELECT count(*) as totalP FROM productos");
            $statement->execute();

            return $statement->fetch();
        }

        public static function totalVentas(){
            $statement=Conexion::conectar()->prepare("SELECT count(*) as totalV FROM ventas");
            $statement->execute();

            return $statement->fetch();
        }

        public static function totalUsuarios(){
            $statement=Conexion::conectar()->prepare("SELECT count(*) as totalU FROM users");
            $statement->execute();

            return $statement->fetch();
        }*/

        ################# PEDIDOS ###############
        public static function registrarProductoPedidoModel($table, $datos)
        {
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(id,nombre_producto,codigo_producto, cantidad, precio_compra, precio_venta, margen, id_proveedor,
                                    fecha_pedido, fecha_entrega) 
                                VALUES (:id,:nomP,:codP, :cant, :total, :totalVenta, :ganancia, :id_proveedor, :fecha_pedido, :fecha_entrega)");
            $statement->bindParam(":id", $datos["id_pedido"], PDO::PARAM_INT);
            $statement->bindParam(":nomP", $datos["nombre_producto"], PDO::PARAM_STR);
            $statement->bindParam(":codP", $datos["codigo_producto"], PDO::PARAM_INT);
            $statement->bindParam(":cant", $datos["cantidad"], PDO::PARAM_INT);
            $statement->bindParam(":total", $datos["totalCompra"], PDO::PARAM_INT);
            $statement->bindParam(":totalVenta", $datos["totalVenta"], PDO::PARAM_INT);
            $statement->bindParam(":ganancia", $datos["ganancia"], PDO::PARAM_INT);
            $statement->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
            $statement->bindParam(":fecha_pedido", $datos["fecha_pedido"], PDO::PARAM_STR);
            $statement->bindParam(":fecha_entrega", $datos["fecha_entrega"], PDO::PARAM_STR);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public static function vistaProdPedidoModel($table, $idP)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id = :id");
            $statement->bindParam(":id", $idP, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function detallePedidoModel($id, $table)
        {
            $statement = Conexion::conectar()->prepare("SELECT * FROM $table WHERE id=:id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function registrarPedidoModel($table, $datos)
        {
            $statement = Conexion::conectar()->prepare(
                "INSERT INTO $table(fecha_pedido, fecha_entrega, total_pedido, id_proveedor) 
                                VALUES (:fP, :fE, :total, :idP)");
            $statement->bindParam(":fP", $datos["fecha_pedido"], PDO::PARAM_STR);
            $statement->bindParam(":fE", $datos["fecha_entrega"], PDO::PARAM_STR);
            $statement->bindParam(":total", $datos["total_pedido"], PDO::PARAM_STR);
            $statement->bindParam(":idP", $datos["proveedor"], PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public static function sumarTotalPedido($table, $idP)
        {
            $statement = Conexion::conectar()->prepare("SELECT sum(precio_compra) as total FROM $table WHERE id=:id");
            $statement->bindParam(":id",  $idP, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch();
        }

        public static function obtenerUltimo($table){
            $statement= Conexion::conectar()->prepare("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
            $statement->execute();

            return $statement->fetch();
        }
    }
?>