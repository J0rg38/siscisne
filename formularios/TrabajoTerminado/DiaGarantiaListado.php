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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Garantia","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Garantia","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Garantia","Imprimir"))?true:false;?>


<?php

$GET_FinId = $_GET['FinId'];


require_once($InsPoo->MtdPaqActividad().'ClsGarantia.php');

$InsGarantia = new ClsGarantia();

// MtdObtenerGarantias($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL) 

$ResGarantia = $InsGarantia->MtdObtenerGarantias(NULL,NULL,NULL,"GarId","ASC",NULL,NULL,NULL,NULL,NULL,$GET_FinId);
$ArrGarantias = $ResGarantia['Datos'];



?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de GARANTIAS de la ORDEN DE TRABAJO</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrGarantias)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="1%" align="center">#</th>
        <th width="23%" align="center">Garantia</th>
        <th width="8%" align="center">Fecha</th>
        <th width="44%" align="center">Cliente</th>
        <th width="14%" align="center">Estado</th>
        <th width="10%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrGarantias as $DatGarantia){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=Garantia&Form=Ver&Id=<?php echo $DatGarantia->GarId;?>">
            <?php echo $DatGarantia->GarId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatGarantia->GarFechaEmision;?></td>
        <td align="left"><?php echo $DatGarantia->CliNombre;?>
        <?php echo $DatGarantia->CliApellidoPaterno;?>
        <?php echo $DatGarantia->CliApellidoMaterno;?>
        </td>
        <td align="center"><?php echo $DatGarantia->GarEstadoDescripcion;?>
		
	
        </td>
        <td align="center">
    
        <?php
			if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=Garantia&Form=Ver&Id=<?php echo $DatGarantia->GarId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
         	<?php
			}
			?>
                    
         <?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/Garantia/FrmGarantiaImprimir.php?Id=<?php echo $DatGarantia->GarId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/Garantia/FrmGarantiaImprimir.php?Id=<?php echo $DatGarantia->GarId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
         
         
         <?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/FichaAccion/FrmFichaAccionFotoImprimir.php?Id=<?php echo $DatGarantia->FccId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/preliminar_foto.png" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/FichaAccion/FrmFichaAccionFotoImprimir.php?Id=<?php echo $DatGarantia->FccId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/iconos/imprimir_foto.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron GARANTIAS para esta ORDEN DE TRABAJO
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   