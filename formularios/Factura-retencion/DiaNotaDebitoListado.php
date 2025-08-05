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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","Imprimir"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<?php

$GET_Id = $_GET['Id'];
$GET_Ta = $_GET['Ta'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');

$InsNotaDebito = new ClsNotaDebito();

//MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
$ResNotaDebito = $InsNotaDebito->MtdObtenerNotaDebitos(NULL,NULL,NULL,"NdbFechaEmision","DESC",1,NULL,$_SESSION['SesionSucursal'],5,NULL,NULL,NULL,$POST_Moneda,$GET_Id,$GET_Ta);
$ArrNotaDebitos = $ResNotaDebito['Datos'];	
?>

<div class="EstFormularioArea"> 
    <div id="ForBuscadorProductos"  >
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="98%"><span class="EstFormularioSubTitulo"> Listado de Notas de Debito</span></td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
    <?php
    if(!empty($ArrNotaDebitos)){
    ?>
    
          <table width="100%" class="EstTablaListado">
          <thead class="EstTablaListadoHead">
          <tr>
            <th width="2%" align="center">#</th>
            <th width="15%" align="center">Id</th>
            <th width="35%" align="center">Cliente</th>
            <th width="13%" align="center">Fecha</th>
            <th width="10%" align="center">Moneda</th>
            <th width="12%" align="center">Total</th>
            <th width="13%" align="center">Acciones</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
    <?php
    $i=1;
    foreach($ArrNotaDebitos as $DatNotaDebito){
    ?>
     
	 <?php $DatNotaDebito->NdbTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaDebito->NdbTotal:($DatNotaDebito->NdbTotal/$DatNotaDebito->NdbTipoCambio));?>
     <?php $DatNotaDebito->NdbTotal = round($DatNotaDebito->NdbTotal,2)?>
     
        <tr>
            <td><?php echo $i;?></td>
            <td align="left">
            <a target="_self"  href="principal.php?Mod=NotaDebito&Form=Ver&Id=<?php echo $DatNotaDebito->NdbId;?>&Id=<?php echo $DatNotaDebito->NdtId;?>">
            <?php echo $DatNotaDebito->NdtNumero;?> - <?php echo $DatNotaDebito->NdbId;?>
            </a>
            </td>
            <td align="left"><?php echo $DatNotaDebito->CliNombre;?> <?php echo $DatNotaDebito->CliApellidoPaterno;?> <?php echo $DatNotaDebito->CliApellidoMaterno;?></td>
            <td align="center"><?php echo $DatNotaDebito->NdbFechaEmision;?></td>
            <td align="center"><?php echo $DatNotaDebito->MonSimbolo;?></td>
            <td align="right"><?php echo number_format($DatNotaDebito->NdbTotal,2);?></td>
            <td align="center">
              
              <?php
                if($PrivilegioVer){
                ?>
              <a target="_self"  href="principal.php?Mod=NotaDebito&Form=Ver&Id=<?php echo $DatNotaDebito->NdbId;?>&Ta=<?php echo $DatNotaDebito->NdtId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
              <?php
                }
                ?>
              
              <?php
             /*   if($PrivilegioVistaPreliminar){
                ?>
              <a href="javascript:FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id=<?php echo $DatNotaDebito->AmoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
              <?php
                }
                ?>
              
              <?php
                if($PrivilegioImprimir){
                ?>        
              
              <a href="javascript:FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id=<?php echo $DatNotaDebito->AmoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
              <?php
                }*/
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
        No se encontraron Notas de Debito para esta Factura
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
   