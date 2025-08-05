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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Imprimir"))?true:false;?>

<?php $PrivilegioGenerarVentaConcretada = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Registrar"))?true:false;?>
<?php $PrivilegioGenerarPedidoCompra = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Registrar"))?true:false;?>

<?php

$GET_CprId = $_GET['CprId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

$InsVentaDirecta = new ClsVentaDirecta();

//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL)

//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL) 
$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,"VdiFecha","ASC",NULL,NULL,NULL,NULL,0,NULL,$GET_CprId);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];



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
if(!empty($ArrVentaDirectas)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="1%" align="center">#</th>
        <th width="23%" align="center">Ord. Venta</th>
        <th width="8%" align="center">Fecha</th>
        <th width="44%" align="center">Cliente</th>
        <th width="14%" align="center">Estado</th>
        <th width="10%" align="center">&nbsp;</th>
        <th width="10%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrVentaDirectas as $DatVentaDirecta){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          <a target="_self"  href="principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo $DatVentaDirecta->VdiId;?>">
            <?php echo $DatVentaDirecta->VdiId;?>
            </a>
        </td>
        <td align="center"><?php echo $DatVentaDirecta->VdiFecha;?></td>
        <td align="left"><?php echo $DatVentaDirecta->CliNombre;?>
        <?php echo $DatVentaDirecta->CliApellidoPaterno;?>
        <?php echo $DatVentaDirecta->CliApellidoMaterno;?>
        </td>
        <td align="center"><?php echo $DatVentaDirecta->VdiEstadoDescripcion;?>
		
	
        </td>
        <td align="center">&nbsp;</td>
        <td align="center">
    
        <?php
			if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo $DatVentaDirecta->VdiId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
         	<?php
			}
			?>
                    
         <?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id=<?php echo $DatVentaDirecta->VdiId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id=<?php echo $DatVentaDirecta->VdiId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
         
         <?php
			if($PrivilegioVer){
			?>
         <a target="_self"  href="principal.php?Mod=VentaDirecta&Form=VerEstado&Id=<?php echo $DatVentaDirecta->VdiId;?>"><img src="imagenes/acciones/ver_estado.png" alt="[O.V. Estado]" title="O.V. Estado" width="19" height="19" border="0" /></a>                
         	<?php
			}
			?>        
    
<?php
//if($PrivilegioGenerarPedidoCompra and ($dat->VdiPedir == "Si" and $dat->VdiPedidoCompra == "No")){
//if($PrivilegioGenerarPedidoCompra and $dat->VdiPedir == "Si"){
	

if($PrivilegioGenerarPedidoCompra and $DatVentaDirecta->VdiGenerarPedidoCompra == "Si" and $DatVentaDirecta->VdiEstado <> 1){
?>		                
	<a href="principal.php?Mod=PedidoCompra&Form=Registrar&Origen=VentaDirecta&VdiId=<?php echo $DatVentaDirecta->VdiId;?>"><img src="imagenes/generar_pedido.png" width="19" height="19" border="0" title="Generar Pedido de Compra" alt="[Generar Pedido de Compra]"   /></a>                
<?php
}
?>

<?php
//if($PrivilegioGenerarVentaConcretada and ($dat->VdiPedidoCompra == "Si" or $dat->VdiPedir == "No") and $dat->VdiVentaConcretada == "No"){
	
//if($PrivilegioGenerarVentaConcretada and $dat->VdiConcretar == "Si"){
//deb($dat->VdiGenerarVentaConcretada);

if($PrivilegioGenerarVentaConcretada and $DatVentaDirecta->VdiGenerarVentaConcretada == "Si" and $DatVentaDirecta->VdiEstado <> 1){
?>		                
	<a href="principal.php?Mod=VentaConcretada&Form=Registrar&Origen=VentaDirecta&VdiId=<?php echo $DatVentaDirecta->VdiId;?>"><img src="imagenes/generar.jpg" width="19" height="19" border="0" title="Generar Venta Concretada" alt="[Generar Venta Concretada]"   /></a>                
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
   