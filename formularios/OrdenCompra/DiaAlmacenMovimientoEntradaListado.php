<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}



////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';


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
/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

/*
*Variables GET
*/
$GET_mod = $_GET['Mod'];
$GET_form = $_GET['Form'];

?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Imprimir"))?true:false;?>

<?php
//$GET_OcoId = $_GET['OcoId'];
//echo " - ";
//$GET_PcoId = $_GET['PcoId'];
$GET_PcdId = $_GET['PcdId'];

if(empty($GET_PcdId)){
	exit("No se encontro el pedido de compra");	
}

//if(empty($GET_OcoId)){
//	if(empty($GET_PcoId)){
//		exit("No se encontro pedido de compra");	
//	}
//}else{
//	//if(empty($GET_PcoId)){
////		exit("No se encontro pedido de compra");	
////	}	
//}

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL)
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoFecha","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$GET_PcdId);

$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];
?>

<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de MOV. ENTRADA A ALMACEN  de la ORDEN DE COMPRA</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrAlmacenMovimientoEntradas)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="3%" align="center">#</th>
        <th width="8%" align="center">Cod. Interno</th>
        <th width="9%" align="center">Fecha Ingreso</th>
        <th width="7%" align="center">Num. Comprob.</th>
        <th width="7%" align="center">Fecha Comprob.</th>
        <th width="5%" align="center">Num. Doc.</th>
        <th width="17%" align="center">Proveedor</th>
        <th width="7%" align="center">Moneda</th>
        <th width="4%" align="center">T.C.</th>
        <th width="13%" align="center">Total</th>
        <th width="8%" align="center">Estado</th>
        <th width="12%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="left">
		<a target="_self"  href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>">
		<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>
        </a>
        </td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->AmoFecha;?></td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->AmoComprobanteNumero;?></td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->AmoComprobanteFecha;?></td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->PrvNumeroDocumento;?></td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->PrvNombreCompleto;?></td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->MonSimbolo;?></td>
        <td align="left"><?php echo $DatAlmacenMovimientoEntrada->AmoTipoCambio;?></td>
        <td align="left"><?php echo number_format($DatAlmacenMovimientoEntrada->AmoTotal,2);?></td>
        <td align="center">

			<?php echo $DatAlmacenMovimientoEntrada->AmoEstadoIcono;?>
			<?php echo $DatAlmacenMovimientoEntrada->AmoEstadoDescripcion;?>

        </td>
        <td align="center">
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaImprimir.php?Id=<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaImprimir.php?Id=<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
          <?php
			}
			?> 
          
          
          
        </td>
        </tr>
        
<?php
$i++;
}
?>
      
      </tbody>
      </table>

<?php
}else{
?>
No se encontraron MOV. ENTRADA A ALMACENpara esta ORDEN DE COMPRA
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
   </div>
   