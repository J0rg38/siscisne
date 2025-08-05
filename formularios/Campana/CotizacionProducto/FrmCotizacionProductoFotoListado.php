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
$POST_Tipo = $_POST['Tipo'];

session_start();
if (!isset($_SESSION['InsCotizacionProductoFoto'.$Identificador])){
	$_SESSION['InsCotizacionProductoFoto'.$Identificador] = new ClsSesionObjeto();	
}
//		SesionObjeto-FichaAccionFoto
//		Parametro1 = FafId
//		Parametro2 =
//		Parametro3 = FafArchivo
//		Parametro4 = FafEstado
//		Parametro5 = FafTiempoCreacion
//		Parametro6 = FafTiempoModificacion

$RepSesionObjetos = $_SESSION['InsCotizacionProductoFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>

    <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
   
    <tbody class="EstTablaListadoBody">
    
    <?php
    $c = 1;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
		
		//deb($POST_Tipo. " - " .$DatSesionObjeto->Parametro7);
		if($POST_Tipo == $DatSesionObjeto->Parametro7){
		
    ?>
    <tr>
    <td align="left" valign="top">
      
	<!--<a target="_blank" href="subidos/cotizacion_producto_fotos/<?php echo $DatSesionObjeto->Parametro3;?>">
      <img src="subidos/cotizacion_producto_fotos/<?php echo $DatSesionObjeto->Parametro3;?>" alt="<?php echo $DatSesionObjeto->Parametro3;?>" title="<?php echo $DatSesionObjeto->Parametro3;?>" width="50" height="50" border="0" /></a><br />-->
    
    <?php echo $c;?>.- 
      <a target="_blank" href="subidos/cotizacion_producto_fotos/<?php echo $DatSesionObjeto->Parametro3;?>"><?php echo $DatSesionObjeto->Parametro3;?>
    </a>
      
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncCotizacionProductoFotoEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $POST_Tipo;?>');" >
        <img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="15" height="15" border="0"  /> [Eliminar]</a>
      <?php
    }
    ?>
      
    </td>
    
   
    </tr>
   
   
    <?php
            $c++;
  
       }
    }
    ?>
    </tbody>
    </table>
    

    
<?php
}
?>
