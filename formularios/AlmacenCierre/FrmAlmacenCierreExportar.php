<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenCierreExportarFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss('AlmacenCierre');?>CssAlmacenCierre.css');
</style>

<?php
$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenCierre.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenCierre.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsAlmacenCierre = new ClsAlmacenCierre();
$InsPersonal = new ClsPersonal();

include($InsProyecto->MtdFormulariosAcc('AlmacenCierre').'AccAlmacenCierreRegistrar.php');

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<!--<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">-->

<div class="EstCapMenu">
<!--<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>
-->
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EXPORTAR STOCK DE ALMACENES</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="hidden" name="Guardar" id="Guardar"   />
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">
                    Instrucciones: <br />
                    - Presione el boton &quot;Generar Excel&quot; para obtener el resumen de stocks de productos en formato excel.</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><input type="button" name="BtnAlmacenCierreGenerarExcel" id="BtnAlmacenCierreGenerarExcel" value="Generar Excel" class="EstFormularioBoton" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><div id="CapAlmacenCierreArchivo"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
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
	
<!--

</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio",// el id del botón que  
	onUpdate : FncEstablecerAlmacenCierreCalculo
	});
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin",// el id del botón que  
	onUpdate : FncEstablecerAlmacenCierreCalculo
	});
</script>-->

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}

?>