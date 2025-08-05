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

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$Identificador = $_POST['Identificador'];
$POST_MonedaId = $_POST['MonedaId'];

session_start();
if (!isset($_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador])){
	$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador] = new ClsSesionObjeto();	
}

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//SesionObjeto-InsInformeTecnicoATS3Operacion
//Parametro1 = ItoId
//Parametro2 = ItoNumero
//Parametro3 = ItoTiempo
//Parametro4 = ItoCostoHora
//Parametro5 = ItoValorTotal
//Parametro6 = ItoEstado
//Parametro7 = ItoTiempoCreacion
//Parametro8 = ItoTiempoModificacion
//Parametro9 = FaeId

$RepSesionObjetos = $_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdObtenerSesionObjetos(true);
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
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="23%" align="center"> Codigo
</th>
<th width="27%" align="center">
  Tiempo
  
</th>
<th align="center">Costo x Hora</th>
<th align="center">Valor Total</th>
<th width="13%" align="center">Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;

//$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	

?>
<tr>
<td align="right"><?php echo $c;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro3;?> hrs</td>
<td width="19%" align="center"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td width="16%" align="center"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td align="center">
  
  <?php
if($_POST['Editar']==1){
?>
  
  
  <a class="EstSesionObjetosItem" href="javascript:FncInformeTecnicoATS3OperacionEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  
  <?php
}
?>
    <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncInformeTecnicoATS3OperacionEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php
		$c++;
		$Total += $DatSesionObjeto->Parametro5;

}
?>
</tbody>
</table>


<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="61%" align="right" class="Total">Total:</td>
  <td width="15%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
</tr>

</tbody>
</table>



<?php
}
?>
