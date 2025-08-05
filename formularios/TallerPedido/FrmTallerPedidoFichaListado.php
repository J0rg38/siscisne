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
$POST_AlmacenId = $_POST['AlmacenId'];

session_start();
if (!isset($_SESSION['InsTallerPedidoFicha'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoFicha'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();

//	SesionObjeto-TallerPedidoFicha
//	Parametro1 = AmoId
//	Parametro2 = AmoFecha
//	Parametro3 = AlmNombre
//	Parametro4 = AmoItems
//	Parametro5 = CliNombre
//	Parametro6 = AmoTiempoCreacion
//	Parametro7 = AmoTiempoModificacion
//	Parametro8 = CliApellidoPaterno
//	Parametro9 = CliApellidoMaterno
//	Parametro10 = AmoTotal
//	Parametro11 = MonNombre
//	Parametro12 = MonSimbolo

//	Parametro13 = GrtNumero
//	Parametro14 = GreId
//	Parametro15 = GrtId

$RepSesionObjetos = $_SESSION['InsTallerPedidoFicha'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb($ArrSesionObjetos);
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
  <th width="6%" align="center">Id</th>
  <th width="9%" align="center">Fecha</th>
  <th width="36%" align="center"> Cliente
</th>
  <th width="11%" align="center">G. Rem.</th>
  <th width="11%" align="center">Almacen</th>
  <th width="9%" align="center">Moneda</th>
  <th width="4%" align="center">Items</th>
  <th width="12%" align="center">Acc.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
	//if($DatSesionObjeto->Parametro18==1){		

	

?>
<tr>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $c;?>
  
  <input style="visibility:hidden;" type="checkbox" name="Chk<?php echo $ModalidadIngreso.$c;?>ProductoId" id="Chk<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId" etiqueta="producto" value="<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" item= "<?php echo $DatSesionObjeto->Item;?>" />
  
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro1;?></td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  <?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
	<?php echo $DatSesionObjeto->Parametro5;?>
    <?php echo $DatSesionObjeto->Parametro8;?>
    <?php echo $DatSesionObjeto->Parametro9;?>
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro13;?>-<?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncTallerPedidoFichaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
/*if($_POST['Eliminar']==1){
?>
<a href="javascript:FncTallerPedidoFichaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
<?php
}*/
?>
  
</td>
</tr>
<?php
		$c++;
		
}

?>



</tbody>
</table>


            
            
            
<?php
}
?>





