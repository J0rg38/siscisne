// JavaScript Document

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

});	



/*
* Funciones PopUp Formulario
*/

function FncCuentaCargar(){
	
	var MonedaId = $("#CmpMonedaId").val();
	var BancoId = $("#CmpBancoId").val();

	var TarjetaId = $("#CmpTarjeta").val();
	
	var CuentaId = $("#CmpCuenta").val();


		$("select#CmpCuenta").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/FormaPago/JnCuenta.php",{Moneda: MonedaId,Banco:BancoId,Tarjeta:TarjetaId}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
			
				for (var i = 0; i < j.length; i++) {
					if(CuentaId == j[i].CueId){
						options += '<option selected="selected" value="' + j[i].CueId + '">' + j[i].BanNombre + ' - ' + j[i].CueNumero + ' - ' + j[i].MonNombre + '</option>';					
					}else{
						options += '<option value="' + j[i].CueId + '">' + j[i].BanNombre + ' - ' + j[i].CueNumero + ' - ' + j[i].MonNombre + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron cuentas");
				
			}
			
			$("select#CmpCuenta").html(options);
			
			FncCuentaFuncion();
			
		});		
		

}


function FncCuentaFuncion(){
	
}