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
$POST_MonedaId = $_POST['MonedaId'];

$POST_Descuento = ((empty($_POST['Descuento']) or $_POST['Descuento']=="undefined")?0:$_POST['Descuento']);
$POST_Total = ((empty($_POST['Total']) or $_POST['Total'] == "undefined" )?0:$_POST['Total']);
$POST_ManoObra = ((empty($_POST['ManoObra']) or $_POST['ManoObra'] == "undefined")?0:$_POST['ManoObra']);

//deb($_POST);
session_start();
if (!isset($_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();
$InsAlmacen = new ClsAlmacen();


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

			//	SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha

$ArrAnulados = array();


$RepSesionObjetos = $_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$_SESSION['SesionSucursal']);
$ArrAlmacenes = $RepAlmacen['Datos'];

$TotalBruto = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	$DatSesionObjeto->Parametro33 = (empty($DatSesionObjeto->Parametro33)?2:$DatSesionObjeto->Parametro33);//
	$DatSesionObjeto->Parametro34 =  (empty($DatSesionObjeto->Parametro34)?2:$DatSesionObjeto->Parametro34);//

	//$TotalBruto += $DatSesionObjeto->Parametro6;
	
		if($DatSesionObjeto->Parametro28==3){
			$TotalBruto += $DatSesionObjeto->Parametro6;
		}
	
}

$Total = $TotalBruto + $POST_Total - $POST_Descuento + $POST_ManoObra;

?>


 <table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
            <tbody class="EstTablaTotalBody">
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td width="64%" align="right" class="Total">Repuestos:</td>
              <td width="12%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalBruto,2);?></td>
            </tr>
            
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Mantenimiento</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($POST_Total,2);?></td>
            </tr>
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Mano de Obra:</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($POST_ManoObra,2);?></td>
            </tr>
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Descuento:</td>
              <td align="right">
             <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span>  <?php echo number_format($POST_Descuento,2);?>
              </td>
            </tr>
            
            
            <tr>
              <td width="17%" align="right" class="Total">&nbsp;</td>
              <td width="7%" align="left" >&nbsp;</td>
              <td align="right" class="Total">Total:</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
              </tr>
            </tbody>
            </table>
            
            


