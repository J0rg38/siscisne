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


session_start();
if (!isset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador])){
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVehiculoRecepcionDetalles = $RepSesionObjetos['Datos'];

?>


<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
    <th width="2%">#</th>
    <th width="2%">&nbsp;</th>
    <th width="2%">Id</th>
    <th width="13%">Zona Comprometida</th>
    <th width="14%">Repuesto Detalle</th>
    <th width="12%"> Solucion</th>
    <th width="12%">Observacion</th>
    <th width="16%">Fotos</th>
    <th width="19%">&nbsp;</th>
    <th width="8%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">

<?php
if(!empty($ArrVehiculoRecepcionDetalles)){
?>
	<?php
    
//						SesionObjeto-VehiculoRecepcionDetalle
//						Parametro1 = VrdId
//						Parametro2 = VreId
//						Parametro3 = VrdZonaComprometida
//						Parametro4 = VrdRepuestoDetalle
//						Parametro5 = VrdSolucion
//						Parametro6 = VrdObservacion
//						Parametro7 = VrdTiempoCreacion
//						Parametro8 = VrdTiempoModificacion
//						Parametro9 = VrdEstado
    
    $c = 1;

	
    foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
    ?>
    
    

        <tr>
        <td align="right">
        <span title="<?php echo $DatVehiculoRecepcionDetalle->Parametro1;?>">
        <?php echo $c;?>
        </span>
        </td>
        <td align="right"> <input style="visibility:hidden;" type="checkbox" etiqueta="detalle" checked="checked"  disabled="disabled" name="CmpVehiculoRecepcionDetalle_<?php echo $DatVehiculoRecepcionDetalle->Item;?>" id="CmpVehiculoRecepcionDetalle_<?php echo $DatFichaAccionProducto->Item;?>" value="<?php echo $DatVehiculoRecepcionDetalle->Item;?>" /></td>
        <td align="right"><?php echo $DatVehiculoRecepcionDetalle->Parametro1;?>
        
       
        
        </td>
        <td align="right">
        
        <?php echo $DatVehiculoRecepcionDetalle->Parametro3;?>
        
      
        
        
        </td>
        <td align="right"><?php echo $DatVehiculoRecepcionDetalle->Parametro4;?></td>
        <td align="right"><?php echo $DatVehiculoRecepcionDetalle->Parametro5;?></td>
        <td align="right"><?php echo $DatVehiculoRecepcionDetalle->Parametro6;?></td>
        <td align="center">
        
        
  <div id="fileuploader<?php echo $DatVehiculoRecepcionDetalle->Item?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatVehiculoRecepcionDetalle->Item;?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleFotoSubirArchivo.php",
	formData: {"Identificador":"<?php echo $Identificador;?>","Item":"<?php echo $DatVehiculoRecepcionDetalle->Item;?>"},
	multiple:true,
	autoSubmit:true,
	dragDrop:false,
	fileName:"Filedata",
	showStatusAfterSuccess:false,
	

	abortStr:"Abortar",
	cancelStr:"Cancelar",
	doneStr:"Hecho",

	extErrorStr:"Extension de archivo no permitido",
	sizeErrorStr:"Tamaño no permitido",
	uploadErrorStr:"No se pudo subir el archivo",
	
	
	onSuccess:function(files,data,xhr){
		FncVehiculoRecepcionDetalleFotoListar('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');
	}
	
	});
});
              
            </script>
                          
        </td>
        <td align="left">
      
<div  id="CapVehiculoRecepcionDetalleFotoAccion<?php echo $DatVehiculoRecepcionDetalle->Item;?>"></div>
        
        <div class="EstCapVehiculoRecepcionDetalleFotos" id="CapVehiculoRecepcionDetalleFotos<?php echo $DatVehiculoRecepcionDetalle->Item;?>"></div>
        
        </td>
        <td align="center">
          <?php
        if($POST_Editar==1){
        ?>
          <a class="EstSesionObjetosItem" href="javascript:FncVehiculoRecepcionDetalleEscoger('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          <?php
        }
        ?>
          
          <?php
        if($POST_Eliminar==1){
        ?>
          <a href="javascript:FncVehiculoRecepcionDetalleEliminar('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?>
          
          
        </td>
        </tr>

	<?php
//        $TotalBruto = $TotalBruto + $DatVehiculoRecepcionDetalle->Parametro6;
		$TotalBruto = $TotalBruto + $DetalleImporteFinal;
		$TotalDescuento = $TotalDescuento + $DetalleDescuento;
		
		
    $c++;
    }
    ?>

<?php
}
?>

<?php
//if(!empty($SubManoObra)){
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
	/*
?>


    <tr>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="right">MANO DE OBRA</td>
      <td align="right">-</td>
        <td align="right">
    
        <?php	// $SubManoObra = ($POST_ManoObra);?>
        <?php	// echo number_format($SubManoObra,2);?>
        <?php	echo number_format($POST_ManoObra,2);?>
    
        </td>
      <td align="right">1.00</td>
      <td align="right"><?php //echo number_format($SubManoObra,2)?>
      <?php	echo number_format($POST_ManoObra,2)?></td>
      <td align="right" bgcolor="#99FF66">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="center" bgcolor="#FFFF99">-</td>
      <td align="center" bgcolor="#FFCC33">-</td>
      <td align="center">-</td>
      <td align="center">&nbsp;</td>
      <td align="center">-</td>
      <td align="center">-</td>
    </tr>

<?php*/	
	$TotalBruto = $TotalBruto + $POST_ManoObra;
}
?>

<?php

$TotalRepuesto = $TotalBruto;
//$TotalDescuento = $TotalDescuento;

/*if(!empty($POST_PorcentajeDescuento)){
	//$TotalDescuento = $TotalBruto * ($POST_PorcentajeDescuento/100);
	$TotalBruto = $TotalBruto - $TotalDescuento;
	
}*/


if($POST_IncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto;
	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

}

	//if($POST_IncluyeImpuesto == 1){
//
//		$Total = $TotalBruto;
//		$SubTotal = $Total / (($EmpresaImpuestoVenta/100)+1);
//		$Impuesto = $Total - $SubTotal;	
//		$POST_ManoObra = $POST_ManoObra / (($EmpresaImpuestoVenta/100)+1);
//		
//		if(!empty($POST_PorcentajeDescuento)  and $POST_PorcentajeDescuento <> "" and $POST_PorcentajeDescuento<>"0.00"){
//			
//			$TotalDescuento = ( $SubTotal * ($POST_PorcentajeDescuento / 100) );
//			$SubTotal = $SubTotal - ( $SubTotal * ($POST_PorcentajeDescuento / 100) )  ;
//			$SubTotal = $SubTotal + $POST_ManoObra;
//			$Impuesto = $SubTotal * 0.18;
//			$Total = $SubTotal + $Impuesto;
//			
//		}
//		
//	}else{
//		
//		
//		$SubTotal = $TotalBruto;
//		$Impuesto =  $SubTotal*(($EmpresaImpuestoVenta/100));	
//		$Total = $SubTotal + $Impuesto;
//		
//		if(!empty($POST_PorcentajeDescuento)){
//			
//			$TotalDescuento = ( $SubTotal * ($POST_PorcentajeDescuento / 100) );
//			$SubTotal = $SubTotal - $TotalDescuento;
//			$SubTotal = $SubTotal + $POST_ManoObra;
//			$Impuesto = $SubTotal * 0.18;
//			$Total = $SubTotal + $Impuesto;
//
//		}
//
//		
//	}

?>
  </tbody>
</table>


