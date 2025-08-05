<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR BACK ORDER DE REPUESTOS</span></td>
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
    - Este modulo sirve para registrar el back order de la llegada de repuestos.<br />
	- Para ver el resultado haga click aqui <a  target="_blank" href="principal.php?Mod=Reporte&Form=OrdenCompraBackOrder">Reporte Back Order</a>
    
</div>
              
  <br /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">

				<iframe src="formularios/OrdenCompra/acc/AccOrdenCompraImportarBO.php" id="IfrOrdenCompraImportarBO" name="IfrOrdenCompraImportarBO" scrolling="Auto"  frameborder="0" width="800" height="500"></iframe>

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
