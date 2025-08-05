<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

////ACL
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
////INSTANCIAS
$InsMensaje = new ClsMensaje();
$InsSesion = new ClsSesion();
$InsACL = new ClsACL();




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Boleta No.  <?php echo $InsClientePago->DtaNumero;?> - <?php echo $InsClientePago->DocId;?></title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">

<!--
Librerias de Validacion
-->
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationSelect.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextarea.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>
<!--
Libreria para Caja de Autocompletar
-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox.css" />
	
    -->

<!--
Nombre: JQUERY-TABS2
Descripcion: Libreria para tabs
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-tab/jquery-tab.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-tab/jquery-tab.js"></script>

<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>tipsy-0.1.7/src/stylesheets/tipsy.css" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>tipsy-0.1.7/src/javascripts/jquery.tipsy.js"></script>

 <!--
Libreria para Cadena Aleatoria
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.random.php');?>


<script type="text/javascript">
$(function(){
	//Hack para corregir autocompletar
	$("<div id='CapAutoCompletar' />").appendTo(document.body);
});

<?php
$random = new Random();
$Identificador = $random->random_text(10, false, false, true);
?>

//Pasando variables genrales PHP a Javascript	
var MonedaSimbolo = "<?php echo $EmpresaMoneda;?>";
var EmpresaMonedaId = "<?php echo $EmpresaMonedaId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";

//var ArcPrincipal = "principal.php";
var Ruta = "<?php echo $InsProyecto->Ruta; ?>";	
</script>
</head>

<body >

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Ver")){
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Editar")){
	$PrivilegioEditar = true;
}else{
	$PrivilegioEditar = false;
}
?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("FormaPago");?>JsFormaPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("ClientePago");?>JsClientePagoFunciones.js" ></script>

<?php
$GET_id = $_GET['Id'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj("ClientePago").'MsjClientePago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTarjetaEntidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTarjetaMarca.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsClientePago = new ClsClientePago();
$InsFormaPago = new ClsFormaPago();
$InsMoneda = new ClsMoneda();

	
include($InsProyecto->MtdFormulariosAcc("ClientePago").'AccClientePagoEditar.php');

$RepFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaNombre","ASC",1,NULL);
$ArrFormaPagos = $RepFormaPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();

$(document).ready(function (){	
	FncClientePagoEstablecerMoneda();
});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncEstablecerClientePagoFormaPago";
var FormaPagoEditar = 2;

</script>


	
    
<div class="EstCapMenu">
  
            <div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove();" ><img src="../../imagenes/iconos/salir.png" alt="[Salir]" title="Salir"  />Salir</a></div>
            
            
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Listado")){
?>  
<div class="EstSubMenuBoton"><a href="FrmBoletaPagoListado.php?Id=<?php echo $InsClientePago->DocId;?>&Ta=<?php echo $InsClientePago->DtaId;?>"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>
<?php
}
?>                     
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="FrmBoletaPagoEditar.php?Id=<?php echo $InsClientePago->CpaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   

</div>

<div class="EstCapContenido">
                                                 

        
        
<ul class="tabs">
	<li><a href="#tab1">Pago de Cliente</a></li>
	<li><a href="#tab2">Comprobante de Pago</a></li>
</ul>

<div class="tab_container">
	<div id="tab1" class="tab_content">
	<!--Content-->  		
	
       
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="4"><span class="EstFormularioTitulo">VER PAGO DE CLIENTE - BOLETA</span></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="193"><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td colspan="2"><input name="CmpId" type="hidden" id="CmpId" value="<?php echo $InsClientePago->CpaId;?>" />
              <input name="CmpDocumentoId" type="hidden" id="CmpDocumentoId" value="<?php echo $InsClientePago->DocId;?>" />
              <input name="CmpDocumentoTalonario" type="hidden" id="CmpDocumentoTalonario" value="<?php echo $InsClientePago->DtaId;?>" />
              <input name="CmpDocumentoTalonarioNumero" type="hidden" id="CmpDocumentoTalonarioNumero" value="<?php echo $InsClientePago->DtaNumero;?>" />
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="3" /></td>
            <td width="1">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Documento:</td>
            <td colspan="2">
				<?php echo $InsClientePago->DtaNumero;?> - <?php echo $InsClientePago->DocId;?>            </td>
            <td>&nbsp;</td>
            </tr>
          
          
          
          
          

          
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Descripcion:</td>
            <td colspan="2"><textarea name="CmpDescripcion" cols="40" rows="3" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion" ><?php echo  $InsClientePago->CpaDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Forma de Pago:</td>
            <td colspan="2"><select disabled="disabled" name="CmpFormaPago" id="CmpFormaPago" class="EstFormularioCombo" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrFormaPagos as $DatFormaPago){
					?>
              <option <?php if($InsClientePago->FpaId==$DatFormaPago->FpaId){ echo 'selected="selected"';}?> value="<?php echo $DatFormaPago->FpaId;?>"><?php echo $DatFormaPago->FpaNombre;?></option>
              <?php  
					}
					?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Fecha:<br /><span class="EstFormularioSubEtiqueta">dd/mm/yyyy</span></td>
            <td colspan="2">
            
            <input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsClientePago->CpaFecha)){ echo date("d/m/Y");}else{ echo $InsClientePago->CpaFecha; }?>" size="15" maxlength="10" readonly="readonly" />
            
            
             dd/mm/yyyy</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda:</td>
            <td colspan="2"><input type="hidden" name="CmpMonedaId" id="CmpMonedaId" value="<?php echo $EmpresaMonedaId;?>" />
              <select disabled="disabled"  onchange="FncMonedaBuscar('Id');" class="EstFormularioCombo" name="CmpMonedaId2" id="CmpMonedaId2">
                <option value="">Escoja una opcion</option>
                <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsClientePago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                <?php
			  }
			  ?>
              </select>
              
              
              </td>
            <td><div id="CapMonedaBuscar"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tipo de Cambio (0.000):</td>
            <td colspan="2"><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" value="<?php if (empty($InsClientePago->CpaTipoCambio)){ echo "";}else{ echo $InsClientePago->CpaTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaMonto"></span></span>):</td>
            <td colspan="2"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php if(empty($InsClientePago->CpaMonto)){ echo "0.00";}else{ echo number_format($InsClientePago->CpaMonto,2); }?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Considerar en:</td>
            <td colspan="2"><?php
			switch($InsClientePago->CpaDestino){
				case 1:
					$OpcDestino1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcDestino2 = 'selected="selected"';				
				break;
			}
			?>
              <select disabled="disabled" name="CmpDestino" id="CmpDestino" class="EstFormularioCombo">
                <option value="1" <?php echo $OpcDestino1;?> >Caja Diaria</option>
                <option value="2" <?php echo $OpcDestino2;?> >Caja General</option>
                </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td colspan="2"><?php
					switch($InsClientePago->CpaEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
              <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"><input type="hidden" name="CmpChequeNumeroAux" id="CmpChequeNumeroAux"  value="<?php echo $InsClientePago->CpaChequeNumero;?>"/>
			<input type="hidden" name="CmpTarjetaMarcaAux" id="CmpTarjetaMarcaAux" value="<?php echo $InsClientePago->TmaNombre;?>" />
			<input type="hidden" name="CmpTarjetaMarcaIdAux" id="CmpTarjetaMarcaIdAux" value="<?php echo $InsClientePago->TmaId;?>" />

			<input type="hidden" name="CmpTarjetaEntidadAux" id="CmpTarjetaEntidadAux" value="<?php echo $InsClientePago->TenNombre;?>" />
			<input type="hidden" name="CmpTarjetaEntidadIdAux" id="CmpTarjetaEntidadIdAux" value="<?php echo $InsClientePago->TenId;?>" />
              
			<input type="hidden" name="CmpBancoAux" id="CmpBancoAux"  value="<?php echo $InsClientePago->BanNombre;?>"/>
			<input type="hidden" name="CmpBancoIdAux" id="CmpBancoIdAux"  value="<?php echo $InsClientePago->BanId;?>"/>
              
			<input type="hidden" name="CmpBancoDepositarAux" id="CmpBancoDepositarAux"  value="<?php echo $InsClientePago->BanNombreDepositar;?>"/>
			<input type="hidden" name="CmpBancoDepositarIdAux" id="CmpBancoDepositarIdAux"  value="<?php echo $InsClientePago->BanIdDepositar;?>"/>
              
			<input type="hidden" name="CmpTransaccionNumeroAux" id="CmpTransaccionNumeroAux" value="<?php echo $InsClientePago->CpaTransaccionNumero;?>" />

			<input type="hidden" name="CmpTarjetaNumeroAux" id="CmpTarjetaNumeroAux" value="<?php echo $InsClientePago->CpaTarjetaNumero;?>" />
			<input type="hidden" name="CmpTarjetaTipoAux" id="CmpTarjetaTipoAux" value="<?php echo $InsClientePago->CpaTarjetaTipo;?>" />
              
			<input type="hidden" name="CmpNumeroReferenciaAux" id="CmpNumeroReferenciaAux" value="<?php echo $InsClientePago->CpaNumeroReferencia;?>" />
			<input type="hidden" name="CmpRetencionPorcentajeAux" id="CmpRetencionPorcentajeAux" value="<?php echo $InsClientePago->CpaRetencionPorcentaje;?>" />

			<input type="hidden" name="CmpTransaccionSituacionAux" id="CmpTransaccionSituacionAux" value="<?php echo $InsClientePago->CpaTransaccionSituacion;?>" />


</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><div id="CapFormaPago"></div></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
        </table>
		</div></td>
       </tr>
    </table>
		 
</div>
    
	<div id="tab2" class="tab_content">
	<!--Content-->
    
  	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td>
               
               <?php              
              
if(!empty($_SESSION['SesCpaFoto'.$Identificador])){

	$extension = strtolower(pathinfo($_SESSION['SesCpaFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesCpaFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

	<img  src="../../subidos/clientepago_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />

<?php	
}else{
?>
No hay FOTO
<?php	
}
?>


               </td>
               <td>&nbsp;</td>
             </tr>           
             </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	  
    
    	</div>    
</div>


	
        
  </div>      
    
  <?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

</body>
</html>
