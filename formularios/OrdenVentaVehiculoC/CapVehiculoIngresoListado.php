<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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

$POST_VehiculoMarca = $_POST['VehiculoMarca'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_AnoModelo = $_POST['AnoModelo'];
$POST_AnoFabricacion = $_POST['AnoFabricacion'];
$POST_Color = $_POST['Color'];


$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

if(empty($POST_VehiculoMarca)){
	die("No ha escogido una marca de vehiculo");
}

if(empty($POST_VehiculoModelo)){
	die("No ha escogido un modelo de vehiculo");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoStock = new ClsVehiculoStock();
$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();

//MtdObtenerVehiculoStockModelos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VesId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL)
$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoStocks(NULL,NULL,NULL,"VmoNombre","ASC",NULL,NULL,$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_VehiculoVersion,$POST_AnoFabricacion,$POST_AnoModelo,$POST_Color);
$ArrVehiculoStocks = $ResVehiculoStock['Datos'];		

?>

Filtrando: <b>Año Fabricacion:</b> <?php echo $POST_AnoFabricacion; ?> / <b>Año Modelo:</b> <?php echo $POST_AnoModelo; ?> / <b>Color:</b> <?php echo $POST_Color; ?>

    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="2" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
        <th width="2%">#</th>
        <th width="5%">Foto</th>
        <th width="17%">Marca</th>
        <th width="17%">Modelo</th>
        <th width="17%">Version</th>
        <th width="14%">Precio Lista</th>
        <th width="14%">Precio Cierre</th>
        <th width="14%">Disponibilidad</th>
        <th width="0%">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
	$SumaStock = 0;
    foreach($ArrVehiculoStocks as $DatVehiculoStock){
    ?>
    <tr id="Fila_<?php echo $c;?>">
    <td align="right"><?php echo $c;?></td>
    <td align="center">
    
    
    <?php
if(!empty($DatVehiculoStock->VveFoto)){
?>
      
<a href="javascript:FncVehiculoVersionVistaPreliminar('<?php echo $DatVehiculoStock->VveId;?>')">
      <img src="subidos/vehiculo_version_fotos/<?php echo $DatVehiculoStock->VveFoto;?>" width="50" border="0" align="Vista Previa"  title="Vista Previa" /></a>
      <?php	
}
?>


</td>
    <td align="right"><?php echo $DatVehiculoStock->VmaNombre;?></td>
    <td align="right"><?php echo $DatVehiculoStock->VmoNombre;?></td>
    <td align="right"><?php echo $DatVehiculoStock->VveNombre;?></td>
    <td align="right">
	
	<?php
	if(!empty($POST_AnoFabricacion)){
	?>
    
		<?php
		$VehiculoListaPrecioDetallePrecioCierre = 0;
		$VehiculoListaPrecioDetallePrecioLista = 0;
		$VehiculoListaPrecioFechaVigencia = "";

		$VehiculoListaPrecioDetalleBonoGM = 0;
		$VehiculoListaPrecioDetalleBonoDealer = 0;
		$VehiculoListaPrecioDetalleDescuentoGerencia = 0;
		
		$VehiculoListaPrecioDetalleMinimo = 0;

		//MtdObtenerVehiculoListaPrecioDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VldId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoListaPrecio=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oPrecioEstricto=false)
        $ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","1",NULL,$DatVehiculoStock->VveId,$POST_AnoFabricacion,true);
        $ArrVehiculoListaPrecioDetalles = $ResVehiculoListaPrecioDetalle['Datos'];
        
		//deb($ArrVehiculoListaPrecioDetalles);
        if(!empty($ArrVehiculoListaPrecioDetalles)){
            foreach($ArrVehiculoListaPrecioDetalles as $DatVehiculoListaPrecioDetalle){
        ?>
      <?php $VehiculoListaPrecioDetallePrecioCierre = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioCierre:($DatVehiculoListaPrecioDetalle->VldPrecioCierre/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php $VehiculoListaPrecioDetallePrecioLista = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioLista:($DatVehiculoListaPrecioDetalle->VldPrecioLista/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php $VehiculoListaPrecioFechaVigencia = $DatVehiculoListaPrecioDetalle->VlpFechaVigencia;?>
      <?php $VehiculoListaPrecioDetalleBonoGM = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldBonoGM:($DatVehiculoListaPrecioDetalle->VldBonoGM/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php $VehiculoListaPrecioDetalleBonoDealer = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldBonoDealer:($DatVehiculoListaPrecioDetalle->VldBonoDealer/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php $VehiculoListaPrecioDetalleDescuentoGerencia = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia:($DatVehiculoListaPrecioDetalle->VldDescuentoGerencia/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      
			
			<?php
			if($POST_MonedaId == $EmpresaMonedaId){
				
				$TipoCambio = 1;
				
				if(empty($POST_TipoCambio)){
					
					$InsTipoCambio = new ClsTipoCambio();
					$InsTipoCambio->MonId = $DatVehiculoListaPrecioDetalle->MonId;
					$InsTipoCambio->TcaFecha = date("Y-m-d");
					$InsTipoCambio->MtdObtenerTipoCambioFecha();
					
					
					if(empty($InsTipoCambio->TcaId)){
						
						$InsTipoCambio->MtdObtenerTipoCambioUltimo();
						$TipoCambio =  $InsTipoCambio->TcaMontoComercial;
						
					}else{
						$TipoCambio =  $InsTipoCambio->TcaMontoComercial;
					}
					
				}else{
					$TipoCambio = $POST_TipoCambio;
				}
				
				
				//deb($InsTipoCambio->TcaMontoComercial);
				//deb($InsTipoCambio);

				$VehiculoListaPrecioDetallePrecioCierre = $VehiculoListaPrecioDetallePrecioCierre * $TipoCambio;				
				$VehiculoListaPrecioDetallePrecioLista = $VehiculoListaPrecioDetallePrecioLista * $TipoCambio;
				
				
				$VehiculoListaPrecioDetalleBonoGM = $VehiculoListaPrecioDetalleBonoGM * $TipoCambio;
				$VehiculoListaPrecioDetalleBonoDealer = $VehiculoListaPrecioDetalleBonoDealer * $TipoCambio;
				$VehiculoListaPrecioDetalleDescuentoGerencia = $VehiculoListaPrecioDetalleDescuentoGerencia * $TipoCambio;
				
				
			}
			?>
			
			<?php
			$VehiculoListaPrecioDetalleMinimo = $VehiculoListaPrecioDetallePrecioCierre - $VehiculoListaPrecioDetalleBonoGM - $VehiculoListaPrecioDetalleBonoDealer - $VehiculoListaPrecioDetalleDescuentoGerencia;
			?>
            
		<?php
            }
        }
        ?>
        
      <?php
		if(!empty($VehiculoListaPrecioDetallePrecioLista)){
		?>
			<span class="EstVehiculoListaPrecioDetallePrecioLista"><?php echo number_format($VehiculoListaPrecioDetallePrecioLista,2); ?></span>
			<?php if(!empty($TipoCambio)){?>
			<br />
			T.C.: <?php echo $TipoCambio;?>
			<?php }?>
		<?php
		}else{
		?>
		No se encontro precio	
		<?php	
		}
		?>
        
	<?php
        }else{
    ?>
            No ingreso año de fabricación
    <?php	
        }
    ?> 

        </td>
    <td align="right">
	
	<?php
	if(!empty($POST_AnoFabricacion)){
	?>

		<?php
		if(!empty($VehiculoListaPrecioDetallePrecioCierre)){
		?>

          <span class="EstVehiculoListaPrecioDetallePrecioCierre"><?php echo number_format($VehiculoListaPrecioDetallePrecioCierre,2); ?></span>
            <?php if(!empty($TipoCambio)){?>
            <br />
            T.C.: <?php echo $TipoCambio;?>
            <?php }?>
            
		<?php
		}else{
		?>
      		No se encontro precio
		<?php	
		}
		?>
        

	
	<?php
        }else{
    ?>
            No ingreso año de fabricación
    <?php	
        }
    ?> 


    
        
        </td>
    <td align="right"><?php echo number_format($DatVehiculoStock->VesStockVersion,2);?>
      <?php
	/*if(!empty($DatVehiculoStock->VesStockVersion)){
	?>
		<?php echo $DatVehiculoStock->VesStockVersion;?>    
    <?php	
	}else{
	?>
    Sin Stock
    <?php	
	}*/
	?></td>
    <td align="center">
    
    <!--<input type="button" name="BtnBuscarVIN" id="BtnBuscarVIN_<?php echo $c;?>" value="Buscar VIN" />-->
  <!--  <a title="Buscar VIN" name="BtnBuscarVIN" id="BtnBuscarVIN_<?php echo $c;?>" href="javascript:void(0);">
    Buscar VIN
    </a>-->
    
   <!-- <input type="button" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" />
    -->
    </td>
    </tr>
    <?php
	$SumaStock += $DatVehiculoStock->VesStockVersion;
    $c++;
    }
    ?>
    <tr>
    <td align="right"></td>
    <td align="right"></td>
    <td align="right"></td>
    <td align="right"></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">Total:</td>
    <td align="right"><?php echo number_format($SumaStock,2);?></td>

    <td align="right">&nbsp;</td>
    </tr>
    </tbody>
</table>

<input type="hidden" name="CmpPropietariosTotal" id="CmpPropietariosTotal" value="<?php echo $c;?>" />