<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"ORDEN_TRABAJO_".date('d-m-Y').".xls\";");
 
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
$POST_CondicionPago = $_POST['CmpCondicionPago'];
$POST_Moneda = $_POST['CmpMoneda'];

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


if($POST_Todos=="Si"){
	$POST_pag = "";
}else{

	if(empty($POST_pag)){
		$POST_pag = '0,'.$POST_num;
	}
	
}


$GET_VdiId = $_GET['VdiId'];

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
$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,VdiId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda);

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
                <th width="5%" >ID</th>
                <th width="8%" >ORD. VENTA</th>
                <th width="12%" >NUM. RECIBO</th>
                <th width="12%" >NUM. TRANSAC.</th>
                <th width="12%" >FECHA</th>
                <th width="9%" >MONEDA</th>
                <th width="5%" >T.C.</th>
                <th width="5%" >ESTADO</th>
                <th width="7%" >MONTO</th>
                <th width="10%" >FEECHA CREACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="11" align="center">&nbsp;</td>
              </tr>
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;


				$TotalAbonos = 0;
				$TotalOrdenCobros = 0;
				
				
								foreach($ArrPagos as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="5%"   ><?php echo $dat->PagId;  ?></td>
                <td align="right" valign="middle" width="8%"   ><?php echo $dat->VdiId;  ?></td>
                <td  width="12%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                <td  width="12%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                <td  width="12%" align="right" ><?php echo $dat->PagFecha; ?></td>
                <td align="right" ><?php echo ($dat->MonNombre);?></td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
                <td  width="7%" align="right" >


<?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>


				<?php echo number_format($dat->PagMonto,2); ?></td>
                <td  width="10%" align="right" ><?php echo ($dat->PagTiempoCreacion);?></td>
        </tr>

              <?php		
			  
			  
			    
			  if($dat->PagEstado == 1){
				  $TotalOrdenCobros += $dat->PagMonto;
			  }
			  
			  if($dat->PagEstado == 3){
				  $TotalAbonos += $dat->PagMonto;
			  }
			  
			  
			  
			  $f++;

									}

									?>
            </tbody>
      </table>
