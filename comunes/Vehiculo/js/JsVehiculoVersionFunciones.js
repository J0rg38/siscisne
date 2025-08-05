// JavaScript Document

var VehiculoVersionHabilitado = 1;
var VehiculoVersionVigencia = 0

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	
	if($("#CmpVehiculoVersionId").val()==""  || $("#CmpVehiculoVersionId").val() == null){
		$("#BtnVehiculoVersionEditar").hide();
		$("#BtnVehiculoVersionRegistrar").show();
	}else{
		$("#BtnVehiculoVersionEditar").show();
		$("#BtnVehiculoVersionRegistrar").hide();
	}

});	








/* 
* Funciones PopUp Formulario
*/

function FncVehiculoVersionCargarFormulario(oForm){

	var VehiculoVersionId = $("#CmpVehiculoVersion").val();
	var VehiculoVersionNombre = $("#CmpVehiculoVersionNombre").val();

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();	

	tb_show(this.title,'principal2.php?Mod=VehiculoVersion&Form='+oForm+'&Dia=1&Id='+VehiculoVersionId+'&VehiculoVersionNombre='+VehiculoVersionNombre+'&VehiculoMarca='+VehiculoMarca+'&VehiculoModelo='+VehiculoModelo+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=450&modal=true',this.rel);	
		
}


function FncTBCerrarFunncion(oModulo){
	
	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			try{
				eval("Fnc"+oModulo+"Buscar('Id');");		
			}catch(e){
				
			}		
		}
	}

}



function FncVehiculoVersionBuscar(oCampo){
	FncVehiculoVersionesCargar();
	
	
	
	
//	var Dato = $('#CmpVehiculoVersion'+oCampo).val();
//	
//	if(Dato==""){
//		$('#CmpVehiculoVersion'+oCampo).focus();
//		$('#CmpVehiculoVersion'+oCampo).select();		
//	}else{
//				
//		$.ajax({
//		type: 'POST',
//		dataType : 'json',
//		url: 'comunes/Vehiculo/acc/AccVehiculoVersionBuscar.php',
//		data: 'Campo='+oCampo+'&Dato='+Dato,
//		success: function(InsVehiculoIngreso){
//				if(InsVehiculoIngreso.EinId!=null){		
//							
//					FncVehiculoIngresoEscoger(InsVehiculoIngreso.EinId,InsVehiculoIngreso.EinVIN,InsVehiculoIngreso.EinPlaca,InsVehiculoIngreso.EinColor,InsVehiculoIngreso.EinAnoFabricacion,InsVehiculoIngreso.VmaId,InsVehiculoIngreso.VmoId,InsVehiculoIngreso.VveId ,InsVehiculoIngreso.VmaNombre,InsVehiculoIngreso.VmoNombre,InsVehiculoIngreso.VveNombre,InsVehiculoIngreso.CliId,InsVehiculoIngreso.EinAnoVehiculo,InsVehiculoIngreso.EinAnoModelo,InsVehiculoIngreso.EinNumeroMotor);
//					
//				}
//			}
//		});	
//	}

}


function FncVehiculoVersionesCargar(){
	
	console.log("FncVehiculoVersionesCargar");
	
	var VehiculoModeloId = $("#CmpVehiculoModelo").val();
	var VehiculoVersionId = $("#CmpVehiculoVersionId").val();

	var VehiculoVersion = $("#CmpVehiculoVersion").val();

//	if(VehiculoVersion ==""  || VehiculoVersion == null){
//		$("#BtnVehiculoVersionEditar").hide();
//		$("#BtnVehiculoVersionRegistrar").show();
//	}else{
//		$("#BtnVehiculoVersionEditar").show();
//		$("#BtnVehiculoVersionRegistrar").hide();
//	}
	
	
	//if(VehiculoVersionHabilitado==1){
//		$('#CmpVehiculoVersion').removeAttr('disabled');
//	}else{
//		$('#CmpVehiculoVersion').attr('disabled', 'disabled');
//	}

	if(VehiculoModeloId != ""){

		$("select#CmpVehiculoVersion").html('<option value="">Escoja una opcion</option>');
		
		$.getJSON("comunes/Vehiculo/JnVehiculoVersion.php",{Modelo: VehiculoModeloId,VehiculoVersionVigencia:VehiculoVersionVigencia}, function(j){
		
			var options = '';
			
			options += '<option value="">Escoja una opcion</option>';
			
			if(j.length != 0){
				
				for (var i = 0; i < j.length; i++) {
					if(VehiculoVersionId == j[i].VveId){
						options += '<option selected="selected" value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';		
					}else{
						options += '<option value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';				
					}
				}
				
			}else{
				alert("No se encontraron versiones");
			}
			
			$("select#CmpVehiculoVersion").html(options);


			if($("#CmpVehiculoVersion").val()==""  || $("#CmpVehiculoVersion").val() == null){
				$("#BtnVehiculoVersionEditar").hide();
				$("#BtnVehiculoVersionRegistrar").show();
			}else{
				$("#BtnVehiculoVersionEditar").show();
				$("#BtnVehiculoVersionRegistrar").hide();
			}
			
			FncVehiculoVersionFuncion();
		});		
		
		
		
			$("select#CmpVehiculoVersion").change(function(){

				$.getJSON("comunes/Vehiculo/JnVehiculoVersionDatos.php",{VehiculoVersionId: $(this).val()}, function(j){
					if(j.length != 0){
						
						
						
						$("#CmpVehiculoVersionCaracteristica1").val(j.VveCaracteristica1);
						$("#CmpVehiculoVersionCaracteristica2").val(j.VveCaracteristica2);
						$("#CmpVehiculoVersionCaracteristica3").val(j.VveCaracteristica3);
						$("#CmpVehiculoVersionCaracteristica4").val(j.VveCaracteristica4);
						$("#CmpVehiculoVersionCaracteristica5").val(j.VveCaracteristica5);
						$("#CmpVehiculoVersionCaracteristica6").val(j.VveCaracteristica6);
						$("#CmpVehiculoVersionCaracteristica7").val(j.VveCaracteristica7);
						$("#CmpVehiculoVersionCaracteristica8").val(j.VveCaracteristica8);
						$("#CmpVehiculoVersionCaracteristica9").val(j.VveCaracteristica9);
						$("#CmpVehiculoVersionCaracteristica10").val(j.VveCaracteristica10);
						
						$("#CmpVehiculoVersionCaracteristica11").val(j.VveCaracteristica11);
						$("#CmpVehiculoVersionCaracteristica12").val(j.VveCaracteristica12);
						$("#CmpVehiculoVersionCaracteristica13").val(j.VveCaracteristica13);
						$("#CmpVehiculoVersionCaracteristica14").val(j.VveCaracteristica14);
						$("#CmpVehiculoVersionCaracteristica15").val(j.VveCaracteristica15);
						$("#CmpVehiculoVersionCaracteristica16").val(j.VveCaracteristica16);
						$("#CmpVehiculoVersionCaracteristica17").val(j.VveCaracteristica17);
						$("#CmpVehiculoVersionCaracteristica18").val(j.VveCaracteristica18);
						$("#CmpVehiculoVersionCaracteristica19").val(j.VveCaracteristica19);
						$("#CmpVehiculoVersionCaracteristica20").val(j.VveCaracteristica20);
						
							
					}
				});	
				
				
		
			});
			
			
	}else{
		
		$("#BtnVehiculoVersionEditar").hide();
		$("#BtnVehiculoVersionRegistrar").show();
		
		$("select#CmpVehiculoVersion").html("");
		
	}
}


function FncVehiculoVersionFuncion(){
	
}

function FncCargarVehiculoVersionCaracteristicas(){

	var VehiculoVersionId = $("#CmpVehiculoVersionId").val();
	
	if(VehiculoVersionId!=""){
		
		$.getJSON("comunes/Vehiculo/JnVehiculoVersionDatos.php",{VehiculoVersionId: VehiculoVersionId}, function(j){
			if(j.length != 0){
				
				if(j.VveCaracteristica1!=null){
					
					
				}	
						$("#CmpVehiculoVersionCaracteristica1").val(j.VveCaracteristica1);
						$("#CmpVehiculoVersionCaracteristica2").val(j.VveCaracteristica2);
						$("#CmpVehiculoVersionCaracteristica3").val(j.VveCaracteristica3);
						$("#CmpVehiculoVersionCaracteristica4").val(j.VveCaracteristica4);
						$("#CmpVehiculoVersionCaracteristica5").val(j.VveCaracteristica5);
						$("#CmpVehiculoVersionCaracteristica6").val(j.VveCaracteristica6);
						$("#CmpVehiculoVersionCaracteristica7").val(j.VveCaracteristica7);
						$("#CmpVehiculoVersionCaracteristica8").val(j.VveCaracteristica8);
						$("#CmpVehiculoVersionCaracteristica9").val(j.VveCaracteristica9);
						$("#CmpVehiculoVersionCaracteristica10").val(j.VveCaracteristica10);
						
						$("#CmpVehiculoVersionCaracteristica11").val(j.VveCaracteristica11);
						$("#CmpVehiculoVersionCaracteristica12").val(j.VveCaracteristica12);
						$("#CmpVehiculoVersionCaracteristica13").val(j.VveCaracteristica13);
						$("#CmpVehiculoVersionCaracteristica14").val(j.VveCaracteristica14);
						$("#CmpVehiculoVersionCaracteristica15").val(j.VveCaracteristica15);
						$("#CmpVehiculoVersionCaracteristica16").val(j.VveCaracteristica16);
						$("#CmpVehiculoVersionCaracteristica17").val(j.VveCaracteristica17);
						$("#CmpVehiculoVersionCaracteristica18").val(j.VveCaracteristica18);
						$("#CmpVehiculoVersionCaracteristica19").val(j.VveCaracteristica19);
						$("#CmpVehiculoVersionCaracteristica20").val(j.VveCaracteristica20);
						
				
			
				
			}
		});		
		
	}else{
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una version de vehiculo",
					callback: function(result){
						
					}
				});
		
	}
	
	
}