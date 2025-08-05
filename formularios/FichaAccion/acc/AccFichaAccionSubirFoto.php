<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_GET['Identificador'];
$ModalidadIngreso = $_GET['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}



//if (!isset($_SESSION['InsFichaAccionFoto'.$Identificador])){	
//	$_SESSION['InsFichaAccionFoto'.$Identificador] = new ClsSesionObjeto();
//}else{	
//	$_SESSION['InsFichaAccionFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionFoto'.$Identificador]);
//}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link rel="stylesheet" type="text/css" href="../../../estilos/CssGeneral.css"/>

</head>

<!--
Nombre: JQUERY
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>

<!--
Nombre: UPLOADIFY
Descripcion: 
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>uploadify/jquery.uploadify.min.js"></script>  

<body>

<?php

$RepFichaAccionFoto = $_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrFichaAccionFotos = $RepFichaAccionFoto['Datos'];

deb('InsFichaAccionFoto'.$ModalidadIngreso.$Identificador);
deb($ArrFichaAccionFotos);
?>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" valign="top">
        
            <form>
                <div id="queue"></div>
                <input id="file_upload" name="file_upload" type="file" multiple="true">
            </form>
        
            <script type="text/javascript">
                <?php $timestamp = time();?>
                $(function() {
                    $('#file_upload').uploadify({
                        'formData'     : {
                            'timestamp' : '<?php echo $timestamp;?>',
                            'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
                            'Identificador' : '<?php echo $Identificador;?>',
                            'ModalidadIngreso' : '<?php echo $ModalidadIngreso;?>'					
                        },
                        'swf'      : '../../../librerias/uploadify/uploadify.swf',
                        'uploader' : 'AccFichaAccionSubirFoto2.php',
						'onUploadComplete' : function(file) {
							
						}
                    });
                });
            </script>
        
            </td>
        </tr>
        <tr>
        <td>
			
            <a href="javascript:location.reload();">[Recargar]</a>
            
            <table class="EstTablaListado">
            <tbody class="EstTablaListadoBody">

				<?php
                foreach($ArrFichaAccionFotos as $DatFichaAccionFoto){
                ?>
                <tr>
                    <td>
                         <?php echo $DatFichaAccionFoto->FafArchivo;?>               	
                    </td>
                    <td>
                    ddfssdf
                    </td>
                </tr>
                <?php
                }
                ?>

            </tbody>
            </table>
        
        
        </td>
        </tr>
		</table>



</body>
</html>





	
	