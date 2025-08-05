// JavaScript Document



$().ready(function() {	

	
});	


function FncAlmacenesCargar(){
	
	console.log("FncAlmacenesCargar");
	
	var SucursalId = $("#CmpSucursal").val();
	var AlmacenId = $("#CmpAlmacenId").val();
		
	//if(DepartamentoHabilitado==1){
//		$('#CmpDepartamento').removeAttr('disabled');
//	}else{
//		$('#CmpDepartamento').attr('disabled', 'disabled');
//	}
	
		$("select#CmpAlmacen").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Producto/jn/JnAlmacenes.php",{Sucursal:SucursalId}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(AlmacenId == j[i].AlmId){
						options += '<option selected="selected" value="' + j[i].AlmId + '">' + j[i].AlmNombre + '</option>';					
					}else{
						options += '<option value="' + j[i].AlmId + '">' + j[i].AlmNombre + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron empleados");
				
			}
			
			$("select#CmpAlmacen").html(options);
			
			$("select#CmpAlmacen").unbind();
			$("select#CmpAlmacen").change(function(){

		
			});
			
			
			FncAlmacenFuncion();
			
		});		
		
	
}


function FncAlmacenFuncion(){
	
}
