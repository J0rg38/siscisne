<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraGMFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraGMDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCompraGM.css');
</style>

<?php

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompraGM.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsOrdenCompra = new ClsOrdenCompra();
$InsMoneda = new ClsMoneda();
$InsPedidoCompra = new ClsPedidoCompra();
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();


$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,2);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraGMRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	//FncMonedaBuscar('Id');
	$('#CmpTipo').focus();
	
//	FncOrdenCompraDetalleListar();
	
	FncOrdenCompraEstablecerMoneda();
	
});
/*
Configuracion Formulario
*/
//var OrdenCompraDetalleEditar = 1;
//var OrdenCompraDetalleEliminar = 1;
</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">

<div class="EstCapMenu">


<?php
if($Registro){
?>

	<?php
    /*if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    
    <?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
    <?php
    if($PrivilegioGenerarExcel){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 
    
    <?php	  
    }*/
    ?>  
<?php
}
?>    


<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        ORDEN DE COMPRA GM</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
	<ul class="tabs">
        <li><a href="#tab1">Orden de Compra</a></li>


	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->


<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6"><span class="EstFormularioSubTitulo">Datos de la Orden de Compra GM
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
                      <td colspan="3">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCompra->OcoId;?>" size="25" maxlength="25" /></td>
                      <td align="left" valign="top">Tipo:</td>
                      <td align="left" valign="top"><span id="spryselect1">
                        
                        <?php
			switch($InsOrdenCompra->OcoTipo){
				
				case "ZGAR":
					$OcoTipo1 =  'selected="selected"';
				break;
				
				case "ZVOR":
					$OcoTipo2 =  'selected="selected"';
				break;
				
				case "YRUSH":
					$OcoTipo3 =  'selected="selected"';
				break;
				
				case "ZTOOL":
					$OcoTipo4 =  'selected="selected"';
				break;

				case "STK":
					$OcoTipo5 =  'selected="selected"';
				break;
			
																																		
			}
			?>
                        <label>
                          
                          <select class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
                            <option value="">Escoja una opcion</option>
                            <option <?php echo $OcoTipo1;?> value="ZGAR">ZGAR</option>
                            <option <?php echo $OcoTipo2;?> value="ZVOR">ZVOR</option>
                            <option <?php echo $OcoTipo3;?> value="YRUSH">YRUSH</option>
                            <option <?php echo $OcoTipo4;?> value="ZTOOL">ZTOOL</option>
                            <option <?php echo $OcoTipo5;?> value="STK">STK</option>
                            
                            </select>
                          </label>
                        
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo Dealer:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoDealer" type="text" class="EstFormularioCaja" id="CmpCodigoDealer" value="<?php echo $InsOrdenCompra->OcoCodigoDealer;?>" size="20" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield7">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsOrdenCompra->OcoFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCompra->OcoFecha; }?>" size="15" maxlength="10" />
                          </label>
                        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td align="left" valign="top">Hora:</td>
                      <td align="left" valign="top"><span id="sprytextfield">
                        <label for="CmpHora"></label>
                        <input  class="EstFormularioCaja" name="CmpHora" type="text" id="CmpHora" value="<?php if (empty($InsOrdenCompra->OcoHora)){ echo "";}else{ echo $InsOrdenCompra->OcoHora; } ?>" size="10" maxlength="10" onchange="FncOrdenCompraDetalleListar();" />
                        <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Moneda:</td>
                      <td align="left" valign="top">
                        
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                              
                              
                              <span id="spryselect2">
                                <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                                  <option value="">Escoja una opcion</option>
                                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                                  <?php
			  }
			  ?>
                                  </select>
                                <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span>
                              
                              
                              
                              </td>
                            <td>
                              <div id="CapMonedaBuscar"></div>
                              </td>
                            </tr>
                          </table>
                        
                        </td>
                      <td align="left" valign="top">Tipo de Cambio:<br />
                        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                      <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncOrdenCompraDetalleListar();" value="<?php if (empty($InsOrdenCompra->OcoTipoCambio)){ echo "";}else{ echo $InsOrdenCompra->OcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td align="left" valign="top">Estado:</td>
                      <td align="left" valign="top"><?php
					switch($InsOrdenCompra->OcoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
				/*		case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;*/
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                          <option <?php echo $OpcEstado1;?> value="1">En Armado</option>
                          <!--   <option <?php echo $OpcEstado2;?> value="2">Atendido</option>-->
                          <option <?php echo $OpcEstado3;?> value="3">Enviado</option>
                          </select>
                        
                        
                        </td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td colspan="5" align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCompra->OcoObservacion;?></textarea></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="center"></td>
                      <td align="center"></td>
                      <td align="center"></td>
                      <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div>     
                </td>
            </tr>
            
            <tr>
              <td valign="top">
                
                <div class="EstFormularioArea">
                  
                  
                  <table width="781" class="EstTablaListado">
                    <tbody class="EstTablaListadoBody">
                      
                      <?php
				foreach($ArrPedidoCompras as $DatPedidoCompra){
				?>
                      <tr>
                        <td><span class="EstFormularioSubTitulo">Pedidos de Compra </span></td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                     
                      <tr>
                        <td>
                          
                          <input type="checkbox" name="CmpPedidoCompra_<?php echo $DatPedidoCompra->PcoId;?>" id="CmpPedidoCompra_<?php echo $DatPedidoCompra->PcoId;?>" value="<?php echo $DatPedidoCompra->PcoId;?>" /> (*)
                          <span class="EstFormularioSubTitulo">
                            <?php echo $DatPedidoCompra->PcoId;?> - <?php echo $DatPedidoCompra->PcoFecha;?>
                            </span>
                          
                          <?php
					$ResPedidoCompraDetalle =  $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,NULL,NULL,NULL,$DatPedidoCompra->PcoId);
					$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];	
					?>
                          
                          <table width="781" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                           <tr>
                                <th valign="top">Cod. Original</th>
                                <th  valign="top">Cod. Alternativo</th>
                                <th  valign="top">Nombre</th>
                                <th  valign="top">Cantidad</th>
                              </tr>
                              </thead>
                            <tbody class="EstTablaListadoBody">
                             
                              <?php
                    foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
                    ?>

                              <tr>
                                <td width="93" align="right" valign="top"><?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?></td>
                                <td width="100" align="right" valign="top"><?php echo $DatPedidoCompraDetalle->ProCodigoAlternativo;?></td>
                                <td width="404" align="right" valign="top"><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
                                <td width="78" align="right" valign="top"><?php echo $DatPedidoCompraDetalle->PcdCantidad;?></td>
                                </tr>
                              <?php	
                    }
                    ?>
                              </tbody>
                            </table>
                          <br />
                          
                          </td>
                        </tr>
                      <?php
				}
				?>
                
                 <tr>
                        <td>(*) Marque en el casllero para considerar el pedido en la orden de compra, caso contrario deje sin marcar el casillero y el pedido no se incluira en la orden de compra.</td>
                      </tr>
                      </tbody>
                    </table>
                  
                  </div>
                
                
                </td>
            </tr>        
          </table>
          
          
    </div>

 

</div>      
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	
	
	
  


<!--  -->
  
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
</script>

<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "time");
</script>
<?php

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
?>