<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<?php

$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj("NotaDebitoTalonario").'MsjNotaDebitoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');

$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaDebitoTalonarioEditar.php');

$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>



<div class="EstCapMenu">
            <?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsNotaDebitoTalonario->NdtId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  


</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        TALONARIO DE NOTA DE EBITO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaDebitoTalonario->NdtTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaDebitoTalonario->NdtTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>    <br />
        
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
            <td>C&oacute;digo Interno:</td>
            <td><input  readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsNotaDebitoTalonario->NdtId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>N&uacute;mero:</td>
            <td>
            <input value="<?php echo $InsNotaDebitoTalonario->NdtNumero;?>"  class="EstFormularioCaja"  name="CmpNumero" type="text" id="CmpNumero" size="10" maxlength="5" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Inicio:</td>
            <td><input value="<?php echo $InsNotaDebitoTalonario->NdtInicio;?>"  class="EstFormularioCaja"  name="CmpInicio" type="text" id="CmpInicio" size="20" maxlength="20" readonly="readonly" /></td>
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
	
	
	
    



<?php
}else{
echo ERR_GEN_101;
}
?>
