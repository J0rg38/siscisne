// JavaScript Document

function FncReporteKardexValorizadoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteKardexValorizado'+oIndice).action;
	
	document.getElementById('FrmReporteKardexValorizado'+oIndice).target = '_blank';
	document.getElementById('FrmReporteKardexValorizado'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteKardexValorizado'+oIndice).submit();
	
	document.getElementById('FrmReporteKardexValorizado'+oIndice).target = 'IfrReporteKardexValorizado'+oIndice;
	document.getElementById('FrmReporteKardexValorizado'+oIndice).action = Accion;
	
}

function FncReporteKardexValorizadoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteKardexValorizado'+oIndice).action;
	
	document.getElementById('FrmReporteKardexValorizado'+oIndice).target = '_blank';
	document.getElementById('FrmReporteKardexValorizado'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteKardexValorizado'+oIndice).submit();
	
	document.getElementById('FrmReporteKardexValorizado'+oIndice).target = 'IfrReporteKardexValorizado'+oIndice;
	document.getElementById('FrmReporteKardexValorizado'+oIndice).action = Accion;
	
}



function FncReporteKardexValorizadoNuevo(){


	
				
}




function FncReporteKardexValorizadoNuevo(){

	$('#CmpProductoId').val("");		
	$('#CmpProductoCodigoAlternativo').val("");		
	$('#CmpProductoCodigoOriginal').val("");		
	$('#CmpProductoNombre').val("");	
	
	$('#CmpProductoUnidadMedidaKardex').html("");	
	
	
	$('#CmpProductoCodigoAlternativo').select();
				
}


function FncProductoFuncion(){
	
	var ProductoId = $("#CmpProductoId").val();

		$.getJSON("comunes/UnidadMedida/JnProductoKardexUnidadMedida.php?ProductoId="+ProductoId,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if("1" == j[i].UmeUso){
				options += '<option value="' + j[i].UmeUso + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeUso + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpProductoUnidadMedidaKardex").html(options);
	})
}