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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Imprimir"))?true:false;?>



<?php
$GET_AmoId = $_GET['AmoId'];

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

$InsFactura = new ClsFactura();

$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$GET_AmoId);
$ArrFacturas = $ResFactura['Datos'];


?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de FACTURAS de la VENTA CONCRETADA</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrFacturas)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="1%" align="center">#</th>
        <th width="23%" align="center">Factura</th>
        <th width="8%" align="center">Fecha</th>
        <th width="44%" align="center">Cliente</th>
        <th width="14%" align="center">Estado</th>
        <th width="10%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrFacturas as $DatFactura){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=Factura&Form=Ver&Id=<?php echo $DatFactura->FacId;?>&Ta=<?php echo $DatFactura->FtaId;?>">
            <?php echo $DatFactura->FtaNumero;?> - <?php echo $DatFactura->FacId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatFactura->FacFechaEmision;?></td>
        <td align="left"><?php echo $DatFactura->CliNombre;?>
        <?php echo $DatFactura->CliApellidoPaterno;?>
        <?php echo $DatFactura->CliApellidoMaterno;?>
        </td>
        <td align="center"><?php echo $DatFactura->FacEstadoDescripcion;?>
		
	
        </td>
        <td align="center">
    
        <?php
			if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=Factura&Form=Ver&Id=<?php echo $DatFactura->FacId;?>&Ta=<?php echo $DatFactura->FtaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
         	<?php
			}
			?>


                <?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncFacturaVistaPreliminar('<?php echo $DatFactura->FacId;?>','<?php echo $DatFactura->FtaId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncFacturaImprmir('<?php echo $DatFactura->FacId;?>','<?php echo $DatFactura->FtaId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
            
               
         <?php
/*			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id=<?php echo $DatFactura->FacId;?>&Ta=<?php echo $DatFactura->FtaId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id=<?php echo $DatFactura->FacId;?>&Ta=<?php echo $DatFactura->FtaId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron FACTURAS para esta VENTA CONCRETADA
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      
      
      
      </td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
   </div>
   