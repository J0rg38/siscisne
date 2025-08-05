<?php
//session_cache_limiter("public");
session_start();

//session_destroy();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}
////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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
//CONTROL DE LISTA DE ACCESO
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

//CONFIGURACION DE EMPRESA
require_once($InsPoo->MtdPaqConfiguracion().'ClsConfiguracionEmpresa.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsConfiguracionEmpresa->CemId = "CEM-10000";
$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width"/>
 
<title><?php echo $SistemaNombre;?> <?php echo $SistemaVersion;?> - <?php echo $EmpresaNombre;?> - Usuario: <?php echo $_SESSION['SesionNombre'];?> [<?php echo $_SESSION['SesionUsuario'];?>] </title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<!--
Nombre: JQUERY
Descripcion: 
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.9.1.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.11.2.min.js"></script>-->

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>
<script type="text/javascript" src="js/JsLeerCodigoBarra.js"></script>

<!--
Nombre: NUPLOAD
Descripcion: 
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/uploadfile.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.uploadfile.min.js"></script>



</head>
<body >

<script type="text/javascript">

$(function(){

	$("#CmpCantidad").select();
	
	$("#BtnGuardar").click(function(){
		$("#Form1").submit();
	});
	
	$("#BtnCerrar").click(function(){
		 window.location = "LeerCodigoBarra.php";
	});
	
	


});
	
var ProductoFotoSoloEditar = 1;
var ProductoFotoSoloEliminar = 1;

</script>



<?php

$GET_CB = $_GET['CB'];
$GET_Usuario = $_GET['U'];
$_SESSION['SesProFotoSolo'] = "";

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProductoListaPrecioCotizado.php');
?>

<?php
//if(!empty($GET_CB)){
?>

Codigo Leido Original: <?php echo $GET_CB;?><br>

<?php
//$GET_CB = $GET_CB + 1 - 1;
?>
Codigo final <?php echo $GET_CB;?><br>

<?php
$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();

$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal,ProCodigoAlternativo","contiene",$GET_CB,"ProNombre","ASC","1",NULL,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];

?>
    
    <table width="100%" class="EstFormularioTabla">
    <tr>
      <td colspan="2" align="center">
      <span class="EstFormularioTitulo">
      LECTURA DE CODIGO DE BARRAS</span>
      </td>
      </tr>
    <tr>
      <td width="148">Codigo Buscado:</td>
      <td width="868"><?php echo $GET_CB;?></td>
    </tr>
    <tr>
      <td colspan="2">Resultados:</td>
    </tr>
    <tr>
      <td colspan="2">
      
      
      
    <?php
    if(!empty($ArrProductos)){
    ?>
Se encontraron    (<?php echo count($ArrProductos);?>) registros.
        <table width="100%" class="EstTablaListado">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="3%">#</th>
          <th width="18%">Cod. Orig.</th>
          <th width="16%">Cod. Reemp.</th>
          <th width="43%">Unidad</th>
          <th width="20%">Stock</th>
          </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
    <?php	
	$i = 1;
        foreach($ArrProductos as $DatProducto){
    ?>	
        <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $DatProducto->ProCodigoOriginal?></td>
          <td><?php echo $DatProducto->ProCodigoAlternativo?></td>
          <td><?php echo $DatProducto->UmeNombre?></td>
          <td><?php //echo $DatProducto->ProStock?>
            

<?php
$InsAlmacenStock = new ClsAlmacenStock();
//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false) {
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,$POST_ord,$POST_sen,1,'1',NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,$POST_Referencia,$DatProducto->ProId,NULL,$POST_Almacen,$TieneMovimiento);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

if(!empty($ArrAlmacenStocks)){
	foreach($ArrAlmacenStocks as $DatAlmacenStock){
?>
		
		<?php echo number_format($DatAlmacenStock->AstStockReal,2);?>
<?php	
	}
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
        No se encontraron datos
    <?php	
    }
    
    
    ?>
    
    
            <hr>
            
  <form id="Form1" action="inventario.php" method="POST"  >
	Usuario:  <input type="text" name="CmpUsuario" id="CmpUsuario" value="<?php echo $GET_Usuario;?>" /><br />
        
Codigo: <input type="text" name="CmpCodigo" id="CmpCodigo" value="<?php echo $GET_CB;?>" /><br />
Nombre: <input type="text" name="CmpNombre" id="CmpNombre" value="<?php echo $DatProducto->ProNombre?>" /><br />
Ubicacion: <input type="text" name="CmpUbicacion" id="CmpUbicacion" value="<?php echo $DatProducto->ProUbicacion?>" /><br />
Cantidad:  <input type="text" name="CmpCantidad" id="CmpCantidad" value="1" /><br />
Observaciones:  
<textarea name="CmpObservacion" cols="30" rows="2" id="CmpObservacion"></textarea>
<br />



               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncProductoFotoSoloListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProductoFotoSoloEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapProductoFotoSolosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadProductoFotoSolo">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
											
											var acodigo = $("#CmpCodigo").val();
											
											$("#fileUploadProductoFotoSolo").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"acc/AccProductoSubirFotoSolo.php",
											formData: {"Identificador":"<?php echo $Identificador;?>","codigo":acodigo},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												alert("La foto subio correctamente");
												FncProductoFotoSoloListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapProductoFotoSolos" id="CapProductoFotoSolos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapProductoFotoSolosResultado"> </div></td>
             </tr>
             </table>
            
             
                 
  <input type="button"  name="BtnGuardar" id="BtnGuardar" value="Guardar" />
  <input type="button"  name="BtnCerrar" id="BtnCerrar" value="Cerrar" />
  
  </form>
            <br><br>
            <br>
            
            
            <a href="historial.php?U=<?php echo $GET_Usuario;?>">Ver Mi Inventario</a>
            
    </td>
    </tr>
    </table>
    
<hr>

<h3>Historial</h3>
<?php
include("historia.php");
?>
<?php	
//}else{
?>

<!--
No se encontro codigo para leer
   --> 
<?php	
//}
?>



<?php
$InsMensaje->MenResultado = $_SESSION['SesAviso'];
$InsMensaje->MtdImprimirResultado();
unset($_SESSION['SesAviso']);
?>

</body>
</html>


