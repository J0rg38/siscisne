// JavaScript Document

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

});	



/*
* Funciones PopUp Formulario
*/

function FncTarjetaCargar(){
	
	var MonedaId = $("#CmpMonedaId").val();
	var CuentaId = $("#CmpCuenta").val();
	
	var TarjetaId = $("#CmpTarjeta").val();

		$("select#CmpTarjeta").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/FormaPago/JnTarjeta.php",{Moneda: MonedaId,Cuenta:CuentaId}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
			
				for (var i = 0; i < j.length; i++) {
					if(TarjetaId == j[i].TarId){
						options += '<option selected="selected" value="' + j[i].TarId + '">' + j[i].TarNombre + ' - ' + j[i].MonNombre + '</option>';					
					}else{
						options += '<option value="' + j[i].TarId + '">' + j[i].TarNombre  + ' - ' + j[i].MonNombre + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron cuentas");
				
			}
			
			$("select#CmpTarjeta").html(options);
			
			FncTarntaFuncion();
			
		});		
		

}


function FncTarntaFuncion(){
	
}