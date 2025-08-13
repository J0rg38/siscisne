<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"APROBACIONES_ORDEN_VENTA_VEHICULO_PENDIENTES_".date('d-m-Y').".xls\";");
 
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
$POST_sen = ($_POST['Sen'] ?? '');
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
$POST_Moneda = $_POST['Moneda'];

//if(!$_POST){
//	$POST_Moneda = "MON-10001";	
//}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '20';
}
if(empty($POST_ord)){
	$POST_ord = 'OvvTiempoSolicitudEnvio';
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
$POST_finicio =  "01/01/".date("Y");
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

//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}
$POST_pag = "";

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();



//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=0,$oAprobacion2=0,$oAprobacion2=3) 
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("OvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,3,0,0);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];



?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >ID</th>
                <th width="5%" >SUCURSAL</th>
                <th width="4%" >FECHA DE ENVIO</th>
                <th width="9%" >NUM. DOC.</th>
                <th width="25%" >CLIENTE</th>
                <th width="5%" >VIN</th>
                <th width="7%" >MARCA</th>
                <th width="7%" >MODELO</th>
                <th width="7%" >VERSION</th>
                <th width="6%" >COLOR</th>
                <th width="6%" >AÑO FAB.</th>
                <th width="6%" >AÑO MOD.</th>
                <th width="6%" >MONEDA </th>
                <th width="4%" >T.C.</th>
                <th width="2%" >ABONOS</th>
                <th width="7%" >TOTAL</th>
                <th width="4%" >ASESOR DE VENTAS</th>
                <th width="4%" >NOTAS</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="19" align="center">&nbsp;</td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrOrdenVentaVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="4%"   >
                  
                  <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId;?>');">
                  <?php echo $dat->OvvId;  ?>
                  </a>
                  
                </td>
                <td  width="5%" align="right" ><?php echo $dat->SucNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OvvTiempoSolicitudEnvio);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="25%" align="left" >
                

    - <?php echo ($dat->CliNombre);?>
    <?php echo ($dat->CliApellidoPaterno);?>
    <?php echo ($dat->CliApellidoMaterno);?>

                
                   
                  
                  
                 <?php
				 $InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();
				 
				 $ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$dat->OvvId);
				 $ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

//deb( $ArrOrdenVentaVehiculoPropietarios);
				 ?>
                 
                 <?php
				 if(!empty($ArrOrdenVentaVehiculoPropietarios)){
					 foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
				?>
                	<?php
					if($DatOrdenVentaVehiculoPropietario->CliId <> $dat->CliId){
					?><br />
                    



		- <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?>
                    	<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?>
                    	<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?>

                    
                        
                    <?php
					}
					?>
                	
                    
                <?php		 
					 }
				 }
				 ?>
               
                  
                  
                </td>
                <td  width="5%" align="right" >
				
				
				<?php
if($PrivilegioVehiculoIngresoEditar or $PrivilegioVehiculoIngresoVer){
?>

<a href="javascript:FncVehiculoIngresoCargarFormulario('<?php echo (($PrivilegioVehiculoIngresoEditar)?'Editar':'Ver');?>','<?php echo $dat->EinId?>');"  ><?php echo ($dat->EinVIN);?></a>

<?php
}else{
?>
<?php echo ($dat->EinVIN);?>
<?php	
}
?>


<?php //echo ($dat->EinVIN);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->OvvColor);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->OvvAnoFabricacion);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->OvvAnoModelo);?></td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->OvvTipoCambio;  ?></td>
                <td  width="2%" align="right" >
                  
                  
                  
                  <?php
//if($PrivilegioPagoListado and $dat->OvvPago == "Si"){
if( $dat->OvvPago == "Si"){
?>
                  <a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('Listado','<?php echo $dat->OvvId;?>');" > Tiene Abonos</a>
  <?php
}else{
?>
                  No Tiene Abonos
  <?php	
}
?>
                  
                  
                  
  <?php
/*if($PrivilegioPagoListado){
?>
                  <a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('Listado','<?php echo $dat->OvvId;?>');" >Ord. Cobro / Abonos</a>
                  <?php
}*/
?>
                  
                  
</td>
                <td  width="7%" align="right" >
                  
                  
                  <?php $dat->OvvTotal = (($dat->OvvTotal/(empty($dat->OvvTipoCambio)?1:$dat->OvvTipoCambio)));?>
                
                
                  <?php echo number_format($dat->OvvTotal,2);?>
                  
                  
                  
                  
                 
                </td>
                <td  width="4%" align="right" ><?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OvvObservacionAsignacion);?></td>
        </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->OvvSubTotal;
									$Impuesto += $dat->OvvImpuesto ;
									$Total += $dat->OvvTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

									?>
            </tbody>
      </table>
