// JavaScript Document
var Recepcion = "1";

//function FncGuardar(){
//	
//	//HACK
//	$("#CmpEstado").removeAttr('disabled');		
//	
//}

function FncValidar(){

	var Fecha = $("#CmpFecha").val();
	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
	
	var MonedaId = $("#CmpMonedaId").val();
	var Total = $("#CmpTotal").val();
	
		if(Fecha == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha ",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
		
		}else if(VehiculoIngresoVIN == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un VIN",
					callback: function(result){
						$("#CmpVehiculoIngresoVIN").focus();
					}
				});
				
			return false;
			
		}else if(MonedaId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});
				
			return false;
	

		}else if(Total == "" || Total == "0.00"){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una duracion ",
					callback: function(result){
						$("#CmpDuracion").focus();
					}
				});

			return false;

		}else if(FncValidarPersonalHoraVehiculoIngresoEvento()==false){

			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"El horario esta ocupado en este turno",
					callback: function(result){
						$("#CmpHoraProgramada").focus();
					}
				});
				
				return false;
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');		
		$("#CmpEstado").removeAttr('disabled');	
		$("#CmpSucursal").removeAttr('disabled');	
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
		$("#CmpSucursal").removeAttr('disabled');	
		
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	$('#BtnValidarVehiculoIngresoEvento').on('click', function() {
		
		FncValidarPersonalHoraVehiculoIngresoEvento();
		
	});
	
	
	
	$('#BtnVehiculoIngresoEventoCalendario').on('click', function() {

		FncVehiculoIngresoEventoCalendarioCargarFormulario();

	});
	
	$('#BtnVehiculoIngresoEventoVerRestricciones').on('click', function() {

		FncVehiculoIngresoEventoVerRestriccionesoCargarFormulario();

	});
	
	
	
//	$('#CmpPersonalMecanico').on('change', function() {
//
//		
//
//	});
	
	$( "#CmpPersonalMecanico" ).change(function() {
		FncCargarPersonalHorario();
	});

	FncVehiculoIngresoEventoMantenimientoKilometrajeEstablecer();
	
	
	
	$('#CmpSucursal').on('change', function() {
	
		FncPersonalesCargar();	
		FncPersonalTecnicosCargar();
		
	});
	
	
	$("select#CmpMonedaId").change(function(){
		FncVehiculoIngresoEventoEstablecerMoneda();
	});

	
});


function FncClienteSimpleFuncion(InsCliente){
	
	if(InsCliente.EinId!=null && InsCliente.EinId!=""){
		
		//$("#CmpVehiculoIngresoId").val(InsCliente.EinId);	
//		
//		FncVehiculoIngresoSimpleBuscar("Id");
		
		var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();		
		
		if(VehiculoIngresoId==""){
			$("#CmpVehiculoIngresoId").val(InsCliente.EinId);	
			FncVehiculoIngresoSimpleBuscar("Id");
		}
		

	}else{
		//FncVehiculoIngresoSimpleNuevo();
	}
	
}


function FncClienteSimpleBuscar(oCampo){

	var Dato = $('#CmpCliente'+oCampo).val();
	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();

	if(Dato==""){
		$('#CmpCliente'+oCampo).focus();
		$('#CmpCliente'+oCampo).select();		
	}else{

		//////$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Cliente/acc/AccClienteBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(InsCliente){

				if(InsCliente.CliId!=null){					
					
					//////$('.error').text("Listo").fadeIn(400).delay(1500).fadeOut(400);
					
						FncClienteSimpleEscoger(InsCliente);				//FncClienteSimpleEscoger(InsCliente.CliId,InsCliente.CliNumeroDocumento,InsCliente.CliNombreCompleto,InsCliente.TdoId,InsCliente.CliTelefono,InsCliente.CliCelular,InsCliente.CliDireccion,InsCliente.LtiId,InsCliente.LtiUtilidad,InsCliente.CliEmail,InsCliente.EinId,InsCliente.MonId,InsCliente.LtiMargenUtilidad,InsCliente.CliDistrito,InsCliente.CliProvincia,InsCliente.CliDepartamento,InsCliente.LtiPorcentajeDescuento);
				}

			}
		});	
	}

}

function FncClienteSimpleFuncion(InsCliente){
	
	console.log("FncClienteSimpleFuncion");
	
	if(InsCliente.EinId!=""){
		
		$("#CmpVehiculoIngresoId").val(InsCliente.EinId);	
		FncVehiculoIngresoSimpleBuscar("Id");
	}
	
	
}


function FncVehiculoIngresoSimpleNuevoFuncion(){
	
	$("#CmpVehiculoMarcaId").val("");
	$("#CmpVehiculoModeloId").val("");
	$("#CmpVehiculoVersionId").val("");
	
	
	$("#CmpVehiculoMarca").val("");
	$("#CmpVehiculoModelo").val("");
	$("#CmpVehiculoVersion").val("");
	$("#CmpVehiculoIngresoPlaca").val("");
		
		
}

function FncVehiculoIngresoSimpleFuncion(InsVehiculoIngreso){
	
	console.log("FncVehiculoIngresoSimpleFuncion");
	
	$("#CmpVehiculoMarcaId").val(InsVehiculoIngreso.VmaId);
	$("#CmpVehiculoModeloId").val(InsVehiculoIngreso.VmoId);
	$("#CmpVehiculoVersionId").val(InsVehiculoIngreso.VveId);
	
	
	$("#CmpVehiculoMarca").val(InsVehiculoIngreso.VmaNombre);
	$("#CmpVehiculoModelo").val(InsVehiculoIngreso.VmoNombre);
	$("#CmpVehiculoVersion").val(InsVehiculoIngreso.VveNombre);
	$("#CmpVehiculoIngresoPlaca").val(InsVehiculoIngreso.EinPlaca);
		
	console.log("FncVehiculoIngresoSimpleFuncion");
	
	if(InsVehiculoIngreso.CliId!=null && InsVehiculoIngreso.CliId!=""){
		
		var ClienteId = $("#CmpClienteId").val();
		
		if(ClienteId==""){
			$("#CmpClienteId").val(InsVehiculoIngreso.CliId);	
			FncClienteSimpleBuscar("Id");
		}

	}else{

	}
	
	FncVehiculoIngresoEventoMantenimientoKilometrajeEstablecer();
	
	FncVehiculoIngresoEventoHistorialListar();
	
}





function FncVehiculoIngresoEventoMantenimientoKilometrajeEstablecer(){
	
	console.log("FncVehiculoIngresoEventoMantenimientoKilometrajeEstablecer");
	
	var VehiculoMarcaId = $('#CmpVehiculoMarcaId').val();
	var KilometrajeMantenimiento = $('#CmpKilometrajeMantenimiento').val();
console.log(VehiculoMarcaId);
	$.getJSON("comunes/Vehiculo/JnPlanMantenimientoKilometraje.php?VehiculoMarcaId="+VehiculoMarcaId,{}, function(j){

		var options = '';
		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {

			if(KilometrajeMantenimiento == j[i].PmkKilometraje){
				options += '<option value="' + j[i].PmkKilometraje + '" selected="selected">' + j[i].PmkEtiqueta+ ' km</option>';				
			}else{
				options += '<option value="' + j[i].PmkKilometraje + '" >' + j[i].PmkEtiqueta+ ' km</option>';				
			}

		}

		$('select#CmpVehiculoIngresoEventoPresupuestoMantenimientoKilometraje').html(options);
		
	})
	
}



function FncVehiculoIngresoEventoCalendarioCargarFormulario(){
	
	//tb_show(this.title,'principal2.php?Mod=VehiculoIngresoEvento&Form=VerCalendarioFull&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	FncCargarVentanaFullv3('principal2','VehiculoIngresoEvento','VerCalendarioFull','');
	
		

}


function FncVehiculoIngresoEventoVerRestriccionesoCargarFormulario(){
	
	//tb_show(this.title,'principal2.php?Mod=VehiculoIngresoEvento&Form=VerRestricciones&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=280&width=480&modal=true',this.rel);
	
	FncCargarVentanaFullv3('principal2','VehiculoIngresoEvento','VerRestricciones','');		

}

function FncValidarPersonalHoraVehiculoIngresoEvento(){

	var respuesta = true;
	
	var FechaProgramada = $("#CmpFechaProgramada").val();
	var HoraProgramada = $("#CmpHoraProgramada").val();
	var PersonalMecanico = $("#CmpPersonalMecanico").val();
	var Sucursal = $("#CmpSucursal").val();
		
	/*	if(PersonalMecanico==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un mecanico",
				callback: function(result){
					$("#CmpPersonalMecanico").focus();
				}
			});
			
		}else */if(FechaProgramada==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una fecha",
				callback: function(result){
					$("#CmpFechaProgramada").focus();
				}
			});
			
		}else if(HoraProgramada==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una hora",
				callback: function(result){
					$("#CmpHoraProgramada").focus();
				}
			});
			}else if(Sucursal==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una sucursal",
				callback: function(result){
					$("#CmpSucursal").focus();
				}
			});
			
			
		}else{
			
				$.ajax({
					type: 'POST',
					dataType: "json",
					url: 'formularios/VehiculoIngresoEvento/acc/AccValidarVehiculoIngresoEvento.php',
					data: 'FechaProgramada='+FechaProgramada+
					'&HoraProgramada='+(HoraProgramada)+
					'&Sucursal='+(Sucursal)+
					'&PersonalMecanico='+PersonalMecanico,
					success: function(InsVehiculoIngresoEvento){
						
						if(InsVehiculoIngresoEvento['respuesta']=="2"){

							dhtmlx.confirm("Se ha alcanzado el total de citas permitidos en este horario. ("+InsVehiculoIngresoEvento['citas']+" de "+InsVehiculoIngresoEvento['limite']+" citas). ¿Desea continuar de todas maneras?", function(result){
								if(result==true){		
									respuesta = true;
								}else{
									respuesta = false;
								}
							});
							
						}else{

							var saldo = InsVehiculoIngresoEvento['limite'] - InsVehiculoIngresoEvento['citas']

							dhtmlx.alert({
								title:"Aviso",
								type:"alert",
								text:"VehiculoIngresoEvento disponible en este horario ("+saldo+" de "+InsVehiculoIngresoEvento['limite']+" citas)",
								callback: function(result){
									
								}
							});

						
							
							//dhtmlx.alert({
//								title:"Aviso",
//								type:"alert-error",
//								text:"",
//								callback: function(result){
//									$("#CmpHoraProgramada").focus();
//								}
//							});
						}
						
						//if(InsVehiculoIngresoEvento.CitId !=null){
//								
//									dhtmlx.confirm("Ya existe una cita para esta hora asignada a tecnico escogido. ¿Desea continuar de todas maneras?", function(result){
//										if(result==true){		
//											respuesta = true;
//										}else{
//											respuesta = false;
//										}
//									});
//		
//		//
////								dhtmlx.alert({
////								title:"Aviso",
////								type:"alert-error",
////								text:"Ya existe una cita para esta hora, asignada ese mecanico",
////								callback: function(result){
////									$("#CmpHoraProgramada").focus();
////								}
////							});
//	
//						}else{
//	
//						}
					},
					error: function(){
						
					}
	
				});
			
		}

	return respuesta;
	
}



function FncCargarPersonalHorario(){

	var FechaProgramada = $("#CmpFechaProgramada").val();
	var HoraProgramada = $("#CmpHoraProgramada").val();
	var PersonalMecanico = $("#CmpPersonalMecanico").val();
		
	if(FechaProgramada != "" && HoraProgramada=="" && PersonalMecanico==""){
		
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: 'formularios/VehiculoIngresoEvento/CapPersonalHorario.php',
			data: 'FechaProgramada='+FechaProgramada+
			'&HoraProgramada='+(HoraProgramada)+
			'&PersonalMecanico='+PersonalMecanico,
			success: function(html){
			
				$("#CapPersonalHorario").html(html);
			
			},
			error: function(){
				
			}
		
		});
		
	}else{
		$("#CapPersonalHorario").html("");
	}

	
	
}


function FncVehiculoIngresoEventoHistorialListar(){
console.log("FncVehiculoIngresoEventoHistorialListar");
	var Identificador = $('#Identificador').val();

	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();	

	$('#CapVehiculoIngresoEventoHistorialAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngresoEvento/FrmVehiculoIngresoEventoHistorial.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapVehiculoIngresoEventoHistorialAccion').html('Listo');	
			$("#CapVehiculoIngresoEventoHistoriales").html("");
			$("#CapVehiculoIngresoEventoHistoriales").append(html);
		}
	});
	
	


}


 
 
 /*
 *
 */
 
 
 // JavaScript Document

 

function FncPersonalTecnicosCargar(){
	
	console.log("FncPersonalTecnicosCargar");
	
	var SucursalId = $("#CmpSucursal").val();
	var PersonalId = $("#CmpPersonalMecanico").val();
		
	//if(DepartamentoHabilitado==1){
//		$('#CmpDepartamento').removeAttr('disabled');
//	}else{
//		$('#CmpDepartamento').attr('disabled', 'disabled');
//	}
	
		$("select#CmpPersonalMecanico").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Personal/jn/JnPersonales.php",{Sucursal:SucursalId,Taller:1}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(PersonalId == j[i].PerId){
						options += '<option selected="selected" value="' + j[i].PerId + '">' + j[i].PerNombre+ ' '+ j[i].PerApellidoPaterno+ ' '+ j[i].PerApellidoMaterno + '</option>';					
					}else{
						options += '<option value="' + j[i].PerId + '">' + j[i].PerNombre+ ' '+ j[i].PerApellidoPaterno+ ' '+ j[i].PerApellidoMaterno + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron empleados");
				
			}
			
			$("select#CmpPersonalMecanico").html(options);
			
			$("select#CmpPersonalMecanico").unbind();
			$("select#CmpPersonalMecanico").change(function(){

		
			});
			
			
			FncPersonalTecnicoFuncion();
			
		});		
		
	
}


function FncPersonalTecnicoFuncion(){
	
}



function FncVehiculoIngresoEventoEstablecerMoneda(){

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