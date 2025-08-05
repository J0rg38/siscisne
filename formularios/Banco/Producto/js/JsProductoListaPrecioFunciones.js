// JavaScript Document

function FncGuardar(){
	
	//HACK
	//$("#CmpEstado").removeAttr('disabled');		

		
	
}


$().ready(function() {


/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncCotizacionProductoEstablecerMoneda();
	});

	

});
	

/*
* FUNCIONES
*/
function FncProductoListaPrecioEstablecerMoneda(){

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


/*
* FUNCIONES ADICIONALES
*/


/*
* FUNCIONES IMPRESION
*/


/*****************************************************************************/









