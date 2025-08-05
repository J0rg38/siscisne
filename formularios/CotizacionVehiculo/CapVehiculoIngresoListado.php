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

$POST_VehiculoMarca = $_POST['VehiculoMarca'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_AnoModelo = $_POST['AnoModelo'];
$POST_AnoFabricacion = $_POST['AnoFabricacion'];
$POST_Color = $_POST['Color'];
$POST_Sucursal = $_SESSION['SesionSucursal'];

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

//MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL,$oVehiculo=NULL,$oAno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoStocks(NULL,NULL,NULL,"VmoNombre","ASC",NULL,NULL,$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_VehiculoVersion,$POST_AnoFabricacion,$POST_AnoModelo,$POST_Color,$POST_Sucursal,NULL,date("Y"),NULL,NULL);
$ArrVehiculoStocks = $ResVehiculoStock['Datos'];		

?>

Filtrando: <!--<b>Año Fabricacion:</b> <?php echo $POST_AnoFabricacion; ?> /--> <b>Año Modelo:</b> <?php echo $POST_AnoModelo; ?> / <b>Color:</b> <?php echo $POST_Color; ?>

    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="2" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
        <th width="2%">#</th>
        <th width="4%">Foto</th>
        <th width="13%">Cod. Identificador</th>
        <th width="13%">Marca</th>
        <th width="13%">Modelo</th>
        <th width="16%">Version</th>
        <th width="12%">Precio Lista</th>
        <th width="11%">Precio Cierre</th>
        <th width="11%">Disponibilidad</th>
        <th width="5%">Escoger</th>
      </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
	$SumaStock = 0;
    foreach($ArrVehiculoStocks as $DatVehiculoStock){
    ?>
    
    <?php
	if($DatVehiculoStock->VstStockReal>0){
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
    <td align="right">
	<span title="<?php echo $DatVehiculoStock->VehId;?>">
	<?php echo $DatVehiculoStock->VehCodigoIdentificador;?>
    </span>
    </td>
    <td align="right"><?php echo $DatVehiculoStock->VmaNombre;?></td>
    <td align="right"><?php echo $DatVehiculoStock->VmoNombre;?></td>
    <td align="right"><?php echo $DatVehiculoStock->VveNombre;?></td>
    <td align="right">
      
      <?php
	if(!empty($POST_AnoModelo)){
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
        $ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","1",NULL,$DatVehiculoStock->VveId,$POST_AnoModelo,true);
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
      No ingreso año de modelo
      <?php	
        }
    ?> 
      
    </td>
    <td align="right">
	
	<?php
	if(!empty($POST_AnoModelo)){
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
            No ingreso año de modelo
    <?php	
        }
    ?> 


    
        
        </td>
    <td align="right">
	
	
	<?php //echo number_format($DatVehiculoStock->VesStockVersion,2);?>
    
    <span class="EstVehiculoIngresoDisponibilidad">
    
    <?php echo number_format($DatVehiculoStock->VstStockReal,2);?>
    
    </span>
    
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
    <td align="center"><input type="radio" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" onclick="FncCotizacionVehiculoDetalleEscoger('<?php echo $c;?>','<?php echo $DatVehiculoStock->VveId;?>','<?php echo (empty($VehiculoListaPrecioDetallePrecioLista)?0:$VehiculoListaPrecioDetallePrecioLista);?>','<?php echo (empty($VehiculoListaPrecioDetallePrecioCierre)?0:$VehiculoListaPrecioDetallePrecioCierre);?>','<?php echo $DatVehiculoStock->EinColor;?>','<?php echo $DatVehiculoStock->EinId;?>','<?php echo $DatVehiculoStock->EinAnoModelo;?>','<?php echo $VehiculoListaPrecioFechaVigencia;?>','<?php echo $DatVehiculoStock->EinAnoFabricacion;?>');" /></td>
    </tr>
    
    <tr>
        <td align="right">&nbsp;</td>
        <td colspan="8" align="right">
        
<?php
//MtdObtenerVehiculoIngresoColores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oEstadoVehicular=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oVehiculo=NULL)
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresoColores(NULL,NULL,NULL,'EinId','Desc','',NULL,NULL,NULL,$POST_Sucursal,"STOCK",$POST_AnoModelo,NULL,$DatVehiculoStock->VehId);
$ArrVehiculoIngresoColores  =$ResVehiculoIngreso['Datos'];
?>

<?php
if($ArrVehiculoIngresoColores){
	foreach($ArrVehiculoIngresoColores as $DatVehiculoIngresoColor){
?>
			<?php echo $DatVehiculoIngresoColor->EinColor;?>: <?php echo $DatVehiculoIngresoColor->EinTotalColor;?><br />
<?php	
	}
}
?>
        
        </td>
        <td align="center">&nbsp;</td>
      </tr>
      
      
      
    <?php	
	
			$SumaStock += $DatVehiculoStock->VstStockReal;
    $c++;
	}
	?>
  
    
    <?php
	
    }
    ?>
    <tr>
    <td colspan="8" align="right">
      
      <span class="EstFormularioTotalEtiqueta">Total:</span></td>
    <td align="right">
      <span class="EstFormularioTotalContenido">
        <?php echo number_format($SumaStock,2);?>
        </span>
    </td>

    <td align="right">&nbsp;</td>
    </tr>
    </tbody>
</table>

