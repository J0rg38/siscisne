// JavaScript Document


function FncCotizacionProductoVistaPreliminar(oId){
	FncPopUp('../CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVentaDirectaVistaPreliminar(oId){
	FncPopUp('../VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVentaConcretadaVistaPreliminar(oId){
	FncPopUp('../VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}
function FncPedidoCompraVistaPreliminar(oId){
	FncPopUp('../PedidoCompra/FrmPedidoCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncAlmacenMovimientoEntradaVistaPreliminar(oId){
	FncPopUp('../AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}