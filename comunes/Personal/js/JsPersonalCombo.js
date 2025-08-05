// JavaScript Document

var Ventas = "";
var Almacen = "";
var Recepcion = "";
var Taller = "";
var Libres = "";

$().ready(function() {	

	
});	


function FncPersonalesCargar(){
	
	console.log("FncPersonalesCargar");
	
	var SucursalId = $("#CmpSucursal").val();
	var PersonalId = $("#CmpPersonalId").val();
		
	//if(DepartamentoHabilitado==1){
//		$('#CmpDepartamento').removeAttr('disabled');
//	}else{
//		$('#CmpDepartamento').attr('disabled', 'disabled');
//	}
	
		$("select#CmpPersonal").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Personal/jn/JnPersonales.php",{Sucursal:SucursalId,Ventas:Ventas,Ventas:Ventas,Recepcion:Recepcion,Taller:Taller,Libres:Libres}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(PersonalId == j[i].PerId){
						options += '<option selected="selected" value="' + j[i].PerId + '">' + j[i].PerNombre+ ' '+ j[i].PerApellidoPaterno+ ' '+ j[i].PerApellidoMaterno + '</option>';					
					}else{
						options += '<option value="' + j[i].PerId + '">' + j[i].PerNombre+ ' '+ j[i].PerApellidoPaterno+ ' '+ j[i].PerApellidoMaterno + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron empleados");
				
			}
			
			$("select#CmpPersonal").html(options);
			
			$("select#CmpPersonal").unbind();
			$("select#CmpPersonal").change(function(){

		
			});
			
			
			FncPersonalFuncion();
			
		});		
		
	
}


function FncPersonalFuncion(){
	
}
