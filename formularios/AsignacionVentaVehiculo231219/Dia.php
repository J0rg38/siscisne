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

$GET_VdiId = $_GET['VdiId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsVentaConcretada = new ClsVentaConcretada();
$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento();
$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento();
$InsVentaDirecta = new ClsVentaDirecta();

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL)

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL) 

// MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaConcretadaId=NULL)
$InsVentaDirecta->VdiId = $GET_VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta(false);		

if(!empty($InsVentaDirecta->FinId)){
	
	$InsFichaIngreso = new ClsFichaIngreso();
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId","esigual",$InsVentaDirecta->FinId,"FinId","ASC",NULL,(NULL),(NULL),NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,0,NULL,NULL,0,NULL,NULL,NULL,NULL,$POST_Sucursal,false);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];

}





?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de Ordenes de Trabajo de la Orden de Venta</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($InsVentaDirecta->FinId)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="13%" align="center">Orden de Trabajo</th>
        <th width="11%" align="center">Fecha</th>
        <th width="32%" align="center">Cliente</th>
        <th width="9%" align="center">Estado</th>
        <th width="12%" align="center">Factura</th>
        <th width="12%" align="center">Boleta</th>
        <th width="9%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrFichaIngresos as $DatFichaIngreso){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=VentaConcretada&Form=Ver&Id=<?php echo $DatFichaIngreso->FinId;?>">
            <?php echo $DatFichaIngreso->FinId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatFichaIngreso->FinFecha;?></td>
        <td align="left"><?php echo $DatFichaIngreso->CliNombre;?>
        <?php echo $DatFichaIngreso->CliApellidoPaterno;?>
        <?php echo $DatFichaIngreso->CliApellidoMaterno;?>
        </td>
        <td align="center"><?php echo $DatFichaIngreso->FinEstadoDescripcion;?>
		
	
        </td>
        <td align="center">
            
            <?php
            $ResFacturaAlmacenMovimiento = $InsFacturaAlmacenMovimiento->MtdObtenerFacturaAlmacenMovimientos(NULL,NULL,'FamId','Desc',NULL,NULL,NULL,$DatFichaIngreso->FinId,true,"3");
            $ArrFacturaAlmacenMovimientos = $ResFacturaAlmacenMovimiento['Datos'];
            ?>
            
            <?php
            foreach($ArrFacturaAlmacenMovimientos as $DatFacturaAlmacenMovimiento){
            ?>
            <?php echo $DatFacturaAlmacenMovimiento->FtaNumero ?> - <?php echo $DatFacturaAlmacenMovimiento->FacId ?><br />
            <?php
            }
            ?>
        </td>
        <td align="center">
        
			<?php
            //MtdObtenerBoletaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oBoleta=NULL,$oBoletaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)
            $ResBoletaAlmacenMovimiento = $InsBoletaAlmacenMovimiento->MtdObtenerBoletaAlmacenMovimientos(NULL,NULL,'BamId','Desc',NULL,NULL,NULL,$DatFichaIngreso->FinId,true,"3");
            $ArrBoletaAlmacenMovimientos = $ResBoletaAlmacenMovimiento['Datos'];
            ?>
            
            
            <?php
            foreach($ArrBoletaAlmacenMovimientos as $DatBoletaAlmacenMovimiento){
            ?>
                <?php echo $DatBoletaAlmacenMovimiento->BtaNumero ?> - <?php echo $DatBoletaAlmacenMovimiento->BolId ?><br />
            <?php	
            }
            ?>


        </td>
        <td align="center">
    
        <?php
			/*if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatFichaIngreso->FinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
         	<?php
			}*/
			?>
                    
         <?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id=<?php echo $DatFichaIngreso->FinId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id=<?php echo $DatFichaIngreso->FinId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron Ordenes de Trabajo para esta Orden de Venta
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   