// JavaScript Document

var DistritoHabilitado = 1;


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

});	



function FncDistritosCargar(){
	
	console.log("FncDistritosCargar");
	
	var Provincia = $("#CmpProvincia").val();
	var DistritoId = $("#CmpDistritoId").val();
	
	//if(DistritoHabilitado==1){
//		$('#CmpDistrito').removeAttr('disabled');
//	}else{
//		$('#CmpDistrito').attr('disabled', 'disabled');
//	}
	
	if(Provincia != ""){

		$("select#CmpDistrito").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDistritos.php",{Provincia: Provincia}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(DistritoId == j[i].UbiDistrito){
						options += '<option selected="selected" value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron distritos");
				
			}
			
			$("select#CmpDistrito").html(options);
			
			FncDistritoFuncion();
			
		});		
		
	}else{

		$("select#CmpDistrito").html("");

	}
}


function FncDistritoFuncion(){
	
}