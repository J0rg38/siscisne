// JavaScript Document


function FncValidar(){

	var CmpProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		
		if(CmpProductoCodigoOriginal == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un codigo original",
					callback: function(result){
						$("#CmpProductoCodigoOriginal").focus();
					}
				});
				
			return false;
	
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}
$().ready(function() {

/*
* EVENTOS - NAVEGACION
*/		

	$('#BtnVer').on('click', function() {
		
		if(FncValidar()){
			
		}
		
	});
	
	
	$( "#CmpProductoCodigoOriginal" ).keypress(function( event ) {
		if ( event.which == 13 ) {
			FncProductoConsultaVer();
		}
	});

	setInterval('FncSeleccionarCaja();',5000);
});

function FncSeleccionarCaja(){
	$("#CmpProductoCodigoOriginal").select();
}

function FncProductoConsultaVer(){
	
	if(FncValidar()){
		
		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		
		$('#CapProductoConsulta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'IfrProductoConsulta.php',
			data: 'ProductoCodigoOriginal='+ProductoCodigoOriginal,
			success: function(html){
				$('#CapProductoConsulta').html(html);	
				$("#CmpProductoCodigoOriginal").select();
			},
			error: function(html){
				$("#CmpProductoCodigoOriginal").select();
			}
		});

	}

}


function FncProductoConsultaImprimir(oIndice){
	
	if(FncValidar()){
		
		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		
		FncPopUp("formularios/Producto/IfrProductoConsulta.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+"&P=1");
		
	}

}

function FncProductoConsultaNuevo(){


	
				
}


$(function(){
	
	function FncProductoFormato(row) {			
		return "<td>"+row[8]+"</td>";
	}
	
	
	$("#CmpProductoCodigoOriginal").unautocomplete();
	$("#CmpProductoCodigoOriginal").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 100,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoOriginal").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoId").val(data[0]);				
			FncProductoBuscar("Id");	
		}		
	});
	
});




