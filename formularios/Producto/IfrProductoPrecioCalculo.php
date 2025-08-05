<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"CONSULTA_PRECIO_PRODUCTO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_ProductoCodigoOriginal = $_POST['CmpProductoCodigoOriginal'];
$POST_Moneda = $_POST['CmpMoneda'];
$POST_MargenUtilidad = $_POST['CmpMargenUtilidad'];
$POST_Flete = $_POST['CmpFlete'];
$POST_ManoObra = $_POST['CmpManoObra'];

$POST_PorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];

$POST_TipoCambio = 1;

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProducto = new ClsProducto();
$InsMoneda = new ClsMoneda();
$InsClienteListaPrecio = new ClsClienteListaPrecio();

//MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 
//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)

if(empty($POST_ProductoCodigoOriginal)){
	exit("Ingrese un codigo original de repuesto");
}

$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$POST_ProductoCodigoOriginal,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];

$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$POST_ProductoCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$POST_ProductoCodigoOriginal ,"PlpId","ASC","1",1);
$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];

//$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$POST_ProductoCodigoOriginal ,"PreId","ASC",NULL,1);
//$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();


$InsProducto->ProId = $ArrProductos[0]->ProId;
unset($ArrProductos);
$InsProducto->MtdObtenerProducto(false);



?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CONSULTA DE PRECIO DE PRODUCTO


 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
        


<?php
/*$ProductoNombre = "";
$ProductoCodigo = "";
if(!empty($ArrProductoListaPrecios)){
?>

	<?php
        foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
    ?>
        
        <?php $ProductoNombre =  trim($DatProductoListaPrecio->PlpNombre);?>
        <?php $ProductoCodigo =  trim($DatProductoListaPrecio->PlpCodigo);?>
    
    <?php
        }
    ?>

<?php
}*/
?>
 
<?php
$Costo = 0;
$Impuesto = 0;
$Flete = 0;
$MargenUtilidad = 0;
$Precio = 0;
$CostoTotal = 0;
?>
                
<?php
if(!empty($ArrProductoListaPrecios)){
	foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
		
		$MonedaId = $DatProductoListaPrecio->MonId;

		$InsTipoCambio = new ClsTipoCambio();
		$InsTipoCambio->MonId = $MonedaId;
		$InsTipoCambio->TcaFecha = date("Y-m-d");
		$InsTipoCambio->MtdObtenerTipoCambioActual();

		if(empty($InsTipoCambio->TcaId)){
			$InsTipoCambio->MtdObtenerTipoCambioUltimo();
		}
		
		$MonedaLocalTipoCambio = $InsTipoCambio->TcaMontoComercial;



//		$CostoOriginal = $DatProductoListaPrecio->PlpPrecioReal;
//		$MonedaSimboloOriginal = $DatProductoListaPrecio->MonSimbolo;
		if($POST_Moneda == $DatProductoListaPrecio->MonId){

			$Costo = $DatProductoListaPrecio->PlpPrecioReal;			

		}else{

			//CONVIRTIENDO A MONEDA LOCAL
			$Costo = ($DatProductoListaPrecio->PlpPrecioReal * $MonedaLocalTipoCambio);
			
			if($EmpresaMonedaId == $POST_Moneda){
				
				$MonedaConvertirTipoCambio =  1;
				
			}else{
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $POST_Moneda;
				$InsTipoCambio->TcaFecha = date("Y-m-d");
				$InsTipoCambio->MtdObtenerTipoCambioActual();
	
				if(empty($InsTipoCambio->TcaId)){
					$InsTipoCambio->MtdObtenerTipoCambioUltimo();
				}

				$MonedaConvertirTipoCambio = $InsTipoCambio->TcaMontoComercial;

			}
			
			//CONVIRTIENDO A MONEDA SOLICITADA
			$Costo = $Costo * $MonedaConvertirTipoCambio;
		}

	}
}

$Impuesto = ( ($POST_PorcentajeImpuestoVenta/100) ) * $Costo;

	$Precio = $Costo + $Impuesto;

$Flete = ( ($POST_Flete/100) ) * $Precio;

$ManoObra = ( ($POST_ManoObra/100) ) * ($Precio + $Flete);


	$CostoTotal = $Precio = $Precio + $Flete + $ManoObra ;

$MargenUtilidad = ( ($POST_MargenUtilidad/100) ) * $Precio;

	$Precio = $Precio + $MargenUtilidad;

?>       
                
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">

        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="95%" align="center">
            
            <table width="70%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $POST_ProductoCodigoOriginal;?>
                  
                  </th>
                </tr>
                 </thead>
                  <tbody class="EstTablaReporteBody">
                <tr>
                  <td colspan="2" align="left" valign="top"><span class="EstReporteTitulo">DATOS DEL PRODUCTO</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Codigo Original:</td>
                  <td align="left" valign="top"><?php  echo ($InsProducto->ProCodigoOriginal); ?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><?php  echo ($InsProducto->ProNombre); ?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top"><span class="EstReporteTitulo">PRECIO PROVEEDOR</span></td>
                  </tr>
                <tr>
                  <td align="left" valign="top">Precio  GM:</td>
                  <td align="left" valign="top">
	 
              <?php  echo $InsMoneda->MonSimbolo; ?>
                
                <?php  echo number_format($Costo,2); ?></td>
                </tr>
               
                
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top"><span class="EstReporteTitulo">CALCULO DE PRECIO</span></td>
                  </tr>
                <tr>
                  <td align="left" valign="top">Tipo de Cambio:</td>
                  <td align="left" valign="top">
                  
<?php echo number_format($MonedaConvertirTipoCambio,3);?>


                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Impuesto:</td>
                  <td align="left" valign="top"><?php  echo $InsMoneda->MonSimbolo; ?>
                  
                  <?php  echo number_format($Impuesto,2); ?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Otros Costos

                  :<br>
(flete)</td>
                  <td align="left" valign="top"><?php  echo $InsMoneda->MonSimbolo; ?>
                  
                    <?php  echo number_format($Flete,2); ?>
                    
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Otros Costos

                  :<br>
(Mano de Obra)</td>
                  <td align="left" valign="top"><?php  echo $InsMoneda->MonSimbolo; ?>
                  
                    <?php  echo number_format($ManoObra,2); ?>
                    
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">COSTO TOTAL:</td>
                  <td align="left" valign="top"><?php  echo $InsMoneda->MonSimbolo; ?>
                  <?php  echo number_format($CostoTotal,2); ?> </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Margen de Utilidad: </td>
                  <td align="left" valign="top"><?php  echo $InsMoneda->MonSimbolo; ?>
                  <?php  echo number_format($MargenUtilidad,2); ?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio Bruto:</td>
                  <td align="left" valign="top"> <?php  echo $InsMoneda->MonSimbolo; ?> <?php  echo number_format($Precio,2); ?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">PRECIO FINAL:</td>
                  <td align="left" valign="top"><?php  echo $InsMoneda->MonSimbolo; ?>
                
                   <?php  echo number_format(FncRedondearCYC($Precio),2); ?>
                  
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">
                  
                  <span class="EstReporteTitulo">
                  STOCK Y DISPONIBILIDAD
                  </span>
                  
                  </td>
                  </tr>
                <tr>
                  <td width="29%" align="left" valign="top">Disponible en Lista de GM:</td>
                  <td width="71%" align="left" valign="top">
				
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>  
						<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> 
					<?php
					}
					?>
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?> &nbsp;</td>
                </tr>
                
                <?php
				/*foreach($ArrClientes as $DatCliente){
				?>
                <tr>
                  <td align="left" valign="top">
				  Precio p/ Cliente:
				  <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                  <td align="left" valign="top">
                  
                  <?php
				  $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$POST_ProductoCodigoOriginal, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
				  $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
				  ?>
                  
                  <?php
                  foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
				?>
                
                
                 <?php
					if($InsMoneda->MonId <> $EmpresaMonedaId){
						
						if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
						?>
							<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
						}else{
							
							$DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
						?>
                    		<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                    	<?php
						}
						?>
                    
                    <?php	
					}else{
					?>
					
                    	<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                    
					<?php	
					}
					?>
                    
                    
                      <span class="EstTablaReporteEspecial1">
                    
                    Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                    Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                    
                    </span>
                    
                    
                <?php
					  
				  }
                  ?>
                 
                 
                 
                  </td>
                </tr>
                <?php
				}*/
				?>
                <tr>
                  <td align="left" valign="top">Disponible en Almacen Local:</td>
                  <td align="left" valign="top">
                  
					<?php echo ($DatProducto->ProStockReal>0)?'SI':'NO';?> (<?php echo number_format($DatProducto->ProStockReal,2);?>)
                    
                  
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </tbody>
            
            </table></td>
            <td width="2%" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>