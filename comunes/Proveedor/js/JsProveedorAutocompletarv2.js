// JavaScript Document

/*
Configuracion Autocompletar
*/
$().ready(function() {

//	$("#BtnProveedorEditar").hide();
//	$("#BtnProveedorRegistrar").show();
	
	function ProveedorFormato(row) {
		return row[1];
	}

	$("#CmpProveedorNombreCompleto").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombreCompleto", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpProveedorNombreCompleto").result(function(event, data, formatted) {
		if (data){
			$("#CmpProveedorId").val(data[0]);				
			FncProveedorBuscar("Id");
		}		
	});
	
	
	
	
	
	function ProveedorFormato2(row) {
		return row[2];
	}

	$("#CmpProveedorNumeroDocumento").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpProveedorNumeroDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpProveedorId").val(data[0]);				
			FncProveedorBuscar("Id");
		}		
	});
	



});