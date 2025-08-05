// JavaScript Document


$().ready(function() {

	

	$("#CmpValidarUso").change(function(){
		FncEstablecerProveedorComunicadoUso();
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

function FncEstablecerProveedorComunicadoUso(){
	
	if($("#CmpValidarUso").is(':checked')){
	
		$(".CapVehiculoUso").hide();
		
		
	}else{


		
		$(".CapVehiculoUso").show();
		
	}

}



function FncEstablecerProveedorComunicadoTipoUnidadMedidaBase(){

	var ProveedorComunicadoTipo = $("#CmpTipo").val();
	var UnidadMedidaBase = $("#CmpUnidadMedidaBaseAux").val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProveedorComunicado/CapProveedorComunicadoTipoUnidadMedidaBase.php',
		data: 'UnidadMedidaBase='+UnidadMedidaBase+'&ProveedorComunicadoTipo='+ProveedorComunicadoTipo+'&ProveedorComunicadoTipoUnidadMedidaBaseHabilitado='+ProveedorComunicadoTipoUnidadMedidaBaseHabilitado,
		success: function(html){
			$('#CapProveedorComunicadoTipoUnidadMedidaBase').html(html);							
			
			FncEstablecerProveedorComunicadoTipoUnidadMedidaIngreso();
		
			$('input[type=radio]').each(function () {

				if($(this).attr('etiqueta')=="unidad_medida_base"){
					
					 $($(this)).click(function(){
						FncEstablecerProveedorComunicadoTipoUnidadMedidaIngreso();
					});
	
				}

			});
			
			
		}
	});

}

function FncEstablecerProveedorComunicadoTipoUnidadMedidaIngreso(){

	var ProveedorComunicadoTipo = $("#CmpTipo").val();
	var ProveedorComunicadoUnidadMedidaIngreso = $("#CmpUnidadMedidaIngresoAux").val();
	//var ProveedorComunicadoUnidadMedidaBase = $("#CmpUnidadMedidaBaseAux").val();
	var ProveedorComunicadoUnidadMedidaBase = $("input[name='CmpUnidadMedidaBase']:checked").val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProveedorComunicado/CapProveedorComunicadoTipoUnidadMedidaIngreso.php',
		data: 'ProveedorComunicadoUnidadMedidaBase='+ProveedorComunicadoUnidadMedidaBase+'&ProveedorComunicadoUnidadMedidaIngreso='+ProveedorComunicadoUnidadMedidaIngreso+'&ProveedorComunicadoTipo='+ProveedorComunicadoTipo+'&ProveedorComunicadoTipoUnidadMedidaIngresoHabilitado='+ProveedorComunicadoTipoUnidadMedidaIngresoHabilitado,
		success: function(html){
			$('#CapProveedorComunicadoTipoUnidadMedidaIngreso').html(html);							

				FncEstablecerProveedorComunicadoTipoUnidadMedidaSalida();

				$('input[type=radio]').each(function () {
					
					if($(this).attr('etiqueta')=="unidad_medida_ingreso"){
						
						 $($(this)).click(function(){
							FncEstablecerProveedorComunicadoTipoUnidadMedidaSalida();
						});
		
					}
	
				});
			
		}
	});

	

}

function FncEstablecerProveedorComunicadoTipoUnidadMedidaSalida(){

	var ProveedorComunicadoTipo = $("#CmpTipo").val();
	var ProveedorComunicadoUnidadMedidaIngreso = $("input[name='CmpUnidadMedidaIngreso']:checked").val(); 
	var ProveedorComunicadoUnidadMedidaBase = $("input[name='CmpUnidadMedidaBase']:checked").val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProveedorComunicado/CapProveedorComunicadoTipoUnidadMedidaSalida.php',
		data: 'ProveedorComunicadoTipo='+ProveedorComunicadoTipo+'&ProveedorComunicadoUnidadMedidaIngreso='+ProveedorComunicadoUnidadMedidaIngreso+'&ProveedorComunicadoUnidadMedidaBase='+ProveedorComunicadoUnidadMedidaBase,
		success: function(html){
			$('#CapProveedorComunicadoTipoUnidadMedidaSalida').html(html);							
		}
	});

}

function FncProveedorComunicadoTipoUnidadMedidaIngresoNuevo(){

	var ProveedorComunicadoTipoUnidadMedidaIngreso = $("#CmpProveedorComunicadoTipoUnidadMedidaIngresoNuevo").val();
	var ProveedorComunicadoTipoId = $("#CmpTipo").val();
	var ProveedorComunicadoUnidadMedidaId = $("input[name='CmpUnidadMedidaBase']:checked").val(); 
	
	//alert(ProveedorComunicadoUnidadMedidaId);
	if(ProveedorComunicadoUnidadMedidaId!="undefined" && ProveedorComunicadoUnidadMedidaId!=undefined){

		if(ProveedorComunicadoTipoUnidadMedidaIngreso!=""){

			$.ajax({
				type: 'POST',
				url: 'formularios/ProveedorComunicado/acc/AccProveedorComunicadoTipoUnidadMedidaIngresoRegistrar.php',
				data: 'ProveedorComunicadoTipoUnidadMedidaIngreso='+ProveedorComunicadoTipoUnidadMedidaIngreso+'&ProveedorComunicadoTipoId='+ProveedorComunicadoTipoId+'&ProveedorComunicadoUnidadMedidaId='+ProveedorComunicadoUnidadMedidaId,
				success: function(html){
					FncEstablecerProveedorComunicadoTipoUnidadMedidaIngreso();		
					FncEstablecerProveedorComunicadoTipoUnidadMedidaSalida();
				}
			});
			
		}else{
			alert("Ingrese la nueva unidad de medida");
			$("#CmpProveedorComunicadoTipoUnidadMedidaIngresoNuevo").focus();
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




function FncProveedorComunicadoCodigoBarraImprimir(){
	
	var Accion = document.getElementById('FrmEditar').action;
	
	//document.getElementById('FrmEditar'+oIndice).target = '_blank';
	document.getElementById('FrmEditar').action = Accion+'?P=1';
	document.getElementById('FrmEditar').submit();
		document.getElementById('FrmEditar').action = Accion;
	
	
}
