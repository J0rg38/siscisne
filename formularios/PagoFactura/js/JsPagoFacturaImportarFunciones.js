
$().ready(function() {


/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncPagoFacturaEstablecerMoneda();
		FncCuentaCargar();
	});
	
	$("select#CmpCuenta").change(function(){
		FncPagoFacturaEstablecerCuenta();
	});
	

});
	

/*
* FUNCIONES
*/
function FncPagoFacturaEstablecerMoneda(){

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
				FncTipoCambioCargar(MonedaId,Fecha);				
			}
		}
		FncMonedaBuscar('Id');
	}
}


function FncPagoFacturaEstablecerCuenta(){
	
	var CuentaId = $('#CmpCuentaId').val();
	
	$.getJSON("comunes/Moneda/JnCuenta.php?CuentaId="+CuentaId,{}, 
		function(j){
			$("#CmpMonedaId").val(j.MonId);
			FncPagoFacturaEstablecerMoneda();

	});

}

