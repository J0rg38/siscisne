// JavaScript Document

$(function(){
	$("select#CmpSucursal").change(function(){
	
		if($(this).val()==""){
			$("#CapSucursalImagen").html("");			
		}else{
			$.getJSON("comunes/Sucursal/JnSucursal.php",{Id: $(this).val()}, function(j){
				 
				$("#CapSucursalImagen").html('<img src="subidos/sucursal/'+j.SucImagenThumb+'" border="0" alt="'+j.SucImagen+'" /> ');
			})
		}
	})
})





function FncValidar(){

		var Usuario = $("#CmpUsuario").val();
		var Contrasena = $("#CmpContrasena").val();
		var Sucursal = $("#CmpSucursal").val();
		
		if(Usuario == ""){		

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un usuario",
					callback: function(result){
						$("#CmpUsuario").focus();
					}
				});
					
			return false;
			
		}else if(Contrasena == ""){			
	
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una contraseña",
					callback: function(result){
						$("#CmpContrasena").focus();
					}
				});
		return false;
		}else if(Sucursal == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una sucursal",
					callback: function(result){
						$("#CmpSucursal").focus();
					}
				});
				return false;
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	$('#FrmSesion').on('submit', function() {

		return FncValidar();

	});

/*
* EVENTOS - NAVEGACION
*/		

	//if( isMobile.any() ) {
//		$('#CmpVersionCelular').prop('checked', true);
//	}
//	
	
	
});