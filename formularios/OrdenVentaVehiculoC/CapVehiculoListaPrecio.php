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
$POST_Color = $_POST['Color'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');


$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();

//MtdObtenerVehiculoListaPrecioDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VldId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoListaPrecio=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oPrecioEstricto=false,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL)
$ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","",NULL,$POST_VehiculoVersion,NULL,false,$POST_VehiculoModelo,$POST_VehiculoMarca);
$ArrVehiculoListaPrecioDetalles = $ResVehiculoListaPrecioDetalle['Datos'];
		
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
        <th width="5%">Id</th>
        <th width="6%">Num. Proforma</th>
        <th width="6%">Año/Mes Proforma</th>
        <th width="5%">VIN</th>
        <th width="5%">Marca</th>
        <th width="8%">Modelo</th>
        <th width="5%">Version</th>
        <th width="5%">Año Fab. </th>
        <th width="5%">Año Mod.</th>
        <th width="5%"> Color </th>
        <th width="7%">Ubicacion</th>
        <th width="7%">Precio Lista</th>
        <th width="6%">Precio Cierre</th>
        <th width="7%">Descuento Gerencia</th>
        <th width="3%"> Acc.</th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    
    <?php
    $c = 1;
    foreach($ArrVehiculoListaPrecioDetalles as $DatVehiculoListaPrecioDetalle){
    ?>
    <tr id="Fila_<?php echo $c;?>">
    <td align="right"><?php echo $c;?></td>
    <td colspan="4" align="center">A PEDIDO</td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VmaNombre;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VmoNombre;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VveNombre;?></td>
    <td align="right"><?php echo $DatVehiculoListaPrecioDetalle->VldAnoModelo;?></td>
    <td align="center">-</td>
    <td colspan="2" align="center">A PEDIDO</td>
    <td align="center"><?php $DatVehiculoListaPrecioDetalle->VldPrecioLista = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioLista:($DatVehiculoListaPrecioDetalle->VldPrecioLista/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php echo number_format($DatVehiculoListaPrecioDetalle->VldPrecioLista,2);?></td>
    <td align="right"><?php $DatVehiculoListaPrecioDetalle->VldPrecioCierre = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioCierre:($DatVehiculoListaPrecioDetalle->VldPrecioCierre/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php echo number_format($DatVehiculoListaPrecioDetalle->VldPrecioCierre,2);?></td>
    <td align="center">
      <?php $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia:($DatVehiculoListaPrecioDetalle->VldDescuentoGerencia/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
      <?php echo number_format($DatVehiculoListaPrecioDetalle->VldDescuentoGerencia,2);?>
      
    </td>
    <td align="center">
  <!--    FncVehiculoIngresoListadoEscoger(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oVIN,oVehiculoIngresoDescuentoGerencia,oAnoFabricacion-->
  <input type="radio" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" onclick="FncVehiculoIngresoListadoEscoger('<?php echo $c;?>','<?php echo $DatVehiculoListaPrecioDetalle->VveId;?>','<?php echo $DatVehiculoListaPrecioDetalle->VldPrecioLista;?>','<?php echo $DatVehiculoListaPrecioDetalle->VldPrecioCierre;?>','','','');"> 
      
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
        <th width="3%">Id</th>
        <th width="6%">Num. Proforma</th>
        <th width="6%">Año/Mes Proforma</th>
        <th width="5%">VIN</th>
        <th width="6%">Marca</th>
        <th width="7%">Modelo</th>
        <th width="5%">Version</th>
        <th width="5%">Año Fab. </th>
        <th width="5%">Año Mod.</th>
        <th width="6%"> Color
        </th>
        <th width="8%">Ubicacion</th>
        <th width="9%">Precio Lista</th>
        <th width="5%">Precio Cierre</th>
        <th width="7%">Descuento Gerencia</th>
        <th width="2%"> Acc.</th>
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
        <?php echo $DatVehiculoIngreso->EinId;?>
    </td>
    <td align="right"><?php echo $DatVehiculoIngreso->VprCodigo;?></td>
    <td align="right">
    
    <?php echo $DatVehiculoIngreso->VprAno;?>
    <?php
    if(!empty($DatVehiculoIngreso->VprMes)){
    ?>/<?php echo FncConvertirMes($DatVehiculoIngreso->VprMes);?>
    <?php
    }
    ?>
    
    
    </td>
    <td align="right">
	
	<a href="javascript:FncVehiculoIngresoCargarFormularioListado('Editar','<?php echo $DatVehiculoIngreso->EinId;?>')">
	
	<?php echo $DatVehiculoIngreso->EinVIN;?></a></td>
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
        $VehiculoListaPrecioDetallePrecioLista = 0;
        $VehiculoListaPrecioDetallePrecioCierre = 0;
		
		
        $ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","1",NULL,$DatVehiculoIngreso->VveId,$DatVehiculoIngreso->EinAnoFabricacion);
        $ArrVehiculoListaPrecioDetalles = $ResVehiculoListaPrecioDetalle['Datos'];
        ?>
      <?php
        if(!empty($ArrVehiculoListaPrecioDetalles)){
            foreach($ArrVehiculoListaPrecioDetalles as $DatVehiculoListaPrecioDetalle){
        ?>
      
			<?php $VehiculoListaPrecioDetallePrecioLista = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioLista:($DatVehiculoListaPrecioDetalle->VldPrecioLista/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
    
			<?php $VehiculoListaPrecioDetallePrecioCierre = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioCierre:($DatVehiculoListaPrecioDetalle->VldPrecioCierre/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>  
    
      <?php		
            }
        }
        ?>
        
        <?php
		if(!empty($VehiculoListaPrecioDetallePrecioLista)){
		?>
       		<span class="EstVehiculoListaPrecioDetallePrecioLista"><?php echo number_format($VehiculoListaPrecioDetallePrecioLista,2); ?></span>
        <?php	
		}else{
		?>
         No se encontro precio
        <?php	
		}
		?>
        
        
        
        
        
        </td>
    <td align="right">
        
        <?php
		if(!empty($VehiculoListaPrecioDetallePrecioCierre)){
		?>
       		<span class="EstVehiculoListaPrecioDetallePrecioCierre"><?php echo number_format($VehiculoListaPrecioDetallePrecioCierre,2); ?></span>
        <?php	
		}else{
		?>
         No se encontro precio
        <?php	
		}
		?>
        
        
        
        </td>
    <td align="center">
	
	
	
	<?php $DatVehiculoIngreso->EinDescuentoGerencia = (($EmpresaMonedaId==$DatVehiculoIngreso->MonId or empty($DatVehiculoIngreso->MonId))?$DatVehiculoIngreso->EinDescuentoGerencia:($DatVehiculoIngreso->EinDescuentoGerencia/$DatVehiculoIngreso->EinTipoCambio));?>
      <?php echo number_format($DatVehiculoIngreso->EinDescuentoGerencia,2);?>
      
      
      
      </td>
    <td align="center">
      
      <!--    FncVehiculoIngresoListadoEscoger(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oVIN,oVehiculoIngresoDescuentoGerencia,oAnoFabricacion-->
      

      <input type="radio" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" onclick="FncVehiculoIngresoListadoEscoger('<?php echo $c;?>','<?php echo $DatVehiculoIngreso->VveId;?>','<?php echo $VehiculoListaPrecioDetallePrecioLista;?>','<?php echo $VehiculoListaPrecioDetallePrecioCierre;?>','<?php echo $DatVehiculoIngreso->EinColor;?>','<?php echo $DatVehiculoIngreso->EinId;?>','<?php echo $DatVehiculoIngreso->EinAnoModelo;?>','<?php echo $DatVehiculoIngreso->EinVIN;?>','<?php echo $DatVehiculoIngreso->EinDescuentoGerencia;?>','<?php echo $DatVehiculoIngreso->EinAnoFabricacion;?>');"> 
      
      
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