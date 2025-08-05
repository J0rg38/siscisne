<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
         
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraGMFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraGMPedidoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCompraGM.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompraGM.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsOrdenCompra = new ClsOrdenCompra();
$InsMoneda = new ClsMoneda();

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraDetalle'.$Identificador])){	
	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraGMEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

//deb($GET_id);
?>

<?php
if( ($InsOrdenCompra->OcoEstado ==1 or $InsOrdenCompra->OcoEstado == 3  )){
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
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	



    
      
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
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
               <td colspan="-1">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="-1">&nbsp;</td>
               <td colspan="-1"></td>
               <td colspan="-1">&nbsp;</td>
               <td>&nbsp;</td>
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
				

																																		
			}
			?>
            
				<select disabled="disabled" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
                <option value="">Escoja una opcion</option>
                <option <?php echo $OcoTipo1;?> value="ZGAR">ZGAR</option>
                <option <?php echo $OcoTipo2;?> value="ZVOR">ZVOR</option>
                <option <?php echo $OcoTipo3;?> value="YRUSH">YRUSH</option>
                <option <?php echo $OcoTipo4;?> value="ZTOOL">ZTOOL</option>
                <option <?php echo $OcoTipo5;?> value="STK">STK</option>
				</select>
                   
                   
                   
                <!-- <select disabled="disabled" class="EstFormularioCombo" name="CmpTipoAux" id="CmpTipoAux">
                <option value="">Escoja una opcion</option>
                <option <?php echo $OcoTipo1;?> value="ZGAR">ZGAR</option>
                <option <?php echo $OcoTipo2;?> value="ZVOR">ZVOR</option>
                <option <?php echo $OcoTipo3;?> value="YRUSH">YRUSH</option>
                <option <?php echo $OcoTipo4;?> value="ZTOOL">ZTOOL</option>
                <option <?php echo $OcoTipo5;?> value="STK">STK</option>

                   </select>
                 <input type="hidden" name="CmpTipo" id="CmpTipo" value="<?php echo $InsOrdenCompra->OcoTipo;?>" />-->
               </td>
               <td colspan="-1" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Dealer:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoDealer" type="text" class="EstFormularioCaja" id="CmpCodigoDealer" value="<?php echo $InsOrdenCompra->OcoCodigoDealer;?>" size="20" maxlength="20" /></td>
               <td colspan="-1" align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td colspan="-1" align="left" valign="top"><span id="sprytextfield10">
                 <input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsOrdenCompra->OcoFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCompra->OcoFecha; }?>" size="15" maxlength="10" readonly="readonly" />
                 <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td colspan="-1" align="left" valign="top">Hora:</td>
               <td align="left" valign="top"><span id="sprytextfield">
                 <label for="CmpHora"></label>
                 <input name="CmpHora" type="text"  class="EstFormularioCaja" id="CmpHora" onchange="FncOrdenCompraPedidoListar();" value="<?php if (empty($InsOrdenCompra->OcoHora)){ echo "";}else{ echo $InsOrdenCompra->OcoHora; } ?>" size="10" maxlength="10" readonly="readonly" />
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
                     <!--  <input type="hidden" name="CmpMonedaId" id="CmpMonedaId" value="<?php echo $InsOrdenCompra->MonId; ?>" />-->
                       </td>
                     <td>
                       <div id="CapMonedaBuscar"></div>
                       </td>
                     </tr>
                   </table>
               </td>
               <td colspan="-1" align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td colspan="-1" align="left" valign="top">
               
               <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncOrdenCompraPedidoListar();" value="<?php if (empty($InsOrdenCompra->OcoTipoCambio)){ echo "";}else{ echo $InsOrdenCompra->OcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
               </td>
               <td align="left" valign="top">Estado: </td>
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
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">En Armado</option>
                   <!-- <option <?php echo $OpcEstado2;?> value="2">Atendido</option>-->
                   <option <?php echo $OpcEstado3;?> value="3">Enviado</option>
                 </select>
                 
                 
                 
            
            
                 </td>
               <td align="left">&nbsp;</td>
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
               <td colspan="-1">&nbsp;</td>
               <td colspan="-1"></td>
               <td colspan="-1">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             </table>
             
           </div></td>
       </tr>
       <tr>
         <td valign="top">
                  </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="2%"><input type="hidden" name="CmpOrdenCompraPedidoAccion" id="CmpOrdenCompraPedidoAccion" value="AccOrdenCompraGMDetalleRegistrar.php" /></td>
               <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncOrdenCompraPedidoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/></a><a href="javascript:FncOrdenCompraPedidoEliminarTodo();"></a></td>
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
	
</script>

<script type="text/javascript">
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "date", {isRequired:false, format:"dd/mm/yyyy"});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "time");
</script>

<?php
}else{
	echo ERR_OCO_604;
}
?>

<?php

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
//$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
?>