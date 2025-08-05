<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDepartamentoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsProvinciaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDistritoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProveedor.css');
</style>

<?php
$Edito = false;

//VARIABLES
$GET_id = $_GET['Id'];
$GET_Tipo = $_GET['Tipo'];
$GET_Ruta = $_GET['Ruta'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProveedor.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCIAS
$InsProveedor = new ClsProveedor();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProveedorEditar.php');
//DATOS
$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

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

	$("#CmpNumeroDocumento").focus();

	
	FncDepartamentosCargar()
	
});

/*
Configuracion Formulario
*/

</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>','<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;&nbsp;
<?php	
}
?>

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        PROVEEDOR</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedor->PrvTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedor->PrvTiempoModificacion;?></span></td>
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
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>C&oacute;digo:</td>
                  <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProveedor->PrvId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFormularioSubTitulo">Contacto 1</span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Tipo de Documento:</td>
                  <td><select class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsProveedor->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoNombre1" type="text" id="CmpContactoNombre1" value="<?php echo $InsProveedor->PrvContactoNombre1;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Numero de Documento:</td>
                  <td><input value="<?php echo $InsProveedor->PrvNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" /></td>
                  <td>&nbsp;</td>
                  <td>Celular:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoCelular1" type="text" id="CmpContactoCelular1" value="<?php echo $InsProveedor->PrvContactoCelular1;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Nombre o Razon Social:</td>
                  <td><input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsProveedor->PrvNombre;?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                  <td>Email:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoEmail1" type="text" id="CmpContactoEmail1" value="<?php echo $InsProveedor->PrvContactoEmail1;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Paterno:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" value="<?php echo $InsProveedor->PrvApellidoPaterno;?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Materno:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" value="<?php echo $InsProveedor->PrvApellidoMaterno;?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFormularioSubTitulo">Contacto 2</span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha Nac.:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input class="EstFormularioCajaFecha"  name="CmpFechaNacimiento" type="text" id="CmpFechaNacimiento" value="<?php if(!empty($InsProveedor->PrvFechaNacimiento)){ echo $InsProveedor->PrvFechaNacimiento;}?>" size="15" maxlength="10" />                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaNacimiento" name="BtnFechaNacimiento" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoNombre2" type="text" id="CmpContactoNombre2" value="<?php echo $InsProveedor->PrvContactoNombre2;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Direccion:</td>
                  <td><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsProveedor->PrvDireccion;?>" size="40" maxlength="200" /></td>
                  <td>&nbsp;</td>
                  <td>Celular:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoCelular2" type="text" id="CmpContactoCelular2" value="<?php echo $InsProveedor->PrvContactoCelular2;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Departamento:</td>
                  <td align="left" valign="top"><input name="CmpDepartamentoId" type="hidden"  id="CmpDepartamentoId" value="<?php echo $InsProveedor->PrvDepartamento;?>" size="20" maxlength="10" readonly="readonly" />
                    <select class="EstFormularioCombo" id="CmpDepartamento" name="CmpDepartamento">
                    </select></td>
                  <td>&nbsp;</td>
                  <td>Email:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoEmail2" type="text" id="CmpContactoEmail2" value="<?php echo $InsProveedor->PrvContactoEmail2;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Provincia:</td>
                  <td align="left" valign="top"><input name="CmpProvinciaId" type="hidden"  id="CmpProvinciaId" value="<?php echo $InsProveedor->PrvProvincia;?>" size="20" maxlength="10" readonly="readonly" />
                    <select class="EstFormularioCombo" id="CmpProvincia" name="CmpProvincia">
                    </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Distrito:</td>
                  <td align="left" valign="top"><input name="CmpDistritoId" type="hidden"  id="CmpDistritoId" value="<?php echo $InsProveedor->PrvDistrito;?>" size="20" maxlength="10" readonly="readonly" />
                    <select class="EstFormularioCombo" id="CmpDistrito" name="CmpDistrito">
                    </select></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFormularioSubTitulo">Contacto 3</span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Pais:</td>
                  <td align="left" valign="top"><input  name="CmpPais" type="text"  class="EstFormularioCaja" id="CmpPais" value="<?php echo $InsProveedor->PrvPais;?>" size="40" maxlength="200" /></td>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoNombre3" type="text" id="CmpContactoNombre3" value="<?php echo $InsProveedor->PrvContactoNombre3;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Tel&eacute;fono:</td>
                  <td><input value="<?php echo $InsProveedor->PrvTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" /></td>
                  <td>&nbsp;</td>
                  <td>Celular:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoCelular3" type="text" id="CmpContactoCelular3" value="<?php echo $InsProveedor->PrvContactoCelular3;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Celular:</td>
                  <td><input value="<?php echo $InsProveedor->PrvCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" /></td>
                  <td>&nbsp;</td>
                  <td>Email:</td>
                  <td><input class="EstFormularioCaja"   name="CmpContactoEmail3" type="text" id="CmpContactoEmail3" value="<?php echo $InsProveedor->PrvContactoEmail3;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsProveedor->PrvEmail;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Estado:</td>
                  <td><?php
			switch($InsProveedor->PrvEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
                    <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                      <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
                      </select></td>
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
    </table>
</div>
	
	
	
    

</form>

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaNacimiento",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaNacimiento"// el id del botón que  
	});
</script>
<?php

}else{
	echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

