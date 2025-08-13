<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"TRANSFERENCIAS_PRODUCTOS_DETALLADO_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');



$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num'] ?? '');

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';

/*
* Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'TptTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

/*
* Otras variables
*/

if(empty($POST_finicio)){
$POST_finicio = "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_estado)){
	$POST_estado = 0;
}
if(empty($POST_con)){
	$POST_con = "contiene";
}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

$POST_pag = "";

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');



$InsTrasladoProducto = new ClsTrasladoProducto();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

	  
//MtdObtenerTrasladoProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TptId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$=NULL,$oSucursal=NULL,$oSucursalDestino=NULL) 
$ResTrasladoProducto = $InsTrasladoProducto->MtdObtenerTrasladoProductos("amo.TptId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Sucursal);
$ArrTrasladoProductos = $ResTrasladoProducto['Datos'];
$TrasladoProductosTotal = $ResTrasladoProducto['Total'];
$TrasladoProductosTotalSeleccionado = $ResTrasladoProducto['TotalSeleccionado'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();
?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="3%" >ID</th>
                <th width="6%" >SUCURSAL ORIGEN</th>
                <th width="7%" >SUCURSAL DESTINO</th>
                <th width="5%" >FECHA</th>
                <th width="7%" >TIPO OPERACION</th>
                <th width="8%" >TIPO COMPROB.</th>
                <th width="8%" >REFERENCIA</th>
                <th width="16%" >RESPONSABLE</th>
                <th width="7%" >G. REM..</th>
                <th width="2%" >EST.</th>
                <th width="2%" >IT.</th>
                <th width="4%" >CIERRE</th>
                <th width="7%" >FECHA CREACION			    </th>
                <th width="4%" >COD. ORIGINAL</th>
                <th width="4%" >NOMBRE</th>
                <th width="4%" >U.M.</th>
                <th width="4%" >CANT.</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="18" align="center">&nbsp;</td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrTrasladoProductos as $dat){


$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();
//MtdObtenerTrasladoProductoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoProducto=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoProductoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResTrasladoProductoDetalle =  $InsTrasladoProductoDetalle->MtdObtenerTrasladoProductoDetalles(NULL,NULL,NULL,"TpdId","ASC",NULL,$dat->TptId);
$ArrTrasladoProductoDetalles  = 	$ResTrasladoProductoDetalle['Datos'];	


if(!empty($ArrTrasladoProductoDetalles)){
	foreach($ArrTrasladoProductoDetalles as $DatTrasladoProductoDetalle){
?>

<?php		

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="3%"   >
				
				
				<?php echo $dat->TptId;  ?></td>
                <td  width="6%" align="right" ><?php echo ($dat->SucNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->SucNombreDestino);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->TptFecha);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->TopNombre);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->CtiNombre);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->TptReferencia);?></td>
                <td  width="16%" align="right" ><?php echo ($dat->PerNombre);?> <?php echo ($dat->PerApellidoPaterno);?> <?php echo ($dat->PerApellidoMaterno);?></td>
                <td  width="7%" align="right" >
                  
                  <?php
				if($dat->TptGuiaRemision == "Si"){
				?>
                  
                  <a href="formularios/TrasladoProducto/DiaGuiaRemisionListado.php?height=440&amp;width=850&amp;TptId=<?php echo $dat->TptId?>" class="thickbox" title=""><?php echo ($dat->TptGuiaRemision); ?></a>
                  
                  <?php	
				}else{
				?>
                  <?php echo ($dat->TptGuiaRemision); ?>
                  <?php	
				}
				?>
                </td>
                <td  width="2%" align="right" >
                  <?php //echo $dat->TptEstadoIcono;?> 
                  
                <?php
				/*switch($dat->TptEstado){
					
						case 1:
				?>
                 No Realizado
                  <?php
					
						break;
					
						case 3:
				?>
               Realizao
                  <?php							
						break;	

					}*/
				?>
                <?php echo $dat->TptEstadoDescripcion;?>
                </td>
                <td  width="2%" align="right" ><?php echo ($dat->TptTotalItems);?></td>
                <td  width="4%" align="center" ><?php            
if($dat->TptCierre == "1"){
?>
                  Cerrado
                  <?php	
}
?></td>
                <td  width="7%" align="right" ><?php echo ($dat->TptTiempoCreacion);?></td>
                <td  width="4%" align="center" ><?php echo ($DatTrasladoProductoDetalle->ProCodigoOriginal);?></td>
                <td  width="4%" align="center" ><?php echo ($DatTrasladoProductoDetalle->ProNombre);?></td>
                <td  width="4%" align="center" ><?php echo ($DatTrasladoProductoDetalle->UmeNombre);?></td>
                <td  width="4%" align="center" ><?php echo number_format($DatTrasladoProductoDetalle->TpdCantidad,2);?></td>
              </tr>

              <?php		$f++;

									
								

             	}
}
   
                
									

									}
									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									$SubTotal = number_format($SubTotal,2);

									?>
            </tbody>
      </table>
