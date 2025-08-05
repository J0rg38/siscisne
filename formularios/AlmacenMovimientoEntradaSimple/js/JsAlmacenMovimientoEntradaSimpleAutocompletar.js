///*
//Configuracion Autocompletar
//*/
//$().ready(function() {
//
//	function ProveedorFormato(row) {
//		return row[1];
//	}
//		
//	function ProveedorFormato2(row) {
//		return row[2];
//	}
//	
//	$("#CmpInternacionalProveedorNombre1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre1").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId1").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","1");
//		}		
//	});
//	
//	
//	$("#CmpInternacionalProveedorNombre2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId2").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","2");
//		}		
//	});	
//	
//	
//	$("#CmpInternacionalProveedorNombre3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId3").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","3");
//		}		
//	});	
//	
//	$("#CmpInternacionalProveedorNombre4").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre4").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId4").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","4");
//		}		
//	});		
//	
//	$("#CmpInternacionalProveedorNombre5").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre5").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId5").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","5");
//		}		
//	});	
//			
//	$("#CmpInternacionalProveedorNombre6").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre6").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId6").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","6");
//		}		
//	});	
//		
//		
//	$("#CmpInternacionalProveedorNombre7").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre7").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId7").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","7");
//		}		
//	});	
//		
//	$("#CmpInternacionalProveedorNombre8").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre8").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId8").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","8");
//		}		
//	});		
//	
//	$("#CmpInternacionalProveedorNombre9").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpInternacionalProveedorNombre9").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId9").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","9");
//		}		
//	});	
//	
//	
//	
//	
//	
//	$("#CmpNacionalProveedorNombre1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpNacionalProveedorNombre1").result(function(event, data, formatted) {
//		if (data){
//			
//			$("#CmpNacionalProveedorId1").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Nacional","1");
//		}		
//	});
//	
//	
//	$("#CmpNacionalProveedorNombre2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpNacionalProveedorNombre2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalProveedorId2").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Nacional","2");
//		}		
//	});	
//	
//	
//	$("#CmpNacionalProveedorNombre3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato
//	});		
//
//	$("#CmpNacionalProveedorNombre3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalProveedorId3").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Nacional","3");
//		}		
//	});	
//	
//	
//	
///*
//==
//*/
//		
//	$("#CmpInternacionalProveedorNumeroDocumento1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento1").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId1").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","1");
//		}		
//	});
//	
//	
//	$("#CmpInternacionalProveedorNumeroDocumento2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId2").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","2");
//		}		
//	});
//	
//	$("#CmpInternacionalProveedorNumeroDocumento3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId3").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","3");
//		}		
//	});
//	
//	$("#CmpInternacionalProveedorNumeroDocumento4").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento4").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId4").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","4");
//		}		
//	});	
//	
//	$("#CmpInternacionalProveedorNumeroDocumento5").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento5").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId5").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","5");
//		}		
//	});
//	
//	$("#CmpInternacionalProveedorNumeroDocumento6").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento6").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId6").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","6");
//		}		
//	});
//		
//	$("#CmpInternacionalProveedorNumeroDocumento7").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento7").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId7").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","7");
//		}		
//	});
//	
//	$("#CmpInternacionalProveedorNumeroDocumento8").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento8").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId8").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","8");
//		}		
//	});
//	
//	
//	
//	$("#CmpInternacionalProveedorNumeroDocumento9").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpInternacionalProveedorNumeroDocumento9").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpInternacionalProveedorId9").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Internacional","9");
//		}		
//	});
//
//
//
//
//
//	$("#CmpNacionalProveedorNumeroDocumento1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpNacionalProveedorNumeroDocumento1").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalProveedorId1").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Nacional","1");
//		}		
//	});	
//	
//
//
//	$("#CmpNacionalProveedorNumeroDocumento2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpNacionalProveedorNumeroDocumento2").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalProveedorId2").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Nacional","2");
//		}		
//	});	
//	
//	
//	$("#CmpNacionalProveedorNumeroDocumento3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
//		width: 500,
//		max: 20,
//		selectFirst: true,
//		formatItem: ProveedorFormato2
//	});		
//
//	$("#CmpNacionalProveedorNumeroDocumento3").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpNacionalProveedorId3").val(data[0]);				
//			FncAlmacenMovimientoEntradaProveedorBuscar("Id","Nacional","3");
//		}		
//	});	
//	
//
//});