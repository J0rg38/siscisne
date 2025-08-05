// JavaScript Document


$().ready(function() {

	

	$("#CmpValidarUso").change(function(){
		FncEstablecerProductoUso();
	});
	
});

//FUNCIONES
function FncSeleccionarVehiculoVersiones(oModeloId){

	if($("#CmpVehiculoModelo_"+oModeloId).is(':checked')){

		$('input[type=checkbox]').each(function () {
			if($(this).attr('tipo')=="vve" && $(this).attr('modelo')==oModeloId){
				$(this).attr('checked', true);
			}
		});
	}else{
		$('input[type=checkbox]').each(function () {

			if($(this).attr('tipo')=="vve" && $(this).attr('modelo')==oModeloId){
				$(this).attr('checked', false);
			}

		});
	}
	
}

function FncEstablecerProductoUso(){
	
	if($("#CmpValidarUso").is(':checked')){
	
		$(".CapVehiculoUso").hide();
		
		
	}else{


		
		$(".CapVehiculoUso").show();
		
	}

}



function FncEstablecerProductoTipoUnidadMedidaBase(){

	var ProductoTipo = $("#CmpTipo").val();
	var UnidadMedidaBase = $("#CmpUnidadMedidaBaseAux").val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Producto/CapProductoTipoUnidadMedidaBase.php',
		data: 'UnidadMedidaBase='+UnidadMedidaBase+'&ProductoTipo='+ProductoTipo+'&ProductoTipoUnidadMedidaBaseHabilitado='+ProductoTipoUnidadMedidaBaseHabilitado,
		success: function(html){
			$('#CapProductoTipoUnidadMedidaBase').html(html);							
			
			FncEstablecerProductoTipoUnidadMedidaIngreso();
		
			$('input[type=radio]').each(function () {

				if($(this).attr('etiqueta')=="unidad_medida_base"){
					
					 $($(this)).click(function(){
						FncEstablecerProductoTipoUnidadMedidaIngreso();
					});
	
				}

			});
			
			
		}
	});

}

function FncEstablecerProductoTipoUnidadMedidaIngreso(){

	var ProductoTipo = $("#CmpTipo").val();
	var ProductoUnidadMedidaIngreso = $("#CmpUnidadMedidaIngresoAux").val();
	//var ProductoUnidadMedidaBase = $("#CmpUnidadMedidaBaseAux").val();
	var ProductoUnidadMedidaBase = $("input[name='CmpUnidadMedidaBase']:checked").val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Producto/CapProductoTipoUnidadMedidaIngreso.php',
		data: 'ProductoUnidadMedidaBase='+ProductoUnidadMedidaBase+'&ProductoUnidadMedidaIngreso='+ProductoUnidadMedidaIngreso+'&ProductoTipo='+ProductoTipo+'&ProductoTipoUnidadMedidaIngresoHabilitado='+ProductoTipoUnidadMedidaIngresoHabilitado,
		success: function(html){
			$('#CapProductoTipoUnidadMedidaIngreso').html(html);							

				FncEstablecerProductoTipoUnidadMedidaSalida();

				$('input[type=radio]').each(function () {
					
					if($(this).attr('etiqueta')=="unidad_medida_ingreso"){
						
						 $($(this)).click(function(){
							FncEstablecerProductoTipoUnidadMedidaSalida();
						});
		
					}
	
				});
			
		}
	});

	

}

function FncEstablecerProductoTipoUnidadMedidaSalida(){

	var ProductoTipo = $("#CmpTipo").val();
	var ProductoUnidadMedidaIngreso = $("input[name='CmpUnidadMedidaIngreso']:checked").val(); 
	var ProductoUnidadMedidaBase = $("input[name='CmpUnidadMedidaBase']:checked").val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Producto/CapProductoTipoUnidadMedidaSalida.php',
		data: 'ProductoTipo='+ProductoTipo+'&ProductoUnidadMedidaIngreso='+ProductoUnidadMedidaIngreso+'&ProductoUnidadMedidaBase='+ProductoUnidadMedidaBase,
		success: function(html){
			$('#CapProductoTipoUnidadMedidaSalida').html(html);							
		}
	});

}

function FncProductoTipoUnidadMedidaIngresoNuevo(){

	var ProductoTipoUnidadMedidaIngreso = $("#CmpProductoTipoUnidadMedidaIngresoNuevo").val();
	var ProductoTipoId = $("#CmpTipo").val();
	var ProductoUnidadMedidaId = $("input[name='CmpUnidadMedidaBase']:checked").val(); 
	
	//alert(ProductoUnidadMedidaId);
	if(ProductoUnidadMedidaId!="undefined" && ProductoUnidadMedidaId!=undefined){

		if(ProductoTipoUnidadMedidaIngreso!=""){

			$.ajax({
				type: 'POST',
				url: 'formularios/Producto/acc/AccProductoTipoUnidadMedidaIngresoRegistrar.php',
				data: 'ProductoTipoUnidadMedidaIngreso='+ProductoTipoUnidadMedidaIngreso+'&ProductoTipoId='+ProductoTipoId+'&ProductoUnidadMedidaId='+ProductoUnidadMedidaId,
				success: function(html){
					FncEstablecerProductoTipoUnidadMedidaIngreso();		
					FncEstablecerProductoTipoUnidadMedidaSalida();
				}
			});
			
		}else{
			alert("Ingrese la nueva unidad de medida");
			$("#CmpProductoTipoUnidadMedidaIngresoNuevo").focus();
		}
		
	}else{
		alert("Escoja una Unidad de Medida (Base)");	
	}
	
	
}


function FncVehiculoVersionMarcarTodo(){

	if($("#CmpVehiculoVersionMarcarTodo").is(':checked')){
		$('input[type=checkbox]').each(function () {
			if($(this).attr('tipo')=="vve"){
				$(this).attr('checked', true);		
			}			 
		});
	}else{
		$('input[type=checkbox]').each(function () {
			if($(this).attr('tipo')=="vve"){
				$(this).attr('checked', false);
			}
			
		});
	}
	
}


function FncVehiculoAnoMarcarTodo(){

	if($("#CmpVehiculoAnoMarcarTodo").is(':checked')){
		$('input[type=checkbox]').each(function () {
			if($(this).attr('tipo')=="ano"){
				$(this).attr('checked', true);		
			}			 
		});
	}else{
		$('input[type=checkbox]').each(function () {
			if($(this).attr('tipo')=="ano"){
				$(this).attr('checked', false);
			}
			
		});
	}
	
}

/*
FUNCIONES ADICIONALES
*/
function FncImprimirCodigoBarra(){

	var acc = document.getElementById("FrmGenerar").action;
	document.getElementById("FrmGenerar").action = acc+'&P=1';
	//document.getElementById("FrmGenerar").target = '_blank';
	document.getElementById("FrmGenerar").submit();
	//document.getElementById("FrmGenerar").action = "#";
	//document.getElementById("FrmGenerar").target = '_self';

}

function FncImprimir(){
	window.print() ;
}
