
/******************************************************************************/

function FncTallerPedidoAlmacenMovimientoEntradaNuevo(){
	
	$('#CmpAlmacenMovimientoEntradaId').val("");
	$('#CmpAlmacenMovimientoEntradaComprobanteNumero').val("");
	$('#CmpAlmacenMovimientoEntradaComprobanteFecha').val("");		
	$('#CmpAlmacenMovimientoEntradaConcepto').val("");	
	$('#CmpAlmacenMovimientoEntradaTotal').val("");
	
	$('#CmpProveedorNombre').val("");
	$('#CmpProveedorApellidoPaterno').val("");
	$('#CmpProveedorApellidoMaterno').val("");
	
	$('#CmpAlmacenMovimientoEntradaMonedaId').val("");
	$('#CmpAlmacenMovimientoEntradaMonedaNombre').val("");
	$('#CmpAlmacenMovimientoEntradaMonedaSimbolo').val("");	

	$('#CmpTallerPedidoAlmacenMovimientoEntradaItem').val("")
	
	
	$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Listo para registrar elementos');	
				
	$('#CmpAlmacenMovimientoEntradaComprobanteNumero').focus();	
			
	$('#CmpTallerPedidoAlmacenMovimientoEntradaAccion').val("AccTallerPedidoAlmacenMovimientoEntradaRegistrar.php");
	
	$('#CmpAlmacenMovimientoEntradaComprobanteNumero').removeAttr('readonly');
	
	$("#BtnAlmacenMovimientoEntradaEditar").hide();
	$("#BtnAlmacenMovimientoEntradaRegistrar").show();

}

function FncTallerPedidoAlmacenMovimientoEntradaGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpTallerPedidoAlmacenMovimientoEntradaAccion').val();		
	
	var AlmacenMovimientoEntradaId = $('#CmpAlmacenMovimientoEntradaId').val();
	var AlmacenMovimientoEntradaComprobanteNumero = $('#CmpAlmacenMovimientoEntradaComprobanteNumero').val();
	var AlmacenMovimientoEntradaComprobanteFecha = $('#CmpAlmacenMovimientoEntradaComprobanteFecha').val();
	var AlmacenMovimientoEntradaConcepto = $('#CmpAlmacenMovimientoEntradaConcepto').val();
	var AlmacenMovimientoEntradaTotal = $('#CmpAlmacenMovimientoEntradaTotal').val();
	
	var ProveedorNombre = $('#CmpProveedorNombre').val();
	var ProveedorApellidoPaterno = $('#CmpProveedorApellidoPaterno').val();
	var ProveedorApellidoMaterno = $('#CmpProveedorApellidoMaterno').val();
	
	var AlmacenMovimientoEntradaMonedaNombre = $('#CmpAlmacenMovimientoEntradaMonedaNombre').val();
	var AlmacenMovimientoEntradaMonedaSimbolo = $('#CmpAlmacenMovimientoEntradaMonedaSimbolo').val();
	var AlmacenMovimientoEntradaMonedaId = $('#CmpAlmacenMovimientoEntradaMonedaId').val();
	
	var AlmacenMovimientoEntradaFoto = $('#CmpAlmacenMovimientoEntradaFoto').val();
	
	var Item = $('#CmpTallerPedidoAlmacenMovimientoEntradaItem').val();
	
	if(AlmacenMovimientoEntradaComprobanteNumero==""){
		$('#CmpAlmacenMovimientoEntradaComprobanteNumero').select();	
	}else{
		
		$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Guardando...');

			$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&AlmacenMovimientoEntradaComprobanteNumero='+AlmacenMovimientoEntradaComprobanteNumero+
			'&AlmacenMovimientoEntradaComprobanteFecha='+AlmacenMovimientoEntradaComprobanteFecha+
			'&AlmacenMovimientoEntradaConcepto='+AlmacenMovimientoEntradaConcepto+
			'&AlmacenMovimientoEntradaId='+AlmacenMovimientoEntradaId+
			'&AlmacenMovimientoEntradaTotal='+AlmacenMovimientoEntradaTotal+
			'&ProveedorNombre='+ProveedorNombre+
			'&ProveedorApellidoPaterno='+ProveedorApellidoPaterno+
			'&ProveedorApellidoMaterno='+ProveedorApellidoMaterno+
			
			'&AlmacenMovimientoEntradaMonedaSimbolo='+AlmacenMovimientoEntradaMonedaSimbolo+
			'&AlmacenMovimientoEntradaMonedaNombre='+AlmacenMovimientoEntradaMonedaNombre+
			'&AlmacenMovimientoEntradaMonedaId='+AlmacenMovimientoEntradaMonedaId+
			
			'&AlmacenMovimientoEntradaFoto='+AlmacenMovimientoEntradaFoto+
			
			'&Item='+Item,
			success: function(){
			  
			$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Listo');							
			  FncTallerPedidoAlmacenMovimientoEntradaListar();
			}
		  
		});
			
		FncTallerPedidoAlmacenMovimientoEntradaNuevo();	
	
	}

}


function FncTallerPedidoAlmacenMovimientoEntradaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoAlmacenMovimientoEntradaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TallerPedidoAlmacenMovimientoEntradaEditar+'&Eliminar='+TallerPedidoAlmacenMovimientoEntradaEliminar,
		success: function(html){
			$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Listo');	

			$("#CapTallerPedidoAlmacenMovimientoEntradas").html("");
			$("#CapTallerPedidoAlmacenMovimientoEntradas").append(html);
		}
	});

}


function FncTallerPedidoAlmacenMovimientoEntradaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Editando...');
	$('#CmpTallerPedidoAlmacenMovimientoEntradaAccion').val("AccTallerPedidoAlmacenMovimientoEntradaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoAlmacenMovimientoEntradaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsTallerPedidoAlmacenMovimientoEntrada){
	
			//SesionObjeto-TallerPedidoAlmacenMovimientoEntrada
			//Parametro1 = FigId
			//Parametro2 = AmoId
			//Parametro3 = AmoComprobanteNumero
			//Parametro4 = AmoComprobanteFecha
			//Parametro5 = AmoTotal
			//Parametro6 = FigEstado
			//Parametro7 = FigTiempoCreacion
			//Parametro8 = FigTiempoModificacion
			//Parametro9 = PrvNombre
			//Parametro10 = PrvApellidoPaterno
			//Parametro11 = PrvApellidoMaterno
			//Parametro12 = 
			//Parametro13 = 
			//Parametro14 = 
	
			$('#CmpTallerPedidoAlmacenMovimientoEntradaId').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro1);
			
			$('#CmpAlmacenMovimientoEntradaId').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro2);			
			$('#CmpAlmacenMovimientoEntradaComprobanteNumero').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro3);
			$('#CmpAlmacenMovimientoEntradaComprobanteFecha').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro4);
			$('#CmpAlmacenMovimientoEntradaConcepto').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro17);
			$('#CmpAlmacenMovimientoEntradaTotal').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro5);
			
			$('#CmpProveedorNombre').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro9);
			$('#CmpProveedorApellidoPaterno').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro10);
			$('#CmpProveedorApellidoMaterno').val(InsTallerPedidoAlmacenMovimientoEntrada.Parametro11);
			
			$('#CmpTallerPedidoAlmacenMovimientoEntradaItem').val(InsTallerPedidoAlmacenMovimientoEntrada.Item);
	
		}
	});
	

	$('#CmpAlmacenMovimientoEntradaComprobanteNumero').select();

	//$('#CmpAlmacenMovimientoEntradaNombre').attr('readonly', true);
	///$('#CmpAlmacenMovimientoEntradaComprobanteNumero').attr('readonly', true);
	
	
	$("#BtnAlmacenMovimientoEntradaEditar").show();
	$("#BtnAlmacenMovimientoEntradaRegistrar").hide();
	
	
}

function FncTallerPedidoAlmacenMovimientoEntradaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoAlmacenMovimientoEntradaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html("Eliminado");	
				FncTallerPedidoAlmacenMovimientoEntradaListar();
			}
		});

		FncTallerPedidoAlmacenMovimientoEntradaNuevo();

	}
	
}



function FncTallerPedidoAlmacenMovimientoEntradaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoAlmacenMovimientoEntradaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapTallerPedidoAlmacenMovimientoEntradaAccion').html('Eliminado');	
				FncTallerPedidoAlmacenMovimientoEntradaListar();
			}
		});	
			
		FncTallerPedidoAlmacenMovimientoEntradaNuevo();
	}
	
}



/*
* GASTOS
*/

//$(function(){
//
//	$("#BtnTallerPedidoAlmacenMovimientoEntradaEditar").hide();
//	$("#BtnTallerPedidoAlmacenMovimientoEntradaRegistrar").show();
//	
//});
//
//function FncTallerPedidoAlmacenMovimientoEntradaNuevo(){
//
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaId').val("");
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaNumeroComprobante').val("");
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaFecha').val("");
//	$('#CmpTallerPedidoProveedorNombre').val("");
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaTotal').val("");
//
//	$("#BtnTallerPedidoAlmacenMovimientoEntradaEditar").hide();
//	$("#BtnTallerPedidoAlmacenMovimientoEntradaRegistrar").show();
//
//}
//
//function FncTallerPedidoAlmacenMovimientoEntradaEscoger(InsTallerPedidoAlmacenMovimientoEntrada){	
//
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaId').val(InsTallerPedidoAlmacenMovimientoEntrada.FigId);
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaNumeroComprobante').val(InsTallerPedidoAlmacenMovimientoEntrada.AmoComprobanteNumero);
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaFecha').val(InsTallerPedidoAlmacenMovimientoEntrada.AmoComprobanteFecha);
//	$('#CmpTallerPedidoProveedorNombre').val(InsTallerPedidoAlmacenMovimientoEntrada.PrvNombre+" "+InsTallerPedidoAlmacenMovimientoEntrada.PrvApellidoPaterno+" "+InsTallerPedidoAlmacenMovimientoEntrada.PrvApellidoMaterno);
//	$('#CmpTallerPedidoAlmacenMovimientoEntradaTotal').val(InsTallerPedidoAlmacenMovimientoEntrada.FigTotal);
//	
//	$("#BtnTallerPedidoAlmacenMovimientoEntradaEditar").show();
//	$("#BtnTallerPedidoAlmacenMovimientoEntradaRegistrar").hide();
//
//}
//
//
//function FncTallerPedidoAlmacenMovimientoEntradaBuscar(oCampo){
//	
//	var Dato = $('#CmpTallerPedidoAlmacenMovimientoEntrada'+oCampo).val()
//	
//	if(Dato!=""){
//	
//		$.ajax({
//			type: 'POST',
//			dataType: 'json',
//			url: Ruta+'comunes/Documento/acc/AccAlmacenMovimientoEntradaBuscar.php',
//			data: 'Campo='+oCampo+'&Dato='+Dato,
//			success: function(InsAlmacenMovimientoEntrada){
//
//				if(InsAlmacenMovimientoEntrada.AmoId!="" && InsAlmacenMovimientoEntrada.AmoId!=null){
//					FncTallerPedidoAlmacenMovimientoEntradaEscoger(InsAlmacenMovimientoEntrada);
//				}else{
//					$('#CmpTallerPedidoAlmacenMovimientoEntrada'+oCampo).focus();
//					$('#CmpTallerPedidoAlmacenMovimientoEntrada'+oCampo).select();						
//				}
//
//			}
//		});
//		
//	}
//
//}

//
//function FncTallerPedidoAlmacenMovimientoEntradaFormato(row) {			
//	
//	return "<td>"+row[2]+"</td><td>"+row[1]+"</td><td align='left'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[5]+"</td>";
//	
//}
//
//
//$(function(){
//	
//	$("#CmpTallerPedidoAlmacenMovimientoEntradaNumeroComprobante").unautocomplete();
//	$("#CmpTallerPedidoAlmacenMovimientoEntradaNumeroComprobante").autocomplete('comunes/Documento/XmlAlmacenMovimientoEntrada.php?Campo=AmoComprobanteNumero', {
//		width: 900,
//		max: 100,
//		formatItem: FncTallerPedidoAlmacenMovimientoEntradaFormato,				
//		minChars: 3,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpTallerPedidoAlmacenMovimientoEntradaNumeroComprobante").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpTallerPedidoAlmacenMovimientoEntradaId").val(data[0]);				
//			FncFichaIngresoAlmacenMovimientoEntradaBuscar("Id");	
//		}		
//	});
//});