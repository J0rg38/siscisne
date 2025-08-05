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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Imprimir"))?true:false;?>



<?php

$GET_EinId = $_GET['EinId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoInstalar.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsVentaConcretada = new ClsVentaConcretada();
$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento();
$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento();
$InsVentaDirecta = new ClsVentaDirecta();
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoInstalar = new ClsVehiculoInstalar();

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL)

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL) 

// MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaConcretadaId=NULL)
$InsVehiculoIngreso->EinId = $GET_EinId;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);		
																																								//MtdObtenerVehiculoInstalars($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VisId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oSucursal=NULL) 
$ResVehiculoInstalar = $InsVehiculoInstalar->MtdObtenerVehiculoInstalars(NULL,NULL,NULL,"VisFecha","DESC","500",NULL,NULL,FncCambiaFechaAMysql(NULL),(NULL),NULL,$POST_Sucursal);
$ArrVehiculoInstalars = $ResVehiculoInstalar['Datos'];


?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de Instalaciones de Accesorios / VIN <?php echo $InsVehiculoIngreso->EinVIN;?></span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>


      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="5%" align="center">#</th>
        <th width="12%" align="center">Id</th>
        <th width="16%" align="center">Fecha</th>
        <th width="34%" align="center">Aprobado por</th>
        <th width="11%" align="center">Referencia</th>
        <th width="11%" align="center">Estado</th>
        <th width="11%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrVehiculoInstalars as $DatVehiculoInstalar){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
       <!--   <a target="_self"  href="principal.php?Mod=VehiculoInstakar&Form=Ver&Id=<?php echo $DatVehiculoInstalar->VisId;?>">-->
            <?php echo $DatVehiculoInstalar->VisId;?>
            <!--</a>-->
        </td>
        <td align="center"><?php echo $DatVehiculoInstalar->VisFecha;?></td>
        <td align="left"><?php echo $DatVehiculoInstalar->PerNombre;?>
        <?php echo $DatVehiculoInstalar->PerApellidoPaterno;?>
        <?php echo $DatVehiculoInstalar->PerApellidoMaterno;?>
        </td>
        <td align="center">
        
        
          <?php echo $DatVehiculoInstalar->VisReferencia;?>
        
        </td>
        <td align="center"><?php echo $DatVehiculoInstalar->VisEstadoDescripcion;?>
          
          
        </td>
        <td align="center">
          
          <?php
			/*if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatVehiculoInstalar->FinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
         	<?php
			}*/
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/VehiculoInstalar/FrmVehiculoInstalarImprimir.php?Id=<?php echo $DatVehiculoInstalar->VisId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/VehiculoInstalar/FrmVehiculoInstalarImprimir.php?Id=<?php echo $DatVehiculoInstalar->VisId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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

      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   