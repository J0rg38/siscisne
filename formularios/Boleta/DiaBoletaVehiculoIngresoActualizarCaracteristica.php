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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","Imprimir"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<?php

$GET_Id = $_GET['Id'];
$GET_Ta = $_GET['Ta'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

$InsNotaCredito = new ClsNotaCredito();

//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrFechaEmision","DESC",1,NULL,$_SESSION['SesionSucursal'],5,NULL,NULL,NULL,$POST_Moneda,$GET_Id,$GET_Ta);
$ArrNotaCreditos = $ResNotaCredito['Datos'];	
?>

<div class="EstFormularioArea"> 
    <div id="ForBuscadorProductos"  >
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="98%"><span class="EstFormularioSubTitulo"> Listado de Notas de Credito</span></td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
     <div class="EstFormularioArea" >
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo"> Datos Declaracion	de Aduana</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">DUA:</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinDUA;?>"  class="EstFormularioCaja"  name="CmpDUA" type="text" id="CmpDUA" size="30" maxlength="50" /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Caracteristicas del Vehiculo</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Nombre</td>
      <td colspan="3"><input  name="CmpVehiculoIngresoNombre" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoNombre" value="<?php echo $InsVehiculoIngreso->EinNombre;?>" size="30" maxlength="50" />
        (**)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Marca:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaMarca" value="<?php echo $InsVehiculoIngreso->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Traccion: <span class="EstFormularioSubIndice">(7)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica7);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica7" type="text" id="CmpVehiculoVersionCaracteristica7" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Modelo:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaModelo" value="<?php echo $InsVehiculoIngreso->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Carroceria: <span class="EstFormularioSubIndice">(8)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica8);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica8" type="text" id="CmpVehiculoVersionCaracteristica8" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Año Fabricacion:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaAnoFabricacion" value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Num. Puertas: <span class="EstFormularioSubIndice">(9)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica9);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica9" type="text" id="CmpVehiculoVersionCaracteristica9" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Motor:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaNumeroMotor" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaNumeroMotor" value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Combustible: <span class="EstFormularioSubIndice">(10)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica10" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica10" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica10);?>" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Cilindros: <span class="EstFormularioSubIndice">(1)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica1);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica1" type="text" id="CmpVehiculoVersionCaracteristica1" size="25" maxlength="50" />
        (*)</td>
      <td>Peso Bruto: <span class="EstFormularioSubIndice">(11)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica11);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica11" type="text" id="CmpVehiculoVersionCaracteristica11" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Ejes: <span class="EstFormularioSubIndice">(2)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica2);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica2" type="text" id="CmpVehiculoVersionCaracteristica2" size="25" maxlength="50" />
        (*)</td>
      <td>Carga Util: <span class="EstFormularioSubIndice">(12)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica12" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica12" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica12);?>" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Chasis:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaVIN" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Peso Seco: <span class="EstFormularioSubIndice">(13)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica13" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica13" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica13);?>" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Color Interior:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaColorInterior" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaColorInterior" value="<?php echo $InsVehiculoIngreso->EinColorInterior;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Alto: <span class="EstFormularioSubIndice">(14)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica14);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica14" type="text" id="CmpVehiculoVersionCaracteristica14" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Color Exterior:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaColor" value="<?php echo $InsVehiculoIngreso->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Largo: <span class="EstFormularioSubIndice">(15)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica15);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica15" type="text" id="CmpVehiculoVersionCaracteristica15" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Cilindrada: <span class="EstFormularioSubIndice">(3)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica3);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica3" type="text" id="CmpVehiculoVersionCaracteristica3" size="25" maxlength="50" />
        (*)</td>
      <td>Ancho: <span class="EstFormularioSubIndice">(16)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica16);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica16" type="text" id="CmpVehiculoVersionCaracteristica16" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Asientos: <span class="EstFormularioSubIndice">(4)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica4);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica4" type="text" id="CmpVehiculoVersionCaracteristica4" size="25" maxlength="50" />
        (*)</td>
      <td>Dist. Ejes: <span class="EstFormularioSubIndice">(17)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica17);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica17" type="text" id="CmpVehiculoVersionCaracteristica17" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Cap. Pasajeros: <span class="EstFormularioSubIndice">(5)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica5);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica5" type="text" id="CmpVehiculoVersionCaracteristica5" size="25" maxlength="50" />
        (*)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">(*) Estos campos solo deben ser modificados con los datos originales de la DUA.<br /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
</div>
        
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div>
</div>
   