// JavaScript Document


function FncOrdenVentaVehiculoSeguimientoLlamadaValidar(){
	
	var respuesta = true
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();

	if(FechaInicio==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar una fecha de inicio",
			callback: function(result){
				$("#CmpFechaInicio").focus();
			}
		});
					
		respuesta = false;
		
	}else if(FechaFin==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar una fecha fin",
			callback: function(result){
				$("#CmpFechaFin").focus();
			}
		});

		respuesta = false;
	}
	
	return respuesta;
	
}

$().ready(function() {

	$("#BtnVer").click(function(){
		if(FncOrdenVentaVehiculoSeguimientoLlamadaValidar()){
			FncOrdenVentaVehiculoSeguimientoLlamadaVer();
		}
	});
	
	$("#BtnImprimir").click(function(){
		if(FncOrdenVentaVehiculoSeguimientoLlamadaValidar()){
			FncOrdenVentaVehiculoSeguimientoLlamadaImprimir();
		}
	});
	
	$("#BtnExcel").click(function(){
		if(FncOrdenVentaVehiculoSeguimientoLlamadaValidar()){
			FncOrdenVentaVehiculoSeguimientoLlamadaGenerarExcel();
		}
	});

});



function FncOrdenVentaVehiculoSeguimientoLlamadaVer(){
	
	
	//if(FncOrdenVentaVehiculoSeguimientoLlamadaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Modalidad = $("#CmpModalidad").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		var Filtro = $("#CmpFiltro").val();
		
		//var OrdenVentaVehiculoId = $("#CmpOrdenVentaVehiculoId").val();
		
		//var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
		//var ClienteNombre = $("#CmpClienteNombre").val();
		//var ClienteId = $("#CmpClienteId").val();
		
		var SucursalId = $("#CmpSucursal").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
	
	
		$('#CapOrdenVentaVehiculoSeguimientoLlamada').html("Cargando...");	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculo/IfrOrdenVentaVehiculoSeguimientoLlamada.php',
			data: 'FechaInicio='+FechaInicio
			+'&FechaFin='+FechaFin
			
			//+'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId
			//+'&ClienteNumeroDocumento='+ClienteNumeroDocumento
			//+'&ClienteNombre='+ClienteNombre
			//+'&ClienteId='+ClienteId
			+'&SucursalId='+SucursalId
			+'&Filtro='+Filtro
			
			+'&VehiculoMarca='+VehiculoMarca
			+'&Modalidad='+Modalidad
			+'&IncluirCSI='+IncluirCSI
			+'&DiasTranscurridos='+DiasTranscurridos
			
		
		
			
			+'&Orden='+Orden
			+'&Sentido='+Sentido,
			success: function(html){
				$('#CapOrdenVentaVehiculoSeguimientoLlamada').html(html);	
				
				
				$('input[type=checkbox]').each(function () {
				
					if($(this).attr('etiqueta')=="fila"){
						
						var Sigla = $(this).val();
						var Motivo = $(this).attr('motivo')
					
						$("#BtnCSIDatos_"+Sigla).click(function(){
							
							dhtmlx.alert({
								title:"Aviso",
								type:"alert-error",
								text:Motivo,
								callback: function(result){
									
								}
							});	
							
						});
						
						
					}			 
				
				});
		
				
				
				
			}
		});

	//}

}


function FncOrdenVentaVehiculoSeguimientoLlamadaImprimir(oIndice){
	
	//if(FncOrdenVentaVehiculoSeguimientoLlamadaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Modalidad = $("#CmpModalidad").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		
		var Filtro = $("#CmpFiltro").val();
		
		
		
		//var OrdenVentaVehiculoId = $("#CmpOrdenVentaVehiculoId").val();
//		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
//		var ClienteNombre = $("#CmpClienteNombre").val();
//		var ClienteId = $("#CmpClienteId").val();
		
		var SucursalId = $("#CmpSucursal").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		
		FncPopUp("formularios/OrdenVentaVehiculo/IfrOrdenVentaVehiculoSeguimientoLlamada.php?FechaInicio="+FechaInicio+'&FechaFin='+FechaFin+'&FechaFin='+FechaFin+'&Filtro='+Filtro+'&VehiculoMarca='+VehiculoMarca+'&Modalidad='+Modalidad+'&IncluirCSI='+IncluirCSI+'&DiasTranscurridos='+DiasTranscurridos+'&SucursalId='+SucursalId+'&Orden='+Orden+'&Sentido='+Sentido+"&P=1");
		
	//}

}

function FncOrdenVentaVehiculoSeguimientoLlamadaGenerarExcel(oIndice){
	
	//if(FncOrdenVentaVehiculoSeguimientoLlamadaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Modalidad = $("#CmpModalidad").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		var Filtro = $("#CmpFiltro").val();
		
//		var OrdenVentaVehiculoId = $("#CmpOrdenVentaVehiculoId").val();
//		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
//		var ClienteNombre = $("#CmpClienteNombre").val();
		
		var SucursalId = $("#CmpSucursal").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
	
		FncPopUp("formularios/OrdenVentaVehiculo/IfrOrdenVentaVehiculoSeguimientoLlamada.php?FechaInicio="+FechaInicio+'&FechaFin='+FechaFin+'&FechaFin='+FechaFin+'&Filtro='+Filtro+'&VehiculoMarca='+VehiculoMarca+'&Modalidad='+Modalidad+'&IncluirCSI='+IncluirCSI+'&DiasTranscurridos='+DiasTranscurridos+'&SucursalId='+SucursalId+'&Orden='+Orden+'&Sentido='+Sentido+"&P=2");
		
	//}
	
}



function FncOrdenVentaVehiculoSeguimientoLlamadaNuevo(){


	
				
}







function FncOrdenVentaVehiculoVistaPreliminar(oId){
	
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
		
}


function FncOrdenVentaVehiculoSeguimientoClienteCargarFormulario(oOrdenVentaVehiculoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("OrdenVentaVehiculo","SeguimientoCliente",oOrdenVentaVehiculoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("OrdenVentaVehiculo","SeguimientoCliente",'Id='+oOrdenVentaVehiculoId)
	
}



function FncOrdenVentaVehiculoBuscar(){
	
	FncOrdenVentaVehiculoSeguimientoLlamadaVer();
	
}


function FncOrdenVentaVehiculoSeguimientoEnviarWhatsapp(oNumero,oTexto){
	
	dhtmlx.confirm("¡Recuerda tener abierto Whatsapp Web! "+ oNumero , function(result){
		if(result==true){		
			
			 window.open("https://wa.me/"+oNumero+"?text="+oTexto);
	 		
//			https://wa.me/15551234567?text=I'm%20interested%20in%20your%20car%20for%20sale
			
		}else{
			
		}
	});
	
		
	
}


function FncOrdenVentaVehiculoSeguimientoEnviarEmail(oEmail,oTitulo,oTexto){
	
	dhtmlx.confirm("¡Recuerda tener configurado tu Outlook! "+ oEmail , function(result){
		if(result==true){		
			
			
			$(location).attr('href', 'mailto:'+oEmail+'?subject='
                             + encodeURIComponent(oTitulo)
                             + "&body=" 
                             + encodeURIComponent(oTexto)
 		   );
	
			// window.open("https://wa.me/"+oNumero+"?text="+oTexto);
	 		

		}else{
			
		}
	});
	
		
	
}


function FncOrdenVentaVehiculoSeguimientoEnviarSms(oEmail,oTitulo,oTexto){
	
/*

SABADO 22 Y MIERCOLES 26

*/
/*
120
2100000
40000
50000
*/
	
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"¡Esta funcion no se encuentra habiltiada!",
			callback: function(result){
				
			}
		});
		
		
	//dhtmlx.confirm("¡Recuerda tener configurado tu Outlook! "+ oEmail , function(result){
//		if(result==true){		
//			
//			
//			$(location).attr('href', 'mailto:'+oEmail+'?subject='
//                             + encodeURIComponent(oTitulo)
//                             + "&body=" 
//                             + encodeURIComponent(oTexto)
// 		   );
//	
//			// window.open("https://wa.me/"+oNumero+"?text="+oTexto);
//	 		
//
//		}else{
//			
//		}
//	});
	
		
	
}
		 
function FncOrdenVentaVehiculoEncuestaCargarFormulario(oOrdenVentaVehiculoId){
	
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=EncuestaVenta&Form=Registrar&Dia=1&=","true","false","savedValues","REGISTRAR ENCUESTA","OrdenVentaVehiculoId="+oOrdenVentaVehiculoId)
							
}

		 
		 
		 
function FncCargarListadoContarEncuestas(){
	
	
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="fila"){
			
			var Sigla = $(this).val();
			var OrdenVentaVehiculoId = $(this).attr('ficha_ingreso');
			var FechaInicio = $(this).attr('fecha_inicio');
			var FechaFin = $(this).attr('fecha_fin');
			
			$.ajax({
				type: 'GET',
				url: 'formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoContarEncuestas.php',
				data: 'FechaInicio='+FechaInicio
				+'&FechaFin='+FechaFin
				
				+'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId,
				success: function(html){
					
					$('#CapTotalEncuestas_'+Sigla).html(html);	
					
				}
			});
			
		}			 
	
	});
					
					
}

function FncCargarListadoContarOrdenVentaVehiculoLlamadas(){
	
	
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="fila"){
			
			var Sigla = $(this).val();
			var OrdenVentaVehiculoId = $(this).attr('ficha_ingreso');
			var FechaInicio = $(this).attr('fecha_inicio');
			var FechaFin = $(this).attr('fecha_fin');
			
			$.ajax({
				type: 'GET',
				url: 'formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoContarOrdenVentaVehiculoLlamadas.php',
				data: 'FechaInicio='+FechaInicio
				+'&FechaFin='+FechaFin
				
				+'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId,
				success: function(html){
					
					$('#CapTotalOrdenVentaVehiculoLlamadas_'+Sigla).html(html);	
					
				}
			});
			
		}			 
	
	});
					
					
}
		 
function FncEncuestaVentaBuscar(){


	FncCargarListadoContarEncuestas();

	//FncCargarListadoContarOrdenVentaVehiculoLlamadas();
				
}

function FncOrdenVentaVehiculoSeguimientoCargar(){


	FncCargarListadoContarEncuestas();
	
	FncCargarListadoContarOrdenVentaVehiculoLlamadas();
				
}




