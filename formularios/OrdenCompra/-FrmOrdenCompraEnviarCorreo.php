<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraPedidoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCompraGM.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompra.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsOrdenCompra = new ClsOrdenCompra();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraDetalle'.$Identificador])){	
	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraDetalle'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraEnviarCorreo.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncOrdenCompraPedidoListar();
	
	FncOrdenCompraEstablecerMoneda();
	
	
});

var OrdenCompraPedidoEditar = 2;
var OrdenCompraPedidoEliminar = 2;
var OrdenCompraPedidoVerEstado = 2;
</script>



<form id="FrmEnviarCorreo" name="FrmEnviarCorreo" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">



<div class="EstCapMenu">
           
           
           <?php
    if($PrivilegioVistaPreliminar){
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
    }
    ?>  
    
     
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsOrdenCompra->OcoId;?>&Su=<?php echo $InsOrdenCompra->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ENVIAR ORDEN DE COMPRA POR CORREO ELECTRONICO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Orden de Compra</a></li>


</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCompra->OcoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCompra->OcoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
   
        
        
        
        
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
            <td align="left" valign="top"><textarea name="CmpDestinatario" cols="100" rows="3" class="EstFormularioCaja" id="CmpDestinatario"><?php echo $InsOrdenCompra->OcoDestinatarios;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
              
              </table>
              </div>

         
         </td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
          <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Orden de Compra 
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
		      <td align="left" valign="top">Codigo:</td>
		      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCompra->OcoId;?>" size="25" maxlength="25" /></td>
		      <td align="left" valign="top">Tipo:</td>
		      <td align="left" valign="top"><?php
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
				
				case "ALM":
					$OcoTipo6 =  'selected="selected"';
				break;
				
				case "YPRO":
					$OcoTipo7 =  'selected="selected"';
				break;
																														
			}
			?>
		        <label>
		          <select disabled="disabled" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
		            <option value="">Escoja una opcion</option>
		            <option <?php echo $OcoTipo1;?> value="ZGAR">ZGAR</option>
		            <option <?php echo $OcoTipo2;?> value="ZVOR">ZVOR</option>
		            <option <?php echo $OcoTipo3;?> value="YRUSH">YRUSH</option>
		            <option <?php echo $OcoTipo4;?> value="ZTOOL">ZTOOL</option>
		            <option <?php echo $OcoTipo7;?> value="YPRO">YPRO</option>
		            <option <?php echo $OcoTipo5;?> value="STK">STK</option>
		            <option <?php echo $OcoTipo6;?> value="ALM">ALM</option>
		            </select>
		          </label></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>Proveedor:</td>
		      <td><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsOrdenCompra->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly"  /></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Tipo Doc.:
		        <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsOrdenCompra->PrvId;?>" size="3" /></td>
		      <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
		        <option value="">Escoja una opcion</option>
		        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
		        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsOrdenCompra->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
		        <?php
			}
			?>
		        </select></td>
		      <td align="left" valign="top">Num. Doc.:</td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsOrdenCompra->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
		          <td><div id="CapProveedorBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Fecha:<br />
		        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsOrdenCompra->OcoFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCompra->OcoFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">Fecha Llegada Estimada:<br />
                <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input name="CmpFechaLlegadaEstimada" type="text" class="EstFormularioCajaFecha" id="CmpFechaLlegadaEstimada" value="<?php echo $InsOrdenCompra->OcoFechaLlegadaEstimada;?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Hora:</td>
		      <td align="left" valign="top"><input name="CmpHora" type="text"  class="EstFormularioCaja" id="CmpHora" onchange="FncAlmacenMovimientoEntradaDetalleListar();" value="<?php if (empty($InsOrdenCompra->OcoHora)){ echo "";}else{ echo $InsOrdenCompra->OcoHora; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Moneda:</td>
		      <td align="left" valign="top">
		        <table border="0" cellpadding="0" cellspacing="0">
		          <tr>
		            <td>
		              <select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
		                <option value="">Escoja una opcion</option>
		                <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
		                <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
		                <?php
			  }
			  ?>
		                </select>
		              
		              </td>
		            <td>
		              <div id="CapMonedaBuscar"></div>
		              </td>
		            </tr>
		          </table>
		        
		        </td>
		      <td align="left" valign="top">Tipo de Cambio:<br />
		        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
		      <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaDetalleListar();" value="<?php if (empty($InsOrdenCompra->AmoTipoCambio)){ echo "";}else{ echo $InsOrdenCompra->OcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Codigo Dealer:</td>
		      <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoDealer" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoDealer" value="<?php echo $InsOrdenCompra->OcoCodigoDealer;?>" size="20" maxlength="20" /></td>
		      <td align="left" valign="top">Estado: </td>
		      <td align="left" valign="top"><?php
					switch($InsOrdenCompra->OcoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						/*case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;
						*/

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
					}
					?>
		        <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
		          <option <?php echo $OpcEstado1;?> value="1">En Armado</option>
		          <!-- <option <?php echo $OpcEstado2;?> value="2">Atendido</option>-->
		          <option <?php echo $OpcEstado3;?> value="3">Enviado</option>
		          <option <?php echo $OpcEstado4;?> value="4">Con Entrada</option>
		          </select></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Observacion:</td>
		      <td align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCompra->OcoObservacion;?></textarea></td>
		      <td align="left" valign="top">Respuesta de Proveedor:</td>
		      <td align="left" valign="top"><textarea name="CmpRespuestaProveedor" cols="40" rows="4" readonly="readonly" class="EstFormularioCajaDeshabilitada" id="CmpRespuestaProveedor"><?php echo $InsOrdenCompra->OcoRespuestaProveedor;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>Procesado por Proveedor:</td>
		      <td align="left"><?php
					switch($InsOrdenCompra->OcoProcesadoProveedor){
						case 1:
							$OpcProcesadoProveedor1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcProcesadoProveedor2 = 'selected = "selected"';						
						break;
						
					}
					?>
		        <select  class="EstFormularioCombo" name="CmpProcesadoProveedor" id="CmpProcesadoProveedor" disabled="disabled">
		          <option <?php echo $OpcProcesadoProveedor1;?> value="1">Si</option>
		          <option <?php echo $OpcProcesadoProveedor2;?> value="2">No</option>
		          </select></td>
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
		    </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpOrdenCompraPedidoAccion" id="CmpOrdenCompraPedidoAccion" value="AccOrdenCompraGMDetalleRegistrar.php" /></td>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncOrdenCompraPedidoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenCompraPedidoEliminarTodo();"></a></td>
               <td width="1%"><div id="CapOrdenCompraPedidosResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapOrdenCompraPedidos" class="EstCapOrdenCompraPedidos" > </div></td>
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

if(empty($GET_dia)){

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}

?>
