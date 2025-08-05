<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoConsulta.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>

<?php
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
    
    <span class="EstFormularioTitulo">CONSULTA DE VIN/PLACA </span>  </td>
  <td width="2%"><a href="formularios/VehiculoIngreso/inf/InfVehiculoIngresoConsulta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
   <!-- <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>VehiculoIngreso/IfrVehiculoIngresoConsulta.php" target="IfrVehiculoIngresoConsulta" method="post" name="FrmVehiculoIngresoConsulta" id="FrmVehiculoIngresoConsulta">
     --> 
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de FIltro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>VIN: </td>
                <td>
                  <a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                  
                  
                  </td>
                <td><input  name="CmpVehiculoIngresoId" type="hidden"  id="CmpVehiculoIngresoId" value="" size="10" maxlength="10"/>
                  <input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" size="25" maxlength="50" /></td>
                <td>Placa:</td>
                <td><a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td>
                
                
                <input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="" size="20" maxlength="50"  />
                
                
                  
                  </td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/nicono/ver.png" alt="[Ver]" title="Ver" height="45" width="45" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
          </table>
      <!--</form> -->   </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
 <!-- <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>VehiculoIngreso/IfrVehiculoIngresoConsulta.php" target="IfrVehiculoIngresoConsulta" id="IfrVehiculoIngresoConsulta" name="IfrVehiculoIngresoConsulta" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>
  -->
  <div id="CapVehiculoIngresoConsulta"></div>
  </td>
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

