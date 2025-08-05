<?php
   if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
   ?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsListaPrecio.js" ></script>
<?php
   /* 
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
   
   /**
    *
    * @author Ing. Jonathan Blanco Alave
    */
   
   $POST_cam = ($_POST['Cam']);
   $POST_fil = ($_POST['Fil']);

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }

	
   
  
   

   $POST_ord = ($_POST['Ord']);
   $POST_sen = ($_POST['Sen']);
   $POST_pag = ($_POST['Pag']);
   $POST_p = ($_POST['P']);
   $POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

   $POST_seleccionados = $_POST['cmp_seleccionados'];
   $POST_acc = $_POST['Acc'];
   
   //Nuevo
   $POST_ProductoTipo = $_POST['CmpProductoTipo'];
   $POST_ClienteTipo = $_POST['CmpClienteTipo'];
   $POST_UnidadMedida = $_POST['CmpUnidadMedida'];
   
   $POST_con = $_POST['Con'];
   $POST_est = $_POST['Est'];
   
   if(empty($POST_p)){
   	$POST_p = '1';
   }
   
   if(empty($POST_num)){
   	$POST_num = '10';
   }
   if(empty($POST_ord)){
   	$POST_ord = 'ProTiempoModificacion';
   }
   
   if(empty($POST_sen)){
   	$POST_sen = 'DESC';
   }
   
   if(empty($POST_pag)){
   	$POST_pag = '0,'.$POST_num;
   }
   
   if(empty($POST_cam)){
   	$POST_cam = "ProNombre";
   }
   
   // Variables Extra
   
   if(empty($POST_con)){
   	$POST_con = "contiene";
   }
   
   $MargenUtilidad = 0;
   
   //include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProducto.php');
   
   require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');   require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
   require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
   require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
   //require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
   require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
   
//   require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
	require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
   
   
   $InsProducto = new ClsProducto();
   $InsProductoTipo = new ClsProductoTipo();
   $InsListaPrecio = new ClsListaPrecio();
   
   $InsClienteTipo = new ClsClienteTipo();
   
//   $InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
   $InsUnidadMedida = new ClsUnidadMedida();
   
   //include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccListaPrecio.php');
   
   
   $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal,ProCodigoAlternativo,ProNombre,ProId,RtiNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,$POST_ProductoTipo,NULL);
   $ArrProductos = $ResProducto['Datos'];
   $ProductosTotal = $ResProducto['Total'];
   $ProductosTotalSeleccionado = $ResProducto['TotalSeleccionado'];
   
   $RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
   $ArrProductoTipos = $RepProductoTipo['Datos'];
   
//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];
   
   
    //
//	$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,'UmeId','ASC',NULL,2) ;
	$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,'UmeId','ASC',NULL) ;
	$ArrUnidadMedidas = $ResUnidadMedida['Datos'];
	
//   $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,NULL);
//   $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
   
   if(!empty($POST_ClienteTipo)){
	   	$InsClienteTipo->LtiId = $POST_ClienteTipo;
	   	$InsClienteTipo->MtdObtenerClienteTipo();
   	//$MargenUtilidad = $InsClienteTipo->LtiUtilidad;
   }else{
   	//$MargenUtilidad = 0;	
   }

   if(!empty($POST_UnidadMedida)){
	   $InsUnidadMedida->UmeId = $POST_UnidadMedida;
	   $InsUnidadMedida->MtdObtenerUnidadMedida();	   
   }

   //deb($InsClienteTipo);
   //$InsMensaje->MenResultado = $Resultado;
   //$InsMensaje->MtdImprimirResultado();
   
   /*
    * interface FrmProductoListado {
       //put your code here  
   }
   */
   
   
   ?>
<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >
   <div class="EstCapMenu">
   
   
   
      <?php
         /*  if($PrivilegioGenerarExcel){
         ?>
      <div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div>
      <?php	  
         }*/
         ?>
      <?php
         /*if($PrivilegioImprimir){
         ?>
      <div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/submenu/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
      <?php
         }
         ?>
      <?php
         if($PrivilegioEliminar){
         ?>
      <div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div>
      <?php
         }*/
         ?>
   </div>
   <div class="EstCapContenido">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
         <tr>
            <td height="25"><span class="EstFormularioTitulo">LISTA DE PRECIOS</span></td>
         </tr>
         <tr>
            <td>
               Mostrando <b><?php echo $ProductosTotalSeleccionado;?></b> de <b><?php echo $ProductosTotal;?></b> registros.
            </td>
         </tr>
         <tr>
            <td align="right">
               <input type="hidden" name="CmpCategoria" id="CmpCategoria" value="" />
               <input type="hidden" name="Acc" id="Acc" value="" />
               <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
               <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
               <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
               <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
               <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
                 <span class="EstFormularioEtiqueta">Buscar:</span>

 <span class="EstFormularioContenido">  
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    </span>
    
               <select class="EstFormularioCombo" name="Con" id="Con">
                  <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
                  <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
                  <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
                  <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
                  <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
                  <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
               </select>
               <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
                  <option value="ProId" <?php if($POST_cam=="ProId"){ echo 'selected="selected"';}?>>Id</option>
                  <option value="ProCodigoAlternativo" <?php if($POST_cam=="ProCodigoAlternativo"){ echo 'selected="selected"';}?>>Cod. Alternativo</option>
                  <option value="ProCodigoOriginal" <?php if($POST_cam=="ProCodigoOriginal"){ echo 'selected="selected"';}?>>Cod. Original</option>
                  <option value="ProNombre" <?php if($POST_cam=="ProNombre"){ echo 'selected="selected"';}?>>Nombre</option>
                  
                  </select>-->
               Tipo de Producto:
               <select class="EstFormularioCombo" name="CmpProductoTipo" id="CmpProductoTipo">
                  <option value="">Todos</option>
                  <?php
                     foreach($ArrProductoTipos as $DatProductoTipo){
                     ?>
                  <option <?php echo $DatProductoTipo->RtiId;?> <?php echo ($DatProductoTipo->RtiId==$POST_ProductoTipo)?'selected="selected"':"";?> value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
                  <?php
                     }
                     ?>
               </select>
               Tipo de Cliente:
               <select class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                  <option value="">Escoja una opcion</option>
                  <?php
                     foreach($ArrClienteTipos as $DatTipoCliente){
                     ?>
                  <option <?php echo $DatTipoCliente->LtiId;?> <?php echo ($DatTipoCliente->LtiId==$POST_ClienteTipo)?'selected="selected"':"";?> value="<?php echo $DatTipoCliente->LtiId?>"><?php echo $DatTipoCliente->LtiNombre;?></option>
                  <?php
                     }
                     ?>
               </select>
               Und. de Med.:
               <select class="EstFormularioCombo" name="CmpUnidadMedida" id="CmpUnidadMedida">
                  <option value="">Escoja una opcion</option>
                  <?php
                     foreach($ArrUnidadMedidas as $DatUnidadMedida){
                     ?>
                  <option <?php echo ($DatUnidadMedida->UmeId==$POST_UnidadMedida)?'selected="selected"':"";?> value="<?php echo $DatUnidadMedida->UmeId;?>"><?php echo $DatUnidadMedida->UmeNombre;?> [<?php echo $DatUnidadMedida->UmeAbreviacion?>]</option>
                  <?php
                     }
                     ?>
               </select>
               Estado:
               <select class="EstFormularioCombo" name="Est" id="Est">
                  <option <?php if($POST_est==""){ echo 'selected="selected"';}?> value="">Todos</option>
                  <option <?php if($POST_est=="1"){ echo 'selected="selected"';}?> value="1">En actividad</option>
                  <option <?php if($POST_est=="2"){ echo 'selected="selected"';}?> value="2">Sin actividad</option>
               </select>
               <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" />
            </td>
         </tr>
         <tr>
            <td width="87%" valign="top">
               <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
                  <thead class="EstTablaListadoHead">
                     <tr>
                        <th width="1%" rowspan="2" >#</th>
                        <th width="2%" rowspan="2" >
                           <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				
                        </th>
                        <th width="2%" rowspan="2" ><?php
                           if($POST_ord == "ProId"){
                           	if($POST_sen == "DESC"){
                           ?>
                           <a href="javascript:FncOrdenar('ProId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('ProId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                           <?php
                              }
                              }else{
                              
                              ?>
                           <a href="javascript:FncOrdenar('ProId','ASC');"> Id.  </a>
                           <?php
                              }
                              ?>
                        </th>
                        <th width="4%" rowspan="2" ><?php
                           if($POST_ord == "RtiNombre"){
                           	if($POST_sen == "DESC"){
                           ?>
                           <a href="javascript:FncOrdenar('RtiNombre','ASC');"> Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('RtiNombre','DESC');"> Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                           <?php
                              }
                              }else{
                              
                              
                              ?>
                           <a href="javascript:FncOrdenar('RtiNombre','ASC');"> Tipo </a>
                           <?php
                              }
                              ?>
                        </th>
                        <th width="6%" rowspan="2" ><?php
                           if($POST_ord == "ProCodigoOriginal"){
                           	if($POST_sen == "DESC"){
                           ?>
                           <a href="javascript:FncOrdenar('ProCodigoOriginal','ASC');"> Cod. Orig. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('ProCodigoOriginal','DESC');"> Cod. Orig. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                           <?php
                              }
                              }else{
                              
                              
                              ?>
                           <a href="javascript:FncOrdenar('ProCodigoOriginal','ASC');"> Cod. Orig. </a>
                           <?php
                              }
                              ?>
                        </th>
                        <th width="7%" rowspan="2" ><?php
                           if($POST_ord == "ProCodigoAlternativo"){
                           	if($POST_sen == "DESC"){
                           ?>
                          <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alt. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                          <?php
                              }else{
                              ?>
                          <a href="javascript:FncOrdenar('ProCodigoAlternativo','DESC');"> Cod. Alt. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                          <?php
                              }
                              }else{
                              
                              
                              ?>
                          <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alt. </a>
                          <?php
                              }
                              ?>
                        </th>
                        <th width="29%" rowspan="2" >
                           <?php
                              if($POST_ord == "ProNombre"){
                              	if($POST_sen == "DESC"){
                              ?>
                           <a href="javascript:FncOrdenar('ProNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('ProNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                           <?php
                              }
                              }else{
                              
                              
                              ?>
                           <a href="javascript:FncOrdenar('ProNombre','ASC');"> Nombre  </a>
                           <?php
                              }
                              ?>		
                        </th>
                        <th width="7%" rowspan="2" ><?php
                              if($POST_ord == "ProReferencia"){
                              	if($POST_sen == "DESC"){
                              ?>
                          <a href="javascript:FncOrdenar('ProReferencia','ASC');"> Referencia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                          <?php
                              }else{
                              ?>
                          <a href="javascript:FncOrdenar('ProReferencia','DESC');"> Referencia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                          <?php
                              }
                              }else{
                              
                              
                              ?>
                          <a href="javascript:FncOrdenar('ProReferencia','ASC');"> Referencia </a>
                        <?php
                              }
                              ?></th>
                        <th width="6%" rowspan="2" ><?php
                           if($POST_ord == "ProCosto"){
                           	if($POST_sen == "DESC"){
                           ?>
                           <a href="javascript:FncOrdenar('ProCosto','ASC');"> Costo  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('ProCosto','DESC');"> Costo  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                           <?php
                              }
                              }else{
                              
                              
                              ?>
                           <a href="javascript:FncOrdenar('ProCosto','ASC');"> Costo  </a>
                           <?php
                              }
                              ?>
                        </th>
                        <th colspan="3" >
                           <?php
                              if(!empty($InsClienteTipo->LtiId)){
                              ?>
                           <?php echo $InsClienteTipo->LtiNombre;?>
                           <?php	
                              }else{
                              ?>
                           [Escoja un tipo de cliente]
                           <?php	
                              }		
                              ?>		
                        </th>
                        <th width="9%" rowspan="2" ><?php
                           if($POST_ord == "UmeNombre"){
                           	if($POST_sen == "DESC"){
                           ?>
                           <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M.<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('UmeNombre','DESC');"> U.M.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                           <?php
                              }
                              }else{
                              
                              
                              ?>
                           <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M. </a>
                           <?php
                              }
                              ?>
                        </th>
                        <th width="3%" rowspan="2" ><?php
                           if($POST_ord == "ProEstado"){
                           	if($POST_sen == "DESC"){
                           ?>
                           <a href="javascript:FncOrdenar('ProEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                           <?php
                              }else{
                              ?>
                           <a href="javascript:FncOrdenar('ProEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                           <?php
                              }
                              }else{
                              
                              
                              ?>
                           <a href="javascript:FncOrdenar('ProEstado','ASC');"> Est. </a>
                           <?php
                              }
                              ?>
                        </th>
                        <th width="6%" rowspan="2" >Acciones</th>
                     </tr>
                     <tr>
                        <th width="5%" >% UTIL.</th>
                        <th width="7%" >VALOR VENTA</th>
                        <th width="6%" >PRECIO VENTA</th>
                     </tr>
                  </thead>
                  <tfoot class="EstTablaListadoFoot">
                     <tr>
                        <td colspan="15" align="center">
                           Mostrar de
                           <select class="EstFormularioCombo" onChange="javascript:FncListar(this.value);" name="Num" id="Num">
                              <option <?php if($POST_num=="5"){ echo 'selected="selected"';}?> value="5">5</option>
                              <option <?php if($POST_num=="10"){ echo 'selected="selected"';}?> value="10">10</option>
                              <option <?php if($POST_num=="15"){ echo 'selected="selected"';}?> value="15">15</option>
                              <option <?php if($POST_num=="20"){ echo 'selected="selected"';}?> value="20">20</option>
                              <option <?php if($POST_num=="25"){ echo 'selected="selected"';}?> value="25">25</option>
                              <option <?php if($POST_num=="30"){ echo 'selected="selected"';}?> value="30">30</option>
                              <option <?php if($POST_num=="50"){ echo 'selected="selected"';}?> value="50">50</option>
                              <option <?php if($POST_num=="100"){ echo 'selected="selected"';}?> value="100">100</option>
                              <option <?php if($POST_num==$ProductosTotal){ echo 'selected="selected"';}?> value="<?php echo $ProductosTotal;?>">Todos</option>
                           </select>
                           <?php
                              $numxpag = $POST_num;
                              
                              //if(empty($POST_fil)){
                              	$tregistros = $ProductosTotal;
                              //}else{
                              //	$tregistros = ($ProductosTotalSeleccionado);
                              //}
                              
                              $cant_paginas=ceil($tregistros/$numxpag);
                              ?>
                           <?php
                              if($POST_p<>"1"){
                              ?>
                           <a class="EstPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag;?>','1');">
                           Inicio					</a>
                           <?php
                              }
                              ?>
                           &nbsp;
                           <?php
                              if($POST_p<=$cant_paginas & $POST_p<>"1"){
                              
                              $pagina = explode(",",$POST_pag);
                              
                              ?>
                           <a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]-$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p-1)?>');">Anterior</a>
                           <?php
                              }
                              ?>
                           &nbsp;
                           <?php
                              $xpag =10;
                              
                              $inicio = 0;
                              $fin = 0;
                              
                              if($POST_p-$xpag>0){
                              	$inicio = $POST_p-$xpag;
                              }else{
                              	$inicio = $POST_p-($POST_p-$xpag*-1);
                              }
                              
                              if($POST_p+$xpag<$cant_paginas){
                              	$fin = $POST_p+$xpag;
                              }else{
                              	$fin = $POST_p+($POST_p-$xpag*-1);
                              }
                              ?>
                           <?php
                              $num = 0;
                              
                              for($i=1;$i<=$cant_paginas;$i++){
                              ?>
                           <?php
                              if($i>=$inicio and $i<=$fin){
                              ?>	
                           <?php
                              if($POST_p==$i){
                              ?>
                           <span class="EstPaginaActual"><?php echo $i;?></span>
                           <?php	
                              }else{
                              ?>
                           <a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo $num?>,<?php echo $numxpag;?>','<?php echo $i?>');" ><?php echo $i?></a>                        
                           <?php	
                              }
                              ?>
                           <?php
                              }
                              ?>
                           <?php
                              $num = $num + $numxpag ;
                              }
                              ?>
                           &nbsp;
                           <?php
                              if($POST_p<$cant_paginas){
                              	$pagina = explode(",",$POST_pag);
                              ?>
                           <a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]+$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p+1)?>');">Siguiente</a>
                           <?php
                              }
                              ?>
                           &nbsp;
                           <?php
                              if($POST_p<>$cant_paginas){
                              ?>
                           <a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Final</a>
                           <?php
                              }
                              ?>
                           &nbsp;
                           Pagina <?php echo $POST_p;?> de <?php echo $cant_paginas;?>                    
                        </td>
                     </tr>
                  </tfoot>
                  <tbody class="EstTablaListadoBody">
                     <?php
                        $pagina = explode(",",$POST_pag);
                        $f=$pagina[0]+1;
                        
                        foreach($ArrProductos as $dat){
                        
                        ?>
                     <tr id="Fila_<?php echo $f;?>">
                        <td width="1%" align="center"  ><?php echo $f;?></td>
                        <td width="2%" align="center"  >
                           <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->ProId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->ProId; ?>" />				
                        </td>
                        <td align="right" valign="middle" width="2%"   >
						
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ProId;?>&TipoCliente=<?php echo $POST_ClienteTipo;?>"><?php echo $dat->ProId;  ?></a>

                        </td>
                        <td align="right" valign="middle" width="4%"   ><?php echo $dat->RtiNombre; ?></td>
                        <td width="6%" align="right" valign="middle" bgcolor="#A0DF82"   >
						<?php echo $dat->ProCodigoOriginal; ?>
						<!--<a href="javascript:FncProductoCargarFormulario('Ver','<?php echo $dat->ProId;  ?>');">
						<?php echo $dat->ProCodigoOriginal; ?>
                        </a>-->
                        </td>
                        <td width="7%" align="right" valign="middle"   ><?php echo $dat->ProCodigoAlternativo; ?></td>
                        <td align="right" valign="middle" width="29%"   ><?php echo $dat->ProNombre; ?>
						<!--<a href="javascript:FncProductoCargarFormulario('Ver','<?php echo $dat->ProId;  ?>');">
                        
						<?php echo $dat->ProNombre; ?>
                        </a>-->
                        </td>
                        <td  width="7%" align="right" >
						
						<a href="javascript:FncProductoCargarFormulario('Ver','<?php echo $dat->ProId;  ?>');">
						
						<?php echo $dat->ProReferencia; ?></a></td>
                        <td  width="6%" align="right" ><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span><?php echo number_format($dat->ProCosto,2); ?></td>
                        <?php
                           $ListaPrecioValorVenta = 0;
                           $ListaPrecioPrecio = 0;
                           $ListaPrecioPorcentajeUtilidad = 0;
                           
                           		if(!empty($InsClienteTipo->LtiId) and !empty($InsUnidadMedida->UmeId)){
                           		?>
                        <?php
                           $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'Desc','0,10',$dat->ProId,$InsClienteTipo->LtiId,$InsUnidadMedida->UmeId);
                           $ArrListaPrecios = $ResListaPrecio['Datos'];
                           ?>
                        <?php
                           foreach($ArrListaPrecios as $DatListaPrecio){
                           	$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
                           	$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
                           	$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
                           }
                           ?>
                        <?php	
                           }	
                           ?>
                        <td  width="5%" align="right" >
                           <?php
                              if(!empty($InsClienteTipo->LtiId)){
                              ?>
								<?php
								if(!empty($InsUnidadMedida->UmeId)){
								?>
		                           <?php echo number_format($ListaPrecioPorcentajeUtilidad,2);?> %                                
                                <?php
								}else{
								?>
		                           [Escoja una unidad de medida]        						                        
                                <?php	
								}
								?>

                           <?php	
                              }else{
                              ?>
                           [Escoja un tipo de cliente]
                           <?php	
                              }		
                              ?>	
                        </td>
                        <td  width="7%" align="right" >
                           <?php
                              if(!empty($InsClienteTipo->LtiId)){
                              ?>
                              
								<?php
								if(!empty($InsUnidadMedida->UmeId)){
								?>
                           <?php echo number_format($ListaPrecioValorVenta,2);?>
                            <?php
								}else{
								?>
		                           [Escoja una unidad de medida]        						                        
                                <?php	
								}
								?>
                           <?php	
                              }else{
                              ?>
                           [Escoja un tipo de cliente]
                           <?php	
                              }		
                              ?>	
                        </td>
                        <td  width="6%" align="right" >
                           <?php
                              if(!empty($InsClienteTipo->LtiId)){
                              ?>
                              								<?php
								if(!empty($InsUnidadMedida->UmeId)){
								?>
                                
                           <?php echo number_format($ListaPrecioPrecio,2);?>
                            <?php
								}else{
								?>
		                           [Escoja una unidad de medida]        						                        
                                <?php	
								}
								?>
                           <?php	
                              }else{
                              ?>
                           [Escoja un tipo de cliente]
                           <?php	
                              }		
                              ?>	
                        </td>
                        <td  width="9%" align="right" ><?php echo $dat->UmeNombre; ?></td>
                        <td  width="3%" align="right" ><?php
                           switch($dat->ProEstado){
                           	case 1:
                           ?>
                           <img src="imagenes/activo.gif" alt="[Activo]" title="En actividad" width="20" height="20" />
                           <?php
                              break;
                              
                              case 2:
                              ?>
                           <img src="imagenes/inactivo.gif" alt="[Inactivo]" title="Sin actividad" width="20" height="20" />
                           <?php
                              break;
                              
                              }
                              ?>
                        </td>
                        <td  width="6%" align="center" >
                           <?php
                              //if(!empty($InsClienteTipo->LtiId)){
                              ?>    
                           <?php
                              if($PrivilegioEditar){
                              ?>
                           <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->ProId;?>&TipoCliente=<?php echo $POST_ClienteTipo;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
                           <?php
                              }
                              ?>
                           <?php
                              if($PrivilegioVer){
                              ?>
                           <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ProId;?>&TipoCliente=<?php echo $POST_ClienteTipo;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                           <?php
                              }
                              ?>
                           <?php	
                              /*}else{
                              ?>
                           [Escoja un tipo de cliente]
                           <?php	
                              }*/		
                              ?>	
                        </td>
                     </tr>
                     <?php		$f++;
                        }
                        
                        ?>
                  </tbody>
               </table>
            </td>
         </tr>
      </table>
   </div>
</form>
<?php
   }else{
   	echo ERR_GEN_101;
   }
   
   
   //$InsMensaje->MenResultado = $Resultado;
   //$InsMensaje->MtdImprimirResultado();
   
   ?>