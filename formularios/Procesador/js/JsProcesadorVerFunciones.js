

function FncProcesadorArchivoNuevo(){
}

function FncProcesadorArchivoGuardar(){
	
}


function FncProcesadorArchivoListar(oItem){

	var Identificador = $('#Identificador').val();

	$('#CapProcesadorArchivosAccion'+oItem).html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Procesador/FrmProcesadorArchivoListado'+oItem+'.php',
		data: 'Identificador='+Identificador+'&Tipo=',
		success: function(html){
			$('#CapProcesadorArchivosAccion'+oItem).html('Listo');	
			$("#CapProcesadorArchivos"+oItem).html("");
			$("#CapProcesadorArchivos"+oItem).append(html);
		}
	});
	
	

}
