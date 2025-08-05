// JavaScript Document

function FncValidar(){

var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Personal = $("#CmpPersonal").val();
		
		if(FechaInicio == ""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de inicio",
					callback: function(result){
						$("#CmpFechaInicio").focus();
					}
				});
							
			
			return false;
		}else if(FechaFin == ""){			
//			alert("Debes ingresar una fecha de termino");			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de termino",
					callback: function(result){
						$("#CmpFechaFin").focus();
					}
				});


			
			return false;
		}else if(Personal == ""){
//			alert("Debe escoger un responsable.");	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger un responsable",
					callback: function(result){
						$("#CmpPersonal").focus();
					}
				});


			
			return false;
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



	$("#CmpFechaInicio").keyup(function(){
		
		if($(this).val().length == 10){
			//FncEstablecerAlmacenCierreCalculo($(this).val(),$("#CmpFechaFin").val());		
			FncEstablecerAlmacenCierreCalculo();		
		}
		
	});

	$("#CmpFechaFin").keyup(function(){
		
		if($(this).val().length == 10){
			//FncEstablecerAlmacenCierreCalculo($("#CmpFechaInicio").val(),$(this).val());		
			FncEstablecerAlmacenCierreCalculo();		
		}
		
	});


	$("#CmpFechaInicio").change(function(){
		
		if($(this).val().length == 10){
			//FncEstablecerAlmacenCierreCalculo($(this).val(),$("#CmpFechaFin").val());		
			FncEstablecerAlmacenCierreCalculo();		
		}
		
	});

	$("#CmpFechaFin").change(function(){
		
		if($(this).val().length == 10){
			//FncEstablecerAlmacenCierreCalculo($("#CmpFechaInicio").val(),$(this).val());		
			FncEstablecerAlmacenCierreCalculo();		
		}
		
	});

	
});

function FncEstablecerAlmacenCierreCalculo(){
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
	if(FechaInicio!=""){
		if(FechaFin!=""){
			$.getJSON("formularios/AlmacenCierre/jn/JnAlmacenCierreCalculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin,{}, function(j){
				
				if(j!=null){

					$("#CmpEntradasTotalCompras").val(j.AciEntradasTotalCompras);
					$("#CmpEntradasTotalOtrasFichas").val(j.AciEntradasTotalOtrasFichas);
					$("#CmpEntradasTotalTransferencias").val(j.AciEntradasTotalTransferencias);
					$("#CmpEntradasTotalConversiones").val(j.AciEntradasTotalConversiones);
					
					$("#CmpSalidasTotalFichaIngresos").val(j.AciSalidasTotalFichaIngresos);
					$("#CmpSalidasTotalVentaConcretadas").val(j.AciSalidasTotalVentaConcretadas);
					$("#CmpSalidasTotalOtrasFichas").val(j.AciSalidasTotalOtrasFichas);
					$("#CmpSalidasTotalTransferencias").val(j.AciSalidasTotalTransferencias);
					$("#CmpSalidasTotalConversiones").val(j.AciSalidasTotalConversiones);
					
					
					
				}
				
				
		
			});
			
			//FncAlmacenCierreGenerarArchivo();
			
		}else{
		}
	}else{
		
	}
	
		
}
/*
function FncAlmacenCierreGenerarArchivo(){
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
	if(FechaInicio!=""){
		if(FechaFin!=""){

							$('#CapAlmacenCierreArchivo').html("Generando archivo...");	
					$.ajax({
						type: 'POST',
						url: 'formularios/AlmacenCierre/acc/AccAlmacenCierreGenerarExcel.php',
						data: 'FechaInicio='+FechaInicio+'&FechaFin='+FechaFin,
						success: function(html){
							$('#CapAlmacenCierreArchivo').html(html);	
						}
					});

			
		}
	}
					
					
	
}
*/
