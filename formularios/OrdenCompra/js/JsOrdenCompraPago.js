// JavaScript Document

function FncClienteCSIEditarImprimir(oIndice){
	var Accion = document.getElementById('FrmClienteCSIEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmClienteCSIEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = 'IfrClienteCSIEditar'+oIndice;
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion;
	
}

function FncClienteCSIEditarGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmClienteCSIEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmClienteCSIEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = 'IfrClienteCSIEditar'+oIndice;
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion;
	
}



function FncClienteCSIEditarNuevo(){

		
}







$().ready(function() {



});





function FncClienteCSIEditarCargarListado(){
	
	var CmpFechaInicio = $("#CmpFechaInicio").val();
	var CmpFechaFin = $("#CmpFechaFin").val();
	var CmpOrden = $("#CmpOrden").val();
	var CmpSentido = $("#CmpSentido").val();
	
	$("#CapClienteCSIEditar").html("Cargando...");
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Cliente/IfrClienteCSIEditarListado.php',
			data: 'CmpFechaInicio='+CmpFechaInicio+'&CmpFechaFin='+CmpFechaFin+'&CmpOrden='+CmpOrden+'&CmpSentido='+CmpSentido,
			success: function(html){
			
				$("#CapClienteCSIEditar").html(html);
				
				
					$('input[type=checkbox]').each(function () {

						if($(this).attr('etiqueta')=="cliente"){
							FncClienteCSIEditarCargar($(this).val(),1);
						}			 
				
					});

			}
		});
					
}



function FncClienteCSIEditarAccion(oClienteId){

	var ClienteCSIIncluir = 2;
	var ClienteCSIExcluirMotivo = $("#CapClienteCSIExcluirMotivo_"+oClienteId).val();
	
	if($("#CmpClienteCSIincluir_"+oClienteId).is(':checked')){
		 ClienteCSIIncluir = 1;
	}
	
	$("#CapClienteCSIEditarAccion_"+oClienteId).html("Guardando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Cliente/acc/AccClienteCSIEditar.php',
		data: 'ClienteId='+oClienteId+'&ClienteCSIIncluir='+ClienteCSIIncluir+'&ClienteCSIExcluirMotivo='+ClienteCSIExcluirMotivo,
		success: function(html){

			FncClienteCSIEditarCargar(oClienteId,1);	
				

		}
	});
	
	
		
		
}



function FncClienteCSIEditarCargar(oClienteId,oCambioColor){

	$("#CapClienteCSIEditarAccion_"+oClienteId).html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Cliente/CapClienteCSIEditar.php',
		data: 'ClienteId='+oClienteId,
		success: function(html){

			$("#CapClienteCSIEditarAccion_"+oClienteId).html(html);

			if(oCambioColor==1){
				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#7EFA03');
			}else{
				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');	
			}
			
			$("#CapClienteCSIExcluirMotivo_"+oClienteId).keypress(function (event) {  
				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');
			}); 
	

		}

	});

}



//function FncClienteCSIEditarIncluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=2&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//function FncClienteCSIEditarExcluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//
//
//function FncClienteBuscar(){
//	FncClienteCSIEditarCargarListado();
//}

