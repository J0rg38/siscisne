<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"COMPRAS_".date('d-m-Y').".xls\";");
 
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
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

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
$POST_origen = $_POST['Origen'];
$POST_TipoFecha = $_POST['TipoFecha'];
$POST_Moneda = $_POST['Moneda'];
$POST_Almacen = $_POST['CmpAlmacen'];
$POST_Sucursal = $_POST['CmpSucursal'] ?? '';

if(empty($POST_p)){$POST_p = '1';}
if(empty($POST_num)){$POST_num = '10';}
if(empty($POST_ord)){$POST_ord = 'AmoId';}
if(empty($POST_sen)){$POST_sen = 'DESC';}
if(empty($POST_pag)){$POST_pag = '0,'.$POST_num;}
/*
* Otras variables
*/
if(empty($POST_finicio)){
	$POST_finicio = "01/01/".date("Y");;
}

if(empty($POST_ffin)){$POST_ffin = date("d/m/Y");}
if(empty($POST_estado)){$POST_estado = 0;}
if(empty($POST_con)){$POST_con = "contiene";}
if(empty($POST_TipoFecha)){$POST_TipoFecha = "AmoFecha";}


if(!$_POST){
 $POST_Sucursal=$_SESSION['SesionSucursal'];	
}

//deb($_POST);
$POST_pag = "";

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oSucursal=NULL)																											
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas("AmoId,prv.PrvNombre,prv.PrvApellidoPaterno,prv.PrvApellidoMaterno,AmoComprobanteNumero,AmoGuiaRemisionNumero,amo.OcoId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_origen,$POST_Moneda,NULL,NULL,NULL,NULL,$POST_TipoFecha,0,0,NULL,NULL,NULL,1,$POST_Almacen,$POST_Sucursal);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];
$AlmacenMovimientoEntradasTotal = $ResAlmacenMovimientoEntrada['Total'];
$AlmacenMovimientoEntradasTotalSeleccionado = $ResAlmacenMovimientoEntrada['TotalSeleccionado'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$POST_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >ID</th>
                <th width="5%" >FECHA INGRESO</th>
                <th width="7%" >COMPROB.</th>
                <th width="7%" >NUM. COMPROB.</th>
                <th width="7%" >FEC. COMPROB.</th>
                <th width="18%" >PROVEEDOR</th>
                <th width="6%" >ORD. COMPRA</th>
                <th width="4%" >MARCA </th>
                <th width="4%" >N. CRE.</th>
                <th width="6%" >MONEDA</th>
                <th width="3%" >T.C.</th>
                <th width="4%" >TOTAL</th>
                <th width="3%" >EST.</th>
                <th width="2%" >IT.</th>
                <th width="5%" >REV.</th>
                <th width="6%" >FECHA CREACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="17" align="center">&nbsp;</td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrAlmacenMovimientoEntradas as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   >
                 
                  <?php echo $dat->AmoId;  ?>


                </td>
                <td  width="5%" align="right" ><?php echo ($dat->AmoFecha);?></td>
                <td  width="7%" align="right" ><?php echo $dat->CtiNombre;  ?></td>
                <td  width="7%" align="right" >
				
				<h2><?php echo $dat->AmoComprobanteNumero;  ?></h2></td>
                <td  width="7%" align="right" ><?php echo $dat->AmoComprobanteFecha;  ?></td>
                <td  width="18%" align="right" >
                  

  <?php echo ($dat->PrvNombreCompleto);?>

                  
                  
                  
</td>
                <td  width="6%" align="right" ><?php
if($PrivilegioOrdenCompraVer){
?>
                <?php echo ($dat->OcoId);?>
                  <?php	
}else{
?>
                  <?php echo ($dat->OcoId);?>
                  <?php	
}
?></td>
                <td  width="4%" align="right" ><?php echo $dat->VmaNombre;  ?></td>
                <td  width="4%" align="right" >
                  
                  
                  
                  <?php
if($dat->AmoNotaCreditoCompra == "Si"){
?>
                Tiene N. Cred.  
                  
  <?php	
}else{
?>
                  No Tien N. Cred.
                  
                  <?php	
}
?>    
                  
                </td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->AmoTipoCambio;  ?></td>
                <td  width="4%" align="right" >
                  
                  <?php $dat->AmoTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->AmoTotal:($dat->AmoTotal/$dat->AmoTipoCambio));?>                          
                  <?php echo number_format($dat->AmoTotal,2);?>
                  <?php
					$Total += $dat->AmoTotal ;
			
				?>
                </td>
                <td  width="3%" align="right" ><?php echo $dat->AmoEstadoIcono;?> <?php echo $dat->AmoEstadoDescripcion;?>
                  <?php
				/*switch($dat->AmoEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/pendiente.gif" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />
                  <?php							
						break;	

					}*/
				?></td>
                <td  width="2%" align="right" ><?php echo ($dat->AmoTotalItems);?></td>
                <td  width="5%" align="right" ><?php echo $dat->AmoRevisadoIcono;?> <?php echo $dat->AmoRevisadoDescripcion;?></td>
                <td align="right" ><?php echo ($dat->AmoTiempoCreacion);?></td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									$SubTotal = number_format($SubTotal,2);

									?>
            </tbody>
      </table>
