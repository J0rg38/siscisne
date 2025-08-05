<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico",$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsInformeTecnicoIT200Funciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssInformeTecnicoIT200.css');
</style>
<?php
$GET_id = $_GET['Id'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjInformeTecnico.php');

require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnico.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsInformeTecnico = new ClsInformeTecnico();
$InsPersonal = new ClsPersonal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccInformeTecnicoEditar.php');

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
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



		
});

/*
Configuracion Formulario
*/

</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsInformeTecnico->IteId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsInformeTecnico->IteId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
          	<?php
			if($PrivilegioEditar and $InsInformeTecnico->IteEstado == 1){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsInformeTecnico->IteId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
              


</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER INFORME TECNICO IT200</span></td>
      </tr>
      <tr>
        <td colspan="2">

<div class="EstFormularioArea">
         
	<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td>Creado el:</td>
			<td><span class="EstFormularioDatoRegistro"><?php echo $InsInformeTecnico->IteTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsInformeTecnico->IteTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>  
                
                 <br />
                 
<ul class="tabs">
	<li><a href="#tab1">Informe Tecnico <span class="EstFormularioTitulo">IT200</span></a></li>


</ul>     

  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     


        
       
        
   
       
       
        
   
        
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
 
        <tr>
          <td valign="top">
          
          
          <div class="EstFormularioArea">
            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td colspan="6"><span class="EstFormularioSubTitulo">Datos del Informe Tecnico <span class="EstFormularioTitulo">IT200</span></span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Codigo de Formato:</td>
                <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoFormato" type="text" class="EstFormularioCaja" id="CmpCodigoFormato" value="IT-200" size="15" maxlength="20" /></td>
                <td align="left" valign="top">No. de Reporte:</td>
                <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsInformeTecnico->IteId;?>" size="15" maxlength="20" /></td>
                <td align="left" valign="top">Propietario:</td>
                <td align="left" valign="top"><input  name="CmpPropietario" type="text"  class="EstFormularioCaja" id="CmpPropietario" value="<?php echo $InsInformeTecnico->ItePropietario;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Fecha de Emision:<br />
                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo ($InsInformeTecnico->IteFecha);?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Fecha de Venta:<br />
                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                <td align="left" valign="top"><input name="CmpFechaVenta" type="text" class="EstFormularioCajaFecha" id="CmpFechaVenta" value="<?php echo $InsInformeTecnico->IteFechaVenta;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Nro. de VIN:</td>
                <td align="left" valign="top"><input  name="CmpVehiculoIngresoVIN" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="<?php echo $InsInformeTecnico->EinVIN;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Tipo y No. de Motor:</td>
                <td align="left" valign="top"><input  name="CmpMotor" type="text"  class="EstFormularioCaja" id="CmpMotor" value="<?php echo $InsInformeTecnico->IteMotor;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">Tipo de Transmision:</td>
                <td align="left" valign="top"><input  name="CmpTipoTransmision" type="text"  class="EstFormularioCaja" id="CmpTipoTransmision" value="<?php echo $InsInformeTecnico->IteTipoTransmision;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Kilometraje:</td>
                <td align="left" valign="top"><input  name="CmpKilometraje" type="text"  class="EstFormularioCaja" id="CmpKilometraje" value="<?php echo $InsInformeTecnico->FinVehiculoKilometraje;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">Tipo de Carroceria:</td>
                <td align="left" valign="top"><input  name="CmpTipoCarroceria" type="text"  class="EstFormularioCaja" id="CmpTipoCarroceria" value="<?php echo $InsInformeTecnico->IteTipoCarroceria;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">Carga/Tara:</td>
                <td align="left" valign="top"><input  name="CmpCarga" type="text"  class="EstFormularioCaja" id="CmpCarga" value="<?php echo $InsInformeTecnico->IteCarga;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Ciudad:</td>
                <td align="left" valign="top"><input  name="CmpCiudad" type="text"  class="EstFormularioCaja" id="CmpCiudad" value="<?php echo $InsInformeTecnico->IteCiudad;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">Departamento:</td>
                <td align="left" valign="top"><input  name="CmpDepartamento" type="text"  class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsInformeTecnico->IteDepartamento;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">Uso del Vehiculo:</td>
                <td align="left" valign="top"><input  name="CmpUsoVehiculo" type="text"  class="EstFormularioCaja" id="CmpUsoVehiculo" value="<?php echo $InsInformeTecnico->IteUsoVehiculo;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Altitud M.S.N.M:</td>
                <td align="left" valign="top"><input  name="CmpAltitud" type="text"  class="EstFormularioCaja" id="CmpAltitud" value="<?php echo $InsInformeTecnico->IteAltitud;?>" size="30" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top">Ord. de Trabajo:</td>
                <td align="left" valign="top"><input readonly="readonly" name="CmpFichaIngresoId" type="text" class="EstFormularioCaja" id="CmpFichaIngresoId" value="<?php echo $InsInformeTecnico->FinId;?>" size="15" maxlength="20" /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">Sintoma</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top"><textarea name="CmpCondicion" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpCondicion"><?php echo stripslashes($InsInformeTecnico->IteCondicion);?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">Diagnostico</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top"><textarea name="CmpCausa" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpCausa"><?php echo stripslashes($InsInformeTecnico->IteCausa);?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">Accion Correctiva</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top"><textarea name="CmpCorreccion" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpCorreccion"><?php echo stripslashes($InsInformeTecnico->IteCorreccion);?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top"> Conclusiones</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top"><textarea name="CmpConclusion" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpConclusion"><?php echo stripslashes($InsInformeTecnico->IteConclusion);?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> </tr>
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

	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
