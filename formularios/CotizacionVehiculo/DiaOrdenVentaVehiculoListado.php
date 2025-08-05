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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Imprimir"))?true:false;?>

<?php $PrivilegioGenerarVentaConcretada = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Registrar"))?true:false;?>
<?php $PrivilegioGenerarPedidoCompra = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Registrar"))?true:false;?>

<?php

$GET_CveId = $_GET['CveId'];



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();


//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL)

// MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL)
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","ASC",NULL,NULL,NULL,"1,3,4,5",NULL,NULL,NULL,0,NULL,$GET_CveId);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

			 
?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de ORDENES DE VENTA de la COTIZACION
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrOrdenVentaVehiculos)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="1%" align="center">#</th>
        <th width="23%" align="center">Ord. Venta Veh.</th>
        <th width="8%" align="center">Fecha</th>
        <th width="44%" align="center">Cliente</th>
        <th width="14%" align="center">Estado</th>
        <th width="10%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=OrdenVentaVehiculo&Form=Ver&Id=<?php echo $DatOrdenVentaVehiculo->OvvId;?>">
            <?php echo $DatOrdenVentaVehiculo->OvvId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatOrdenVentaVehiculo->OvvFecha;?></td>
        <td align="left">
		
		

    - <?php echo ($DatOrdenVentaVehiculo->CliNombre);?>
    <?php echo ($DatOrdenVentaVehiculo->CliApellidoPaterno);?>
    <?php echo ($DatOrdenVentaVehiculo->CliApellidoMaterno);?>

                
                
                  
                 <?php
				 $InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();
				 
				 $ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$DatOrdenVentaVehiculo->OvvId);
				 $ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

//deb( $ArrOrdenVentaVehiculoPropietarios);
				 ?>
                 
                 <?php
				 if(!empty($ArrOrdenVentaVehiculoPropietarios)){
					 foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
				?>
                	<?php
					if($DatOrdenVentaVehiculoPropietario->CliId <> $DatOrdenVentaVehiculo->CliId){
					?><br />
                    
		- <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?>
                    	<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?>
                    	<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?>

                    
                        
                    <?php
					}
					?>
                	
                    
                <?php		 
					 }
				 }
				 ?>
               
		
		<?php /*echo $DatOrdenVentaVehiculo->CliNombre;?>
        <?php echo $DatOrdenVentaVehiculo->CliApellidoPaterno;?>
        <?php echo $DatOrdenVentaVehiculo->CliApellidoMaterno;*/?>
        
        
        
        </td>
        <td align="center"><?php echo $DatOrdenVentaVehiculo->OvvEstadoDescripcion;?>
          
          
        </td>
        <td align="center">
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=OrdenVentaVehiculo&Form=Ver&Id=<?php echo $DatOrdenVentaVehiculo->OvvId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id=<?php echo $DatOrdenVentaVehiculo->OvvId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id=<?php echo $DatOrdenVentaVehiculo->OvvId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron ORDENES DE VENTA para esta COTIZACION
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   