
function FncGuardar(){
	
	//HACK
	$("#CmpMoneda").removeAttr('disabled');		
	

}



/*
* PUNTO PARTIDA
*/

/*
* DEPARTAMENTO
*/
var DepartamentoHabilitado = 1;

function FncDepartamentosCargar(){
	
	var DepartamentoAux = $("#CmpDepartamentoAux").val();
		
	if(DepartamentoHabilitado==1){
		$('#CmpDepartamento').removeAttr('disabled');
	}else{
		$('#CmpDepartamento').attr('disabled', 'disabled');
	}
	
		$("select#CmpDepartamento").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDepartamentos.php",{Departamento:1}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(DepartamentoAux == j[i].UbiDepartamento){
						options += '<option selected="selected" value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron departamentos");
				
			}
			
			$("select#CmpDepartamento").html(options);
		
			$("select#CmpDepartamento").unbind();	
			$("select#CmpDepartamento").change(function(){

				FncProvinciasCargar();
		
			});
			
		});		
		
	
}


/*
* PROVINCIAS
*/
var ProvinciaHabilitado = 1;

function FncProvinciasCargar(){
	
	var Departamento = $("#CmpDepartamento").val();
	var ProvinciaAux = $("#CmpProvinciaAux").val();
	
	if(ProvinciaHabilitado==1){
		$('#CmpProvincia').removeAttr('disabled');
	}else{
		$('#CmpProvincia').attr('disabled', 'disabled');
	}
	
	if(Departamento != ""){

		$("select#CmpProvincia").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnProvincias.php",{Departamento: Departamento}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(ProvinciaAux == j[i].UbiProvincia){
						options += '<option selected="selected" value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron provincias");
				
			}
			
			$("select#CmpProvincia").html(options);
			
			$("select#CmpProvincia").unbind();	
			$("select#CmpProvincia").change(function(){

				FncDistritosCargar();
		
			});
			
		});		
		
	}else{

		$("select#CmpProvincia").html("");

	}
}


/*
* DISTRITO
*/

var DistritoHabilitado = 1;

function FncDistritosCargar(){
	
	var Provincia = $("#CmpProvincia").val();
	var DistritoAux = $("#CmpDistritoAux").val();
	
	if(DistritoHabilitado==1){
		$('#CmpDistrito').removeAttr('disabled');
	}else{
		$('#CmpDistrito').attr('disabled', 'disabled');
	}
	
	if(Provincia != ""){

		$("select#CmpDistrito").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDistritos.php",{Provincia: Provincia}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(DistritoAux == j[i].UbiDistrito){
						options += '<option selected="selected" value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron distritos");
				
			}
			
			$("select#CmpDistrito").html(options);
			
			$("select#CmpDistrito").unbind();		
			$("select#CmpDistrito").change(function(){

				$.ajax({
					type: 'GET',
					dataType: 'json',
					url: Ruta+'comunes/Ubigeo/jn/JnDistrito.php',
					data: 'Distrito='+$(this).val(),
					success: function(InsDistrito){
												
						if(InsDistrito.UbiId!="" & InsDistrito.UbiId!=null){
							//FncVehiculoEscoger(InsVehiculo.VehId,InsVehiculo.VmaNombre,InsVehiculo.VmoNombre,InsVehiculo.VveNombre,InsVehiculo.VtiNombre,InsVehiculo.VehColor);
							$("#CmpCodigoUbigeo").val(InsDistrito.UbiCodigo);
							
						}else{
							$("#CmpCodigoUbigeo").val("");
							//$('#CmpVehiculo'+oCampo).focus();
							//$('#CmpVehiculo'+oCampo).select();						
						}
						
					}
				});
		
			});
			
		});		
		
	}else{

		$("select#CmpDistrito").html("");

	}
}