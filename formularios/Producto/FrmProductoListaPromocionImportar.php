<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR ARCHIVOS DE LISTA DE PROMOCION DE REPUESTOS</span></td>
      </tr>
      <tr>
        <td>
        
        
                                <br />
   
        
        
     

      
    
		
		
		 <div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Importar</span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
              
  <div class="EstNotasTitulo">Descripcion:</div>
  <div class="EstNotas">
    - Este modulo sirve para poder actualizar en listado de promocion de repuestos.</div>
              
  <br /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">

				<iframe src="formularios/Producto/acc/AccProductoListaPromocionImportar.php" id="IfrProductoListaPromocionImportar" name="IfrProductoListaPromocionImportar" scrolling="Auto"  frameborder="0" width="600" height="500"></iframe>

              </td>
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
        <td align="center">&nbsp;</td>
      </tr>
    </table>
    
</div>
<?php
}else{
echo ERR_GEN_101;
}
?>
