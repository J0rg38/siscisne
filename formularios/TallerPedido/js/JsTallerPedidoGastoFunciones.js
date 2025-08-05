
/******************************************************************************/

function FncTallerPedidoGastoNuevo(){
	
	$('#CmpGastoId').val("");
	$('#CmpGastoComprobanteNumero').val("");
	$('#CmpGastoComprobanteFecha').val("");		
	$('#CmpGastoConcepto').val("");	
	$('#CmpGastoTotal').val("");
	
	$('#CmpProveedorNombre').val("");
	$('#CmpProveedorApellidoPaterno').val("");
	$('#CmpProveedorApellidoMaterno').val("");
	
	$('#CmpGastoMonedaId').val("");
	$('#CmpGastoMonedaNombre').val("");
	$('#CmpGastoMonedaSimbolo').val("");	

	$('#CmpTallerPedidoGastoItem').val("")
	
	
	$('#CapTallerPedidoGastoAccion').html('Listo para registrar elementos');	
				
	$('#CmpGastoComprobanteNumero').focus();	
			
	$('#CmpTallerPedidoGastoAccion').val("AccTallerPedidoGastoRegistrar.php");
	
	$('#CmpGastoComprobanteNumero').removeAttr('readonly');
	
	$("#BtnGastoEditar").hide();
	$("#BtnGastoRegistrar").show();

}

function FncTallerPedidoGastoGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpTallerPedidoGastoAccion').val();		
	
	var GastoId = $('#CmpGastoId').val();
	var GastoComprobanteNumero = $('#CmpGastoComprobanteNumero').val();
	var GastoComprobanteFecha = $('#CmpGastoComprobanteFecha').val();
	var GastoConcepto = $('#CmpGastoConcepto').val();
	var GastoTotal = $('#CmpGastoTotal').val();
	
	var ProveedorNombre = $('#CmpProveedorNombre').val();
	var ProveedorApellidoPaterno = $('#CmpProveedorApellidoPaterno').val();
	var ProveedorApellidoMaterno = $('#CmpProveedorApellidoMaterno').val();
	
	var GastoMonedaNombre = $('#CmpGastoMonedaNombre').val();
	var GastoMonedaSimbolo = $('#CmpGastoMonedaSimbolo').val();
	var GastoMonedaId = $('#CmpGastoMonedaId').val();
	
	var GastoFoto = $('#CmpGastoFoto').val();
	
	var Item = $('#CmpTallerPedidoGastoItem').val();
	
	if(GastoComprobanteNumero==""){
		$('#CmpGastoComprobanteNumero').select();	
	}else{
		
		$('#CapTallerPedidoGastoAccion').html('Guardando...');

			$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&GastoComprobanteNumero='+GastoComprobanteNumero+
			'&GastoComprobanteFecha='+GastoComprobanteFecha+
			'&GastoConcepto='+GastoConcepto+
			'&GastoId='+GastoId+
			'&GastoTotal='+GastoTotal+
			'&ProveedorNombre='+ProveedorNombre+
			'&ProveedorApellidoPaterno='+ProveedorApellidoPaterno+
			'&ProveedorApellidoMaterno='+ProveedorApellidoMaterno+
			
			'&GastoMonedaSimbolo='+GastoMonedaSimbolo+
			'&GastoMonedaNombre='+GastoMonedaNombre+
			'&GastoMonedaId='+GastoMonedaId+
			
			'&GastoFoto='+GastoFoto+
			
			'&Item='+Item,
			success: function(){
			  
			$('#CapTallerPedidoGastoAccion').html('Listo');							
			  FncTallerPedidoGastoListar();
			}
		  
		});
			
		FncTallerPedidoGastoNuevo();	
	
	}

}


function FncTallerPedidoGastoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapTallerPedidoGastoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoGastoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TallerPedidoGastoEditar+'&Eliminar='+TallerPedidoGastoEliminar,
		success: function(html){
			$('#CapTallerPedidoGastoAccion').html('Listo');	

			$("#CapTallerPedidoGastos").html("");
			$("#CapTallerPedidoGastos").append(html);
		}
	});

}


function FncTallerPedidoGastoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapTallerPedidoGastoAccion').html('Editando...');
	$('#CmpTallerPedidoGastoAccion').val("AccTallerPedidoGastoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoGastoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsTallerPedidoGasto){
	
			//SesionObjeto-TallerPedidoGasto
			//Parametro1 = FigId
			//Parametro2 = GasId
			//Parametro3 = GasComprobanteNumero
			//Parametro4 = GasComprobanteFecha
			//Parametro5 = GasTotal
			//Parametro6 = FigEstado
			//Parametro7 = FigTiempoCreacion
			//Parametro8 = FigTiempoModificacion
			//Parametro9 = PrvNombre
			//Parametro10 = PrvApellidoPaterno
			//Parametro11 = PrvApellidoMaterno
			//Parametro12 = 
			//Parametro13 = 
			//Parametro14 = 
	
			$('#CmpTallerPedidoGastoId').val(InsTallerPedidoGasto.Parametro1);
			
			$('#CmpGastoId').val(InsTallerPedidoGasto.Parametro2);			
			$('#CmpGastoComprobanteNumero').val(InsTallerPedidoGasto.Parametro3);
			$('#CmpGastoComprobanteFecha').val(InsTallerPedidoGasto.Parametro4);
			$('#CmpGastoConcepto').val(InsTallerPedidoGasto.Parametro17);
			$('#CmpGastoTotal').val(InsTallerPedidoGasto.Parametro5);
			
			$('#CmpProveedorNombre').val(InsTallerPedidoGasto.Parametro9);
			$('#CmpProveedorApellidoPaterno').val(InsTallerPedidoGasto.Parametro10);
			$('#CmpProveedorApellidoMaterno').val(InsTallerPedidoGasto.Parametro11);
			
			$('#CmpTallerPedidoGastoItem').val(InsTallerPedidoGasto.Item);
	
		}
	});
	

	$('#CmpGastoComprobanteNumero').select();

	//$('#CmpGastoNombre').attr('readonly', true);
	///$('#CmpGastoComprobanteNumero').attr('readonly', true);
	
	
	$("#BtnGastoEditar").show();
	$("#BtnGastoRegistrar").hide();
	
	
}

function FncTallerPedidoGastoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapTallerPedidoGastoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoGastoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapTallerPedidoGastoAccion').html("Eliminado");	
				FncTallerPedidoGastoListar();
			}
		});

		FncTallerPedidoGastoNuevo();

	}
	
}



function FncTallerPedidoGastoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapTallerPedidoGastoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoGastoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapTallerPedidoGastoAccion').html('Eliminado');	
				FncTallerPedidoGastoListar();
			}
		});	
			
		FncTallerPedidoGastoNuevo();
	}
	
}



/*
* GASTOS
*/

//$(function(){
//
//	$("#BtnTallerPedidoGastoEditar").hide();
//	$("#BtnTallerPedidoGastoRegistrar").show();
//	
//});
//
//function FncTallerPedidoGastoNuevo(){
//
//	$('#CmpTallerPedidoGastoId').val("");
//	$('#CmpTallerPedidoGastoNumeroComprobante').val("");
//	$('#CmpTallerPedidoGastoFecha').val("");
//	$('#CmpTallerPedidoProveedorNombre').val("");
//	$('#CmpTallerPedidoGastoTotal').val("");
//
//	$("#BtnTallerPedidoGastoEditar").hide();
//	$("#BtnTallerPedidoGastoRegistrar").show();
//
//}
//
//function FncTallerPedidoGastoEscoger(InsTallerPedidoGasto){	
//
//	$('#CmpTallerPedidoGastoId').val(InsTallerPedidoGasto.FigId);
//	$('#CmpTallerPedidoGastoNumeroComprobante').val(InsTallerPedidoGasto.GasComprobanteNumero);
//	$('#CmpTallerPedidoGastoFecha').val(InsTallerPedidoGasto.GasComprobanteFecha);
//	$('#CmpTallerPedidoProveedorNombre').val(InsTallerPedidoGasto.PrvNombre+" "+InsTallerPedidoGasto.PrvApellidoPaterno+" "+InsTallerPedidoGasto.PrvApellidoMaterno);
//	$('#CmpTallerPedidoGastoTotal').val(InsTallerPedidoGasto.FigTotal);
//	
//	$("#BtnTallerPedidoGastoEditar").show();
//	$("#BtnTallerPedidoGastoRegistrar").hide();
//
//}
//
//
//function FncTallerPedidoGastoBuscar(oCampo){
//	
//	var Dato = $('#CmpTallerPedidoGasto'+oCampo).val()
//	
//	if(Dato!=""){
//	
//		$.ajax({
//			type: 'POST',
//			dataType: 'json',
//			url: Ruta+'comunes/Documento/acc/AccGastoBuscar.php',
//			data: 'Campo='+oCampo+'&Dato='+Dato,
//			success: function(InsGasto){
//
//				if(InsGasto.GasId!="" && InsGasto.GasId!=null){
//					FncTallerPedidoGastoEscoger(InsGasto);
//				}else{
//					$('#CmpTallerPedidoGasto'+oCampo).focus();
//					$('#CmpTallerPedidoGasto'+oCampo).select();						
//				}
//
//			}
//		});
//		
//	}
//
//}

//
//function FncTallerPedidoGastoFormato(row) {			
//	
//	return "<td>"+row[2]+"</td><td>"+row[1]+"</td><td align='left'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[5]+"</td>";
//	
//}
//
//
//$(function(){
//	
//	$("#CmpTallerPedidoGastoNumeroComprobante").unautocomplete();
//	$("#CmpTallerPedidoGastoNumeroComprobante").autocomplete('comunes/Documento/XmlGasto.php?Campo=GasComprobanteNumero', {
//		width: 900,
//		max: 100,
//		formatItem: FncTallerPedidoGastoFormato,				
//		minChars: 3,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpTallerPedidoGastoNumeroComprobante").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpTallerPedidoGastoId").val(data[0]);				
//			FncFichaIngresoGastoBuscar("Id");	
//		}		
//	});
//});