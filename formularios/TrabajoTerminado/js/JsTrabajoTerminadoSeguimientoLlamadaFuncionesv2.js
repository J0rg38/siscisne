// JavaScript Document


function FncTrabajoTerminadoSeguimientoLlamadaValidar(){
	
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
		if(FncTrabajoTerminadoSeguimientoLlamadaValidar()){
			FncTrabajoTerminadoSeguimientoLlamadaVer();
		}
	});
	
	$("#BtnImprimir").click(function(){
		if(FncTrabajoTerminadoSeguimientoLlamadaValidar()){
			FncTrabajoTerminadoSeguimientoLlamadaImprimir();
		}
	});
	
	$("#BtnExcel").click(function(){
		if(FncTrabajoTerminadoSeguimientoLlamadaValidar()){
			FncTrabajoTerminadoSeguimientoLlamadaGenerarExcel();
		}
	});

});



function FncTrabajoTerminadoSeguimientoLlamadaVer(){
	
	
	//if(FncTrabajoTerminadoSeguimientoLlamadaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Modalidad = $("#CmpModalidad").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		var Filtro = $("#CmpFiltro").val();
		
		//var FichaIngresoId = $("#CmpFichaIngresoId").val();
		
		//var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
		//var ClienteNombre = $("#CmpClienteNombre").val();
		//var ClienteId = $("#CmpClienteId").val();
		
		var SucursalId = $("#CmpSucursal").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
	
	
		$('#CapTrabajoTerminadoSeguimientoLlamada').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/TrabajoTerminado/IfrTrabajoTerminadoSeguimientoLlamada.php',
			data: 'FechaInicio='+FechaInicio
			+'&FechaFin='+FechaFin
			
			//+'&FichaIngresoId='+FichaIngresoId
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
				$('#CapTrabajoTerminadoSeguimientoLlamada').html(html);	
				
				
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


function FncTrabajoTerminadoSeguimientoLlamadaImprimir(oIndice){
	
	//if(FncTrabajoTerminadoSeguimientoLlamadaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Modalidad = $("#CmpModalidad").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		var Filtro = $("#CmpFiltro").val();
		
		
		//var FichaIngresoId = $("#CmpFichaIngresoId").val();
//		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
//		var ClienteNombre = $("#CmpClienteNombre").val();
//		var ClienteId = $("#CmpClienteId").val();
		
		var SucursalId = $("#CmpSucursal").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		
		FncPopUp("formularios/TrabajoTerminado/IfrTrabajoTerminadoSeguimientoLlamada.php?FechaInicio="+FechaInicio+'&FechaFin='+FechaFin+'&FechaFin='+FechaFin+'&Filtro='+Filtro+'&VehiculoMarca='+VehiculoMarca+'&Modalidad='+Modalidad+'&IncluirCSI='+IncluirCSI+'&DiasTranscurridos='+DiasTranscurridos+'&SucursalId='+SucursalId+'&Orden='+Orden+'&Sentido='+Sentido+"&P=1");
		
	//}

}

function FncTrabajoTerminadoSeguimientoLlamadaGenerarExcel(oIndice){
	
	//if(FncTrabajoTerminadoSeguimientoLlamadaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Modalidad = $("#CmpModalidad").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		var Filtro = $("#CmpFiltro").val();
		
//		var FichaIngresoId = $("#CmpFichaIngresoId").val();
//		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
//		var ClienteNombre = $("#CmpClienteNombre").val();
		
		var SucursalId = $("#CmpSucursal").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
	
		FncPopUp("formularios/TrabajoTerminado/IfrTrabajoTerminadoSeguimientoLlamada.php?FechaInicio="+FechaInicio+'&FechaFin='+FechaFin+'&FechaFin='+FechaFin+'&Filtro='+Filtro+'&VehiculoMarca='+VehiculoMarca+'&Modalidad='+Modalidad+'&IncluirCSI='+IncluirCSI+'&DiasTranscurridos='+DiasTranscurridos+'&SucursalId='+SucursalId+'&Orden='+Orden+'&Sentido='+Sentido+"&P=2");
		
	//}
	
}



function FncTrabajoTerminadoSeguimientoLlamadaNuevo(){


	
				
}







function FncTrabajoTerminadoVistaPreliminar(oId){
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario\n 4 = Acta de Entrega ", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":

				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "4":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirActaEntrega.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
	
		}
		
	}

}


function FncTrabajoTerminadoSeguimientoClienteCargarFormulario(oFichaIngresoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("FichaIngreso","SeguimientoCliente",'Id='+oFichaIngresoId)
	
}



function FncFichaIngresoBuscar(){
	
	FncTrabajoTerminadoSeguimientoLlamadaVer();
	
}


function FncTrabajoTerminadoSeguimientoEnviarWhatsapp(oNumero,oTexto){
	
	dhtmlx.confirm("¡Recuerda tener abierto Whatsapp Web! "+ oNumero , function(result){
		if(result==true){		
			
			 window.open("https://wa.me/"+oNumero+"?text="+oTexto);
	 		
//			https://wa.me/15551234567?text=I'm%20interested%20in%20your%20car%20for%20sale
			
		}else{
			
		}
	});
	
		
	
}


function FncTrabajoTerminadoSeguimientoEnviarEmail(oEmail,oTitulo,oTexto){
	
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


function FncTrabajoTerminadoSeguimientoEnviarSms(oEmail,oTitulo,oTexto){
	
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
		 
function FncTrabajoTerminadoEncuestaCargarFormulario(oFichaIngresoId){
	
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Encuesta&Form=Registrar&Dia=1&=","true","false","savedValues","REGISTRAR ENCUESTA","FichaIngresoId="+oFichaIngresoId)
							
}

		 
		 
		 
function FncCargarListadoContarEncuestas(){
	
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="fila"){
			
			var Sigla = $(this).val();
			var FichaIngresoId = $(this).attr('ficha_ingreso');
			var FechaInicio = $(this).attr('fecha_inicio');
			var FechaFin = $(this).attr('fecha_fin');
			
			$.ajax({
				type: 'GET',
				url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoContarEncuestas.php',
				data: 'FechaInicio='+FechaInicio
				+'&FechaFin='+FechaFin				
				+'&FichaIngresoId='+FichaIngresoId,
				success: function(html){
					
					$('#CapTotalEncuestas_'+Sigla).html(html);	
					
				}
			});
			
		}			 
	
	});
					
					
}

function FncCargarListadoContarFichaIngresoLlamadas(){
	
	
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="fila"){
			
			var Sigla = $(this).val();
			var FichaIngresoId = $(this).attr('ficha_ingreso');
			var FechaInicio = $(this).attr('fecha_inicio');
			var FechaFin = $(this).attr('fecha_fin');
			
			$.ajax({
				type: 'GET',
				url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoContarFichaIngresoLlamadas.php',
				data: 'FechaInicio='+FechaInicio
				+'&FechaFin='+FechaFin
				
				+'&FichaIngresoId='+FichaIngresoId,
				success: function(html){
					
					$('#CapTotalFichaIngresoLlamadas_'+Sigla).html(html);	
					
				}
			});
			
		}			 
	
	});
					
					
}
		 
function FncEncuestaBuscar(){


	FncCargarListadoContarEncuestas();

	//FncCargarListadoContarFichaIngresoLlamadas();
				
}

function FncFichaIngresoSeguimientoCargar(){

	FncCargarListadoContarEncuestas();

	FncCargarListadoContarFichaIngresoLlamadas();
				
}




