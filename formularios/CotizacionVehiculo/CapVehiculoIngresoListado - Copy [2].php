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
$POST_Color = $_POST['Color'];


$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();

//    public function MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL) {
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinAnoFabricacion","ASC",NULL,NULL,NULL,NULL,"STOCK",$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_VehiculoVersion,$POST_AnoModelo,NULL,$POST_Color);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

//MtdObtenerVehiculoListaPrecioDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VldId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoListaPrecio=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL)

if(!empty($POST_VehiculoVersion)){
	
	$ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC",NULL,NULL,$POST_VehiculoVersion,NULL);
	$ArrVehiculoListaPrecioDetalles = $ResVehiculoListaPrecioDetalle['Datos'];
	
}
		
?>

<?php
if(empty($ArrVehiculoIngresos)){
?>


<?php
if(!empty($ArrVehiculoListaPrecioDetalles)){
?>

<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
        <th width="2%">#</th>
        <th width="5%">Foto</th>
        <th width="5%">Id</th>
        <th width="6%">Año/Mes Proforma</th>
        <th width="5%">VIN</th>
        <th width="6%">Marca</th>
        <th width="8%">Modelo</th>
        <th width="6%">Version</th>
        <th width="5%">Año Fab. </th>
        <th width="5%">Año Mod.</th>
        <th width="6%"> Color </th>
        <th width="7%">Ubicacion</th>
        <th width="4%">Precio Lista</th>
        <th width="6%">Precio Cierre</th>
        <th width="3%"> Acc.</th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    
       
        
        
    <?php
    $c = 1;
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
			
          
    <tr id="Fila_<?php echo $c;?>">
    <td align="right"><?php echo $c;?></td>
    <td align="center"><?php
if(!empty($DatVehiculoListaPrecioDetalle->VveFoto)){
?>
      
<a href="javascript:FncVehiculoVersionVistaPreliminar('<?php echo $DatVehiculoListaPrecioDetalle->VveId;?>')">
      <img src="subidos/vehiculo_version_fotos/<?php echo $DatVehiculoListaPrecioDetalle->VveFoto;?>" width="50" border="0" align="Vista Previa"  title="Vista Previa" /></a>
      <?php	
}
?></td>
    <td align="center">A PEDIDO</td>
    <td align="center">A PEDIDO</td>
    <td align="center">A PEDIDO</td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VmaNombre;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VmoNombre;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VveNombre;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VlpAnoFabricacion;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VlpAnoModelo;?></td>
    <td align="center">A PEDIDO</td>
    <td align="center">A PEDIDO</td>
    <td align="center">
	
		<?php
		if(!empty($VehiculoListaPrecioDetallePrecioLista)){
		?>
      <span class="EstVehiculoListaPrecioDetallePrecioLista"><?php echo number_format($VehiculoListaPrecioDetallePrecioLista,2); ?> </span><?php if(!empty($TipoCambio)){?> <br /> T.C.: <?php echo $TipoCambio;?> <?php }?>
      <?php
		}else{
		?>
      No se encontro precio
      <?php	
		}
		?>
        
        
	<?php /*$DatVehiculoListaPrecioDetalle->VldPrecioLista = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioLista:($DatVehiculoListaPrecioDetalle->VldPrecioLista/$TipoCambio));?>
      <?php echo number_format($DatVehiculoListaPrecioDetalle->VldPrecioLista,2);*/?>
      
      
      </td>
    <td align="center">
    
    
    	<?php
		if(!empty($VehiculoListaPrecioDetallePrecioCierre)){
		?>
      <span class="EstVehiculoListaPrecioDetallePrecioCierre"><?php echo number_format($VehiculoListaPrecioDetallePrecioCierre,2); ?> </span><?php if(!empty($TipoCambio)){?> <br /> T.C.: <?php echo $TipoCambio;?> <?php }?>
      <?php
		}else{
		?>
      No se encontro precio
      <?php	
		}
		?>
        
        
		<?php /*$DatVehiculoListaPrecioDetalle->VldPrecioCierre = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioCierre:($DatVehiculoListaPrecioDetalle->VldPrecioCierre/$TipoCambio));?>
		<?php echo number_format($DatVehiculoListaPrecioDetalle->VldPrecioCierre,2);*/?>

    </td>
    <td align="center">
    
<!--
FncCotizacionVehiculoDetalleEscoger(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oFechaVigencia,oAnoFabricacion)
-->

      <input type="radio" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" onclick="FncCotizacionVehiculoDetalleEscoger('<?php echo $c;?>','<?php echo $DatVehiculoListaPrecioDetalle->VveId;?>','<?php echo $VehiculoListaPrecioDetallePrecioLista;?>','<?php echo $VehiculoListaPrecioDetallePrecioCierre;?>','','','<?php echo $DatVehiculoListaPrecioDetalle->VlpAnoModelo;?>','<?php echo $DatVehiculoListaPrecioDetalle->VlpFechaVigencia;?>','<?php echo $DatVehiculoListaPrecioDetalle->VlpAnoFabricacion;?>');"> 
      
    </td>
    </tr>
    <?php
        
    $c++;
    }
    
    
    ?>
    </tbody>
    </table>
<?php	
}else{
?>
No se encontraron elementos
<?php	
}
?>



<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
        <th width="2%">#</th>
        <th width="5%">Foto</th>
        <th width="5%">Id</th>
        <th width="6%">Año/Mes Proforma</th>
        <th width="7%">VIN</th>
        <th width="9%">Marca</th>
        <th width="10%">Modelo</th>
        <th width="8%">Version</th>
        <th width="7%">Año Fab. </th>
        <th width="8%">Año Mod.</th>
        <th width="9%"> Color
        </th>
        <th width="11%">Ubicacion</th>
        <th width="7%">Precio Lista</th>
        <th width="8%">Precio Cierre</th>
        <th width="3%"> Acc.</th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
    foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
    ?>
    <tr id="Fila_<?php echo $c;?>">
    <td align="right"><?php echo $c;?></td>
    <td align="right">
	
	
<?php
if(!empty($DatVehiculoIngreso->EinFoto)){
?>

      <a href="javascript:FncVehiculoIngresoVistaPreliminar('<?php echo $DatVehiculoIngreso->EinId;?>')">
      <img src="subidos/vehiculo_ingreso_fotos/<?php echo $DatVehiculoIngreso->EinFoto;?>" width="50" border="0" align="Vista Previa"  title="Vista Previa" /></a>
      
<?php	
}else if(!empty($DatVehiculoIngreso->VveFoto)){
?>

	<a href="javascript:FncVehiculoVersionVistaPreliminar('<?php echo $DatVehiculoIngreso->VveId;?>')">
      <img src="subidos/vehiculo_version_fotos/<?php echo $DatVehiculoIngreso->VveFoto;?>" width="50" border="0" align="Vista Previa"  title="Vista Previa" /></a>

<?php	
}
?>


</td>
    <td align="right">
        <?php echo $DatVehiculoIngreso->EinId;?>
    </td>
    <td align="right">


	<?php /*echo $DatVehiculoIngreso->VprAno;?>/<?php echo $DatVehiculoIngreso->VprMes;?> <?php echo $DatVehiculoIngreso->VprCodigo;*/?>

    <?php echo $DatVehiculoIngreso->VprAno;?>
    <?php
    if(!empty($DatVehiculoIngreso->VprMes)){
    ?>
    /
    <?php echo FncConvertirMes($DatVehiculoIngreso->VprMes);?>
    <?php
    }
    ?>

    </td>
    <td align="right"><?php echo $DatVehiculoIngreso->EinVIN;?></td>
    <td align="right"><?php echo $DatVehiculoIngreso->VmaNombre;?></td>
    <td align="right"><?php echo $DatVehiculoIngreso->VmoNombre;?></td>
    <td align="right"><?php echo $DatVehiculoIngreso->VveNombre;?></td>
    <td align="right"><?php echo $DatVehiculoIngreso->EinAnoFabricacion;?></td>
    <td align="right"><?php echo $DatVehiculoIngreso->EinAnoModelo;?></td>
    <td align="right">
    
      <?php echo $DatVehiculoIngreso->EinColor;?>
    
    </td>  
    <td align="right">
    
        <?php echo $DatVehiculoIngreso->EinUbicacion;?>
    
    </td>
    <td align="center">
	
	<?php
	
	//deb($POST_MonedaId." - ".$EmpresaMonedaId);
	
		$VehiculoListaPrecioDetallePrecioCierre = 0;
		$VehiculoListaPrecioDetallePrecioLista = 0;
		$VehiculoListaPrecioFechaVigencia = "";

		$VehiculoListaPrecioDetalleBonoGM = 0;
		$VehiculoListaPrecioDetalleBonoDealer = 0;
		$VehiculoListaPrecioDetalleDescuentoGerencia = 0;
		
		$VehiculoListaPrecioDetalleMinimo = 0;


//MtdObtenerVehiculoListaPrecioDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VldId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoListaPrecio=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oPrecioEstricto=false)

        $ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","1",NULL,$DatVehiculoIngreso->VveId,$DatVehiculoIngreso->EinAnoFabricacion,true);
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
      <span class="EstVehiculoListaPrecioDetallePrecioLista"><?php echo number_format($VehiculoListaPrecioDetallePrecioLista,2); ?> </span><?php if(!empty($TipoCambio)){?> <br /> T.C.: <?php echo $TipoCambio;?> <?php }?>
      <?php
		}else{
		?>
      No se encontro precio
      <?php	
		}
		?>
        
		</td>
    <td align="center">



	
	<?php
		if(!empty($VehiculoListaPrecioDetallePrecioCierre)){
		?>
      <span class="EstVehiculoListaPrecioDetallePrecioCierre"><?php echo number_format($VehiculoListaPrecioDetallePrecioCierre,2); ?> </span><?php if(!empty($TipoCambio)){?> <br /> T.C.: <?php echo $TipoCambio;?> <?php }?>
      <?php
		}else{
		?>
      No se encontro precio
      <?php	
		}
		?>
        
        
      
        
        
    </td>
    <td align="center">
      
      
      <input type="radio" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" onclick="FncCotizacionVehiculoDetalleEscoger('<?php echo $c;?>','<?php echo $DatVehiculoIngreso->VveId;?>','<?php echo $VehiculoListaPrecioDetallePrecioLista;?>','<?php echo $VehiculoListaPrecioDetallePrecioCierre;?>','<?php echo $DatVehiculoIngreso->EinColor;?>','<?php echo $DatVehiculoIngreso->EinId;?>','<?php echo $DatVehiculoIngreso->EinAnoModelo;?>','<?php echo $VehiculoListaPrecioFechaVigencia;?>','<?php echo $DatVehiculoIngreso->EinAnoFabricacion;?>');"> 
      
      
      
      
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