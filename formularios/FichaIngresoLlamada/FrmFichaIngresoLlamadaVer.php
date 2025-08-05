<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCliente.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaIngresoLlamada.php');

//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsFichaIngresoLlamada.php');

//INSTANCIAS
$InsFichaIngresoLlamada = new ClsFichaIngresoLlamada();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaIngresoLlamadaEditar.php');
//DATOS
 
?>
<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	//FncTipoDocumentoEstablecer();
	
	//FncClienteEstablecerMoneda();
	
});

/*
Configuracion Formulario
*/
</script>

<title>500</title>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsCliente->CliId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        LLAMADA / OT</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCliente->CliTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCliente->CliTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
         <br />
    
    
   <ul class="tabs">
    <li><a href="#tab1">Llamada</a></li>
    
   
</ul> 
    
    
<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
        

    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Llamada</span>                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                  
                     <input type="hidden" name="CmpClienteUso" id="CmpClienteUso"  value="<?php echo $InsCliente->CliUso;?>" />
                    <input name="CmpClienteBloquear" type="hidden" id="CmpClienteBloquear" value="<?php echo $InsCliente->CliBloquear;?>" size="15" maxlength="20" readonly="readonly" />
                    
                    
                    </td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCliente->CliId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Orden de Trabajo:</td>
                  <td align="left" valign="top"><input  name="CmpFichaIngresoId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId" value="<?php echo $InsFichaIngresoLlamada->FinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td align="left" valign="top">Fecha de O.T.:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFichaIngresoFecha" type="text" class="EstFormularioCajaFecha" id="CmpFichaIngresoFecha" value="<?php  echo $InsFichaIngresoLlamada->FinFecha; ?>" size="10" maxlength="10" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Cliente:</td>
                  <td colspan="3" align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsFichaIngresoLlamada->CliNombre;?> <?php echo $InsFichaIngresoLlamada->CliApellidoPaterno;?> <?php echo $InsFichaIngresoLlamada->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $InsFichaIngresoLlamada->FllFecha;?>" size="9" maxlength="10" readonly="readonly" />
                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td align="left" valign="top"><!--Hora:<br />
                    <span class="EstFormularioSubEtiqueta">(00:00)-->
                    </span></td>
                  <td align="left" valign="top"><!--<input class="EstFormularioCajaHora" name="CmpHoraProgramada" type="text" id="CmpHoraProgramada" value="<?php  echo $InsCita->CitHoraProgramada;?>" size="15" maxlength="10" />--></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Notas:</td>
                  <td colspan="3" align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsFichaIngresoLlamada->FllObservacion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
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
	
	
	
    

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});

</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
