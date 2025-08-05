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

session_start();
if (!isset($_SESSION['InsTallerPedidoGasto'.$Identificador])){
	$_SESSION['InsTallerPedidoGasto'.$Identificador] = new ClsSesionObjeto();	
}


	
//SesionObjeto-TallerPedidoGasto
//Parametro1 = FigId
//Parametro2 = GasId
//Parametro3 = GasComprobanteNumero
//Parametro4 = GasComprobanteFecha
//Parametro5 = GasTotal
//Parametro6 = FigEstado
//Parametro7 = GasTiempoCreacion
//Parametro8 = GasTiempoModificacion
//Parametro9 = PrvNombre
//Parametro10 = PrvApellidoPaterno
//Parametro11 = PrvApellidoMaterno
//Parametro12 = MonNombre
//Parametro13 = MonSimbolo
//Parametro14 = GasTipoCambio
//Parametro15 = MonId
//Parametro16 = GasFoto
//Parametro17 = GasConcepto

$RepSesionObjetos = $_SESSION['InsTallerPedidoGasto'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="9%" align="center">Num. Comprob.</th>
  <th width="11%" align="center">Fecha Comprob.</th>
  <th width="28%" align="center"> Proveedor</th>
  <th width="12%" align="center">Concepto</th>
  <th width="7%" align="center">Moneda</th>
  <th width="7%" align="center">T.C.</th>
  <th width="9%" align="center">Total</th>
  <th width="4%" align="center">Doc. Scan.</th>
  <th width="11%" align="center"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrSesionObjetos as $DatSesionObjeto){

?>


<tr>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $c;?></td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo ($DatSesionObjeto->Parametro3);?></td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo ($DatSesionObjeto->Parametro4);?></td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  
  <?php echo $DatSesionObjeto->Parametro9;?>
<!--   <?php echo $DatSesionObjeto->Parametro10;?>
    <?php echo $DatSesionObjeto->Parametro11;?>
  
  -->
  </td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo ($DatSesionObjeto->Parametro17);?></td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo ($DatSesionObjeto->Parametro13);?></td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo number_format($DatSesionObjeto->Parametro14,3,'.','');?></td>
<td  valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >

<?php $DatSesionObjeto->Parametro5 = (($EmpresaMonedaId==$DatSesionObjeto->Parametro15 or empty($DatSesionObjeto->Parametro15))?$DatSesionObjeto->Parametro5:($DatSesionObjeto->Parametro5/$DatSesionObjeto->Parametro14));?>


<?php echo number_format($DatSesionObjeto->Parametro5,2,'.','');?></td>
<td align="center">



<?php            
if(!empty($DatSesionObjeto->Parametro16)){
	
	$extension = strtolower(pathinfo($DatSesionObjeto->Parametro16, PATHINFO_EXTENSION));
	$nombre_base = basename($DatSesionObjeto->Parametro16, '.'.$extension);  
?>

    <a target="_blank" href="subidos/gastos_fotos/<?php echo $DatSesionObjeto->Parametro16;?>"  title=""><img border="0"  src="imagenes/documento.gif"  /></a>

<?php	
}
?>
</td>
<td align="center">
  
  <?php
if($_POST['Editar']==1){
?>
  
  <a class="EstSesionObjetosItem" href="javascript:FncTallerPedidoGastoEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncTallerPedidoGastoEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?>
  
  
</td>
</tr>
<?php
		
		$c++;
		
	
}




?>
</tbody>
</table>
<br />
<?php
}
?>




