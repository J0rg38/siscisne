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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Imprimir"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<?php

$GET_Id = $_GET['Id'];
$GET_Ta = $_GET['Ta'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');


$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdSeguimientoVentaDirectaDetalles("ProCodigoOriginal","esigual",$POST_CodigoOriginal,$POST_ord,$POST_sen,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];

?>

<div class="EstFormularioArea"> 
    <div id="ForBuscadorProductos"  >
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="98%"><span class="EstFormularioSubTitulo"> Listado de Pedidos de Clientes</span></td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
    <?php
    if(!empty($ArrVentaDirectaDetalles)){
    ?>
    
          <table width="100%" class="EstTablaListado">
          <thead class="EstTablaListadoHead">
          <tr>
            <th width="5%" align="center">#</th>
            <th width="16%" align="center">Sucursal</th>
            <th width="15%" align="center">Id</th>
            <th width="16%" align="center">Fecha</th>
            <th width="33%" align="center">Cliente</th>
            <th width="15%" align="center">Pedido</th>
            <th width="15%" align="center">Atendido</th>
            <th width="15%" align="center">Acciones</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
    <?php
    $i=1;
    foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
    ?>
     
	 <?php //$DatVentaDirectaDetalle->VdiTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatVentaDirectaDetalle->VdiTotal:($DatVentaDirectaDetalle->VdiTotal/$DatVentaDirectaDetalle->VdiTipoCambio));?>
     <?php //$DatVentaDirectaDetalle->VdiTotal = round($DatVentaDirectaDetalle->VdiTotal,2)?>
     
        <tr>
            <td><?php echo $i;?></td>
            <td align="left"><?php echo $DatVentaDirectaDetalle->SucNombre;?></td>
            <td align="left">
            <!--<a target="_self"  href="principal.php?Mod=NotaCredito&Form=Ver&Id=<?php echo $DatVentaDirectaDetalle->VdiId;?>&Id=<?php echo $DatVentaDirectaDetalle->NctId;?>">
           --> <?php echo $DatVentaDirectaDetalle->VdiId;?>
           <!--</a>-->
            </td>
            <td align="center"><?php echo $DatVentaDirectaDetalle->VdiFechaEmision;?></td>
            <td align="left"><?php echo $DatVentaDirectaDetalle->CliNombre;?> <?php echo $DatVentaDirectaDetalle->CliApellidoPaterno;?> <?php echo $DatVentaDirectaDetalle->CliApellidoMaterno;?></td>
            <td align="center"><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);?></td>
            <td align="center">0.00</td>
            <td align="center">
              
              <?php
              /*  if($PrivilegioVer){
                ?>
              <a target="_self"  href="principal.php?Mod=NotaCredito&Form=Ver&Id=<?php echo $DatVentaDirectaDetalle->VdiId;?>&Ta=<?php echo $DatVentaDirectaDetalle->NctId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
              <?php
                }*/
                ?>
              
              <?php
                if($PrivilegioVistaPreliminar){
                ?>
              <a href="javascript:FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id=<?php echo $DatVentaDirectaDetalle->VdiId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
              <?php
                }
                ?>
              
              <?php
                if($PrivilegioImprimir){
                ?>        
              
              <a href="javascript:FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id=<?php echo $DatVentaDirectaDetalle->VdiId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
        No se encontraron registros
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
   