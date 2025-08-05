<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraPedidoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCompra.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompra.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

$InsOrdenCompra = new ClsOrdenCompra();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraDetalle'.$Identificador])){	
	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraCorregir.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

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

	$('#CmpTipo').focus();	

	FncOrdenCompraPedidoListar();
	
	FncOrdenCompraEstablecerMoneda();

});

/*
Configuracion Formulario
*/
var OrdenCompraPedidoEditar = 1;
var OrdenCompraPedidoEliminar = 1;
var OrdenCompraPedidoVerEstado = 2;

</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">


<div class="EstCapMenu">



<?php
if($Edito){
?>

	<?php
/*    if($PrivilegioVistaPreliminar){
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
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	



    
      
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ACTUALIZAR
        ORDEN DE COMPRA </span></td>
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
         <td valign="top"><div class="EstFormularioArea">
           
           
           <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
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
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="-1" align="left" valign="top">&nbsp;</td>
               <td colspan="-1" align="left" valign="top"></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCompra->OcoId;?>" size="25" maxlength="25" /></td>
               <td colspan="-1" align="left" valign="top">Tipo:</td>
               <td colspan="-1" align="left" valign="top">
                 
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
				
				case "CYC":
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
                   </label>
                 
                 
               </td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:</td>
               <td align="left" valign="top"><input name="CmpProveedorNombre" type="text"  class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsOrdenCompra->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" <?php if(!empty($InsOrdenCompra->PrvId)){ echo 'readonly="readonly"';} ?>  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo Doc.:
                 <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsOrdenCompra->PrvId;?>" size="3" /></td>
               <td align="left" valign="top">
                 
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
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
                   <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php if(!empty($InsOrdenCompra->PrvId)){ echo 'readonly="readonly"';} ?>   name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsOrdenCompra->PrvNumeroDocumento;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a></td>
                   <td><div id="CapProveedorBuscar"></div></td>
                   </tr>
               </table></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="-1" align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td colspan="-1" align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsOrdenCompra->OcoFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCompra->OcoFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha Llegada Estimada:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield2">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpFechaLlegadaEstimada" type="text" id="CmpFechaLlegadaEstimada" value="<?php echo $InsOrdenCompra->OcoFechaLlegadaEstimada;?>" size="15" maxlength="10" />
                 </label>
                 <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaLlegadaEstimada" name="BtnFechaLlegadaEstimada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Hora:</td>
               <td align="left" valign="top"><input name="CmpHora" type="text"  class="EstFormularioCaja" id="CmpHora" onchange="FncOrdenCompraPedidoListar();" value="<?php if (empty($InsOrdenCompra->OcoHora)){ echo "";}else{ echo $InsOrdenCompra->OcoHora; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td colspan="-1" align="left" valign="top">&nbsp;</td>
               <td colspan="-1" align="left" valign="top">&nbsp;</td>
               <td align="left">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select>
                     <!--  <input type="hidden" name="CmpMonedaId" id="CmpMonedaId" value="<?php echo $InsOrdenCompra->MonId; ?>" />--></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 </table></td>
               <td colspan="-1" align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td colspan="-1" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncOrdenCompraDetalleListar();" value="<?php if (empty($InsOrdenCompra->OcoTipoCambio)){ echo "";}else{ echo $InsOrdenCompra->OcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                   <td><a href="javascript:FncOrdenCompraEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                   </tr>
               </table></td>
               <td align="left">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Dealer:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoDealer" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoDealer" value="<?php echo $InsOrdenCompra->OcoCodigoDealer;?>" size="20" maxlength="20" /></td>
               <td align="left" valign="top">Estado:</td>
               <td align="left" valign="top"><?php
					switch($InsOrdenCompra->OcoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						/*case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;*/
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">En Armado</option>
                   <!-- <option <?php echo $OpcEstado2;?> value="2">Atendido</option>-->
                   <option <?php echo $OpcEstado3;?> value="3">Enviado</option>
                   <option <?php echo $OpcEstado4;?> value="4">Con Entrada</option>
                 </select></td>
               <td align="left">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCompra->OcoObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="-1">&nbsp;</td>
               <td colspan="-1"></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           
           </div></td>
       </tr>
       <?php
	  // if(empty($GET_dia)){
	   ?>
       <tr>
         <td valign="top">
         
         <div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpOrdenCompraPedidoAccion" id="CmpOrdenCompraPedidoAccion" value="AccOrdenCompraDetalleRegistrar.php" /></td>
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
           </div>
           
           
           </td>
       </tr>
       <?php
	  // }
	   ?>
       
       <tr>
         <td valign="top">&nbsp;</td>
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

	
	
	
    
       


     
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
		Calendar.setup({ 
	inputField : "CmpFechaEstimadaLlegada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEstimadaLlegada"// el id del botón que  
	});
	
	
</script>

<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>


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
