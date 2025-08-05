<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoCierreDia.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Pago");?>JsPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Pago");?>JsPagoAutocompletar.js" ></script>

<?php

$POST_Area = $_POST['Area'];
$POST_Moneda = $_POST['Moneda'];
$POST_Origen = $_POST['Origen'];

if($_POST){
	$_SESSION[$GET_mod."Area"] = $POST_Area;
}else{
	$POST_Area = (empty($_GET['Area'])?$_SESSION[$GET_mod."Area"]:$_GET['Area']);
}

if($_POST){
   $_SESSION[$GET_mod."Origen"] = $POST_Origen;
}else{
	$POST_Origen = (empty($_GET['Origen'])?$_SESSION[$GET_mod."Origen"]:$_GET['Origen']);
}  


if($_POST){
   $_SESSION[$GET_mod."Moneda"] = $POST_Moneda;
}else{
	$POST_Moneda = (empty($_GET['Moneda'])?$_SESSION[$GET_mod."Moneda"]:$_GET['Moneda']);
}  

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');

$InsMoneda = new ClsMoneda();
$InsFormaPago = new ClsFormaPago();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL);
$ArrFormaPagos = $ResFormaPago['Datos'];

?>

<div class="EstCapMenu">
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

</div>


<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">CIERRE DIARIO</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfPagoCierreDia.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Pago/IfrPagoCierreDia.php" target="IfrPagoCierreDia" method="post" name="FrmPagoCierreDia" id="FrmPagoCierreDia">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"><legend>Opciones de Moneda</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Moneda:</td>
                <td><select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php echo (($POST_Moneda==$DatMoneda->MonId)?'selected="selected"':'');?>   ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                </select></td>
              </tr>
            </table></td>
          <td align="left" valign="top"><legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Forma Pago:</td>
                <td><select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
                  <option value="">Escoja una opcion</option>
                  <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
                  <option <?php echo ($InsPago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
                  <?php
			  }
			  
			  ?>
                </select></td>
                <td>Origen:</td>
                <td><select class="EstFormularioCombo" name="CmpOrigen" id="CmpOrigen">
                  <option value="" >Todos</option>
                  <option value="REPUESTOS" <?php if($POST_Origen=="REPUESTOS"){ echo 'selected="selected"';}?>>Repuestos</option>
                  <option value="VEHICULOS" <?php if($POST_Origen=="VEHICULOS"){ echo 'selected="selected"';}?>>Vehiculos</option>
                </select></td>
              </tr>
            </table></td>
          
          <td align="left" valign="top"><legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
              </tr>
              </table>
          </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
<?php
if($PrivilegioImprimir){
?>	
<input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncPagoCierreDiaImprimir('');" />           
<?php	  
}
?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncPagoCierreDiaGenerarExcel('');" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
      </form>    </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Pago/IfrPagoCierreDia.php" target="IfrPagoCierreDia" id="IfrPagoCierreDia" name="IfrPagoCierreDia" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
</tr>
</table>
</div>

<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	}); 
</script>

<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

