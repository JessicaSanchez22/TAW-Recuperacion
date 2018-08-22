<?php 

class Paginas{
	
	public static function enlacesPaginasModel($link){

		if($link == "ingresar" || $link == "inventario" || $link == "editar" || $link == "categorias" || $link=="registroCategoria"
            || $link=="registro" || $link=="editarProducto" || $link=="editarCategoria" || $link=="borrarCategoria" || $link=="borrarProducto"
            || $link=="borrarUsuario" ||$link=="agregarStock" || $link=="tiendas"  || $link=="ventas" || $link=="vender"
            || $link=="borrarVenta" || $link=="detalleVenta" || $link=="clientes" || $link=="registroClientes"
            || $link=="editarCliente" || $link=="compras" || $link=="compra" || $link=="detalleCompra" || $link=="pedidos" || $link=="pedido"
            || $link=="detallePedido"){

			$module =  "views/modules/".$link.".php";
		
		}

		else if($link == "index"){

			$module =  "views/modules/ventas.php";
		
		}

		else if($link == "ok"){

			$module =  "views/modules/registro.php";
		
		}

		else if($link == "fallo"){

			$module =  "views/modules/ventas.php";
		
		}
		
		else if($link == "cambioP"){ //Hubo un cambio en los productos

			$module =  "views/modules/inventario.php";
		
		}

		else if($link == "cambioC"){ //Hubo un cambio en as categorias

			$module =  "views/modules/categorias.php";
		
		}

		else if($link == "cambioCliente"){ //Hubo un cambio en as categorias

			$module =  "views/modules/clientes.php";
		
		}

		else{

			$module =  "views/modules/404.html";

		}
		return $module;

	}

}

?>