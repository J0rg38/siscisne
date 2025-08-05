<?php
session_start();
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


$POST_VehiculoId = $_POST['VehiculoId'];
$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);
$POST_Sucursal = $_POST['Sucursal'];


//deb($_POST);

if(empty($POST_VehiculoId)){
	die("No ha escogido un producto");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardexVehiculo.php');

$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();
$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();
$InsKardexVehiculo = new ClsKardexVehiculo();

//$InsAlmacenStock->ProId = $POST_VehiculoId;
//$InsAlmacenStock->MtdObtenerAlmacenStock();


/*
ENTRADAS
1 - ALMACEN MOVIMIENTO ENTRADA / compras
2 - otros ingresos
6 - TRASLADO ALMACEN
7 - CONVERSION
SALIDAS
1 - ALMACEN MOVIMIENTO SALIDA
2 - TALLER PEDIDO
3 - VENTA CONCRETADA
6 - TRASLADO ALMACEN
7 - CONVERSION
8 - TRANSFERENCIA ENTRADA


*/

if(!empty($POST_AlmacenId)){
	$stipo = "1,2,6";	
}else{
	$stipo = "1,2";
}

//MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) 
$ResVehiculoMovimientoEntradaDetalle = $InsKardexVehiculo->MtdObtenerVehiculoMovimientoEntradaDetalles(NULL,NULL,NULL,'VmvFecha','ASC',NULL,NULL,3,$POST_VehiculoId,$stipo,$POST_Sucursal,$POST_Ano."-01-01",$POST_Ano."-12-31");
$ArrVehiculoMovimientoEntradaDetalles = $ResVehiculoMovimientoEntradaDetalle['Datos'];
?>

        
        
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="EstTablaListado">
<thead class="EstTablaListadoHead">
  <tr>
    <th width="2%" rowspan="2">#</th>
    <th width="5%" rowspan="2">FICHA</th>
    <th width="9%" rowspan="2">FECHA</th>
    <th width="12%" rowspan="2">OPERACION</th>
    <th width="25%" rowspan="2">PROVEEDOR</th>
    <th colspan="2">COMPROB.</th>
    <th colspan="2">ENTRADA</th>
    </tr>
  <tr>
    <th width="8%">NUM. </th>
    <th width="10%">FEC. </th>
    <th width="7%">CANT.</th>
    <th width="9%">U.M.</th>
    </tr>                
  </thead>
<tbody class="EstTablaListadoBody">
<?php
  $i=1;
  $TotalIngresos = 0;
  $TotalIngresosReal = 0;
foreach($ArrVehiculoMovimientoEntradaDetalles as $DatVehiculoMovimientoEntradaDetalle){
?>
 

<tr>
    <td align="left" valign="top"><?php echo $i;?></td>
    <td align="left" valign="top">
      
      <?php //deb($DatVehiculoMovimientoEntradaDetalle->VmvSubTipo);?>
      
      <?php 
    switch($DatVehiculoMovimientoEntradaDetalle->VmvSubTipo){
		
		 case "1":
  ?>
      <a target="_blank" href="principal.php?Mod=VehiculoMovimientoEntrada&Form=Ver&Id=<?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>">
        <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
        </a>
      
  <?php	  
        break;
		
        case "2":
  ?>
      <a target="_blank" href="principal.php?Mod=VehiculoMovimientoEntradaSimple&Form=Ver&Id=<?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>">
        <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
        </a> 	
      <?php  
        break;
        
		    case "3":
  ?>
      <a target="_blank" href="principal.php?Mod=VehiculoMovimientoEntradaSimple&Form=Ver&Id=<?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>">
        <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
        </a> 	
      <?php  
        break;
        
		
		
		 case "6":
  ?>
      <a target="_blank" href="principal.php?Mod=TrasladoVehiculo&Form=Ver&Id=<?php echo $DatVehiculoMovimientoEntradaDetalle->TveId?>">
        <?php echo $DatVehiculoMovimientoEntradaDetalle->TveId?>
        </a> 	
      <?php  
        break;
		
		
		
        default:
  ?>
       <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
      
  <?php	  
        break;
    }
?>
      
    </td>
    <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->VmvFecha?></td>
    <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->TopNombre?></td>
    <td align="left" valign="top">
	
	<?php echo $DatVehiculoMovimientoEntradaDetalle->PrvNombre;?>
      <?php echo $DatVehiculoMovimientoEntradaDetalle->PrvApellidoPaterno;?>
      <?php echo $DatVehiculoMovimientoEntradaDetalle->PrvApellidoMaterno;?>
      
      	<?php echo $DatVehiculoMovimientoEntradaDetalle->CliNombre;?>
      <?php echo $DatVehiculoMovimientoEntradaDetalle->CliApellidoPaterno;?>
      <?php echo $DatVehiculoMovimientoEntradaDetalle->CliApellidoMaterno;?>
      
      
    </td>
    <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->VmvComprobanteNumero?></td>
    <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->VmvComprobanteFecha?></td>
    <td align="right" valign="top" bgcolor="#EEEEEE"><?php echo number_format($DatVehiculoMovimientoEntradaDetalle->VmdCantidad,2);?></td>
    <td align="right" valign="top" bgcolor="#EEEEEE"><?php echo $DatVehiculoMovimientoEntradaDetalle->UmeNombre?></td>
    </tr>
      
  
  <?php
  $TotalIngresosReal += $DatVehiculoMovimientoEntradaDetalle->VmdCantidadReal;
  $TotalIngresos += $DatVehiculoMovimientoEntradaDetalle->VmdCantidad;
  $i++;  
}
?>
<tr>
    <td colspan="7" align="right">TOTAL ENTRADAS:</td>
    <td align="right"><?php echo number_format($TotalIngresos,2);?></td>
    <td align="right">&nbsp;</td>
    </tr>
  </tbody>
</table>