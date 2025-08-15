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

session_start();
if (!isset($_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}


/*
SesionObjeto-FichaIngresoProducto
Parametro1 = FidId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = ProCodigoOriginal
Parametro5 = ProCodigoAlternativo
Parametro6 = 
Parametro7 = FipTiempoCreacion
Parametro8 = FipTiempoModificacion
Parametro9 = UmeId
Parametro10 = FipCantidad
Parametro11 = UmeNombre
*/
		
// Verificar que la clase esté disponible antes de deserializar
if (!class_exists('ClsSesionObjeto')) {
    require_once('../../clases/ClsSesionObjeto.php');
}

// Verificar que el objeto de sesión sea válido
if (isset($_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador]) && 
    is_object($_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador])) {
    
    try {
        $RepSesionObjetos = $_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
        $ArrSesionObjetos = $RepSesionObjetos['Datos'] ?? [];
        $SesionObjetosTotal = $RepSesionObjetos['Total'] ?? 0;
        $SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'] ?? 0;
    } catch (Exception $e) {
        error_log("Error al obtener sesión objetos: " . $e->getMessage());
        $ArrSesionObjetos = [];
        $SesionObjetosTotal = 0;
        $SesionObjetosTotalSeleccionado = 0;
    }
} else {
    $ArrSesionObjetos = [];
    $SesionObjetosTotal = 0;
    $SesionObjetosTotalSeleccionado = 0;
}


?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="12%" align="center">Cod. Original</th>
  <th width="52%" align="center"> Nombre
</th>
  <th width="12%" align="center">U.M.</th>
  <th width="10%" align="center">Cantidad</th>
<th width="12%" align="center"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
<tr>
<td align="right" valign="top"><?php echo $c;?></td>
<td align="left" valign="top"><?php echo $DatSesionObjeto->Parametro17;?></td>
<td align="left" valign="top"><?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="left" valign="top"><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="left" valign="top"><?php echo number_format($DatSesionObjeto->Parametro9,2,'.','');?></td>
<td align="center" valign="top">
  
  <?php
if($_POST['Editar']==1){
?>

<a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoProductoEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>

<?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncFichaIngresoProductoEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?>
  
  
</td>
</tr>
<?php
	$TotalItems++;
$c++;
}




?>
</tbody>
</table>
<br />
<?php
}
?>




