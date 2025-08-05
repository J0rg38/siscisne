// JavaScript Document

/*
Valores por defecto
*/

function FncDocumentoAutocompletarCargar(oTipo){

	$("#CmpDocumento").unautocomplete();	
//	$("#CmpDocumento").val("");	
	
/*	$("#CmpDocumentoId").val("");	
	$("#CmpDocumentoTalonario").val("");	
	$("#CmpDocumentoTalonarioNumero").val("");	
	$("#CmpClienteNombre").val("");	*/
			
	function DocumentoFormato(row) {
		return row[10] + " - " + row[2] + "-" +row[0]+ " | " +row[4]+ " | <i>" +row[3]+ "</i> ";
	}

	switch(oTipo){
		case "1":
			 var Documento = "Venta";
		break;
		
		case "2":
			var  Documento = "Factura";
		break;
		
		case "3":
			 var Documento = "Boleta";
		break;
		
		case "4":
			var  Documento = "NotaEntrega";
		break;
		
		case "5":
			var  Documento = "Compra";
		break;

		case "6":
			var  Documento = "Gasto";
		break;
	}

	$("#CmpDocumento").autocomplete("comunes/Documento/Xml"+Documento+".php", {
		width: 550,
		selectFirst: false,
		formatItem: DocumentoFormato
	});	

	$("#CmpDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpDocumento").val(data[2]+" - "+data[0]);

			$("#CmpDocumentoId").val(data[0]);
			$("#CmpDocumentoTalonario").val(data[1]);
			$("#CmpDocumentoTalonarioNumero").val(data[2]);
			$("#CmpDocumentoSucursalId").val(data[7]);

			$("#CmpClienteNombre").val(data[3]);
			$("#CmpProveedorNombre").val(data[3]);

			$("#CmpClienteNumeroDocumento").val(data[8]);
			$("#CmpClienteDireccion").val(data[9]);

			$("#CmpDocumentoFecha").val(data[4]);
			$("#CmpDocumentoNumero").val(data[2]);			

			if ($.isFunction(window.FncDocumentoFuncion)){
				FncDocumentoFuncion();
			}
			
			$('#CmpDocumento').attr('readonly', true);
		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	var Tipo = $("#CmpTipo").val();
	
	FncDocumentoAutocompletarCargar(Tipo);
		
});