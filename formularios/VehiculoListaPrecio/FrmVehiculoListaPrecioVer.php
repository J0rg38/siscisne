<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoListaPrecioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoListaPrecio.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoListaPrecio.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCIAS
$InsVehiculoListaPrecio = new ClsVehiculoListaPrecio();
$InsVehiculMarca = new ClsVehiculoMarca();

$InsMoneda = new ClsMoneda();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoListaPrecioEditar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript" >

/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
var VehiculoMarcaHabilitado = 1;
var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;

var VehiculoListaPrecioDetalleEditar = 1;
var VehiculoListaPrecioDetalleEliminar = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

$().ready(function() {
	FncVehiculoListaPrecioDetalleListar();
});

</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoListaPrecio->VlpId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
            
            
            




</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER LISTA DE PRECIO DE VEHICULO</span></td>
      </tr>
      <tr>
        <td>
        
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoListaPrecio->VlpTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoListaPrecio->VlpTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>
        
        
                                <br />



 		
<ul class="tabs">
    <li><a href="#tab1"> Lista de Precio</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

    
         <table border="0" cellpadding="2" cellspacing="2">
           <tr>
             <td valign="top"><div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Lista de Precio	del	Vehiculo </span>
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoListaPrecio->VlpId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Lista Dealer No.:</td>
            <td><label for="CmpCodigo"></label>
              <input name="CmpCodigo" type="text" class="EstFormularioCaja" id="CmpCodigo" value="<?php echo $InsVehiculoListaPrecio->VlpCodigo;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha Registro:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $InsVehiculoListaPrecio->VlpFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha (Vigencia):<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFechaVigencia" type="text" class="EstFormularioCajaFecha" id="CmpFechaVigencia" value="<?php echo $InsVehiculoListaPrecio->VlpFechaVigencia;?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                  <option value="">Escoja una opcion</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoListaPrecio->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                  </select></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
            </table></td>
            <td align="left" valign="top">Tipo de Cambio:<br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVehiculoListaPrecioDetalleListar();" value="<?php if (empty($InsVehiculoListaPrecio->VlpTipoCambio)){ echo "";}else{ echo $InsVehiculoListaPrecio->VlpTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                <td><a href="javascript:FncVehiculoListaPrecioEstablecerMoneda();"></a></td>
                </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:</td>
            <td valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoListaPrecio->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td valign="top">Año Fabricacion:</td>
            <td><input name="CmpAnoFabricacion" type="text" class="EstFormularioCaja" id="CmpAnoFabricacion" value="<?php echo $InsVehiculoListaPrecio->VlpAnoFabricacion;?>" size="10" maxlength="4" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Observacion:</td>
            <td valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo addslashes($InsVehiculoListaPrecio->VlpObservacion);?></textarea></td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
			switch($InsVehiculoListaPrecio->VlpEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select  disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
                </select></td>
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
          </tr>
        </table>
        
        </div></td>
           </tr>
           <tr>
             <td valign="top"><div class="EstFormularioArea" >
               <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                 <tr>
                   <td>&nbsp;</td>
                   <td colspan="2"><span class="EstFormularioSubTitulo"> DETALLE DE LA LISTA DE PRECIO DE VEHICULOS </span></td>
                   <td>&nbsp;</td>
                   </tr>
                 <tr>
                   <td width="1%">&nbsp;</td>
                   <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                     para registrar elementos</div></td>
                   <td width="49%" align="right"><a href="javascript:FncVehiculoListaPrecioDetalleListar();"> <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoListaPrecioDetalleEliminarTodo();"></a></td>
                   <td width="1%"><div id="CapVehiculoListaPrecioDetallesResultado"> </div></td>
                   </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td colspan="2"><div id="CapVehiculoListaPrecioDetalles" class="EstCapVehiculoListaPrecioDetalles" > </div></td>
                   <td>&nbsp;</td>
                   </tr>
                 </table>
               </div></td>
           </tr>
           <tr>
             <td valign="top">
               
               </td>
           </tr>
		   
		   
		   </table>
		   

        
        
        
   	

           </div>
	   


           
           
</div>      
               
             
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
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
