
$().ready(function() {


/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncClienteListaPrecioEstablecerMoneda();
	});

	

});
	

/*
* FUNCIONES
*/
function FncClienteListaPrecioEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
		}
		FncMonedaBuscar('Id');
	}
}
