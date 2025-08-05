<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSeguridad
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsCorreo {
    //put your code here
	
	public $CorDestinatario;
	public $CorRemitenteCorreo;
	public $CorRemitenteNombre;
	public $CorAsunto;
	public $CorContenido;
	
	public function __construct(){
		
	}
	
	public function MtdEnviarCorreo($CorDestinatario,$CorRemitenteCorreo,$CorRemitenteNombre,$CorAsunto,$CorContenido,$oCorRutaAdjunto=NULL,$oCorAdjunto=NULL,$oResponder=NULL,$oResponderNombre=NULL){
		
		global  $SistemaCorreoUsuario;
		global  $SistemaCorreoContrasena;
		
		//$CorRemitenteCorreo = "canepatacna@gmail.com";
		
		if(!empty($CorDestinatario) and !empty($CorRemitenteCorreo) and !empty($CorRemitenteNombre) and !empty($CorAsunto) and !empty($CorContenido)){
			
						
			$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Timeout       =   120; // set the timeout (seconds)
   			$mail->SMTPKeepAlive = true; // don't close the connection between messages
	
			//$mail->Host       = "mail.cyc.com.pe"; // SMTP server
			$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "tls";//"ssl";                 // sets the prefix to the servier
			$mail->SMTPSecure = "ssl";//"ssl";                 // sets the prefix to the servier
			$mail->Host       = "mail.cisne.com.pe";      // sets GMAIL as the SMTP server
			$mail->Port       = 465;//587;                   // set the SMTP port for the GMAIL server
			$mail->Username   =  $SistemaCorreoUsuario;  // GMAIL username
			$mail->Password   = $SistemaCorreoContrasena;            // GMAIL password
			$mail->SetFrom($SistemaCorreoUsuario, $CorRemitenteNombre);
			$mail->CharSet = 'UTF-8';
			
			if(!empty($oResponder)){
			
				 $mail->ClearReplyTos();
				 $mail->addReplyTo($oResponder, $oResponderNombre);
					
			}
			
			
			//$mail->AddReplyTo('name@yourdomain.com', 'First Last');
			$mail->Subject = $CorAsunto;		
			$mail->AltBody = ''; // optional - MsgHTML will create an alternate automatically
			
			$mensaje  = "";
			$mensaje .= "<html>";
			$mensaje .= "<head>";
			$mensaje .= "</head>";
			$mensaje .= "<body>";
			
			$mensaje .= $CorContenido;
			
			$mensaje .= "</body>";
			$mensaje .= "</html>";
			
			$mail->MsgHTML( $mensaje);
			
			if(is_array($oCorAdjunto)){
				
				if(!empty($oCorAdjunto)){
					foreach($oCorAdjunto as $DatAdjunto){
						$mail->AddAttachment($oCorRutaAdjunto.$DatAdjunto);
					}
				}
				
			}else{
			
				if(!empty($oCorAdjunto)){
					$mail->AddAttachment($oCorRutaAdjunto.$oCorAdjunto);
				}	
			}
			//if(!empty($oCorAdjunto)){
//				$mail->AddAttachment($oCorRutaAdjunto.$oCorAdjunto);
//			}
			
			$ArrDestinatarios = explode(",",$CorDestinatario);
							
			foreach($ArrDestinatarios as $DatDestinatario){
								
				if(!empty($DatDestinatario)){
					$mail->AddAddress($DatDestinatario, '');
				}
								
			}
			
			$mail->Send();		
	

		}
	
	
	}
}
?>
