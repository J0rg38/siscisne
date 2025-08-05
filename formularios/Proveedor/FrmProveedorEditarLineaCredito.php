<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProveedor.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProveedor.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoProveedor.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompra.php');

//INSTANCIAS
$InsProveedor = new ClsProveedor();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsOrdenCompra = new ClsOrdenCompra();
$InsPagoProveedor = new ClsPagoProveedor();
$InsReporteOrdenCompra = new ClsReporteOrdenCompra();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProveedorEditarLineaCredito.php');
//DATOS

?>
<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
<div class="EstCapMenu">

<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>



          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProveedor->PrvId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ACTUALIZAR
        LINEA DE CREDITO DE PROVEEDOR</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedor->PrvTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedor->PrvTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
         <br />
    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="hidden" name="Guardar" id="Guardar"   />
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>C&oacute;digo Interno:
                    <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $InsProveedor->PrvId;?>" /></td>
                  <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProveedor->PrvId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Linea de Credito:</td>
                  <td align="left" valign="top"><input name="CmpLineaCredito" type="text" class="EstFormularioCajaDeshabilitada" id="CmpLineaCredito" value="<?php echo number_format($InsProveedor->PrvLineaCredito,2);?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Linea de Credito Actual:
                    <input type="hidden" name="CmpTipoCambioFecha" id="CmpTipoCambioFecha" value="<?php echo $InsProveedor->PrvTipoCambioFecha;?>" /></td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpLineaCreditoActual" type="text" id="CmpLineaCreditoActual" value="<?php echo number_format($InsProveedor->PrvLineaCreditoActual,2);?>" size="20" maxlength="20" /> </td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                        <option value="">Escoja una opcion</option>
                        <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                        <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsProveedor->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                        <?php
			  }
			  ?>
                      </select></td>
                      <td><div id="CapMonedaBuscar"></div></td>
                    </tr>
                    <tr> </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Cambio:<br />
                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio"  value="<?php if (empty($InsProveedor->PrvTipoCambio)){ echo "";}else{ echo $InsProveedor->PrvTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td><a href="javascript:FncPrventeEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                      </tr>
                    </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Estado de Linea:</td>
                  <td><?php
				  

			switch($InsProveedor->PrvLineaCreditoActiva){
				case 1:
					$OpcLineaCreditoActiva1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcLineaCreditoActiva2 = 'selected="selected"';
				break;

			}
			?>
                    <select class="EstFormularioCombo" name="CmpLineaCreditoActiva" id="CmpLineaCreditoActiva">
                      <option <?php echo $OpcLineaCreditoActiva1;?> value="1">Activa</option>
                      <option <?php echo $OpcLineaCreditoActiva2;?> value="2">Inactiva</option>
                    </select></td>
                  <td>&nbsp;</td>
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
      </table>
     
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	
	
	
  
</form>
  


<?php
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}
?>