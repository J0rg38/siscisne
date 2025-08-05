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
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

$POST_ProveedorId = $_POST['ProveedorId'];
$POST_MonedaId = $_POST['MonedaId'];

session_start();
if (!isset($_SESSION['InsDesembolsoComprobante'.$Identificador])){
	$_SESSION['InsDesembolsoComprobante'.$Identificador] = new ClsSesionObjeto();	
}



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

/*
SesionObjeto-DesembolsoComprobanteListado
Parametro1 = DcoId
Parametro2 = 
Parametro3 = AmoId
Parametro4 = AmoComprobanteNumero
Parametro5 = AmoComprobanteFecha
Parametro6 = AmoTotal
Parametro7 = PrvId
Parametro8 = MonId
Parametro9 = AmoTipoCambio
Parametro10 = MonNombre
Parametro11 = MonSimbolo
Parametro12 = PrvNombre
Parametro13 = PrvNumeroDocumento
*/

$RepSesionObjetos = $_SESSION['InsDesembolsoComprobante'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="17">#</th>
  <th width="44">Id</th>
  <th width="82">Num. Doc.</th>
  <th width="407">Proveedor</th>
  <th width="135">Num. Comprob.</th>
  <th width="91">Fecha Comprob.</th>
  <th width="78">Moneda</th>
  <th width="63">Total</th>
  <th width="13">&nbsp;</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
	<?php
	
	//deb($DatSesionObjeto->Parametro7." - ".$POST_ProveedorId);
	if($DatSesionObjeto->Parametro7 == $POST_ProveedorId and  $DatSesionObjeto->Parametro8 == $POST_MonedaId){
	?>
   
        <tr>
        <td align="center" valign="top"><?php echo $c;?></td>
        <td align="right" valign="top">
            <?php echo $DatSesionObjeto->Parametro3;?>
        </td>
        <td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro13;?></td>
        <td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro12;?></td>
        <td align="right" valign="top">
          <?php echo utf8_encode($DatSesionObjeto->Parametro4);?>
        </td>
        <td align="right" valign="top">
            <?php echo $DatSesionObjeto->Parametro5;?>
        </td>
        <td width="78" align="right" valign="top"><?php echo $DatSesionObjeto->Parametro11;?></td>
        <td width="63" align="right" valign="top"><?php
        if($DatSesionObjeto->Parametro8<>$EmpresaMonedaId){
        ?>
          <?php echo number_format(($DatSesionObjeto->Parametro6),2);?>
          <?php	
        }else{
        
        ?>
          <?php echo number_format(($DatSesionObjeto->Parametro6 * $DatSesionObjeto->Parametro9),2);?>
          <?php	
        }
        ?></td>
        <td width="13" align="right" valign="top">&nbsp;</td>
        </tr>
     
    <?php	
	}
	?>
    
    
    
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
