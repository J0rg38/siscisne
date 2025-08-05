<?php
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

$Identificador = $_POST['Identificador'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TotalRecargo = (empty($_POST['TotalRecargo']))?0:$_POST['TotalRecargo'];

session_start();
if (!isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');


$InsVentaConcretada = new ClsVentaConcretada();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//SesionObjeto-AlmacenMovimientoEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto

$RepAlmacenMovimientoEntradaDetalle = $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrAlmacenMovimientoEntradaDetalles = $RepAlmacenMovimientoEntradaDetalle['Datos'];

$RepOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraPedidos = $RepOrdenCompraPedido['Datos'];
//deb($ArrOrdenCompraPedidos);
?>

<?php
if(empty($ArrOrdenCompraPedidos)){
?>

		<?php
		if(empty($ArrAlmacenMovimientoEntradaDetalles)){
		?>
        	No se encontraron elementos
        <?php
        }else{
        ?>
            
            <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="1%">#</th>
              <th width="4%">Id</th>
              <th width="10%">Cod. Orig.</th>
              <th width="6%">Cod. Alt.</th>
            <th width="34%"> Nombre
            </th>
            <th width="7%">U.M.</th>
            <th width="5%">
              
              Valor Unitario
              
              
              
            </th>
            
            
            <th width="5%">
              Cantidad</th>
            <th width="9%">
              Valor Total</th>
            <th width="6%">Reemplazo (Lista GM)
              <?php

$FechaReemplazo = "";

?>
              <?php
	// MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {
		
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos(NULL,NULL,NULL ,"PreTiempoCreacion","DESC","1",1);
    $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
    
    if(!empty($ArrProductoReemplazos)){
		foreach($ArrProductoReemplazos as $DatProductoReemplazo){
			
			$FechaReemplazo = $DatProductoReemplazo->PreTiempoCreacion;
		
		}
    }
    ?>
              <?php

echo $FechaReemplazo;

?>
            </th>
            <th width="6%">Estado</th>
            <th width="7%"> Acc.</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
            <?php
            $c = 1;
            $SubTotal = 0;
            //$CantidadTotal = 0;
            //$TotalItems = 0;
            foreach($ArrAlmacenMovimientoEntradaDetalles as $DatSesionObjeto){
            ?>
            
            <?php
            if($InsMoneda->MonId<>$EmpresaMonedaId){
            ?>
            
            <?php	
            }else{
            ?>
                <?php  $DatSesionObjeto->Parametro6 = ($DatSesionObjeto->Parametro6 * $_POST['TipoCambio']);?>
                <?php  $DatSesionObjeto->Parametro4 = ($DatSesionObjeto->Parametro4 * $_POST['TipoCambio']);?>
                <?php  $DatSesionObjeto->Parametro13 = ($DatSesionObjeto->Parametro13 * $_POST['TipoCambio']);?>
            <?php	
            }
            ?>
            <tr>
            <td align="right">
			<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
			<?php echo $c;?>
            </span>
            </td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
            <td align="right">
            
           
       <!--     
 <a href="javascript:FncAlmacenMovimientoEntradaDetalleReemplazorCargar('<?php echo  $Identificador;?>','<?php echo trim($DatSesionObjeto->Item);?>');"><?php echo $DatSesionObjeto->Parametro17;?></a>-->
			
            
	<?php echo $DatSesionObjeto->Parametro17;?>

<a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro17;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>


            </td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro18;?></td>
            <td align="right">
            <?php echo $DatSesionObjeto->Parametro3;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro9;?>
            
            
            
            
            </td>
            <td align="right">
                <?php echo number_format(($DatSesionObjeto->Parametro4),2);?>
               
            </td>
            <td align="right">
              
              <?php echo number_format($DatSesionObjeto->Parametro5,2);?>
              
               <br />
				<span class="EstFormularioSubEtiqueta">
              (<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)
              </span>
            </td>
            <td align="right">
              
              <?php echo number_format(($DatSesionObjeto->Parametro6),2);?>
              
            </td>
            <td align="center" bgcolor="#FFCC33"><?php
        $Reemplazo = "NO";
         $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$DatSesionObjeto->Parametro17 ,"PreId","ASC",NULL,1);
        $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
        
        if(!empty($ArrProductoReemplazos)){
              $Reemplazo= "SI";
        }
             
        ?>
              <?php
if($Reemplazo == "SI"){
?>
              <a href="javascript:FncProductoReemplazoCargar('<?php echo trim($DatSesionObjeto->Parametro17);?>');"><?php echo $Reemplazo;?></a>
              <?php	
}else{
?>
              <?php echo $Reemplazo;?>
              <?php	
}
?></td>
            <td align="right"><?php
			switch($DatSesionObjeto->Parametro25){
				case 1:
			?>
              No Llego
              <?php	
				break;
				
				case 2:
			?>
              Da&ntilde;ado
  <?php	
				break;
				
				case 3:
			?>
              Conforme
  <?php	
				break;
			}
			?></td>
            <td align="center">
            
            <?php
            if($_POST['Editar']==1){
            ?>
            
            
            <a class="EstSesionObjetosItem" href="javascript:FncAlmacenMovimientoEntradaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
            
            <?php
            }
            ?>
            
            <?php
            if($_POST['Eliminar']==1){
            ?>
            <a href="javascript:FncAlmacenMovimientoEntradaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
            <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
            <?php
            }
            ?>
            
            
            </td>
            </tr>
            <?php
            
                $SubTotal = $SubTotal + $DatSesionObjeto->Parametro6;
            
            $c++;
            }
            
            //$POST_TotalRecargo
            $SubTotal = round($SubTotal,2);
            $Recargo = $POST_TotalRecargo;
            $Impuesto = round(($SubTotal + $Recargo) * ($EmpresaImpuestoVenta/100),2);
            $Total = $SubTotal + $Recargo + $Impuesto;
            ?>
            </tbody>
            </table>
<br />
            <table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
            <tbody class="EstTablaTotalBody">
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Sub Total:</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
            </tr>
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Total Recargo:</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Recargo,2);?></td>
            </tr>
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Impuesto (<?php echo $EmpresaImpuestoVenta;?>):</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
            </tr>
            <tr>
              <td width="17%" align="right" class="Total">&nbsp;</td>
              <td width="7%" align="left" >&nbsp;</td>
              <td width="65%" align="right" class="Total">Total:</td>
              <td width="11%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
              
            </tr>
            </tbody>
            </table>
            
        <?php
        }
        ?>
        


<?php	
}else{
?>


	<?php
	$SubTotal = 0;
	$fila = 1;
	foreach($ArrOrdenCompraPedidos as $DatOrdenCompraPedido){
	?>

             <br />
            
            <table width="100%" cellpadding="3" cellspacing="0" border="0">
            <tbody>

                <tr>
                  <td width="6%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Cot.:</td>
                  <td width="5%" align="left" valign="top" >
                  
                  <a href="principal.php?Mod=CotizacionProducto&amp;Form=Listado&amp;Fil=<?php echo $DatOrdenCompraPedido->Parametro6;?>"><?php echo $DatOrdenCompraPedido->Parametro6;?></a>


<?php
if(!empty($DatOrdenCompraPedido->Parametro6)){
?>
	<br /><a href="javascript:FncCotizacionProductoVistaPreliminar('<?php echo $DatOrdenCompraPedido->Parametro6;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /></a>
<?php	
}
?>

                  
                  </td>
                  <td width="7%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Ord. Ven.:</td>
                  
                  <td width="7%" align="left" valign="top" >
                  <a href="principal.php?Mod=VentaDirecta&amp;Form=Listado&amp;Fil=<?php echo $DatOrdenCompraPedido->Parametro4;?>"><?php echo $DatOrdenCompraPedido->Parametro4;?></a>
                  
                  
                    <?php
if(!empty($DatOrdenCompraPedido->Parametro4) and $DatOrdenCompraPedido->Parametro11<>2){
?>
                    <br /><a target="_blank" href="principal.php?Mod=VentaConcretada&amp;Form=Registrar&amp;Origen=VentaDirecta&amp;VdiId=<?php echo $DatOrdenCompraPedido->Parametro4;?>"> <img src="imagenes/generar.jpg" width="19" height="19" border="0" title="Generar Venta Concretada" alt="[Generar Venta Concretada]" align="absmiddle"   /> </a>
                  <?php
}
?>


<?php
if(!empty($DatOrdenCompraPedido->Parametro4)){
?>
<br />
<a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $DatOrdenCompraPedido->Parametro4;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>

<?php
}
?>


</td>
                  <td width="8%" align="left" valign="top" class="EstFormularioEtiquetaFondo">O/C Ref.:</td>
                  <td width="9%" align="left" valign="top">
                  
                  <a href="principal.php?Mod=VentaDirecta&amp;Form=Listado&amp;Fil=<?php echo $DatOrdenCompraPedido->Parametro8;?>"><?php echo $DatOrdenCompraPedido->Parametro8;?></a>
                  
                  
                  </td>
                  <td width="8%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Pedido:</td>
                  <td width="9%" align="left" valign="top" >
 
<a target="_blank" href="principal.php?Mod=PedidoCompra&Form=Listado&Fil=<?php echo $DatOrdenCompraPedido->Parametro1;?>"><?php echo $DatOrdenCompraPedido->Parametro1;?></a>
 
<?php
if(!empty($DatOrdenCompraPedido->Parametro1)){
?>
<br />
<a href="javascript:FncPedidoCompraVistaPreliminar('<?php echo $DatOrdenCompraPedido->Parametro1;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>

<?php
}
?>
                  </td>
                  <td width="7%" align="left" valign="top" class="EstFormularioEtiquetaFondo">Ven. Concretada:</td>
                  <td width="9%" align="left" valign="top">
				  
<?php
if(!empty($DatOrdenCompraPedido->Parametro10)){
	foreach($DatOrdenCompraPedido->Parametro10 as $DatVentaConcretada){
?>

<a href="principal.php?Mod=VentaConcretada&Form=Listado&Fil=<?php echo $DatVentaConcretada;?>"><?php echo $DatVentaConcretada;?></a>
 - 
<a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $DatVentaConcretada;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>


                    <?php	
	}
}
?>





</td>
                  <td width="5%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Cliente:</td>
                  <td width="20%" align="left" valign="top">
                    
                    <a href="principal.php?Mod=Cliente&Form=Listado&Fil=<?php echo $DatOrdenCompraPedido->Parametro3;?>"><?php echo $DatOrdenCompraPedido->Parametro3;?></a>
                    
                    
                  </td>
                </tr>
                					
                <tr>
                  <td align="left" valign="top" class="EstFormularioEtiquetaFondo" >Fecha:</td>
                  <td align="left" valign="top" ><?php echo $DatOrdenCompraPedido->Parametro7;?></td>
                  <td align="left" valign="top" class="EstFormularioEtiquetaFondo" >Fecha:</td>
                  <td align="left" valign="top" ><?php echo $DatOrdenCompraPedido->Parametro5;?></td>
                  <td align="left" valign="top" class="EstFormularioEtiquetaFondo">Fecha:</td>
                  <td align="left" valign="top"><?php echo $DatOrdenCompraPedido->Parametro9;?></td>
                  <td align="left" valign="top" class="EstFormularioEtiquetaFondo" >Fecha:</td>
                  <td align="left" valign="top" ><?php echo $DatOrdenCompraPedido->Parametro2;?></td>
                  <td width="7%" align="left" valign="top" class="EstFormularioEtiquetaFondo">&nbsp;</td>
                  <td width="9%" align="left" valign="top">&nbsp;</td>
                  <td width="5%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >&nbsp;</td>
                  <td width="20%" align="left" valign="top">
               
                  </td>
                </tr>
            </tbody>
            </table>
            
			<br />
    	                
    <?php

        if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
        ?>
        
        
         <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="1%">#</th>
                              <th width="2%">&nbsp;</th>
                              <th width="3%">Id</th>
                              <th width="10%">Cod. Orig.</th>
                              <th width="8%">Cod. Alt.</th>
                            <th width="31%"> Nombre
                            </th>
                            <th width="6%">U.M.</th>
                            <th width="6%">
                              
                              Valor Unitario
                              
                              
                              
                            </th>
                            
                            
                            <th width="5%">
                              Cantidad</th>
                            <th width="6%">
                              Valor Total</th>
                            <th width="6%">Reemplazo (Lista GM)
                              <?php

$FechaReemplazo = "";

?>
                              <?php
	// MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {
		
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos(NULL,NULL,NULL ,"PreTiempoCreacion","DESC","1",1);
    $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
    
    if(!empty($ArrProductoReemplazos)){
		foreach($ArrProductoReemplazos as $DatProductoReemplazo){
			
			$FechaReemplazo = $DatProductoReemplazo->PreTiempoCreacion;
		
		}
    }
    ?>
                              <?php

echo $FechaReemplazo;

?>
                            </th>
                            <th width="6%">Estado</th>
                            <th width="10%"> Acc.</th>
                            </tr>
                            </thead>
                            <tbody class="EstTablaListadoBody">
            <?php
			$c = 1;
			
            foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
            ?>
                
      
                <?php
				
				//deb($DatOrdenCompraPedido->Parametro1." - ".$DatAlmacenMovimientoEntradaDetalle->Parametro22);
				
				//$DatOrdenCompraPedido->Parametro1 == $DatAlmacenMovimientoEntradaDetalle->Parametro22
				
				
              //  if($DatOrdenCompraPedido->Parametro1 == $DatAlmacenMovimientoEntradaDetalle->Parametro22){
                ?>
                
                            <?php
                            if($InsMoneda->MonId<>$EmpresaMonedaId){
                            ?>
                            
                            <?php	
                            }else{
                            ?>
                                <?php  $DatAlmacenMovimientoEntradaDetalle->Parametro6 = ($DatAlmacenMovimientoEntradaDetalle->Parametro6 * $_POST['TipoCambio']);?>
                                <?php  $DatAlmacenMovimientoEntradaDetalle->Parametro4 = ($DatAlmacenMovimientoEntradaDetalle->Parametro4 * $_POST['TipoCambio']);?>
                                <?php  $DatAlmacenMovimientoEntradaDetalle->Parametro13 = ($DatAlmacenMovimientoEntradaDetalle->Parametro13 * $_POST['TipoCambio']);?>
                            <?php	
                            }
                            ?>
                            <tr id="Fila_<?php echo $fila;?>">
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
							<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
							<?php echo $c;?>
                            </span>
                            </td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
                              
  <input onClick="FncAlmacenMovimientoDetalleSeleccionar();" type="checkbox" name="CmpAgregarSeleccionado[]" id="CmpAgregarSeleccionado_<?php echo $fila;?>"  value="<?php echo $fila;?>"  />
                              
                            </td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>"><?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro2;?></td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">


 <!--<a href="javascript:FncAlmacenMovimientoEntradaDetalleReemplazorCargar('<?php echo  $Identificador;?>','<?php echo trim($DatAlmacenMovimientoEntradaDetalle->Item);?>');"><?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro17;?></a>-->
		
        
        <?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro17;?>
        
        								
							<?php //echo $DatAlmacenMovimientoEntradaDetalle->Parametro17;?>
                               <a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro17;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" />
                               
                                </a>
         
          
          
                            </td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>"><?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro18;?></td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
                            <?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro3;?></td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>"><?php echo $DatAlmacenMovimientoEntradaDetalle->Parametro9;?>
                            
                            
                            
                            
                            </td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
                                <?php echo number_format(($DatAlmacenMovimientoEntradaDetalle->Parametro4),2);?>
                               
                            </td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
                              
                              <?php echo number_format($DatAlmacenMovimientoEntradaDetalle->Parametro5,3);?>
                              
                                <br />
				<span class="EstFormularioSubEtiqueta">
                              (<?php echo number_format($DatAlmacenMovimientoEntradaDetalle->Parametro12,3);?>)
                              </span>
                              
                            </td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
                              
                              <?php echo number_format(($DatAlmacenMovimientoEntradaDetalle->Parametro6),2);?>
                              
                            </td>
                            <td align="center" bgcolor="#FFCC33"><?php
        $Reemplazo = "NO";
         $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$DatAlmacenMovimientoEntradaDetalle->Parametro17 ,"PreId","ASC",NULL,1);
        $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
        
        if(!empty($ArrProductoReemplazos)){
              $Reemplazo= "SI";
        }
             
        ?>
                              <?php
if($Reemplazo == "SI"){
?>
                              <a href="javascript:FncProductoReemplazoCargar('<?php echo trim($DatAlmacenMovimientoEntradaDetalle->Parametro17);?>');"><?php echo $Reemplazo;?></a>
                              <?php	
}else{
?>
                              <?php echo $Reemplazo;?>
                              <?php	
}
?></td>
                            <td align="right" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>"><?php
			
			//deb($DatAlmacenMovimientoEntradaDetalle->Parametro25);
			switch($DatAlmacenMovimientoEntradaDetalle->Parametro25){
				case 1:
			?>
                              No Llego
                              <?php	
				break;
				
				case 2:
			?>
                              Da&ntilde;ado
  <?php	
				break;
				
				case 3:
			?>
                              Conforme
  <?php	
				break;
			}
			?></td>
                            <td align="center" class="<?php //echo ($c%2==0)?"EstTablaListadoActivo":"EstTablaListadoInactivo";?>">
                            
                            <?php
                            if($_POST['Editar']==1){
                            ?>
                            <a class="EstSesionObjetosItem" href="javascript:FncAlmacenMovimientoEntradaDetalleEscoger('<?php echo $DatAlmacenMovimientoEntradaDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if($_POST['Eliminar']==1){
                            ?>
                            <a href="javascript:FncAlmacenMovimientoEntradaDetalleEliminar('<?php echo $DatAlmacenMovimientoEntradaDetalle->Item;?>');" >
                            <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
                            <?php
                            }
                            ?>
                            
                             <?php
                            if($_POST['Editar']==1){
                            ?>
                            
                           
                            
                            <a class="EstSesionObjetosItem"  href="javascript:FncAlmacenMovimientoEntradaDetalleReemplazorCargar('<?php echo  $Identificador;?>','<?php echo trim($DatAlmacenMovimientoEntradaDetalle->Item);?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_reemplazar.png" alt="[Reemplazar]" title="Reemplazar" width="25" height="25"  /></a>
                            <?php
                            }
                            ?>
                            
                            <?php
                            /*if($_POST['Editar']==1){
                            ?>
                            
                            <a class="EstSesionObjetosItem" href="javascript:FncAlmacenMovimientoEntradaDetalleEscogerReemplazo('<?php echo $DatAlmacenMovimientoEntradaDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/reemplazar.gif" alt="[Reemplazar]" title="Reemplazar" width="15" height="15"  /></a>
                            
                            <?php
                            }*/
                            ?>
                            
                            
                            </td>
                            </tr>
                            <?php
                            
                                $SubTotal = $SubTotal + $DatAlmacenMovimientoEntradaDetalle->Parametro6;
                            $fila++;
                            $c++;
                           
                            
                            
                            
                            ?>
                           
          
                    
                <?php	
               // }
                ?>
                
                
                
        <?php	
        }
        ?>
        
      
       
        
           </tbody>
                            </table>
                           <!-- <br />
                            	<hr /><br />-->
                                
<br /><br />
                <?php
                }
                ?>   
                
    
    <?php	


    }
    ?>
    
                
    
<?php
$SubTotal = round($SubTotal,2);
$Recargo = $POST_TotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($EmpresaImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;
?>


        <br />
        <table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
        <tbody class="EstTablaTotalBody">
        <tr>
          <td align="right" class="Total">&nbsp;</td>
          <td align="left" >&nbsp;</td>
          <td align="right" class="Total">Sub Total:</td>
          <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
        </tr>
        <tr>
          <td align="right" class="Total">&nbsp;</td>
          <td align="left" >&nbsp;</td>
          <td align="right" class="Total">Total Recargo:</td>
          <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Recargo,2);?></td>
        </tr>
        <tr>
          <td align="right" class="Total">&nbsp;</td>
          <td align="left" >&nbsp;</td>
          <td align="right" class="Total">Impuesto (<?php echo $EmpresaImpuestoVenta;?>):</td>
          <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
        </tr>
        <tr>
          <td width="17%" align="right" class="Total">&nbsp;</td>
          <td width="7%" align="left" >&nbsp;</td>
          <td width="65%" align="right" class="Total">Total:</td>
          <td width="11%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
          
        </tr>
        </tbody>
        </table>
        
<?php	
}
?>
