// JavaScript Document


function FncVehiculoColoresCargar(){
	
	
	var VehiculoMarcaId = $("#CmpVehiculoMarca").val();
	var VehiculoModeloId = $("#CmpVehiculoModelo").val();
	var VehiculoVersionId = $("#CmpVehiculoVersion").val();
	var VehiculoColorId = $("#CmpVehiculoColorId").val();
	//alert(VehiculoMarcaId + " - " +  VehiculoModeloId + " - " + VehiculoVersionId);
	if(VehiculoColorHabilitado==1){
		$('#CmpVehiculoColor').removeAttr('disabled');
	}else{
		$('#CmpVehiculoColor').attr('disabled', 'disabled');
	}

	if(VehiculoMarcaId != "" && VehiculoModeloId != "" && VehiculoVersionId != ""){

		$("select#CmpVehiculoColor").html('<option value="">Escoja una opcion</option>');
		
		$.getJSON("comunes/Vehiculo/JnVehiculoColor.php",{Marca: VehiculoMarcaId, Modelo: VehiculoModeloId, Version: VehiculoVersionId}, function(j){

		var options = '';
		options += '<option value="">Escoja una opcion</option>';			
	
		if(j.length != 0){
			
			for (var i = 0; i < j.length; i++) {
				if(VehiculoColorId == j[i].VehId){
					options += '<option selected="selected" value="' + j[i].VehId + '">' + j[i].VcoNombre + '</option>';		
				}else{
					options += '<option value="' + j[i].VehId + '">' + j[i].VcoNombre + '</option>';				
				}
			}

			
		}else{
			alert("No se encontraron colores");			
		}
			$("select#CmpVehiculoColor").html(options);
			
			FncVehiculoColorFuncion();
		});		
		
	}else{
		$("select#CmpVehiculoColor").html("");
	}
}


function FncVehiculoColorFuncion(){
	
}