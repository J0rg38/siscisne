<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"PAGOS_".date('d-m-Y').".xls\";");
 
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

$POST_Todos = ($_GET['Todos']);


$POST_cam = ($_POST['Cam']);
$POST_fil = ($_POST['Fil']);

if($_POST){
	$_SESSION[$GET_mod."Filtro"] = $POST_fil;
}else{
	$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
}

$POST_ord = ($_POST['Ord']);
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag']);
$POST_p = ($_POST['P']);
$POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'];
$POST_acc = $_POST['Acc'];

/*
* Otras variables
*/

$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Estado = $_POST['Estado'];

$POST_Area = $_POST['Area'];
$POST_Moneda = $_POST['Moneda'];
$POST_Origen = $_POST['Origen'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_Tipo = $_POST['Tipo'];
$POST_FormaPago = $_POST['CmpFormaPago'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'PagTiempoCreacion';
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
	$POST_finicio = "01/".date("m/Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

if($_POST){
	$_SESSION[$GET_mod."Area"] = $POST_Area;
}else{
	$POST_Area = (empty($_GET['Area'])?$_SESSION[$GET_mod."Area"]:$_GET['Area']);
}

if($_POST){
   $_SESSION[$GET_mod."Origen"] = $POST_Origen;
}else{
	$POST_Origen = (empty($_GET['Origen'])?$_SESSION[$GET_mod."Origen"]:$_GET['Origen']);
}  


if($_POST){
   $_SESSION[$GET_mod."Moneda"] = $POST_Moneda;
}else{
	$POST_Moneda = (empty($_GET['Moneda'])?$_SESSION[$GET_mod."Moneda"]:$_GET['Moneda']);
}  

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


if($POST_Todos=="Si"){
	$POST_pag = "";
}else{

	if(empty($POST_pag)){
		$POST_pag = '0,'.$POST_num;
	}
	
}


//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

//INSTANCAS
$InsPago = new ClsPago();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsVentaDirecta = new ClsVentaDirecta();

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL)
$ResPago = $InsPago->MtdObtenerPagos("PagId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,"3,6",$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,$POST_Area,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,$POST_Tipo);

$ArrPagos = $ResPago['Datos'];
$PagosTotal = $ResPago['Total'];
$PagosTotalSeleccionado = $ResPago['TotalSeleccionado'];

//MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
 
$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >ID</th>
                <th width="4%" >FECHA</th>
                <th width="4%" >DOC. AFECTADO</th>
                <th width="4%" >O.T.</th>
                <th width="4%" >DOC. REF.</th>
                <th width="7%" >F. PAGO</th>
                <th width="7%" >NUM. RECIBO</th>
                <th width="6%" >NUM. TRANSAC.</th>
                <th width="4%" >NUM. DOC.</th>
                <th width="15%" >CLIENTE</th>
                <th width="5%" >MONEDA</th>
                <th width="3%" >T.C.</th>
                <th width="5%" >MONTO</th>
                <th width="2%" >APL.</th>
                <th width="2%" >TIPO</th>
                <th width="6%" >ESTADO</th>
                <th width="6%" >FECHA REGISTRO</th>
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

				foreach($ArrPagos as $dat){
				?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="right" valign="middle"   >
               
                  <?php echo $dat->PagId;  ?>
                 
                </td>
                <td width="4%" align="right" valign="middle"   ><?php echo $dat->PagFecha;  ?></td>
                <td width="4%" align="right" valign="middle"   ><?php
				  if(!empty($dat->VdiId)){
				?>
                  <a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');" > <?php echo $dat->VdiId;  ?> </a>
                  <?php
				  }
				  ?>
                  <?php
				  if(!empty($dat->OvvId)){
				?>
                  <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId?>');" > <?php echo $dat->OvvId;  ?> </a>
                  <?php
				  }
				  ?>
                  <?php
				  if(!empty($dat->FacId)){
				?>
                  <?php echo $dat->FtaNumero;?> - <?php echo $dat->FacId;  ?>
                  <?php
				  }
				  ?>
                  <?php
				  if(!empty($dat->BolId)){
				?>
                  <?php echo $dat->BtaNumero;?> - <?php echo $dat->BolId;  ?>
                <?php
				  }
				  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->FinId;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->PagComprobante;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->FpaNombre;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="15%" align="right" ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="5%" align="right" >
				
				
				
				 <?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                  
            
				<?php
				if($dat->PagEstado==6){
				?>-
                
                <?php	
				}else{
			?>
            <?php echo number_format($dat->PagMonto,2); ?>
            <?php		
				}
				?>
				
                
                
                </td>
                <td width="2%" align="right" valign="middle"   >
				
                <?php
                switch($dat->PagUtilizado){
					case "1":
				?>
                	SI
                <?php	
					break;
					
					case "2":
				?>
                	NO
                <?php
					break;	
					
					default:
				?>
                -
                <?php	
					break;
				}
                ?>
				
                
                </td>
                <td width="2%" align="right" valign="middle"   ><?php
	switch($dat->PagTipo){
		case "VDI":
	?>
                 REPUESTOS
                  <?php	
		break;
		
		case "OVV":
	?>
VEHICULOS
                  <?php	
		break;
	}
?></td>
                <td  width="6%" align="right" >
                
                
        <?php echo $dat->PagEstadoDescripcion;


			
				?>             
                
                
                </td>
                <td  width="6%" align="right" ><?php echo ($dat->PagTiempoCreacion);?></td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									

									?>
            </tbody>
      </table>
