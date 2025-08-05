<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Importar")){
?>

<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR BASE DE DATOS DE CLIENTES - LEAD</span></td>
      </tr>
      <tr>
        <td>
        
        
                                <br />
   
        
        
     

      
    
		
		
		 <div class="EstFormularioArea" >
		<table class="EstFormulario" width="594" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="5">&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Importar</span></td>
            <td width="15">&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="3">

<div class="EstNotasTitulo">Descripcion:</div>
<div class="EstNotas">
- Este modulo sirve para poder cargar los datos de clientes en forma masiva a traves de un archivo de excel.
</div>

<br />

<div class="EstNotasTitulo">Notas:</div>
<div class="EstNotas">
- Para actualizar los datos de productos desde excel debera completar el siguiente formato, respetando el orden de las columnas<br />
- Solo se permite archivos excel con extension ".xlsx"<br />

- Formato: <a href="descargas/FormatoClienteImportarLead.xlsx">Descargar</a>
</div>


            
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">

		<iframe src="<?php echo $InsProyecto->MtdFormulariosAcc($GET_mod)?>AccClienteImportarLead.php" id="IfrClienteImportar" name="IfrClienteImportar" scrolling="Auto"  frameborder="0" width="800" height="500"></iframe>
              
              
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="97">&nbsp;</td>
            <td width="451">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
		
		
   
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
?>
