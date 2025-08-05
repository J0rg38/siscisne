<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$ModalidadIngresoId = $_POST['ModalidadIngresoId'];

session_start();
if (!isset($_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}
//		SesionObjeto-FichaAccionFoto
//		Parametro1 = FafId
//		Parametro2 =
//		Parametro3 = FafArchivo
//		Parametro4 = FafEstado
//		Parametro5 = FafTiempoCreacion
//		Parametro6 = FafTiempoModificacion

//deb('InsFichaAccionFoto'.$ModalidadIngreso.$Identificador);
$RepSesionObjetos = $_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb(session_id());
//deb($ArrSesionObjetos)
?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>

    

    
    <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
    <table class="EstTablaListado" cellpadding="0" cellspacing="0" border="0">
   
    <tbody class="EstTablaListadoBody">
    <tr>
    <?php
    $c = 1;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
    ?>
    
    <td align="left" valign="top">
      
	<a target="_blank" href="subidos/ficha_accion_fotos/<?php echo $DatSesionObjeto->Parametro3;?>">
      <img src="subidos/ficha_accion_fotos/<?php echo $DatSesionObjeto->Parametro3;?>" alt="<?php echo $DatSesionObjeto->Parametro3;?>" title="<?php echo $DatSesionObjeto->Parametro3;?>" width="50" height="50" border="0" /></a><br />
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncFichaAccionFotoEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
        <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /> [Eliminar]</a>
      <?php
    }
    ?>
      
    </td>
    
    <?php
	if($c%5==0){
	?>
    </tr><tr>
    <?php
	}
	?>
   
    <?php
            $c++;
  
       
    }
    ?> </tr>
    </tbody>
    </table>
    

    
<?php
}
?>
