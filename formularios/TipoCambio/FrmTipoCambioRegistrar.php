<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php
include($InsProyecto->MtdFormulariosMsj('TipoCambio').'MsjTipoCambio.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

include($InsProyecto->MtdFormulariosAcc('TipoCambio').'AccTipoCambioRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,'MonId','Desc',NULL);
$ArrMonedas = $ResMoneda['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>








<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        TIPO DE CAMBIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda:</td>
            <td>
              <span id="spryselect1">
                
                <select class="EstFormularioCombo" id="CmpMoneda" name="CmpMoneda">
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrMonedas as $DatMoneda){				
				
			?>
                  <option <?php if($InsTipoCambio->MonId == $DatMoneda->MonId){ echo 'selected="selected"';}?> value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?> <?php echo $DatMoneda->MonSimbolo;?></option>
                  <?php
			}
			?>
                  </select>
                
                
                <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span>
              
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td>
            
                           <span id="sprytextfield4">
                 <label>
                   <input class="EstFormularioCajaFecha"  name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsTipoCambio->TcaFecha)){ echo date("d/m/Y");}else{ echo $InsTipoCambio->TcaFecha; }?>" size="15" maxlength="10" />
                   </label>
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Compra:</td>
            <td><span id="sprytextfield1">
            <label>
            <input  class="EstFormularioCaja" name="CmpMontoCompra" type="text" id="CmpMontoCompra" value="<?php echo $InsTipoCambio->TcaMontoCompra;?>" size="10" maxlength="10" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Venta:</td>
            <td><span id="sprytextfield2">
            <label>
              <input  class="EstFormularioCaja" name="CmpMontoVenta" type="text" id="CmpMontoVenta" value="<?php echo $InsTipoCambio->TcaMontoVenta;?>" size="10" maxlength="10" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Comercial:</td>
            <td><span id="sprytextfield5">
              <label>
                <input  class="EstFormularioCaja" name="CmpMontoComercial" type="text" id="CmpMontoComercial" value="<?php echo $InsTipoCambio->TcaMontoComercial;?>" size="10" maxlength="10" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
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
<!--
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"dd/mm/yyyy"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none");
//-->
</script>

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
