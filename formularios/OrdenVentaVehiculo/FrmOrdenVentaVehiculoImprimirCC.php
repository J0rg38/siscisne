<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');

$GET_id = $_GET['Id'];
$GET_M = $_GET['M'];
$GET_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');

$InsPago = new ClsPago();
$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);
$ArrPagos = $ResPago['Datos'];


$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId', 'Desc',NULL,$InsOrdenVentaVehiculo->OvvId,NULL);
$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carta de Compromiso No. <?php echo $InsOrdenVentaVehiculo->OvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssOrdenVentaVehiculoImprimirCC.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimir.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimirCC.js" ></script>

<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>


<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenVentaVehiculo->OvvId)){?> 
FncOrdenVentaVehiculoCCImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	

});
</script>


</head>
<body>





<!--
<hr class="EstReporteLinea">

-->



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td colspan="4" align="left" valign="top">
      
      
      
<?php if($_GET['P']<>1){ ?>


<form id="FrmOrdenDia" name="FrmOrdenDia" method="get" enctype="multipart/form-data" action="#">

<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="P" id="P" value="" />


<table border="0" align="right" cellpadding="0" cellspacing="0">
<tr>
  <td align="right" valign="top">Fecha</td>
  <td align="right" valign="top">:</td>
  <td align="right" valign="top">
    
<input class="EstFormularioCajaFecha" name="Fecha" type="text"  id="Fecha" value="<?php if(empty($GET_Fecha)){ echo date("d/m/Y");}else{ echo $GET_Fecha; }?>" size="10" maxlength="10"/>

<img src="../../imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />

  </td>
  <td align="right" valign="top">&nbsp;</td>
  <td align="right" valign="top">
    
    
    <a id="BtnImprimir" href="javascript:void(0);"> Imprimir <img src="../../imagenes/acciones/imprimir.gif" alt="Imprimir" width="25" height="25" border="0" align="absmiddle" title="Imprimir" /></a></td>
</tr>
</table>

</form>
<?php }?>


</td>
    </tr>
    <tr>
      <td height="99" colspan="4" align="center" valign="top">
      
		<?php
        if($GET_M=="1"){
        ?>
			<!--<img src="../../imagenes/dj_cabecera.jpg" align="[Cabecera]" title="Cabecera"  />-->
            
            <img src="../../imagenes/membretes/cabecera_simple.png" align="[Cabecera]" title="Cabecera"  />
            
        <?php 
        }
        ?>
      
    
      </td>
      </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="right" valign="top">
      
          <span class="EstOrdenVentaVehiculoImprimirContenido">
          <?php
	//  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  list($Dia,$Mes,$Ano) = explode("/",$GET_Fecha);;
	  ?>
        <?php echo ucwords(strtolower($InsOrdenVentaVehiculo->SucDepartamento));?>,  <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
          <?php //echo $InsOrdenVentaVehiculo->OvvFecha;?>
          </span>
          
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">CARTA DE COMPROMISO</span><br />
        <span class="EstPlantillaTituloCodigo"> <!--<?php echo $InsOrdenVentaVehiculo->OvvId;?>--></span>
        
        </td>
      <td width="10%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="9%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="32%" align="right" valign="top" >&nbsp;</td>
      <td width="49%" align="right" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        <p align="justify">
          
          
          <span class="EstOrdenVentaVehiculoImprimirContenido"> Yo</span>
          
          
            
            <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
            <?php
	if($DatOrdenVentaVehiculoPropietario->OvpFirmaDJ=="1"){
	?>			
            
            <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> </span>
            
            
             <span class="EstOrdenVentaVehiculoImprimirContenido"> Identificado(a) con</span>
           <span class="EstOrdenVentaVehiculoImprimirEtiqueta">  <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> 
            </span>
            <?php	 
	}
	?>
            
            
            <?php
	}
	?>    
            
            
          <span class="EstOrdenVentaVehiculoImprimirContenido">       
            me comprometo ante </span><span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $EmpresaNombre;?>  </span><span class="EstOrdenVentaVehiculoImprimirContenido"> ha realizar el trámite de Declaración e Inscripcion del Impuesto Vehicular sobre  la unidad cuyos datos detallo a continuación:</span></p>
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >   <span class="EstOrdenVentaVehiculoImprimirSubTitulo">
        DETALLE DE UNIDAD
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td width="9%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="800" colspan="2" align="left" valign="top" >
        
        
     
        
   
        
        <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="356" align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                MARCA</span></td>
            <td width="10" align="center" valign="middle">:</td>
            <td width="403" align="left" valign="middle">
              
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo strtoupper($InsOrdenVentaVehiculo->VmaNombre);?>
                </span>
              
              </td>
            </tr>
  
          
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">MODELO</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmoNombre;?></span></td>
            </tr>
  
    
          
          <tr>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                CLASE</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $InsOrdenVentaVehiculo->EinCaracteristica20;?>
                </span>
              </td>
            </tr>
       
          
          
          <tr>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                CHASIS</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo strtoupper($InsOrdenVentaVehiculo->EinVIN);?>
                </span>
              </td>
            </tr>
          
          
          <tr>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                MOTOR</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $InsOrdenVentaVehiculo->EinNumeroMotor;?>
                </span>
              </td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">CILINDRADA</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">  <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $InsOrdenVentaVehiculo->EinCaracteristica3;?>
                </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">COLOR</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $InsOrdenVentaVehiculo->EinColor;?> </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">AÑO MODELO</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $InsOrdenVentaVehiculo->EinAnoModelo;?> </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">PLACA</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido">
            
             
                <?php
			if(empty($InsOrdenVentaVehiculo->OvvPlaca)){
			?>
            PENDIENTE
            <?php	
			}else{
				
			?>
             <?php echo $InsOrdenVentaVehiculo->OvvPlaca;?>
            <?php	
			}
			?>
              
              </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          </table>
        

      
        <br />
        <table align="center">
          <tr>
            <td height="140" align="center" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td width="50%" height="140" align="center" valign="top">
              
              
              
              
              
              <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
              <?php
	if($DatOrdenVentaVehiculoPropietario->OvpFirmaDJ=="1"){
	?>			
              _______________________________<br/>
              <span class="EstOrdenVentaVehiculoImprimirFirma"> <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
                </span>  
              <?php	 
	}
	?>
              
              
              <?php
	}
	?>  
              
              
            </td>
            
            
            </tr>
          </table>
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">
        
        
        <?php
        if($GET_M=="1"){
        ?>
        <img src="../../imagenes/dj_pie.jpg" alt="" align="[Pie]" title="Pie"  />
        <?php 
        }
        ?>
        
        
        </td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>




<?php if($_GET['P']<>1){ ?>

<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "Fecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha",//,// el id del bot&oacute;n que  
	onUpdate       :    FncOrdenVentaVehiculoCargar
	}); 
</script>
<?php
}
?> 
 
</body>
</html>
