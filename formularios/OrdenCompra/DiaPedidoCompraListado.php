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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Imprimir"))?true:false;?>

<?php
$GET_OcoId = $_GET['OcoId'];

if(empty($GET_OcoId)){
	exit("No se encontro orden de compra");
}

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');

$InsPedidoCompra = new ClsPedidoCompra();

// MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL) 

$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoId","ASC",NULL,NULL,NULL,NULL,NULL,0,NULL,$GET_OcoId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
?>

<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de PEDIDOS  de la ORDEN DE COMPRA</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrPedidoCompras)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="7%" align="center">Cod. Interno</th>
        <th width="7%" align="center">Fecha</th>
        <th width="9%" align="center">Tipo Doc.</th>
        <th width="9%" align="center">Num. Doc.</th>
        <th width="9%" align="center">Cliente</th>
        <th width="6%" align="center">Moneda</th>
        <th width="6%" align="center">T.C.</th>
        <th width="6%" align="center">Cot.</th>
        <th width="6%" align="center">Ord Ven.</th>
        <th width="6%" align="center">Total</th>
        <th width="10%" align="center">Estado</th>
        <th width="7%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrPedidoCompras as $DatPedidoCompra){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="left">
		<a target="_self"  href="principal.php?Mod=VehiculoIngreso&Form=Ver&Id=<?php echo $DatPedidoCompra->PcoId;?>">
		<?php echo $DatPedidoCompra->PcoId;?>
        </a>
        </td>
        <td align="left"><?php echo $DatPedidoCompra->PcoFecha;?></td>
        <td align="left"><?php echo $DatPedidoCompra->TdoNombre;?></td>
        <td align="left"><?php echo $DatPedidoCompra->CliNumeroDocumento;?></td>
        <td align="left"><?php echo $DatPedidoCompra->CliNombreCompleto;?></td>
        <td align="left"><?php echo $DatPedidoCompra->MonSimbolo;?></td>
        <td align="left"><?php echo $DatPedidoCompra->PcoTipoCambio;?></td>
        <td align="left"><?php echo $DatPedidoCompra->CprId;?></td>
        <td align="left"><?php echo $DatPedidoCompra->VdiId;?></td>
        <td align="left">
		
		<?php echo number_format($DatPedidoCompra->PcoTotal,2);?>
        
        </td>
        <td align="center"><?php echo $DatPedidoCompra->PcoEstadoDescripcion;?></td>
        <td align="center">
          
			<?php
			if($PrivilegioVer){
			?>
			<a target="_self"  href="principal.php?Mod=PedidoCompra&Form=Ver&Id=<?php echo $DatPedidoCompra->PcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
			<?php
			if($PrivilegioVistaPreliminar){
			?>
			<a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
			<?php
			}
			?>
          
			<?php
			if($PrivilegioImprimir){
			?>        
			<a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron PEDIDOS para esta ORDEN DE COMPRA
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
   