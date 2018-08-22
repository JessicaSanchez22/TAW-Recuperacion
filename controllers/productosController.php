<?php

	class ProductosController{
    
    #Se llama a la plantilla 
    #-----------------------

		public function pagina(){
            include "views/template.php";

		}

    #ENLACES
    #-------------------------------
		public function enlacesPaginasController(){

			if(isset($_GET['action'])){

				$enlaces = $_GET['action'];

			}else{
				$enlaces = "index";
			}

			$resp = Paginas::enlacesPaginasModel($enlaces);

			include $resp;
		}

  ####################    PRODUCTOS   ############################
        public static function vistaProductosController(){
            $respuesta = CrudProductos::vistaProductosModel("productos"); //Se llama al modelo que muestra la vista de la tabla de productos

            foreach($respuesta as $row => $item){
                $categoria = CrudProductos::obtenerCategoriaModel("categoria", $item["id_categoria"]); //Por cada registro que devuelva la consulta
                //Se mostrara su id, su codigo, nombre, precio, la cantidad que hay en el stock, y la categoría.

                echo'<tr>
                      <td>'.$item["id"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre"].'</td>
                      <td>'.$item["precio_producto"].'</td>
                      <td>'.$item["cantidad_stock"].'</td>
                      <td>'.$categoria["nombre"].'</td>
                      <td><a href="index.php?action=editarProducto&id='.$item["id"].'" data-tip="Editar"><button class="btn btn-info"><i class="right fa fa-edit"></i> Editar</button></a></td>
                      <td><a href="index.php?action=agregarStock&idProducto='.$item["id"].'"><button class="btn btn-default">Editar stock <i class="right fa  fa-plus"></i></button></a></td>
                      <td><a href="index.php?action=productos&idBorrar='.$item["id"].'" data-tip="Eliminar"><button class="btn btn-danger"><i class="right fa fa-trash"></i> Borrar</button></a></td>
               </tr>';

            }

            if (isset($_GET["idBorrar"])) { //Si se ha dado un id para borrar, el controller lo detecta y elimna el registro
                //que corresponde a ese id.
              $id = $_GET["idBorrar"];

              $respuesta2 = CrudProductos::borrarCategoriaModel($id,"productos"); //Se utiliza el mismo modelo ya que se configuran los parámetros
                //Y se borra el producto que existe con ese id, que tambien se pasa como parametro.

              if($respuesta2){ //Si la consulta de eliminar, se ha ejecutado con exito, entonces se le indica al usuario que el producto
                  //fue eliminado con exito.
                  echo "<script>swal({title: 'Producto eliminado', text: 'Éxito', type:'success'}, 
                  function (){
                    window.location.href = 'index.php?action=productos'
                  }); </script>";
              }

              else{
                  //Si la consulta no se pudo realizar por algun motivo, se le indica al usuario que ha ocurrido un error.
                  echo "<script>swal({title: 'El producto no ha sido eliminado', text: 'Ha ocurrido un error', type:'error'}); </script>";
              }
            }
        }

		public static function registrarProductoController()
        {
            if (isset($_POST['registrarProducto'])) { //Si el boton de registrar Producto, se presionó,
                $idCat = CrudProductos::obtenerIdCategoriaModel("categoria", $_POST["categoria"]); //entonces se le agrega una categoria al producto.

                $data = array("codigo_producto" => $_POST["codigo"], "nombre" => $_POST["nombre"], "precio_producto" => $_POST["precio"],
                    "cantidad_stock" => $_POST["stock"], "categoria" => $idCat["id"]);
                //Recibe a través del método post los campos a
                //registrar del producto, y se almacenan los datos en un array asociativo que será usado más adelante, por el modelo.

                //Se le dice al modelo que es lo que se va a agregar a la base de datos a través de la funcion registrarProductoModel
                $resp = CrudProductos::registrarProductoModel("productos", $data);

                if ($resp) {
                    //Si el producto se registro con exito, se le notifica al usuario
                    echo "<script>swal({title: 'Producto registrado con éxito', text: 'Éxtio', type:'success'}, 
            function (){
              window.location.href = 'index.php?action=inventario'
            }); </script>";
                } else {
                    //De lo contrario, se le dice al usuario que el producto no pudo ser registrado.
                    echo "<script>swal({title: 'Producto no registrado', text: 'Ha ocurrido un error', type:'error'}); </script>";
                }
            }
        }


        public static function editarProductoController(){ //La funcion sirve para editar el producto que ha sido seleccionado
		    //para editar.
          $datosController = $_GET["id"]; //Se obtiene el id del registro que se va a editar
        $respuesta = CrudProductos::editarProductoModel($datosController, "productos"); //Se llama al modelo que realiza
            //la consulta SQL que hace el update a la tabla.
        $categoria = CrudProductos::obtenerCategoriaModel("categoria", $respuesta["id_categoria"]); //Se le asigna una categoria al producto
            //Y se despliegan los datos en un formulario de html en el que el usuario puede modificar los datos que deseea.
            echo "<form method='post' role='form' name='productoEditar'>
                      <div class='box-body'>
                          <div class='form-group'>
                            <input type='hidden' value='".$respuesta["id"]."' name='idEditar'>

                              <label for='nombre'>Nombre</label>
                              <input type='text' name='nombreEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["nombre"]."'>
                          </div>
                          <div class='form-group'>
                              <label for='apellido'>Precio</label>
                              <input type='text' name='precioEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["precio_producto"]."'>
                          </div>
                          <div class='form-group'>
                              <label for='codigo'>Codigo</label>
                              <input type='text' name='codigoEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["codigo_producto"]."'>
                          </div>
                          <div class='form-group'>
                              <label for='usuario'>Stock</label>
                              <input type='text' name='stockEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["cantidad_stock"]."' required>
                          </div>
                          <div class='form-group'>
                              <label for='email'>Categoria</label>
                              <select name='categoria' class='form-control select2' style='width: 100%;'>";
                                    //Se manda llamar el controlador que muestra las categorias existentes para que el usuario elija la que desee.
                                    $categorias = new ProductosController();
                                    $categorias -> obtenerCategoriaController();
                                    
                               echo "</select>
                          </div>
      
                      </div>
                          <button type='submit' class='btn btn-primary' name='productoEditar'>Actualizar producto</button>
                  </form>";
		}
       

          public static function actualizarProductoController(){
            if(isset($_POST["productoEditar"])){ //Si el boton de editar es presionado
                //Se agregan los datos que el usuario introdujo en el formulario de edición, a un arreglo asociativo que será pasado al modelo
                //que ejecutará la consulta SQL para actualizar la tabla de productos.
              $datosController = array( "id"=>$_POST["idEditar"],
                                "precio_producto"=>$_POST["precioEditar"],
                                "nombre"=>$_POST["nombreEditar"],
                                      "cantidad_stock"=>$_POST["stockEditar"],
                                      "nombre_categoria"=>$_POST["categoria"],
                                      "codigo_producto"=>$_POST["codigoEditar"]);

              $respuesta = CrudProductos::actualizarProductoModel($datosController, "productos"); //Se llama al modelo para que se haga la
                //actualizacuion correspondiente.

              if($respuesta == "success"){ //Si la consulta fue exitosa y el registro fue editado, entonces se le muestra un mensaje al usuario,
                  //que dice que la consulta tuvo exito.

                echo "<script>swal({title: 'Producto actualizado', text: 'Éxito', type:'success'}, 
                    function (){
                      window.location.href = 'index.php?action=cambioP'
                    }); </script>";

              }
              else{
                  //Por otro lado, si la consulta no se realizó, el sistema avisa al usuario que ha ocurrido un error.
                echo "<script>swal({title: 'Producto NO actualizado', text: 'Ha ocurrido un error', type:'error'}); </script>";;

              }

            }
		}

		//Funcion del controlador que sirve para registrar un cliente en la base de datos.
        public static function registrarClienteController(){
            if (isset($_POST["registrarCliente"])){ //Si el boton de registrar fue presionado en la vista, significa que el usuario desea
                //registrar un nuevo cliente, etnonces
                //Se colocan los datos en un array asociativo que sera pasado al modelo para registrar el cliente nuevo.
                $datos = array( "nombre"=>$_POST["nombre"],
                    "apellido"=>$_POST["apellido"],
                    "email"=>$_POST["email"],
                    "direccion"=>$_POST["direccion"],
                    "telefono"=>$_POST["telefono"]);

                $respuesta = CrudProductos::registrarClienteModel("clientes",$datos);
                //Valiación de la respuesta del modelo para ver si el usuario se registro con exito.
                if($respuesta){
                    echo "<script>swal({title: 'Cliente registrado', text: 'Éxito', type:'success'}, 
                      function (){
                        window.location.href = 'index.php?action=clientes'
                      }); </script>";
                }
                else{
                    echo "<script>swal({title: 'Cliente no registrado', text: 'Ha ocurrido un error', type:'error'}); </script>";
                }
            }
        }

        public static function obtenerCategoriaController(){ //Funcion que sirve para mostrar las categorias de los productos
            $respuesta = CrudProductos::vistaCategoriasModel("categoria"); //Se llama al modelo que despliega la vista de las dategorias
            //las trae de la tabla y por cada categoria, se muestra como una opción de un menu select.
            foreach($respuesta as $row => $item){
                echo '<option>'.$item["nombre"].'</option>';
            }
        }


        public static function obtenerProductosController(){ //Funcion que obtiene de la tabla
		    //los productos que existen y los muestra en un select
            $respuesta = CrudProductos::vistaProductosModel("productos"); //Se llama a la tabla productos
            foreach($respuesta as $row => $item){
                echo '<option>'.$item["nombre"].'</option>';
            }
        }

        public static function obtenerClientesController(){ //Funcion que muestra los clientes existentes en la base de datos

            $respuesta = CrudProductos::vistaClientesModel("clientes");
            //Se manda llamar al modelo para que consulte la tabla clientes y despliega como opciones
            //los registros que obtiene de la tabla.

            foreach($respuesta as $row => $item){
                echo '<option value="'.$item["id"].'">'.$item["nombre"]." ".$item["apellido"].'</option>';
            }

        }

        public static function obtenerProveedoresController(){ //Funcion que muestra los proveedores
		    //en un select, como opciones.

            $respuesta = CrudProductos::vistaClientesModel("proveedores");
            foreach($respuesta as $row => $item){
                echo '<option value='.$item["id"].'>'.$item["nombre"].'</option>';
            }

        }

        public static function vistaVentasController(){//Funcion que despliega las ventas que existen en la base de datos
            $respuesta = CrudProductos::vistaVentasModel("ventas"); //llama al modelo para obtener las ventas de la tabla ventas
            foreach($respuesta as $row => $item){ //por cada registro que obtiene, despliega el cuerpo de una tabla con los datos del registro,
                echo'<tr>
              				<td>'.$item["id"].'</td>
              				<td>'.$item["total_venta"].'</td>
                      <td>'.$item["id_cliente"].'</td>
                      <td><a href="index.php?action=ventas&idBorrar='.$item["id"].'" data-tip="Eliminar"><button class="btn btn-danger"><i class="right fa fa-trash"></i> Borrar</button></a></td>
                      <td><a href="index.php?action=detalleVenta&idDetalle='.$item["id"].'" data-tip="Detalle"><button class="btn btn-info"><i class="right fa fa-info"></i> Ver detalle</button></a></td>
                    </tr>';

            }

            if (isset($_GET["idBorrar"])) { //Si se ha dado como parametro, un id para eliminar
                //entonces toma el id de la URL y lo pasa al modelo
              $id = $_GET["idBorrar"];

              $respuesta2 = CrudProductos::borrarVentaModel($id,"ventas"); //el modelo se encarga de borrar el registro de la tabla que le es dada
                //como parámetro, el registro que tiene como id, el id que le fue dado como parametro también.

              if($respuesta2){ //Se le despliega un mensaje al usuario en caso de exito
                  echo "<script>swal({title: 'Venta eliminada', text: 'Éxito', type:'success'}, 
                  function (){
                    window.location.href = 'index.php?action=ventas'
                  }); </script>";
              }

              else{
                //En caso contrario tambien se notifica al usuario
                 echo "<script>swal({title: 'La venta no ha sido eliminada', text: 'Ha ocurrido un error', type:'error'}); </script>";
              }
            }

        }

        public static function detalleVentaController(){ //Cuando el usuario desea ver el detalle de una venta que fue realizada,
		    //se presiona un boton que activa esta funcion, se obtiene el id del que se desean obtener los detalles.
              $id = $_GET["idDetalle"];

              $respuesta2 = CrudProductos::detalleVentaModel($id,"venta"); //Se llama al modelo que traera los datos
            //de la tabla, correspondientes al id de la venta de la cual se quieren conocer los detalles.

              foreach($respuesta2 as $row => $item){
                echo'<tr>
                      <td>'.$item["id_venta"].'</td>
                      <td>'.$item["id_producto"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre_producto"].'</td>
                      <td>'.$item["cantidad"].'</td>
                      <td>'.$item["total"].'</td>
                    </tr>';

              }
        }

         public static function registrarProductoVController(){
            if(isset($_POST["agregarP"]) && isset($_POST["cantidad"])){ //Si los campos han sido proporcionados
              $prod =CrudProductos::obtenerProdPorNombre("productos", $_POST["producto"]); //Se obtienen los datos del producto, para usarlos
                //mas adelante.
              $idVenta=CrudProductos::obtenerIdVenta(); //Se obtiene el id de la venta que se desea registrar

              if ($_POST["cantidad"] <= $prod["cantidad_stock"]) {
                CrudProductos::eliminarStockModel("productos", $_POST["cantidad"], $prod["id"]); //Ya que lo que se esta registrando es una venta,
                  //se elimina stock del stock que tiene el producto, ya que como se esta vendiendo producto, el stock debe disminuir.
                $total= (int) $prod["precio_producto"]*(int)$_POST["cantidad"];
                $datos = array("id_venta"=>$idVenta["id"], "id_producto"=>$prod["id"], "codigo_producto"=>$prod["codigo_producto"], "nombre_producto"=>$prod["nombre"],"cantidad"=>$_POST["cantidad"], "total"=> $total);
                $respuesta=CrudProductos::registrarProductoVModel("venta",$datos);
                //Valiación de la respuesta del modelo para ver si se registro el producto al carrito.
                if($respuesta){
                    echo "<script>swal({title: 'Producto agregado al carrito', text: 'Producto registrado', type:'success'}); </script>";
                    //echo "<script>window.location.href = 'index.php?action=vender'</script>";
                }else{
                    //header("location:index.php?action=fallo");
                    echo "<script>swal({title: 'Error', text: 'Ha ocurrido un error al intentar agregar el producto', type:'error'}); </script>";
                    //echo "<script>window.location.href = 'index.php?action=fallo'</script>";
                }
              }
              else{
                 echo "<script>swal({title: 'Error', text: 'No hay stock suficiente', type:'error'}); </script>";
              }

            } else if (isset($_POST["cantidad"]) && $_POST["cantidad"]<=0) { //Si el usuario intenta realizar una venta donde la cantidad es menor
                //a cero, entonces el sistema le notifica que esa cantidad no es correcta.
              echo "<script>swal({title: 'Ingrese una cantidad correcta de stock', text: 'Error', type:'error'}); </script>";
            }
        }

        public static function vistaProdVController(){ //Funcion que muestra los productos que se van agregando a la venta
            $respuesta = CrudProductos::vistaProdVModel("venta"); //Obtiene de la tabla de "venta" todos los qu corresponden a la venta actual.
            foreach($respuesta as $row => $item){
                echo'<tr>
                      <td>'.$item["id_venta"].'</td>
                      <td>'.$item["id_producto"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre_producto"].'</td>
                      <td>'.$item["cantidad"].'</td>
                    </tr>';
            }
        }


        public static function registrarVentaController(){ //Funcion que registra la venta que se esta realizando
          if (isset($_POST["guardar"])) {
            $total= CrudProductos::sumarTotal("venta");
            $datos = array("total_venta" => $total["total"],
                          "cliente"=> $_POST["cliente"]);
            
            //Se le dice al modelo que en la clase "CrudProductos", la funcion "registroarVentaModel" reciba en sus 2 parametros
              // los valores "$datos" y el nombre de la tabla a conectarnos la cual es "users"
            $respuesta = CrudProductos::registrarVentaModel("ventas", $datos);
            $idVenta=CrudProductos::obtenerIdVenta();
            $idVenta["id"]+=1;
            //Valiación de la respuesta del modelo para ver si es un usuario correcto.
            if ($respuesta) {
                echo "<script>swal({title: 'Venta registrada con éxito', text: 'Éxtio', type:'success'}, 
                    function (){
                      window.location.href = 'index.php?action=ventas'
                    }); </script>";
            } else {
              echo "<script>swal({title: 'No se realizo la venta', text: 'Venta no registrada', type:'error'}); </script>";
            }
            
          }
        }

        ################### COMPRAS ###################
        public static function vistaComprasController(){ //Funcion que muestra las compras en la vista
            $respuesta = CrudProductos::vistaModel("compras"); //Se llama al modelo para que muestre las compras que existen en la base de datos.
            foreach($respuesta as $row => $item){
                echo'<tr>
              				<td>'.$item["id"].'</td>
              				<td>'.$item["total_compra"].'</td>
                      <td>'.$item["id_proveedor"].'</td>
                      <td><a href="index.php?action=compras&idBorrar='.$item["id"].'" data-tip="Eliminar"><button class="btn btn-danger"><i class="right fa fa-trash"></i> Borrar</button></a></td>
                      <td><a href="index.php?action=detalleCompra&idDetalle='.$item["id"].'" data-tip="Detalle"><button class="btn btn-info"><i class="right fa fa-info"></i> Ver detalle</button></a></td>
                    </tr>';

            }

            if (isset($_GET["idBorrar"])) { //Si se ha presionado el borrar una compra, entonces se llama al modelo
                $id = $_GET["idBorrar"];

                $respuesta2 = CrudProductos::borrarVentaModel($id,"compras"); //El modelo se encarga de borrar la compra que existe con el id
                //que se le pasa como parametro.

                if($respuesta2){ //Notifica al usuario que la compra fue eliminada.
                    echo "<script>swal({title: 'Compra eliminada', text: 'Éxito', type:'success'}, 
                  function (){
                    window.location.href = 'index.php?action=compras'
                  }); </script>";
                }

                else{

                    echo "<script>swal({title: 'La compra no ha sido eliminada', text: 'Ha ocurrido un error', type:'error'}); </script>";
                }
            }

        }

        public static function detalleCompraController(){ //Si el usuario desea ver mas detalle sobre la compra que tiene en pantalla
            $id = $_GET["idDetalle"]; //Se obtiene por metodo GET la variable que nos indica cual es el id de la compra de la cual
            //se desea conocer el detalle
            $respuesta2 = CrudProductos::detalleCompraModel($id,"compra"); //Se llama el modelo que despliega los componentes a detalle de las
            //ventas y se introduce en un foreach para despliegarlo en una tabla.
            foreach($respuesta2 as $row => $item){
                echo'<tr>
                      <td>'.$item["id"].'</td>
                      <td>'.$item["id_producto"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre_producto"].'</td>
                      <td>'.$item["cantidad"].'</td>
                      <td>'.$item["precio_compra"].'</td>
                      <td>'.$item["precio_venta"].'</td>
                      <td>'.$item["margen"].'</td>
                      <td>'.$item["id_proveedor"].'</td>
                    </tr>';

            }
        }


        public static function registrarProductoCompraController(){
            if(isset($_POST["agregarP"])) {
                $prod = CrudProductos::obtenerProdPorNombre("productos", $_POST["producto"]); //Se obtiene la información del producto
                $idCompra = CrudProductos::obtenerIdCompra(); //Se determina el id de la compra a la que se agregaran los productos
                $total = (int)$prod["precio_producto"] * (int)$_POST["cantidad"];
                $totalVenta = (int)$_POST["precioVenta"] * (int)$_POST["cantidad"];
                //$prov= CrudProductos::obtenerIdClienteModel("proveedores", $_POST["proveedor"]); //Se utiliza la misma funcion del modelo de clientes
                //para obtener el id de una tabla, en este caso, la de proveedores
                if ((int)$totalVenta < (int)$total){
                    $ganancia=0;
                } else {
                    $ganancia = (int)$totalVenta - (int)$total;
                }
                $datos = array("id_compra" => $idCompra["id"], "id_producto" => $prod["id"], "codigo_producto" => $prod["codigo_producto"],
                    "nombre_producto" => $prod["nombre"], "cantidad" => $_POST["cantidad"], "totalCompra" => $total, "totalVenta" => $totalVenta,
                    "ganancia" => $ganancia, "id_proveedor" => $_POST["proveedor"]);

                $respuesta = CrudProductos::registrarProductoCompraModel("compra", $datos);
                //Valiación de la respuesta del modelo para ver si es un usuario correcto.
                if ($respuesta) {
                    CrudProductos::agregarStockModel("productos", $_POST["cantidad"], $prod["id"]); //Se incrementa el stock del articulo
                    echo "<script>swal({title: 'Producto agregado al carrito de compra', text: 'Producto registrado', type:'success'}); </script>";
                    //echo "<script>window.location.href = 'index.php?action=vender'</script>";
                } else {
                    //header("location:index.php?action=fallo");
                    echo "<script>swal({title: 'Error', text: 'Ha ocurrido un error al agregar el producto', type:'error'}); </script>";
                    //echo "<script>window.location.href = 'index.php?action=fallo'</script>";
                }
            }
        }

        public static function vistaProdCompraController(){ //Se depliegan los productos que se estan registrando en la compra
		    //paraque el usuario esté enterado de lo que se va agregando al carrito de compra.
            $respuesta = CrudProductos::vistaProdCompraModel("compra");
            //Una vez que se ha llamada al modelo, se despliega cada uno de sus atributos para que el usuario pueda ver los datos en la vista.
            foreach($respuesta as $row => $item){
                echo'<tr>
                      <td>'.$item["id"].'</td>
                      <td>'.$item["id_producto"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre_producto"].'</td>
                      <td>'.$item["cantidad"].'</td>
                      <td>'.$item["precio_compra"].'</td>
                      <td>'.$item["precio_venta"].'</td>
                      <td>'.$item["margen"].'</td>
                      <td>'.$item["id_proveedor"].'</td>
                    </tr>';
            }
        }


        public static function registrarCompraController(){
		    //Funcion que registra una compra que se ha realizado a proveedor.
            if (isset($_POST["guardarCompra"])) { //Se presionó el botón de registro.
                $total= CrudProductos::sumarTotalCompra("compra"); //Se suma el total del precio de compra de todos los productos que fueron
                //agregados al carrito
                $datos = array("total_compra" => $total["total"], "proveedor"=> $_POST["proveedor"]);
                //Se le dice al modelo que en la clase "CrudProductos", la funcion "registroarCompraModel"
                // reciba en sus 2 parametros los valores "$datos" y el nombre de la tabla a conectarnos la cual es "compras"
                $respuesta = CrudProductos::registrarCompraModel("compras", $datos);
                //Valiación de la respuesta del modelo para ver si es un usuario correcto.
                if ($respuesta) {
                    echo "<script>swal({title: 'Compra registrada con éxito', text: 'Éxtio', type:'success'}, 
                    function (){
                      window.location.href = 'index.php?action=compras'
                    }); </script>";
                } else {
                    echo "<script>swal({title: 'No se realizo la compra', text: No registrada', type:'error'}); </script>";
                }

            }
        }
        ###############################################

        public static function vistaClientesController(){ //Vista que despliega los clientes que existen en la tabla, en conjunto
		    //con todos los datos correspondientes de cada uno.
            $respuesta = CrudProductos::vistaClientesModel("clientes");
            #El constructor foreach proporciona un modo sencillo de iterar sobre arrays.
            # foreach funciona sólo sobre arrays y objetos, y emitirá un error al intentar usarlo
            # con una variable de un tipo diferente de datos o una variable no inicializada.
            foreach($respuesta as $row => $item){
                echo'<tr>
                      <td>'.$item["id"].'</td>
                      <td>'.$item["nombre"].'</td>
                      <td>'.$item["apellido"].'</td>
                      <td>'.$item["email"].'</td>
                      <td>'.$item["direccion"].'</td>
                      <td>'.$item["telefono"].'</td>
                      <td><a href="index.php?action=editarCliente&id='.$item["id"].'"><button class="btn btn-info">Editar</button></a></td>
                      <td><a href="index.php?action=clientes&idBorrar='.$item["id"].'"><button class="btn btn-danger">Borrar</button></a></td>
                    </tr>';

            }
            if (isset($_GET["idBorrar"])) { //Si el usuario ha presionado borrar cliente, entonces se elimina el cliente que se ha seleccionado
                //y se hace la consulta en la tabla para eliminar el registro.
              $id = $_GET["idBorrar"];

              $respuesta2 = CrudProductos::borrarClienteModel($id,"clientes");

              if($respuesta2){
                  echo "<script>swal({title: 'Cliente eliminado', text: 'Éxito', type:'success'}, 
                  function (){
                    window.location.href = 'index.php?action=clientes'
                  }); </script>";
              }

              else{

                 echo "<script>swal({title: 'Cliente no eliminado', text: 'Error', type:'error'}); </script>";
              }
            }
            
        }


        public static function editarClienteController(){ //Si el usuario desea editar un cliente,
		    //se le abrira una vista donde se cargan los datos del cliente cuyo id seleccionó para editar, una vez que se cargaron
            //los datos, el usuario puede editar los compos que desee.
          $datosController = $_GET["id"];
          $respuesta = CrudProductos::editarClienteModel($datosController, "clientes");
            echo "<form method='post' role='form'>
                      <div class='box-body'>
                          <div class='form-group'>
                            <input type='hidden' value='".$respuesta["id"]."' name='idEditar'>
                              <label for='nombre'>Nombre</label>
                              <input type='text' name='nombreEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["nombre"]."'>
                          </div>
                          <div class='form-group'>
                              <label for='apellido'>Apellido</label>
                              <input type='text' name='apellidoEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["apellido"]."'>
                          </div>
                          <div class='form-group'>
                              <label for='email'>Direecion</label>
                              <input type='email' name='emailEditar' class='form-control' value='".$respuesta["email"]."'>
                          </div>
                          <div class='form-group'>
                              <label for='usuario'>Direccion</label>
                              <input type='text' name='direccionEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["direccion"]."' required>
                          </div>
                          <div class='form-group'>
                              <label for='usuario'>Telefono</label>
                              <input type='text' name='telefonoEditar' class='form-control' id='exampleInputEmail1' value='".$respuesta["telefono"]."' required>
                          </div>
      
                      </div>
                          <button type='submit' class='btn btn-primary' name='clienteEditar'>Actualizar usuario</button>
                  </form>";

      }
        
        public static function actualizarClienteController(){ //La funcion que edita el cliente llama al controllador que actualiza los datos
		    //ya que el editar seria solo modificar los datos pero el actualizar es realizar el update en la tabla, por medio del modelo.
          if(isset($_POST["clienteEditar"])){
            //Se pasan los datos en un array asociativo.
            $datosController = array( "id"=>$_POST["idEditar"],
                              "nombre"=>$_POST["nombreEditar"],
                              "apellido"=>$_POST["apellidoEditar"],
                                    "direccion"=>$_POST["direccionEditar"],
                                    "telefono"=>$_POST["telefonoEditar"],
                                    "email"=>$_POST["emailEditar"]);
            
            $respuesta = CrudProductos::actualizarClienteModel($datosController, "clientes");
            //Se llama al modelo para que se actualice el cliente y el registro que se modificó.

            if($respuesta == "success"){
                //Se notifica al usuario, el resultado de la acción.
              echo "<script>swal({title: 'Cliente actualizado con éxito', text: 'Éxito', type:'success'}, 
              function (){
                window.location.href = 'index.php?action=cambioCliente'
              }); </script>";
            }

          else{
               echo "<script>swal({title: 'Cliente no actualizado', text: 'Ha ocurrido un error', type:'error'}); </script>";
            }
          }
        }

        ##################### PEDIDOS ##################

        public static function vistaPedidosController(){ //La vista de pedidos despliega los pedidos que estan registrados en la base de datos
            $respuesta = CrudProductos::vistaModel("pedidos"); //Se llama al modelo y juntos se conectan con la vista, para mostarle al usuario,
            //los datos sobre los pedidos existentes.
            foreach($respuesta as $row => $item){
                echo'<tr>
                        <td>'.$item["id"].'</td>
                        <td>'.$item["total_pedido"].'</td>
                      <td>'.$item["id_proveedor"].'</td>
                      <td>'.$item["fecha_pedido"].'</td>
                      <td>'.$item["fecha_entrega"].'</td>
                      <td><a href="index.php?action=pedidos&idBorrar='.$item["id"].'" data-tip="Eliminar"><button class="btn btn-danger"><i class="right fa fa-trash"></i> Borrar</button></a></td>
                      <td><a href="index.php?action=detallePedido&idDetalle='.$item["id"].'" data-tip="Detalle"><button class="btn btn-info"><i class="right fa fa-info"></i> Ver detalle</button></a></td>
                    </tr>';

            }

            if (isset($_GET["idBorrar"])) { //Si el usuario ha presionado el boton para eliminar algun registro
                $id = $_GET["idBorrar"];

                $respuesta2 = CrudProductos::borrarVentaModel($id,"pedidos");
                //Se llama al modelo y se hace el borrado de la tabla
                //Posteriormente se le notifica al usuario el estado del sistema.
                if($respuesta2){
                    echo "<script>swal({title: 'Pedido eliminado', text: 'Éxito', type:'success'}, 
                  function (){
                    window.location.href = 'index.php?action=pedidos'
                  }); </script>";
                } else{
                    echo "<script>swal({title: 'El pedido no fue eliminado', text: 'Ha ocurrido un error', type:'error'}); </script>";
                }
            }
        }

        public static function detallePedidoController(){
		    //Funcion que sirve para ver el detalle de un pedido en especifico
            $id = $_GET["idDetalle"];
            $respuesta2 = CrudProductos::detallePedidoModel($id,"pedido");
            //Se traen los datos de la tabla pedido, correspondientes al id que se le pasa como parametro a la funcion del modelo.
            foreach($respuesta2 as $row => $item){
                echo'<tr>
                      <td>'.$item["id"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre_producto"].'</td>
                      <td>'.$item["cantidad"].'</td>
                      <td>'.$item["precio_compra"].'</td>
                      <td>'.$item["precio_venta"].'</td>
                      <td>'.$item["margen"].'</td>
                      <td>'.$item["id_proveedor"].'</td>
                      <td>'.$item["fecha_pedido"].'</td>
                      <td>'.$item["fecha_entrega"].'</td>
                    </tr>';
            }
        }

        public static function registrarProductoPedidoController(){
		    //Funcion que agrega los productos de uno por uno al pedido
            if(isset($_POST["agregarPedido"])) {
                //Si se presiono el boton para agregar, entonces se busca el producto, se calculan las cantidades necesarias que se desean.
                $prod = CrudProductos::obtenerProdPorNombre("productos", $_POST["producto"]); //Se obtiene la información del producto
                $idPedido =  $_GET["idPedido"]; //Se determina el id de la compra a la que se agregaran los productos
                $total = (int)$prod["precio_producto"] * (int)$_POST["cantidad"];
                $totalVenta = (int)$_POST["precioVenta"] * (int)$_POST["cantidad"];
                //$prov= CrudProductos::obtenerIdClienteModel("proveedores", $_POST["proveedor"]); //Se utiliza la misma funcion del modelo de clientes
                //para obtener el id de una tabla, en este caso, la de proveedores
                if ((int)$totalVenta < (int)$total){
                    $ganancia=0;
                } else {
                    $ganancia = (int)$totalVenta - (int)$total;
                }
                //Y se obtienen los datos en un array asociativo que permite ingresarlos a la tabla por medio del modelo.
                $datos = array("id_pedido" => $idPedido, "codigo_producto" => $prod["codigo_producto"],
                    "nombre_producto" => $prod["nombre"], "cantidad" => $_POST["cantidad"], "totalCompra" => $total, "totalVenta" => $totalVenta,
                    "ganancia" => $ganancia, "id_proveedor" => $_POST["proveedor"], "fecha_pedido"=> $_POST["fechaPedido"], "fecha_entrega"=> $_POST["fechaEntrega"]);

                $respuesta = CrudProductos::registrarProductoPedidoModel("pedido", $datos);
                //Valiación de la respuesta del modelo para ver si es un usuario correcto.
                if ($respuesta) {
                    echo "<script>swal({title: 'Producto agregado al pedido', type:'success'}); </script>";
                } else {
                    //header("location:index.php?action=fallo");
                    echo "<script>swal({title: 'Error', text: 'Ha ocurrido un error al cargar el producto', type:'error'}); </script>";
                    //echo "<script>window.location.href = 'index.php?action=fallo'</script>";
                }
            }
        }

        public static function vistaProdPedidoController(){
		    //Vista que muestra los productos que son agregados individualmente al pedido que se esta realizando a proveedor.
            $respuesta = CrudProductos::vistaProdPedidoModel("pedido", $_GET["idPedido"]);
            foreach($respuesta as $row => $item){
                echo'<tr>
                      <td>'.$item["id"].'</td>
                      <td>'.$item["codigo_producto"].'</td>
                      <td>'.$item["nombre_producto"].'</td>
                      <td>'.$item["cantidad"].'</td>
                      <td>'.$item["precio_compra"].'</td>
                      <td>'.$item["precio_venta"].'</td>
                      <td>'.$item["margen"].'</td>
                      <td>'.$item["id_proveedor"].'</td>
                      <td>'.$item["fecha_pedido"].'</td>
                      <td>'.$item["fecha_entrega"].'</td>
                    </tr>';
            }
        }


        public static function registrarPedidoController(){
		    //Funcion que registra el pedido completo en la base de datos
            if (isset($_POST["guardarPedido"])) { //una vez presionado el boton
                //Se obtienen los datos necesarios para introducirlos a la tabla
                $total= CrudProductos::sumarTotalPedido("pedido", $_GET["idPedido"]);
                //Se obtiene el total del pedido
                //Se obtiene en numero de pedido desde la tabla que va siendo llenada por los productos que se agregan al "carrito" del pedido.
                $pedido=CrudProductos::vistaProdPedidoModel("pedido", $_GET["idPedido"]);
                $datos = array("fecha_pedido"=>$pedido[0]["fecha_pedido"], "fecha_entrega"=>$pedido[0]["fecha_entrega"],"total_pedido" => $total["total"],
                    "proveedor"=> $pedido[0]["id_proveedor"]);
                //Se le dice al modelo que en la clase "CrudProductos", la funcion "registroarUsuarioModel" reciba en sus 2 parametros los valores "$datos" y el nombre de la tabla a conectarnos la cual es "users"
                $respuesta = CrudProductos::registrarPedidoModel("pedidos", $datos);
                //Valiación de la respuesta del modelo para ver si es un usuario correcto.
                if ($respuesta) {
                    echo "<script>swal({title: 'Registro exitoso', text: 'Éxito', type:'success'}, 
                    function (){
                      window.location.href = 'index.php?action=pedidos'
                    }); </script>";
                } else {
                    echo "<script>swal({title: 'No se realizo el pedido', text: No registrada', type:'error'}); </script>";
                }
            }
        }
	}
  ?>