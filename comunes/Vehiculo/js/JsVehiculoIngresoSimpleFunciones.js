// JavaScript Document

$().ready(function() {	

	if($("#CmpVehiculoIngresoId").val()==""){
		$("#BtnVehiculoIngresoEditar").hide();
		$("#BtnVehiculoIngresoRegistrar").show();
	}else{
		$("#BtnVehiculoIngresoEditar").show();
		$("#BtnVehiculoIngresoRegistrar").hide();
	}
	
	$("#CmpVehiculoIngresoVIN").keypress(function (event) {  
	
		if (event.keyCode == '13' && this.value != "" && $("#CmpVehiculoIngresoVIN").val()=="") {
			FncVehiculoIngresoSimpleBuscar("VIN");
		}
		
		if($.trim($("#CmpVehiculoIngresoVIN").val())==""){
			
			if($.trim($("#CmpVehiculoIngresoId").val())!=""){
				FncVehiculoIngresoSimpleNuevo();
			}
			
		}
			
	}); 
	
	$("select#CmpVehiculoVersion").change(function(){

		FncVehiculoBuscar("Version");
				
	});
	
});	
	
function FncVehiculoIngresoSimpleNuevo(){
	
	$('#CmpVehiculoIngresoId').val("");
	$('#CmpVehiculoIngresoVIN').val("");	
	$("#CmpVehiculoIngresoPlaca").val("");

	$("#CmpVehiculoIngresoMarca").val("");
	$("#CmpVehiculoIngresoModelo").val("");
	$("#CmpVehiculoIngresoVersion").val("");

	$("#CmpVehiculoIngresoMarcaId").val("");
	$("#CmpVehiculoIngresoModeloId").val("");
	$("#CmpVehiculoIngresoVersionId").val("");

	$("#CmpVehiculoIngresoColor").val("");
	$("#CmpVehiculoIngresoAnoFabricacion").val("");
	$("#CmpVehiculoIngresoAnoModelo").val("");
	$("#CmpVehiculoIngresoAnoVehiculo").val("");

	$("#CmpVehiculoIngresoNumeroMotor").val("");


	$("#CmpVehiculoIngresoClienteId").val("");

	/*
	* POPUP REGISTRAR/EDITAR
	*/			
	$("#BtnVehiculoIngresoEditar").hide();
	$("#BtnVehiculoIngresoRegistrar").show();

	FncVehiculoIngresoSimpleNuevoFuncion();

}

function FncVehiculoIngresoSimpleNuevoFuncion(){
	
}




function FncVehiculoIngresoSimpleMarcaNuevo(){

	$("#CmpVehiculoIngresoModelo").val("");
	$("#CmpVehiculoIngresoVersion").val("");

	$("#CmpVehiculoIngresoModelo").html("");
	$("#CmpVehiculoIngresoVersion").html("");

	$("#CmpVehiculoIngresoModeloId").val("");
	$("#CmpVehiculoIngresoVersionId").val("");

}

function FncVehiculoIngresoSimpleModeloNuevo(){
	
	$("#CmpVehiculoIngresoVersion").val("");
	$("#CmpVehiculoIngresoVersion").html("");
	$("#CmpVehiculoIngresoVersionId").val("");

}



function FncVehiculoIngresoSimpleBuscar(oCampo){

	var Dato = $('#CmpVehiculoIngreso'+oCampo).val();
	
	if(Dato==""){
		$('#CmpVehiculoIngreso'+oCampo).focus();
		$('#CmpVehiculoIngreso'+oCampo).select();		
	}else{
				
		$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Vehiculo/acc/AccVehiculoIngresoBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsVehiculoIngreso){
				if(InsVehiculoIngreso.EinId!=null){		
							
					$('.error').text("Listo").fadeIn(400).delay(1500).fadeOut(400);
					//FncVehiculoIngresoSimpleEscoger(InsVehiculoIngreso.EinId,InsVehiculoIngreso.EinVIN,InsVehiculoIngreso.EinPlaca,InsVehiculoIngreso.EinColor,InsVehiculoIngreso.EinAnoFabricacion,InsVehiculoIngreso.VmaId,InsVehiculoIngreso.VmoId,InsVehiculoIngreso.VveId ,InsVehiculoIngreso.VmaNombre,InsVehiculoIngreso.VmoNombre,InsVehiculoIngreso.VveNombre,InsVehiculoIngreso.CliId,InsVehiculoIngreso.EinAnoVehiculo,InsVehiculoIngreso.EinAnoModelo,InsVehiculoIngreso.EinNumeroMotor,InsVehiculoIngreso.OvvId,InsVehiculoIngreso.EinFechaVenta,InsVehiculoIngreso.EinCantidadMantenimientos);
					FncVehiculoIngresoSimpleEscoger(InsVehiculoIngreso);
					
				}
			}
		});	
	}


}


//function FncVehiculoIngresoSimpleEscoger(oVehiculoIngresoId,oVehiculoIngresoVIN,oVehiculoIngresoPlaca,oVehiculoColor,oVehiculoIngresoAnoFabricacion,oVehiculoIngresoMarcaId,oVehiculoIngresoModeloId,oVehiculoIngresoVersionId,oVehiculoMarca,oVehiculoModelo,oVehiculoVersion,oVehiculoIngresoClienteId,oVehiculoIngresoAnoVehiculo,oVehiculoIngresoAnoModelo,oVehiculoIngresoNumeroMotor,oOrdenVentaVehiculoId,oVehiculoIngresoFechaVenta,oVehiculoIngresoCantidadMantenimientos){

function FncVehiculoIngresoSimpleEscoger(InsVehiculoIngreso){
	
	$('#CapVehiculoIngresoBuscar').html('');
	
	$('#CmpVehiculoIngresoId').val(InsVehiculoIngreso.EinId);
	$('#CmpVehiculoIngresoVIN').val(InsVehiculoIngreso.EinVIN);
	$("#CmpVehiculoIngresoPlaca").val(InsVehiculoIngreso.EinPlaca);

	$("#CmpVehiculoIngresoMarca").val(InsVehiculoIngreso.VmaNombre);
	$("#CmpVehiculoIngresoModelo").val(InsVehiculoIngreso.VmoNombre);
	$("#CmpVehiculoIngresoVersion").val(InsVehiculoIngreso.VveNombre);
	
	$("#CmpVehiculoIngresoMarcaId").val(InsVehiculoIngreso.VmaId);
	$("#CmpVehiculoIngresoModeloId").val(InsVehiculoIngreso.VmoId);
	$("#CmpVehiculoIngresoVersionId").val(InsVehiculoIngreso.VveId);
	
	$("#CmpVehiculoIngresoColor").val(InsVehiculoIngreso.EinColor);
	$("#CmpVehiculoIngresoColorInterior").val(InsVehiculoIngreso.EinColorInterior);
	$("#CmpVehiculoIngresoAnoFabricacion").val(InsVehiculoIngreso.EinAnoFabricacion);
	$("#CmpVehiculoIngresoAnoModelo").val(InsVehiculoIngreso.EinAnoModelo);
	$("#CmpVehiculoIngresoAnoVehiculo").val(InsVehiculoIngreso.EinAnoVehiculo);
	$("#CmpVehiculoIngresoNumeroMotor").val(InsVehiculoIngreso.EinNumeroMotor);

	$("#CmpVehiculoIngresoClienteId").val(InsVehiculoIngreso.CliId);

	

//	$("#CmpVehiculoMarcaId").val(InsVehiculoIngreso.VmaId);
//	$("#CmpVehiculoModeloId").val(InsVehiculoIngreso.VmoId);
//	$("#CmpVehiculoVersionId").val(InsVehiculoIngreso.VveId);
//	
//	$("#CmpVehiculoMarca").val(InsVehiculoIngreso.VmaId);
//	$("#CmpVehiculoModelo").val(InsVehiculoIngreso.VmoId);
//	$("#CmpVehiculoVersion").val(InsVehiculoIngreso.VveId);
//	
//	
//	$("#CmpAnoModelo").val(InsVehiculoIngreso.EinAnoModelo);
//	$("#CmpColor").val(InsVehiculoIngreso.EinColor);
	
	//$("#CmpOrdenVentaVehiculoId").val(InsVehiculoIngreso.OvvId);
	
	$("#CmpVehiculoIngresoFechaVenta").val(InsVehiculoIngreso.EinFechaVenta);
	$("#CmpVehiculoIngresoCantidadMantenimientos").val(InsVehiculoIngreso.EinCantidadMantenimientos);
	
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnVehiculoIngresoEditar").show();
	$("#BtnVehiculoIngresoRegistrar").hide();

	FncVehiculoIngresoSimpleFuncion(InsVehiculoIngreso);

	//tb_remove();
}

function FncVehiculoIngresoSimpleFuncion(InsVehiculoIngreso){
	
}







//
//function FncVehiculoIngresoSimpleGuardarSimple(){
//
//	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
//	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
//	
//	var VehiculoMarcaId = $('#CmpVehiculoMarca').val();
//	var VehiculoModeloId = $('#CmpVehiculoModelo').val();
//	var VehiculoVersionId = $('#CmpVehiculoVersion').val();
//	
//	var VehiculoIngresoColor = $('#CmpVehiculoIngresoColor').val();
//	
//	var VehiculoIngresoNumeroMotor = $('#CmpVehiculoIngresoNumeroMotor').val();
//	
//	var VehiculoIngresoAnoFabricacion = $('#CmpVehiculoIngresoAnoFabricacion').val();
//	var VehiculoIngresoAnoModelo = $('#CmpVehiculoIngresoAnoModelo').val();
//	
//	if(VehiculoIngresoVIN==""){
//		alert("No ha ingreso un VIN");
//	}else if(VehiculoMarcaId==""){
//		alert("No ha escogido una MARCA");
//	}else if(VehiculoModeloId == ""){
//		alert("No ha escogido un MODELO");
//	}else if(VehiculoVersionId == ""){
//		alert("No ha escogido una VERSION");
//	}else if(VehiculoIngresoAnoFabricacion==""){
//		alert("No ha ingresado el AÑO DE FABRICACION");
//	}else if(VehiculoIngresoAnoModelo==""){
//		alert("No ha ingresado el AÑO DE MODELO");
//	}else{
//
//		$.ajax({
//			type: 'POST',
//			url: 'comunes/Vehiculo/acc/AccVehiculoIngresoRegistrar.php',
//			data: 'VehiculoIngresoId='+VehiculoIngresoId+'&VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoMarcaId='+VehiculoMarcaId+'&VehiculoModeloId='+VehiculoModeloId+'&VehiculoVersionId='+VehiculoVersionId+'&VehiculoIngresoColor='+VehiculoIngresoColor+'&VehiculoIngresoAnoFabricacion='+VehiculoIngresoAnoFabricacion+'&VehiculoIngresoAnoModelo='+VehiculoIngresoAnoModelo+'&VehiculoIngresoNumeroMotor='+VehiculoIngresoNumeroMotor,
//			success: function(oRespuesto){
//
//				if(oRespuesto!="2"){
//					$('#CmpVehiculoIngresoId').val(oRespuesto);
//					FncVehiculoIngresoSimpleGuardarSimpleFuncion();
//				}
//
//			}
//		});
//		
//	}
//	
////	tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form='+oForm+'&Dia=1&Id='+VehiculoIngresoId+'&VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoMarcaId='+VehiculoMarcaId+'&VehiculoModeloId='+VehiculoModeloId+'&VehiculoVersionId='+VehiculoVersionId+'&VehiculoIngresoColor='+VehiculoIngresoColor+'&VehiculoIngresoAnoFabricacion='+VehiculoIngresoAnoFabricacion+'&VehiculoIngresoAnoModelo='+VehiculoIngresoAnoModelo+'&VehiculoIngresoNumeroMotor='+VehiculoIngresoNumeroMotor+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
//
//}


//function FncVehiculoIngresoSimpleGuardarSimpleFuncion(){
//	
//}


/*
* Funciones PopUp Formulario
*/

function FncVehiculoIngresoSimpleCargarFormulario(oForm){

	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	
	var VehiculoMarcaId = $('#CmpVehiculoMarca').val();
	var VehiculoModeloId = $('#CmpVehiculoModelo').val();
	var VehiculoVersionId = $('#CmpVehiculoVersion').val();
	
	var VehiculoIngresoColor = $('#CmpVehiculoIngresoColor').val();
	
	var VehiculoIngresoNumeroMotor = $('#CmpVehiculoIngresoNumeroMotor').val();
	
	var VehiculoIngresoAnoFabricacion = $('#CmpVehiculoIngresoAnoFabricacion').val();
	var VehiculoIngresoAnoModelo = $('#CmpVehiculoIngresoAnoModelo').val();

	var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.3));
	Alto = Alto - (Alto*(0.2));
	
	tb_show(this.title,'principal2.php?Mod=VehiculoIngresoSimple&Form='+oForm+'&Dia=1&Id='+VehiculoIngresoId+'&VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoMarcaId='+VehiculoMarcaId+'&VehiculoModeloId='+VehiculoModeloId+'&VehiculoVersionId='+VehiculoVersionId+'&VehiculoIngresoColor='+VehiculoIngresoColor+'&VehiculoIngresoAnoFabricacion='+VehiculoIngresoAnoFabricacion+'&VehiculoIngresoAnoModelo='+VehiculoIngresoAnoModelo+'&VehiculoIngresoNumeroMotor='+VehiculoIngresoNumeroMotor+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(Alto)+'&width='+(Ancho)+'&modal=true',this.rel);		

	

}

function FncTBCerrarFunncion(oModulo){

	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			try{
				eval("Fnc"+oModulo+"Buscar('Id');");		
			}catch(e){
				
			}	
		}
	}
	
}

/*
* Funciones PopUp Listado
*/

function FncVehiculoIngresoSimpleFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;

	else if(e) keyCode=e.which;

	if (keyCode==13){	
		FncVehiculoIngresoSimpleFiltrar2();	
	}

}

function FncVehiculoIngresoSimpleFiltrar2(){
	
	var Categoria = $('#CmpVehiculoIngresoCategoria').val();
	var Campo = $('#CmpVehiculoIngresoCampo').val();
	var Condicion = $('#CmpVehiculoIngresoCondicion').val();
	var Filtro = $('#CmpFiltro').val();

	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: 'comunes/Vehiculo/FrmVehiculoIngresoListado.php',
		data: 'Categoria='+Categoria+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		success: function(html){
			$("#CapVehiculoIngresos").html("");
			$("#CapVehiculoIngresos").append(html);
		}
	});

}


function FncVehiculoIngresoSimpleListadorEscoger(oVehiculoIngresoId){
	
	$('#CmpVehiculoIngresoId').val(oVehiculoIngresoId);
	FncVehiculoIngresoSimpleBuscar("Id");
	tb_remove();
}


