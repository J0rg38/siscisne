// JavaScript Document

var DepartamentoHabilitado = 1;

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

	//if($("#CmpDepartamentoId").val()==""){


});	



/*
* Funciones PopUp Formulario
*/


function FncDepartamentosCargar(){
	
	console.log("FncDepartamentosCargar");
	
	var DepartamentoId = $("#CmpDepartamentoId").val();
		
	//if(DepartamentoHabilitado==1){
//		$('#CmpDepartamento').removeAttr('disabled');
//	}else{
//		$('#CmpDepartamento').attr('disabled', 'disabled');
//	}
	
		$("select#CmpDepartamento").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDepartamentos.php",{Departamento:1}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(DepartamentoId == j[i].UbiDepartamento){
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
			
			
			FncDepartamentoFuncion();
			
		});		
		
	
}


function FncDepartamentoFuncion(){
	
}