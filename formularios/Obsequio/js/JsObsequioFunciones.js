// JavaScript Document

//function FncGuardar(){
//	
//	//HACK
//	$("#CmpEstado").removeAttr('disabled');		
//	
//}

function FncValidar(){

	var FechaProgramada = $("#CmpFechaProgramada").val();
	var ClienteId = $("#CmpClienteId").val();
	var Personal = $("#CmpPersonal").val();
	var Duracion = $("#CmpTipo").val();
		
		if(FechaProgramada == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de cita",
					callback: function(result){
						$("#CmpFechaProgramada").focus();
					}
				});
				
			return false;
		}else if(ClienteId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});
				
			return false;
		}else if(Personal == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger un asesor responsable",
					callback: function(result){
						$("#CmpPersonal").focus();
					}
				});

			return false;

}else if(Duracion == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una duracion ",
					callback: function(result){
						$("#CmpTipo").focus();
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
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});


function FncClienteSimpleFuncion(InsCliente){
	
	if(InsCliente.EinId!=null && InsCliente.EinId!=""){
		
		//$("#CmpVehiculoIngresoId").val(InsCliente.EinId);	
//		
//		FncVehiculoIngresoBuscar("Id");
		
		var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();		
		
		if(VehiculoIngresoId==""){
			$("#CmpVehiculoIngresoId").val(InsCliente.EinId);	
			FncVehiculoIngresoBuscar("Id");
		}
		
	//	
//		$("#CmpVehiculoIngresoId").val(InsCliente.EinId);	
//		$("#CmpObsequioPresupuestoClienteTipo").val(InsCliente.LtiId);	
//		
//		//var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();		
//		//if(VehiculoIngresoId!=InsCliente.EinId){			
//		//$("#CmpVehiculoIngresoId").val(InsCliente.EinId);			
//			
//		FncVehiculoIngresoBuscar("Id");
		
		//}
		
	}else{
		//FncVehiculoIngresoNuevo();
	}
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
	if(InsVehiculoIngreso.CliId!=null && InsVehiculoIngreso.CliId!=""){
		
		//$("#CmpClienteId").val(InsVehiculoIngreso.CliId);	
//		
//		FncClienteSimpleBuscar("Id");
		
		var ClienteId = $("#CmpClienteId").val();
		
		if(ClienteId==""){
			$("#CmpClienteId").val(InsVehiculoIngreso.CliId);	
			FncClienteSimpleBuscar("Id");
		}
		//
//		if(ClienteId!=InsVehiculoIngreso.CliId){
//			
//			$("#CmpClienteId").val(InsVehiculoIngreso.CliId);	
//		
//			FncClienteSimpleBuscar("Id");
//			
//		}
		
		FncObsequioMantenimientoKilometrajeEstablecer();
		
	}else{
	//	FncClienteSimpleNuevo();
	}
	
}





function FncObsequioMantenimientoKilometrajeEstablecer(){
	
	var VehiculoMarcaId = $('#CmpVehiculoMarcaId').val();
	var KilometrajeMantenimiento = $('#CmpKilometrajeMantenimiento').val();

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

		$('select#CmpObsequioPresupuestoMantenimientoKilometraje').html(options);
		
	})
	
}



function FncObsequioCalendarioCargarFormulario(oForm){
	
	
	//FncCargarVentanaNuevo(oRuta,oIframe,oModal,oTitulo)
	FncCargarVentanaNuevo('principal2.php?Mod=Obsequio&Form='+oForm+'&Dia=1',"true","true","");
	
//	tb_show(this.title,'principal2.php?Mod=Obsequio&Form='+oForm+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}