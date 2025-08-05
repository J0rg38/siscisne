<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss('Cuenta');?>CssCuenta.css');
</style>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj('Cuenta').'MsjCuenta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

$InsCuenta = new ClsCuenta();
$InsMoneda = new ClsMoneda();
$InsBanco = new ClsBanco();


include($InsProyecto->MtdFormulariosAcc('Cuenta').'AccCuentaEditar.php');

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsCuenta->CueId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        CUENTA</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCuenta->CueTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCuenta->CueTiempoModificacion;?></span></td>
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
                  <td align="left" valign="top">C&oacute;digo Interno:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCuenta->CueId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNumero" type="text" id="CmpNumero" value="<?php echo $InsCuenta->CueNumero;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">CCI:</td>
                  <td align="left" valign="top"><input name="CmpCCI" type="text" class="EstFormularioCaja" id="CmpCCI" value="<?php echo $InsCuenta->CueCCI;?>" size="40" maxlength="45" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Banco:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpBanco" id="CmpBanco">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrBancos as $DatBanco){
			?>
                    <option value="<?php echo $DatBanco->BanId?>" <?php if($InsCuenta->BanId==$DatBanco->BanId){ echo 'selected="selected"';} ?> ><?php echo $DatBanco->BanNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCuenta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Descripcion:</td>
                  <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="4"><?php echo addslashes($InsCuenta->CueObservacion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top"><?php
			switch($InsCuenta->CueEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                      <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
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
	
	
	
    


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

