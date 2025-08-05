// JavaScript Document

function FncInformeTecnicoATS3ProductoNuevo(){
	
	$('#CmpProductoId').val("");  
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoNombre').val("");
	
	$('#CmpInformeTecnicoATS3ProductoCantidad').val("");
	$('#CmpInformeTecnicoATS3ProductoValorUnitario').val("");	
	$('#CmpInformeTecnicoATS3ProductoValorTotal').val("");
	
	$('#CmpInformeTecnicoATS3ProductoItem').val("");	

	$('#CapInformeTecnicoATS3ProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpInformeTecnicoATS3ProductoCodigo').select();
			
	$('#CmpInformeTecnicoATS3ProductoAccion').val("AccInformeTecnicoATS3ProductoRegistrar.php");
	
	
	
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpClienteNombre').removeAttr('readonly');
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncInformeTecnicoATS3ProductoGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpInformeTecnicoATS3ProductoAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal').val();		
			var ProductoNombre = $('#CmpProductoNombre').val();			
			var InformeTecnicoProductoCantidad = $('#CmpInformeTecnicoATS3ProductoCantidad').val();
			var InformeTecnicoProductoValorUnitario = $('#CmpInformeTecnicoATS3ProductoValorUnitario').val();
			var InformeTecnicoProductoValorTotal = $('#CmpInformeTecnicoATS3ProductoValorTotal').val();
			
			var Item = $('#CmpInformeTecnicoATS3ProductoItem').val();

			if(ProductoCodigoOriginal==""){
				$('#CmpProductoCodigoOriginal').focus();	
				
			}else if(InformeTecnicoProductoCantidad=="" || InformeTecnicoProductoCantidad <=0){
				$('#CmparantiaDetalleCantidad').focus();	
				
			}else if(InformeTecnicoProductoValorTotal=="" || InformeTecnicoProductoValorTotal <=0){
				$('#CmpInformeTecnicoATS3ProductoCostoTotal').focus();	
				
			}else{
				$('#CapInformeTecnicoATS3ProductoAccion').html('Guardando...');

						$.ajax({
							type: 'POST',
							url: 'formularios/InformeTecnicoATS3/acc/'+Acc,
							data: 'Identificador='+Identificador+
							'&ProductoId='+ProductoId+
							'&ProductoCodigoOriginal='+ProductoCodigoOriginal+
							'&ProductoNombre='+ProductoNombre+
							'&InformeTecnicoProductoCantidad='+InformeTecnicoProductoCantidad+
							'&InformeTecnicoProductoValorUnitario='+InformeTecnicoProductoValorUnitario+
							'&InformeTecnicoProductoValorTotal='+InformeTecnicoProductoValorTotal+
							'&Item='+Item,
							success: function(){
								
							$('#CapInformeTecnicoATS3ProductoAccion').html('Listo');							
								FncInformeTecnicoATS3ProductoListar();
							}
						});
						

						FncInformeTecnicoATS3ProductoNuevo();	
					
					
			}
			
			
	
}


function FncInformeTecnicoATS3ProductoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapInformeTecnicoATS3ProductoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3ProductoListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+InformeTecnicoATS3ProductoEditar+
		'&Eliminar='+InformeTecnicoATS3ProductoEliminar+
		'&MonedaId='+MonedaId+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapInformeTecnicoATS3ProductoAccion').html('Listo');	
			$("#CapInformeTecnicoATS3Productos").html("");
			$("#CapInformeTecnicoATS3Productos").append(html);
		}
	});

}



function FncInformeTecnicoATS3ProductoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapInformeTecnicoATS3ProductoAccion').html('Editando...');
	$('#CmpInformeTecnicoATS3ProductoAccion').val("AccInformeTecnicoATS3ProductoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3ProductoEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsInformeTecnicoATS3Producto){

//SesionObjeto-InsInformeTecnicoATS3Producto
//Parametro1 = ItpId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = FapId
//Parametro5 = ProNombre
//Parametro6 = ItpCantidad
//Parametro7 = ItpValorUnitario
//Parametro8 = ItpValorTotal	
//Parametro9 = ItpEstado	
//Parametro10 = ItpTiempoCreacion		
//Parametro11 = ItpTiempoModificacion	
//Parametro11 = UmeNombre	
//Parametro12 = ProCodigoOriginal
//Parametro13 = ProCodigoAlternativo

			$('#CmpProductoId').val(InsInformeTecnicoATS3Producto.Parametro2);	
			$('#CmpProductoNombre').val(InsInformeTecnicoATS3Producto.Parametro5);
			$('#CmpProductoCodigoOriginal').val(InsInformeTecnicoATS3Producto.Parametro12);
			
			$('#CmpInformeTecnicoATS3ProductoCantidad').val(InsInformeTecnicoATS3Producto.Parametro6);
			$('#CmpInformeTecnicoATS3ProductoValorUnitario').val(InsInformeTecnicoATS3Producto.Parametro7);
			$('#CmpInformeTecnicoATS3ProductoValorTotal').val(InsInformeTecnicoATS3Producto.Parametro8);

			$('#CmpInformeTecnicoATS3ProductoItem').val(InsInformeTecnicoATS3Producto.Item);
			
			$('#CmpProductoCodigoOriginal').select();
			
			$('#CmpProductoCodigoOriginal').attr('readonly', true);
			$('#CmpProductoNombre').attr('readonly', true);
			
		}
	});
	
	
	
	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncInformeTecnicoATS3ProductoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapInformeTecnicoATS3ProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3ProductoEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapInformeTecnicoATS3ProductoAccion').html("Eliminado");	
				FncInformeTecnicoATS3ProductoListar();
			}
		});

		FncInformeTecnicoATS3ProductoNuevo();

	}
	
}

function FncInformeTecnicoATS3ProductoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapInformeTecnicoATS3ProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3ProductoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapInformeTecnicoATS3ProductoAccion').html('Eliminado');	
				FncInformeTecnicoATS3ProductoListar();
			}
		});	
			
		FncInformeTecnicoATS3ProductoNuevo();
	}
	
}









function FncInformeTecnicoATS3ProductoCalcularValorUnitario(){


	var CostoTotal = $('#CmpInformeTecnicoATS3ProductoValorTotal').val();	
	var Cantidad = $('#CmpInformeTecnicoATS3ProductoCantidad').val();	
	
	var CostoUnitario = 0;
	
	if(CostoTotal!=""){
		if(Cantidad!=""){
			
			CostoUnitario = ((CostoTotal) / Cantidad);

			CostoUnitario = Math.round(CostoUnitario*100000)/100000;
						
			$('#CmpInformeTecnicoATS3ProductoValorUnitario').val(CostoUnitario);
			
		}else{
			$('#CmpInformeTecnicoATS3ProductoCantidad').val("0");
		}
		
	}else{
		$('#CmpInformeTecnicoATS3ProductoValorTotal').val("0");
	}
	
}


function FncInformeTecnicoATS3ProductoCalcularValorTotal(){

	var ValorUnitario = $('#CmpInformeTecnicoATS3ProductoValorUnitarios').val();
	var Cantidad = $('#CmpInformeTecnicoATS3ProductoCantidad').val();	
	var ValorTotal = 0;
	
	if(ValorUnitario!=""){
		if(Cantidad!=""){
			
			ValorTotal = ((Cantidad) * ValorUnitario);
			ValorTotal = Math.round(ValorTotal*100000)/100000;
						
			$('#CmpInformeTecnicoATS3ProductoValorTotal').val(ValorTotal);
			
		}else{
			$('#CmpInformeTecnicoATS3ProductoCantidad').val("0");
		}
		
	}else{
		$('#CmpInformeTecnicoATS3ProductoValorUnitario').val("0");
	}
	
}



$().ready(function() {

	$("#CmpInformeTecnicoATS3ProductoValorTotal").keyup(function (event) {  
		FncInformeTecnicoATS3ProductoCalcularValorUnitario();
	});
	
	$("#CmpInformeTecnicoATS3ProductoCantidad").keyup(function (event) {  
		FncInformeTecnicoATS3ProductoCalcularValorTotal();
	});

});


