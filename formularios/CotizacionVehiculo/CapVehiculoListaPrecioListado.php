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

$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');


$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();

///MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL)
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinAnoFabricacion","ASC",NULL,NULL,NULL,NULL,"STOCK",$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_VehiculoVersion);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

?>

<?php
if(empty($ArrVehiculoIngresos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
    <th width="2%">#</th>
    <th width="4%">Foto</th>
    <th width="4%">Id</th>
    <th width="10%">Año/Mes Proforma</th>
    <th width="10%">VIN</th>
    <th width="10%">Marca</th>
    <th width="9%">Modelo</th>
    <th width="9%">Version</th>
    <th width="8%">Año Fab. </th>
    <th width="9%">Año Mod.</th>
    <th width="10%"> Color
    </th>
    <th width="9%">Ubicacion</th>
    <th width="7%">Precio Cierre</th>
    <th width="9%">Precio Lista</th>
    <th width="4%"> Acc.</th>
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
if(!empty($DatVehiculoIngreso->VveFoto)){
?>
<img src="../../subidos/vehiculo_version_fotos/<?php echo $DatVehiculoIngreso->VveFoto;?>" width="50"  />

<?php	
}
?>
</td>
<td align="right">
	<?php echo $DatVehiculoIngreso->EinId;?>
</td>
<td align="right">

<?php echo $DatVehiculoIngreso->EinAnoProforma;?>
<?php
if(!empty($DatVehiculoIngreso->EinMesProforma)){
?>
/
<?php echo FncConvertirMes($DatVehiculoIngreso->EinMesProforma);?>
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
<td align="right">

	<?php
    $VehiculoListaPrecioDetallePrecioCierre = 0;
    // MtdObtenerVehiculoListaPrecioDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VldId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoListaPrecio=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL)
    $ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","1",NULL,$DatVehiculoIngreso->VveId,$DatVehiculoIngreso->EinAnoFabricacion);
    $ArrVehiculoListaPrecioDetalles = $ResVehiculoListaPrecioDetalle['Datos'];
    
    if(!empty($ArrVehiculoListaPrecioDetalles)){
        foreach($ArrVehiculoListaPrecioDetalles as $DatVehiculoListaPrecioDetalle){
    ?>
    
        <?php $VehiculoListaPrecioDetallePrecioCierre = (($POST_MonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioCierre:($DatVehiculoListaPrecioDetalle->VldPrecioCierre/$POST_TipoCambio));?>
        
        <span class="EstVehiculoListaPrecioDetallePrecioCierre"><?php echo number_format($VehiculoListaPrecioDetallePrecioCierre,2); ?></span>
        
        <br />
        
        <span class="EstVehiculoListaPrecioDetalleAno"><?php echo $DatVehiculoListaPrecioDetalle->VlpAno;?>/<?php echo $DatVehiculoListaPrecioDetalle->VlpMes;?></span>
    
    <?php
        }
    }else{
    ?>
    No se encontro precio
    
    <?php	
    }
    ?>

</td>
<td align="center">

	<?php
    $VehiculoListaPrecioDetallePrecioLista = 0;
    
    $ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,"VlpFecha","DESC","1",NULL,$DatVehiculoIngreso->VveId,$DatVehiculoIngreso->EinAnoFabricacion);
    $ArrVehiculoListaPrecioDetalles = $ResVehiculoListaPrecioDetalle['Datos'];
    ?>
    
    <?php
    if(!empty($ArrVehiculoListaPrecioDetalles)){
        foreach($ArrVehiculoListaPrecioDetalles as $DatVehiculoListaPrecioDetalle){
    ?>
    
        <?php $VehiculoListaPrecioDetallePrecioLista = (($EmpresaMonedaId==$DatVehiculoListaPrecioDetalle->MonId or empty($DatVehiculoListaPrecioDetalle->MonId))?$DatVehiculoListaPrecioDetalle->VldPrecioLista:($DatVehiculoListaPrecioDetalle->VldPrecioLista/$DatVehiculoListaPrecioDetalle->VlpTipoCambio));?>
        <span class="EstVehiculoListaPrecioDetallePrecioLista"><?php echo number_format($VehiculoListaPrecioDetallePrecioLista,2); ?></span>
        <br />
        <span class="EstVehiculoListaPrecioDetalleAno"><?php echo $DatVehiculoListaPrecioDetalle->VlpAno;?>/<?php echo $DatVehiculoListaPrecioDetalle->VlpMes;?></span>
    <?php		
        }
    }else{
    ?>
    No se encontro precio
    <?php	
    }
    ?>

</td>
<td align="center">
  
 																																			
  <input type="radio" name="RbuVehiculoIngreso" id="RbuVehiculoIngreso_<?php echo $c;?>" value="<?php echo $c;?>" onclick="FncVehiculoIngresoSeleccionar('<?php echo $c;?>','<?php echo $DatVehiculoIngreso->VveId;?>','<?php echo $VehiculoListaPrecioDetallePrecioLista;?>','<?php echo $VehiculoListaPrecioDetallePrecioCierre;?>','<?php echo $DatVehiculoIngreso->EinColor;?>','<?php echo $DatVehiculoIngreso->EinId;?>','<?php echo $DatVehiculoIngreso->EinAnoModelo;?>');"> 




  
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