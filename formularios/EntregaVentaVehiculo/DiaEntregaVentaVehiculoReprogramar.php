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

<html>
<head>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="js/JsEntregaVentaVehiculoReprogramar.js"></script>
<link rel="stylesheet" type="text/css" href="css/CssEntregaVentaVeehiculoReprogramar.css">



<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>

<!--
Nombre: JS Timer
Descripcion: 
-->
<!-- Prerequisites: jQuery and jQuery UI Stylesheet -->
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jQuery.ptTimeSelect-0.8/jquery-ui.css" />

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jQuery.ptTimeSelect-0.8/src/jquery.ptTimeSelect.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jQuery.ptTimeSelect-0.8/src/jquery.ptTimeSelect.js"></script>

-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jonthornton-jquery-timepicker-1.11.11-5-gde77772/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jonthornton-jquery-timepicker-1.11.11-5-gde77772/jquery.timepicker.css" />




</head>
<body>
<script type="text/javascript">

$().ready(function() {
	//alert("aaa");
});
</script>
<?php

$GET_Id = $_GET['EvvId'];


require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsPersonal = new ClsPersonal();

$InsEntregaVentaVehiculo->EvvId = $GET_Id;
$InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculo(false);

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $InsEntregaVentaVehiculo->OvvId;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();


	$fecha = date('Y-m-j');
	$nuevafecha = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'd/m/Y' , $nuevafecha );
	
	$InsEntregaVentaVehiculo->EvvFechaProgramada = $nuevafecha;
	$InsEntregaVentaVehiculo->EvvNotificar = 1;
	
	
	
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonaleVendedores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

?>

<div class="EstFormularioArea"> 
  
      <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td colspan="4"><span class="EstFormularioSubTitulo">Reprogramar Entrega de Vehiculo
                    <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
                <td>&nbsp;</td>
                </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Codigo Interno:</td>
                <td align="left" valign="top"><input readonly name="CmpEntregaVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpEntregaVentaVehiculoId" value="<?php echo $InsEntregaVentaVehiculo->EvvId;?>" size="20" maxlength="20" /></td>
                <td align="left" valign="top">Fecha de Registro:<br />
                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFecha" value="<?php if(empty($InsEntregaVentaVehiculo->EvvFecha)){ echo date("d/m/Y");}else{ echo $InsEntregaVentaVehiculo->EvvFecha; }?>" size="15" maxlength="10" readonly /></td>
                <td>&nbsp;</td>
               </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Fecha Programada:<br />
                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                <td align="left" valign="top"><input name="CmpEntregaVentaVehiculoFechaProgramada" type="text" class="EstFormularioCajaFecha" id="CmpEntregaVentaVehiculoFechaProgramada" value="<?php if(empty($InsEntregaVentaVehiculo->EvvFechaProgramada)){ echo date("d/m/Y");}else{ echo $InsEntregaVentaVehiculo->EvvFechaProgramada; }?>" size="15" maxlength="10" />
                <img src="../../imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnEntregaVentaVehiculoFechaProgramada" name="BtnEntregaVentaVehiculoFechaProgramada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                <td align="left" valign="top">Hora Programada:<br />
                  <span class="EstFormularioSubEtiqueta">(00:00)</span></td>
                <td align="left" valign="top"><input name="CmpEntregaVentaVehiculoHoraProgramada" type="text" class="EstFormularioCajaHora" id="CmpEntregaVentaVehiculoHoraProgramada" value="<?php  echo $InsEntregaVentaVehiculo->EvvHoraProgramada;?>" size="15" maxlength="10" />
                  <!--             <div id="sample1" class="ui-widget-content" style="padding: .5em;">
        <p>
            <label>Start</label><br/>
            <input name="s1Time2" value="" /> <br/>
            <label>End</label><br/>
            <input name="s1Time2" value="" />
        </p>
        <p>Some extra select boxes to show to it works under IE.<br/>
            <select>
                <option>Option 1 here</option>
                <option>Options 2 here</option>
            </select><br /> <br />
            <select>
                <option>Option 1 here</option>
                <option>Options 2 here</option>
            </select>
        </p>
    </div>-->
                  <!--<a id="BtnCitaCalendario" href="javascript:FncCitaCalendarioCargarFormulario('VerCalendarioFull')"><img src="imagenes/acciones/calendario_full.png" width="25" height="25" border="0" alt="Calendario" title="Calendario" align="absmiddle" /></a>
            --></td>
                <td>&nbsp;</td>
        </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Duracion Estimada:</td>
                <td align="left" valign="top"><?php
			switch($InsEntregaVentaVehiculo->EvvDuracion){
				case 1:
					$OpcDuracion1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcDuracion2 = 'selected="selected"';
				break;
				
				case 3:
					$OpcDuracion3 = 'selected="selected"';
				break;
				
			}
			?>
                  <select  class="EstFormularioCombo" id="CmpEntregaVentaVehiculoDuracion" name="CmpEntregaVentaVehiculoDuracion">
                    <option <?php echo $OpcDuracion1;?> value="1">1 Hora</option>
                    <option <?php echo $OpcDuracion2;?> value="2">2 Horas</option>
                    <option <?php echo $OpcDuracion3;?> value="3">3 Horas</option>
                  </select></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">VIN:</td>
                <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN" value="<?php echo ($InsEntregaVentaVehiculo->EinVIN);?>" size="35" maxlength="255" readonly /></td>
                <td align="left" valign="top">Marca:</td>
                <td align="left" valign="top"><input name="CmpVehiculoMarca" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoMarca" value="<?php echo ($InsEntregaVentaVehiculo->VmaNombre);?>" size="35" maxlength="255" readonly /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Modelo:</td>
                <td align="left" valign="top"><input name="CmpVehiculoModelo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoModelo" value="<?php echo ($InsEntregaVentaVehiculo->VmoNombre);?>" size="35" maxlength="255" readonly /></td>
                <td align="left" valign="top">Version:</td>
                <td align="left" valign="top"><input name="CmpVehiculoVersion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersion" value="<?php echo ($InsEntregaVentaVehiculo->VveNombre);?>" size="35" maxlength="255" readonly /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Color:</td>
                <td align="left" valign="top"><input name="CmpVehiculoColor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoColor" value="<?php echo ($InsEntregaVentaVehiculo->EinColor);?>" size="35" maxlength="255" readonly /></td>
                <td align="left" valign="top">Cliente:</td>
                <td align="left" valign="top"><input name="CmpClienteNombreCompleto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNombreCompleto"  tabindex="3" value="<?php  echo $InsEntregaVentaVehiculo->CliNombre;?> <?php  echo $InsEntregaVentaVehiculo->CliApellidPaterno;?> <?php  echo $InsEntregaVentaVehiculo->CliApellidMaterno;?>" size="35" maxlength="255" readonly /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                <td>&nbsp;</td>
               </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Orden de Venta:</td>
                <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsEntregaVentaVehiculo->OvvId;?>" size="25" maxlength="25" readonly /></td>
                <td>Asesor de Ventas:</td>
                <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonalVendedor" id="CmpPersonalVendedor" >
                  <option value="">Escoja una opcion</option>
                  <?php
					foreach($ArrPersonaleVendedores as $DatPersonal){
					?>
                  <option <?php echo ($DatPersonal->PerId==$InsEntregaVentaVehiculo->PerIdVendedor)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                  <?php
					}
					?>
                  </select></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Observaciones de Asesor:</td>
                <td align="left" valign="top"><textarea name="CmpObservacion" cols="35" rows="2" readonly class="EstFormularioCajaDeshabilitada" id="CmpObservacion"><?php echo $InsEntregaVentaVehiculo->EvvObservacion;?></textarea></td>
                <td align="left" valign="top">Observaciones:</td>
                <td align="left" valign="top"><textarea name="CmpEntregaVentaVehiculoObservacionSalida" cols="35" rows="2" class="EstFormularioCaja" id="CmpEntregaVentaVehiculoObservacionSalida"><?php echo $InsEntregaVentaVehiculo->EvvObservacionSalida;?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Adicionales</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Accesorios:</td>
                <td align="left" valign="top"><?php
				if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
				?>
                  <?php
					foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
					
						if($DatOrdenVentaVehiculoObsequio->ObsUso == 2){
						?>
                  			
							- <?php echo $DatOrdenVentaVehiculoObsequio->ObsNombre;?><br />
                  <?php	
						}
						
					}
					?>
                  <?php
				}else{
				?>
                  No hay accesorios
  <?php	
				}
				
				?></td>
                <td align="left" valign="top">GLP:</td>
                <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvGLP){
						case "Si":
							$OpcGLP1 = 'selected = "selected"';
						break;

						case "No":
							$OpcGLP3 = 'selected = "selected"';						
						break;
					
					}
					?>
                  <select disabled="disabled" class="EstFormularioCombo" name="CmpGLP" id="CmpGLP">
                    <option <?php echo $OpcGLP1;?> value="Si">Si</option>
                    <option <?php echo $OpcGLP3;?> value="No">No</option>
                </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones adicionales</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><input <?php echo (($InsEntregaVentaVehiculo->EvvNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                  Notificar aprobacion via email (*) </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
        </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top">
                
                
                <input class="EstFormularioBoton" name="BtnEntregaVentaVehiculoGuardar" type="submit"  id="BtnEntregaVentaVehiculoGuardar" value="Reprogramar" />
                <input class="EstFormularioBoton" name="BtnEntregaVentaVehiculoCerrar" type="submit"  id="BtnEntregaVentaVehiculoCerrar" value="Cerrar" /></td>
                <td>&nbsp;</td>
               </tr>
            </table>
    
</div>


<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpEntregaVentaVehiculoFechaProgramada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnEntregaVentaVehiculoFechaProgramada"// el id del botón que  
	});
	

</script>


 <script type="text/javascript">
        $(document).ready(function(){
  
	  $('#CmpEntregaVentaVehiculoHoraProgramada').timepicker(
	  { 
		'timeFormat': 'H:i' ,
		'minTime': '08:00',
		'maxTime': '18:00'
	  
	  }
	  );
	  
	});
    </script>
    
   </body>
   </html>