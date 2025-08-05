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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCreditoCompra","Ver"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCreditoCompra","Imprimir"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCreditoCompra","VistaPreliminar"))?true:false;?>

<?php

$GET_AmoId = $_GET['AmoId'];
//deb($GET_AmoId);
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompra.php');

$InsNotaCreditoCompra = new ClsNotaCreditoCompra();

// MtdObtenerNotaCreditoCompras($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oProveedor=NULL)
$ResNotaCreditoCompra = $InsNotaCreditoCompra->MtdObtenerNotaCreditoCompras(NULL,NULL,NULL,"NNccFechaEmision","ASC",NULL,"3",NULL,NULL,NULL,$GET_AmoId,NULL);
$ArrNotaCreditoCompras = $ResNotaCreditoCompra['Datos'];


?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de NOTAS DE CREDITO de COMPRA
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrNotaCreditoCompras)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="3%" align="center">#</th>
        <th width="15%" align="center">N. Cred.</th>
        <th width="9%" align="center">Fecha</th>
        <th width="48%" align="center">Proveedor</th>
        <th width="12%" align="center">Estado</th>
        <th width="13%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrNotaCreditoCompras as $DatNotaCreditoCompra){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=NotaCreditoCompra&Form=Ver&Id=<?php echo $DatNotaCreditoCompra->NccId;?>">
            <?php echo $DatNotaCreditoCompra->NccId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatNotaCreditoCompra->NccFechaEmision;?></td>
        <td align="left"><?php echo $DatNotaCreditoCompra->PrvNombre;?>
          <?php echo $DatNotaCreditoCompra->PrvApellidoPaterno;?>
          <?php echo $DatNotaCreditoCompra->PrvApellidoMaterno;?>
        </td>
        <td align="center"><?php echo $DatNotaCreditoCompra->NccEstadoDescripcion;?>
          
          
        </td>
        <td align="center">
    
			<?php
            if($PrivilegioVer){
            ?>
				<a target="_self"  href="principal.php?Mod=NotaCreditoCompra&Form=Ver&Id=<?php echo $DatNotaCreditoCompra->NccId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
            <?php
            }
            ?>
              
            <?php
            if($PrivilegioVistaPreliminar){
            ?>
				<a href="javascript:FncPopUp('formularios/NotaCreditoCompra/FrmNotaCreditoCompraImprimir.php?Id=<?php echo $DatNotaCreditoCompra->NccId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            <?php
            }
            ?>
            
            <?php
            if($PrivilegioImprimir){
            ?>        
				<a href="javascript:FncPopUp('formularios/NotaCreditoCompra/FrmNotaCreditoCompraImprimir.php?Id=<?php echo $DatNotaCreditoCompra->NccId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
	No se encontraron NOTAS DE CREDITO para esta COMPRA
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   