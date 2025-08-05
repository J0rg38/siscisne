<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCobro",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCobroVentaDirectaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>


<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCobro","Editar"))?true:false;?>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_VdiId = $_GET['VdiId'];
$GET_FtaId = $_GET['FtaId'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCobroVentaDirecta.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsOrdenCobro.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsOrdenCobroComprobante.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');


//INSTANCIAS
$InsOrdenCobro = new ClsOrdenCobro();
$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsVentaDirecta = new ClsVentaDirecta();
$InsArea = new ClsArea();

$InsVentaDirecta->VdiId = $GET_VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta(false);

//ACCIONES
$VentaDirectaId = "";

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCobroVentaDirectaEditar.php');

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,1);
$ArrAreas = $ResArea['Datos'];




?><div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsOrdenCobro->OcbId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        ORDEN DE COBRO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCobro->OcbTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCobro->OcbTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo Interno:
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="FAC" />
              <input name="CmpVentaDirectaId" type="hidden" id="CmpVentaDirectaId" value="<?php echo $VentaDirectaId;?>" />
              <input name="CmpVentaDirectaTalonarioId" type="hidden" id="CmpVentaDirectaTalonarioId" value="<?php echo $VentaDirectaTalonarioId;?>" />
              <input name="CmpVentaDirectaTalonarioNumero" type="hidden" id="CmpVentaDirectaTalonarioNumero" value="<?php echo $VentaDirectaTalonarioNumero;?>" /></td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCobro->OcbId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Orden de Venta/Orden Ven. Vehiculo:</td>
            <td align="left" valign="top"><input name="CmpVentaDirecta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirecta" value="<?php echo $VentaDirectaId;?>" size="15" maxlength="20"  readonly="readonly"/>
              /
              <input name="CmpOrdenVentaVehiculo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculo" value="<?php echo $OrdenVentaVehiculoId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente: </td>
            <td align="left" valign="top"><input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsOrdenCobro->CliNombre;?> <?php echo $InsOrdenCobro->CliApellidoPaterno;?> <?php echo $InsOrdenCobro->CliId;?>" />
              <input name="CmpClienteNombre" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsOrdenCobro->CliNombre;?> <?php echo $InsOrdenCobro->CliApellidoPaterno;?> <?php echo $InsOrdenCobro->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Area Destino:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAreaId" id="CmpAreaId">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrAreas as $DatArea){
				?>
              <option <?php echo ($InsOrdenCobro->AreId == $DatArea->AreId)?'selected="selected"':''; ?>  value="<?php echo $DatArea->AreId?>"><?php echo $DatArea->AreNombre ?></option>
              <?php
			  }
			  
			  ?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsOrdenCobro->OcbFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Concepto:</td>
            <td align="left" valign="top"><textarea name="CmpConcepto" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpConcepto"><?php echo $InsOrdenCobro->OcbConcepto;?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Condicion de Pago:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpCondicionPago" id="CmpCondicionPago" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrCondicionPagos as $DatCondicionPago){
				?>
              <option <?php echo ($InsOrdenCobro->NpaId == $DatCondicionPago->NpaId)?'selected="selected"':''; ?> value="<?php echo $DatCondicionPago->NpaId?>"><?php echo $DatCondicionPago->NpaNombre ?></option>
              <?php
			  }
			  
			  ?>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled" >
                  <option value="">Escoja una opcion</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCobro->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                  </select></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
              </table></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo de Cambio: <br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncOrdenCobroDetalleListar();" value="<?php if (empty($InsOrdenCobro->OcbTipoCambio)){ echo "";}else{ echo $InsOrdenCobro->OcbTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                <td><a href="javascript:FncOrdenCobroVentaDirectaEstablecerMoneda();"></a></td>
              </tr>
            </table></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Monto:</td>
            <td align="left" valign="top"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php echo number_format($InsOrdenCobro->OcbMonto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsOrdenCobro->OcbEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
				
			}
			?>
              <select disabled="disabled" tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsOrdenCobro->OcbObservacion;?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
        
        </div>
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>


	
	
	
    <?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>


