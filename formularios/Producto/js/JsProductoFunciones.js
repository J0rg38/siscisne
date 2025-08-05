// JavaScript Document


function FncValidar(){

	var CodigoOriginal = $("#CmpCodigoOriginal").val();
	var Nombre = $("#CmpNombre").val();
	var Referencia = $("#CmpReferencia").val();
	var Tipo = $("#CmpTipo").val();
	var ProductoCategoria = $("#CmpProductoCategoria").val();
	
	var UnidadMedidaIngreso = 2;
	var UnidadMedidaBase = 2;

	var Anos = 2;
	var Versiones= 2;
	var UsoGeneral= 2;
	
	/*
	if($("#CmpUnidadMedidaIngreso").is(":checked")){
		 UnidadMedidaIngreso = 1;
	}
	
	if($("#CmpUnidadMedidaBase").is(":checked")){
		 UnidadMedidaBase = 1;
	}
	*/

	if($("#CmpValidarUso").is(':checked')){
		UsoGeneral = 1;
	}
				
		
	if ($("input[name='CmpUnidadMedidaIngreso']:checked").val()) {
        UnidadMedidaIngreso = 1;
    }
	
	if ($("input[name='CmpUnidadMedidaBase']:checked").val()) {
       UnidadMedidaBase = 1;
    }
	
		$('input[type=checkbox]').each(function () {
			
			if($(this).attr('tipo')=="ano"){
				
				if($(this).is(':checked')){
					Anos = 1;
				}
				
			}	
			
			if($(this).attr('tipo')=="vve"){
				
				if($(this).is(':checked')){
					Versiones = 1;
				}
				
			}			 
			
		});
	
	
	if(CodigoOriginal == ""){		
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un codigo original",
				callback: function(result){
					$("#CmpCodigoOriginal").focus();
				}
			});

		return false;
	}else if(Nombre == ""){			
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un nombre",
				callback: function(result){
					$("#CmpNombre").focus();
				}
			});
			
			return false;
	
	}else if(Referencia == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una referencia",
				callback: function(result){
					$("#CmpReferencia").focus();
				}
			});	
	
	return false;
	
	}else if(Tipo == "" ){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un tipo de producto",
				callback: function(result){
					$("#CmpTipo").focus();
				}
			});
	
		return false;
	
	}else if( ProductoCategoria=="" ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una clasificacion de producto",
				callback: function(result){
					$("#CmpProductoCategoria").focus();
				}
			});
	
		return false;
		
	}else if( UnidadMedidaIngreso==2 ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una unidad de medida de ingreso",
				callback: function(result){
					//$("#CmpProductoCategoria").focus();
					
					$("ul.tabs li").removeClass("active"); //Remove any "active" class
						$("#tab4").addClass("active"); //Add "active" class to selected tab
						$(".tab_content").hide(); //Hide all tab content
				
//						var activeTab = $("#tab5").find("a").attr("href"); //Find the href attribute value to identify the active tab + content
						$("#tab4").fadeIn(); //Fade in the active ID content
				}
			});
	
		return false;
		
	}else if( UnidadMedidaBase=="" ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una unidad de medida base",
				callback: function(result){
					//$("#CmpProductoCategoria").focus();
					
					$("ul.tabs li").removeClass("active"); //Remove any "active" class
						$("#tab4").addClass("active"); //Add "active" class to selected tab
						$(".tab_content").hide(); //Hide all tab content
				
//						var activeTab = $("#tab5").find("a").attr("href"); //Find the href attribute value to identify the active tab + content
						$("#tab4").fadeIn(); //Fade in the active ID content
				}
			});
	
		return false;

/*
}else if( Anos==2 && UsoGeneral==2 ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un año de referencia. [Pestaña Uso]",
				callback: function(result){
					//$("#CmpProductoCategoria").focus();
					
						$("ul.tabs li").removeClass("active"); //Remove any "active" class
						$("#tab5").addClass("active"); //Add "active" class to selected tab
						$(".tab_content").hide(); //Hide all tab content
				
//						var activeTab = $("#tab5").find("a").attr("href"); //Find the href attribute value to identify the active tab + content
						$("#tab5").fadeIn(); //Fade in the active ID content
				}
			});
	
		return false;
		
		}else if( Versiones==2 && UsoGeneral==2 ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger el modelo o version de referencia. [Pestaña Uso]",
				callback: function(result){
					//$("#CmpProductoCategoria").focus();
					
						$("ul.tabs li").removeClass("active"); //Remove any "active" class
						$("#tab5").addClass("active"); //Add "active" class to selected tab
						$(".tab_content").hide(); //Hide all tab content
				
//						var activeTab = $("#tab5").find("a").attr("href"); //Find the href attribute value to identify the active tab + content
						$("#tab5").fadeIn(); //Fade in the active ID content
				}
			});
	
		return false;
		*/
	}else{
		
		return true;
		
	}
		
	
}


$().ready(function() {

	$('#FrmRegistrar').on('submit', function() {
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});









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




function FncProductoCodigoBarraImprimir(){
	
	var Accion = document.getElementById('FrmEditar').action;
	
	//document.getElementById('FrmEditar'+oIndice).target = '_blank';
	document.getElementById('FrmEditar').action = Accion+'?P=1';
	document.getElementById('FrmEditar').submit();
		document.getElementById('FrmEditar').action = Accion;
	
	
}
