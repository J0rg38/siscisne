// JavaScript Document

var ProvinciaHabilitado = 1;


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

});	



function FncProvinciasCargar(){
	
	console.log("FncProvinciasCargar");
	
	var Departamento = $("#CmpDepartamento").val();
	var ProvinciaId = $("#CmpProvinciaId").val();
	
	//if(ProvinciaHabilitado==1){
//		$('#CmpProvincia').removeAttr('disabled');
//	}else{
//		$('#CmpProvincia').attr('disabled', 'disabled');
//	}
	
	if(Departamento != ""){

		$("select#CmpProvincia").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnProvincias.php",{Departamento: Departamento}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(ProvinciaId == j[i].UbiProvincia){
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
			
			FncProvinciaFuncion();
			
		});		
		
	}else{

		$("select#CmpProvincia").html("");

	}
}


function FncProvinciaFuncion(){
	
}