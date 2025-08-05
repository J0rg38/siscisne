<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente",$GET_form)){
?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoLlamadaFunciones.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaIngresoLlamada.css');
</style>


<?php
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

 
$GET_FichaIngresoId = $_GET['FinId'];


//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaIngresoLlamada.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsFichaIngresoLlamada.php');

//INSTANCIAS
$InsFichaIngresoLlamada = new ClsFichaIngresoLlamada();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaIngresoLlamadaRegistrar.php');
//DATOS
//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)


?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$("#CmpNumeroDocumento").focus();

//	FncTipoDocumentoEstablecer();
	
});

/*
Configuracion Formulario
*/
</script>



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
        LLAMADA / OT</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
        
        
        
        
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
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><span class="EstFormularioSubTitulo">Datos de la Llamada</span>
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                    <input type="hidden" name="Guardar" id="Guardar"   /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo Interno:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsFichaIngresoLlamada->FllId;?>" size="15" maxlength="20" readonly="readonly" /></td>
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
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Cliente:</td>
                  <td colspan="3" align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsFichaIngresoLlamada->CliNombre;?> <?php echo $InsFichaIngresoLlamada->CliApellidoPaterno;?> <?php echo $InsFichaIngresoLlamada->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFichaIngresoLlamadaFecha" type="text" class="EstFormularioCajaFecha" id="CmpFichaIngresoLlamadaFecha" size="9" maxlength="10" value="<?php echo $Fecha;?>" />
                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFichaIngresoLlamadaFecha" name="BtnFichaIngresoLlamadaFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td align="left" valign="top"><!--Hora:<br />
                    <span class="EstFormularioSubEtiqueta">(00:00)--></span></td>
                  <td align="left" valign="top"><!--<input class="EstFormularioCajaHora" name="CmpHoraProgramada" type="text" id="CmpHoraProgramada" value="<?php  echo $InsCita->CitHoraProgramada;?>" size="15" maxlength="10" />--></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Notas:</td>
                  <td colspan="3" align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsFichaIngresoLlamada->FllObservacion);?></textarea></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
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
	

	
    

</form>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}



//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

