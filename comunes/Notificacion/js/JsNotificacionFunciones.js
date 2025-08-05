// JavaScript Document

function FncNotificacionVerificar(){


	$.getJSON('comunes/Notificacion/acc/AccNotificacionVerificar.php',{UsuarioId:""}, function(j){
			
		var notificacion  = "";
		
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
						
						/*		notificacion += '<div class="EstNotificacion">';
								notificacion += '<div class="EstNotificacionBody">';
										
								notificacion += '<div class="EstNotificacionFila">';
							
								notificacion += '<div class="EstNotificacionIcono">';
								notificacion += '<img src="imagenes/mensajes/aviso.png" width="25" height="25" alt="Aviso" title="Aviso" align="absmiddle">';	
								notificacion += '</div>';
						
								notificacion += '<div class="EstNotificacionContenido">';
								notificacion += ''+j[i].NfnDescripcion;
								notificacion += '</div>';
								
							notificacion += '</div>';
							
							notificacion += '<div class="EstNotificacionFila">';
								
								notificacion += '<div class="EstNotificacionBotones">';		
								notificacion += '</div>';
								
								notificacion += '<div class="EstNotificacionBotones">';		
								notificacion += '<a id="'+j[i].NfnId+'" href="'+j[i].NfnEnlace+'&NfnId='+j[i].NfnId +'">'+j[i].NfnEnlaceNombre+'</a>';				
								notificacion += '</div>';
							
							notificacion += '</div>';
							
						notificacion += '</div>';			
						notificacion += '</div>';
					*/	
					
					var notificacion = "";
					
					if( j[i].UsuFotoOrigen!=null && +j[i].UsuFotoOrigen != "" ){
						
						
						notificacion += '<img src="subidos/usuario_fotos/'+j[i].UsuFotoOrigen+'" width="50" heigth="50" border="0" alt=[Foto] title="'+j[i].UsuUsuario+'">';
						
					}else{
					
						notificacion += '<img src="imagenes/default-avatar.png" width="35" heigth="35" border="0" alt=[Foto] title="'+j[i].UsuUsuario+'" align="absmiddle" >';		
					}
					
					notificacion += '<br>';					
					notificacion += j[i].NfnDescripcion+ '';
					notificacion += '<br>';
					notificacion += '<a id="'+j[i].NfnId+'" href="'+j[i].NfnEnlace+'&NfnId='+j[i].NfnId +'">'+j[i].NfnEnlaceNombre+'</a>';				

					dhtmlx.message({ 
					type:"info", 
					left:'10',
					text:""+notificacion+"",
					expire: 5 });
					
							
				}
				
			}else{
			
			
				dhtmlx.message({ type:"info", text:"No tiene notificaciones el dia de hoy.",expire: -3 });
				
			}
			
			
		});		
		
		/*
	$.ajax({
		type: 'POST',
		url: 'comunes/Notificacion/acc/AccNotificacionVerificar.php',
		data: '',
		success: function(respuesta){

			//if(respuesta == 2){
			if(respuesta != ""){
	
//			 $.ionSound.play("door_bell");	 
	 			//alert(respuesta);				
//				dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/alerta.png' width='25' height='25' border='0' > "+respuesta+"</p>" });
//				dhtmlx.message({ type:"info", text:"<p>"+respuesta+"</p>" });
				dhtmlx.message({ type:"info", text:""+respuesta+"",expire: -3 });
			//	dhtmlx.message({ type:"error", text:respuesta });
				
				
		
			}

		}
	});
			*/

}

function FncNotificacionMostrar(){
	
}