<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"SolicitudDesembolso","Ver")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Personal");?>JsPersonalCorreoElectronicoAutoCompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsSolicitudDesembolsoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsSolicitudDesembolsoDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssSolicitudDesembolso.css');
</style>

<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjSolicitudDesembolso.php');

require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolsoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoGasto.php');

$InsSolicitudDesembolso = new ClsSolicitudDesembolso();
$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();
$InsArea = new ClsArea();
$InsTipoGasto = new ClsTipoGasto();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccSolicitudDesembolsoSolicitarAutorizacion.php');

//DATOS
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

//MtdObtenerAreas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {
$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreNombre","ASC",NULL,NULL);
$ArrAreas = $ResArea['Datos'];

$ResTipoGasto = $InsTipoGasto->MtdObtenerTipoGastos(NULL,NULL,"TgaNombre","ASC",NULL,NULL,NULL);
$ArrTipoGastos = $ResTipoGasto['Datos'];
?>

<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncSolicitudDesembolsoDetalleListar();
		
});


var SolicitudDesembolsoDetalleEditar = 2;
var SolicitudDesembolsoDetalleEliminar = 2;
</script>

<form id="FrmEnviarCorreo" name="FrmEnviarCorreo" method="post" action="#" enctype="multipart/form-data" >


<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsSolicitudDesembolso->SdsId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsSolicitudDesembolso->SdsId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsSolicitudDesembolso->SdsId;?>&Su=<?php echo $InsSolicitudDesembolso->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

<input name="BtnEnviarCorreo"   id="BtnEnviarCorreo" type="image" border="0" src="imagenes/acc_enviar_correo.gif" alt="[Enviar Correo]" title="Enviar Correo" />

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ENVIAR CORREO DE SOLICITUD DE DESEMBOLSO</span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsSolicitudDesembolso->SdsTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsSolicitudDesembolso->SdsTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Solicitud de Desembolso</a></li>

</ul>        

<div class="tab_container">

    <div id="tab1" class="tab_content">
        <!--Content-->     
		<table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">

<div class="EstFormularioArea">
          <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="2"><span class="EstFormularioSubTitulo">Datos del correo electronico
		       
		        </span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Destinatario:</td>
            <td align="left" valign="top"><textarea name="CmpDestinatario" cols="100" rows="3" class="EstFormularioCaja" id="CmpDestinatario"><?php echo $InsSolicitudDesembolso->SdsDestinatarios;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
              
              </table>
              </div></td>
       </tr>

       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Solicitud de Desembolso
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="center">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsSolicitudDesembolso->SdsId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsSolicitudDesembolso->SdsFecha)){ echo date("d/m/Y");}else{ echo $InsSolicitudDesembolso->SdsFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsSolicitudDesembolso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncSolicitudDesembolsoDetalleListar();" value="<?php if (empty($InsSolicitudDesembolso->SdsTipoCambio)){ echo "";}else{ echo $InsSolicitudDesembolso->SdsTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo:</td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpTipoGasto" id="CmpTipoGasto" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrTipoGastos as $DatTipoGasto){
					?>
                 <option <?php echo ($DatTipoGasto->TgaId==$InsSolicitudDesembolso->TgaId)?'selected="selected"':'';?>  value="<?php echo $DatTipoGasto->TgaId;?>"><?php echo $DatTipoGasto->TgaNombre;?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">Area:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpArea" id="CmpArea" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrAreas as $DatArea){
					?>
                 <option <?php echo ($DatArea->AreId==$InsSolicitudDesembolso->AreId)?'selected="selected"':'';?>  value="<?php echo $DatArea->AreId;?>"><?php echo $DatArea->AreNombre;?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente(s) Referencia:</td>
               <td align="left" valign="top"><input name="CmpCliente" type="text" class="EstFormularioCaja" id="CmpCliente" value="<?php echo $InsSolicitudDesembolso->SdsCliente;?>" size="45" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:</td>
               <td align="left" valign="top"><input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsSolicitudDesembolso->SdsVIN;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Placa:</td>
               <td align="left" valign="top"><input name="CmpPlaca" type="text" class="EstFormularioCaja" id="CmpPlaca" value="<?php echo $InsSolicitudDesembolso->SdsPlaca;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Aprobacion</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Aprobado:</td>
               <td align="left" valign="top"><?php
switch($InsSolicitudDesembolso->SdsAprobado){

	case 1:
		$OpcAprobado1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcAprobado2 = 'selected = "selected"';						
	break;

}
?>
                 <select   class="EstFormularioCombo" name="CmpAprobado" id="CmpAprobado"  disabled="disabled"  >
                   <option <?php echo $OpcAprobado1;?> value="1">Si</option>
                   <option <?php echo $OpcAprobado2;?> value="2">No</option>
                   </select></td>
               <td align="left" valign="top">Respuesta:</td>
               <td align="left" valign="top"><textarea name="CmpSolicitudAprobacionRespuesta" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpSolicitudAprobacionRespuesta"><?php echo $InsSolicitudDesembolso->SdsSolicitudAprobacionRespuesta;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos Adicionales</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Titulo:</td>
               <td align="left" valign="top"><input name="CmpAsunto" type="text" class="EstFormularioCaja" id="CmpAsunto" value="<?php echo $InsSolicitudDesembolso->SdsAsunto;?>" size="45" maxlength="255" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaciones en Correo:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionCorreo" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionCorreo"><?php echo $InsSolicitudDesembolso->SdsObservacionCorreo;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y Otras Referencias</span></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">A solicitud de:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" disabled="disabled" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsSolicitudDesembolso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">Orden de Trabajo:</td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><a href="javascript:FncFichaIngresoNuevo();"></a></td>
                   <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsSolicitudDesembolso->FinId;?>" size="20" maxlength="20" />
                     <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  tabindex="3" value="<?php  echo $InsSolicitudDesembolso->FinId;?>" size="15" maxlength="25" readonly="readonly" <?php echo (!empty($InsSolicitudDesembolso->FinId)?'readonly="readonly"':'')?>  /></td>
                   <td><a href="javascript:FncFichaIngresoBuscar('Id');"></a></td>
                   <td></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsSolicitudDesembolso->SdsEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsSolicitudDesembolso->SdsObservacion;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsSolicitudDesembolso->SdsObservacionImpresa;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       
              <tr>
                <td valign="top"><div class="EstFormularioArea" >
                  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                    <tr>
                      <td width="1%"><input type="hidden" name="CmpSolicitudDesembolsoDetalleAccion" id="CmpSolicitudDesembolsoDetalleAccion" value="AccSolicitudDesembolsoDetalleRegistrar.php" /></td>
                      <td width="49%"><div class="EstFormularioAccion" id="CapServicioRepuestoAccion">Listo
                        para registrar elementos</div></td>
                      <td width="49%" align="right">
                        
                        <a href="javascript:FncSolicitudDesembolsoDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                        
                        
                        <a href="javascript:FncSolicitudDesembolsoDetalleEliminarTodo();"></a>
                        
                        
                        </td>
                      <td width="1%"><div id="CapSolicitudDesembolsoDetallesResultado"> </div></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2"><div id="CapSolicitudDesembolsoDetalles" class="EstCapSolicitudDesembolsoDetalles" > </div></td>
                      <td>&nbsp;</td>
                      </tr>
                    </table>
                </div></td>
              </tr>
       <tr>
         <td valign="top">&nbsp;</td>
       </tr>
       </table>
    </div>    
    
<div>		
 
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

</form>	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}

?>
