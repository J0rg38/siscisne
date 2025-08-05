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

$InsVentaConcretada = new ClsVentaConcretada();
$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento();
$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento();

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL)

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL) 

// MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaConcretadaId=NULL)


$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();



$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas("AmoId,CliNombre,CliNumeroDocumento,amo.CprId,amo.VdiId",NULL,NULL,"AmoFecha","ASC",NULL,NULL,NULL,NULL,0,0,0,$GET_VdiId);

$ArrVentaConcretadas = $ResVentaConcretada['Datos'];



?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de VENTAS CONCRETADAS de la ORDEN DE VENTA
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrVentaConcretadas)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="13%" align="center">Venta Concretada</th>
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
foreach($ArrVentaConcretadas as $DatVentaConcretada){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=VentaConcretada&Form=Ver&Id=<?php echo $DatVentaConcretada->VcoId;?>">
            <?php echo $DatVentaConcretada->VcoId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatVentaConcretada->VcoFecha;?></td>
        <td align="left"><?php echo $DatVentaConcretada->CliNombre;?>
        <?php echo $DatVentaConcretada->CliApellidoPaterno;?>
        <?php echo $DatVentaConcretada->CliApellidoMaterno;?>
        </td>
        <td align="center"><?php echo $DatVentaConcretada->VcoEstadoDescripcion;?>
		
	
        </td>
        <td align="center">

<?php
//$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatTallerPedido->AmoId);

//MtdObtenerFacturaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oFacturaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)

?>

<?php
$ResFacturaAlmacenMovimiento = $InsFacturaAlmacenMovimiento->MtdObtenerFacturaAlmacenMovimientos(NULL,NULL,'FamId','Desc',NULL,NULL,NULL,$DatVentaConcretada->VcoId,true,"3");
$ArrFacturaAlmacenMovimientos = $ResFacturaAlmacenMovimiento['Datos'];
?>

<?php
foreach($ArrFacturaAlmacenMovimientos as $DatFacturaAlmacenMovimiento){
?>
<?php echo $DatFacturaAlmacenMovimiento->FtaNumero ?> - <?php echo $DatFacturaAlmacenMovimiento->FacId ?><br />
<?php
}
?>


<?php
/*$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaConcretada->VcoId);
$ArrFacturas = $ResFactura['Datos'];
?>


<?php
foreach($ArrFacturas as $DatFactura){
?>
<?php echo $DatFactura->FtaNumero ?> - <?php echo $DatFactura->FacId ?><br />
<?php
}*/
?>




        </td>
        <td align="center">
        
<?php
//MtdObtenerBoletaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oBoleta=NULL,$oBoletaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)
$ResBoletaAlmacenMovimiento = $InsBoletaAlmacenMovimiento->MtdObtenerBoletaAlmacenMovimientos(NULL,NULL,'BamId','Desc',NULL,NULL,NULL,$DatVentaConcretada->VcoId,true,"3");
$ArrBoletaAlmacenMovimientos = $ResBoletaAlmacenMovimiento['Datos'];
?>


<?php
foreach($ArrBoletaAlmacenMovimientos as $DatBoletaAlmacenMovimiento){
?>
	<?php echo $DatBoletaAlmacenMovimiento->BtaNumero ?> - <?php echo $DatBoletaAlmacenMovimiento->BolId ?><br />
<?php	
}
?>
<?php
//
/*$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"BolFechaEmision","ASC",NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaConcretada->VcoId);
//$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"BolFechaEmision","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaConcretada->VcoId);
$ArrBoletas = $ResBoleta['Datos'];
?>

<?php
foreach($ArrBoletas as $DatBoleta){
?>
	<?php echo $DatBoleta->BtaNumero ?> - <?php echo $DatBoleta->BolId ?><br />
<?php	
}*/
?>

        </td>
        <td align="center">
    
        <?php
			if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=VentaConcretada&Form=Ver&Id=<?php echo $DatVentaConcretada->VcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
         	<?php
			}
			?>
                    
         <?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id=<?php echo $DatVentaConcretada->VcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id=<?php echo $DatVentaConcretada->VcoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron VENTAS CONCRETADAS para esta ORDEN DE VENTA
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   