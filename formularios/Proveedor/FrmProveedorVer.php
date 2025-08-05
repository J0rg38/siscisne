<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
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
//VARIABLES
$GET_id = $_GET['Id'];
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

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProveedor->PrvId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
                  <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProveedor->PrvId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Contacto 1</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Documento:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
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
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input   name="CmpContactoNombre1" type="text" class="EstFormularioCaja" id="CmpContactoNombre1" value="<?php echo $InsProveedor->PrvContactoNombre1;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero de Documento:</td>
                  <td align="left" valign="top"><input  name="CmpNumeroDocumento" type="text"  class="EstFormularioCaja" id="CmpNumeroDocumento" value="<?php echo $InsProveedor->PrvNumeroDocumento;?>" size="40" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input   name="CmpContactoCelular1" type="text" class="EstFormularioCaja" id="CmpContactoCelular1" value="<?php echo $InsProveedor->PrvContactoCelular1;?>" size="40" maxlength="45" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre o Razon Social:</td>
                  <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProveedor->PrvNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpContactoEmail1" type="text" class="EstFormularioCaja" id="CmpContactoEmail1" value="<?php echo $InsProveedor->PrvContactoEmail1;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Paterno:</td>
                  <td align="left" valign="top"><input name="CmpApellidoPaterno" type="text" class="EstFormularioCaja" id="CmpApellidoPaterno" value="<?php echo $InsProveedor->PrvApellidoPaterno;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Materno:</td>
                  <td align="left" valign="top"><input name="CmpApellidoMaterno" type="text" class="EstFormularioCaja" id="CmpApellidoMaterno" value="<?php echo $InsProveedor->PrvApellidoMaterno;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Contacto 2</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha Nac.:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input  name="CmpFechaNacimiento" type="text" class="EstFormularioCajaFecha" id="CmpFechaNacimiento" value="<?php if(!empty($InsProveedor->PrvFechaNacimiento)){ echo $InsProveedor->PrvFechaNacimiento;}?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input   name="CmpContactoNombre2" type="text" class="EstFormularioCaja" id="CmpContactoNombre2" value="<?php echo $InsProveedor->PrvContactoNombre2;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Direccion:</td>
                  <td align="left" valign="top"><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsProveedor->PrvDireccion;?>" size="40" maxlength="200" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input   name="CmpContactoCelular2" type="text" class="EstFormularioCaja" id="CmpContactoCelular2" value="<?php echo $InsProveedor->PrvContactoCelular2;?>" size="40" maxlength="45" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Departamento:</td>
                  <td align="left" valign="top"><input name="CmpDepartamentoId" type="hidden"  id="CmpDepartamentoId" value="<?php echo $InsProveedor->PrvDepartamento;?>" size="20" maxlength="10" readonly="readonly" />
                    <select disabled="disabled" class="EstFormularioCombo" id="CmpDepartamento" name="CmpDepartamento">
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpContactoEmail2" type="text" class="EstFormularioCaja" id="CmpContactoEmail2" value="<?php echo $InsProveedor->PrvContactoEmail2;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Provincia:</td>
                  <td align="left" valign="top"><input name="CmpProvinciaId" type="hidden"  id="CmpProvinciaId" value="<?php echo $InsProveedor->PrvProvincia;?>" size="20" maxlength="10" readonly="readonly" />
                    <select  disabled="disabled" class="EstFormularioCombo" id="CmpProvincia" name="CmpProvincia">
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
                    <select  disabled="disabled" class="EstFormularioCombo" id="CmpDistrito" name="CmpDistrito">
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Contacto 3</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Pais:</td>
                  <td align="left" valign="top"><input  name="CmpPais" type="text"  class="EstFormularioCaja" id="CmpPais" value="<?php echo $InsProveedor->PrvPais;?>" size="40" maxlength="200" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input   name="CmpContactoNombre3" type="text" class="EstFormularioCaja" id="CmpContactoNombre3" value="<?php echo $InsProveedor->PrvContactoNombre3;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tel&eacute;fono:</td>
                  <td align="left" valign="top"><input  name="CmpTelefono" type="text"  class="EstFormularioCaja" id="CmpTelefono" value="<?php echo $InsProveedor->PrvTelefono;?>" size="40" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input   name="CmpContactoCelular3" type="text" class="EstFormularioCaja" id="CmpContactoCelular3" value="<?php echo $InsProveedor->PrvContactoCelular3;?>" size="40" maxlength="45" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input  name="CmpCelular" type="text"  class="EstFormularioCaja" id="CmpCelular" value="<?php echo $InsProveedor->PrvCelular;?>" size="40" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpContactoEmail3" type="text" class="EstFormularioCaja" id="CmpContactoEmail3" value="<?php echo $InsProveedor->PrvContactoEmail3;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpEmail" type="text" class="EstFormularioCaja" id="CmpEmail" value="<?php echo $InsProveedor->PrvEmail;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top"><?php
			switch($InsProveedor->PrvEstado){
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
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
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
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

}else{
	echo ERR_GEN_101;
}
?>