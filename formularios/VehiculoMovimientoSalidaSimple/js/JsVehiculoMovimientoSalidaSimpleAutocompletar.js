///*
//Configuracion Autocompletar
//*/
//$().ready(function() {
//
//	function ClienteFormato(row) {
//		return row[1];
//	}
//		
//	function ClienteFormato2(row) {
//		return row[2];
//	}
//	
//	$("#CmpInternacionalClienteNombre1").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre1").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId1").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","1");
//		}		
//	});
//	
//	
//	$("#CmpInternacionalClienteNombre2").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId2").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","2");
//		}		
//	});	
//	
//	
//	$("#CmpInternacionalClienteNombre3").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId3").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","3");
//		}		
//	});	
//	
//	$("#CmpInternacionalClienteNombre4").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre4").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId4").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","4");
//		}		
//	});		
//	
//	$("#CmpInternacionalClienteNombre5").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre5").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId5").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","5");
//		}		
//	});	
//			
//	$("#CmpInternacionalClienteNombre6").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre6").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId6").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","6");
//		}		
//	});	
//		
//		
//	$("#CmpInternacionalClienteNombre7").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre7").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId7").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","7");
//		}		
//	});	
//		
//	$("#CmpInternacionalClienteNombre8").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre8").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId8").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","8");
//		}		
//	});		
//	
//	$("#CmpInternacionalClienteNombre9").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpInternacionalClienteNombre9").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId9").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","9");
//		}		
//	});	
//	
//	
//	
//	
//	
//	$("#CmpNacionalClienteNombre1").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpNacionalClienteNombre1").result(function(event, data, formatted) {
//		if (data){
//			
//			$("#CmpNacionalClienteId1").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Nacional","1");
//		}		
//	});
//	
//	
//	$("#CmpNacionalClienteNombre2").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpNacionalClienteNombre2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalClienteId2").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Nacional","2");
//		}		
//	});	
//	
//	
//	$("#CmpNacionalClienteNombre3").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato
//	});		
//
//	$("#CmpNacionalClienteNombre3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalClienteId3").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Nacional","3");
//		}		
//	});	
//	
//	
//	
///*
//==
//*/
//		
//	$("#CmpInternacionalClienteNumeroDocumento1").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento1").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId1").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","1");
//		}		
//	});
//	
//	
//	$("#CmpInternacionalClienteNumeroDocumento2").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId2").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","2");
//		}		
//	});
//	
//	$("#CmpInternacionalClienteNumeroDocumento3").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId3").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","3");
//		}		
//	});
//	
//	$("#CmpInternacionalClienteNumeroDocumento4").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento4").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId4").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","4");
//		}		
//	});	
//	
//	$("#CmpInternacionalClienteNumeroDocumento5").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento5").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId5").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","5");
//		}		
//	});
//	
//	$("#CmpInternacionalClienteNumeroDocumento6").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento6").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId6").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","6");
//		}		
//	});
//		
//	$("#CmpInternacionalClienteNumeroDocumento7").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento7").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId7").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","7");
//		}		
//	});
//	
//	$("#CmpInternacionalClienteNumeroDocumento8").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento8").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId8").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","8");
//		}		
//	});
//	
//	
//	
//	$("#CmpInternacionalClienteNumeroDocumento9").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpInternacionalClienteNumeroDocumento9").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalClienteId9").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Internacional","9");
//		}		
//	});
//
//
//
//
//
//	$("#CmpNacionalClienteNumeroDocumento1").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpNacionalClienteNumeroDocumento1").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalClienteId1").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Nacional","1");
//		}		
//	});	
//	
//
//
//	$("#CmpNacionalClienteNumeroDocumento2").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpNacionalClienteNumeroDocumento2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalClienteId2").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Nacional","2");
//		}		
//	});	
//	
//	
//	$("#CmpNacionalClienteNumeroDocumento3").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ClienteFormato2
//	});		
//
//	$("#CmpNacionalClienteNumeroDocumento3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalClienteId3").val(data[0]);				
//			FncVehiculoMovimientoSalidaClienteBuscar("Id","Nacional","3");
//		}		
//	});	
//	
//
//});