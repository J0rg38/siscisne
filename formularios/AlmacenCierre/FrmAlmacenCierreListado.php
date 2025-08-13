<?php
if ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, $GET_form)) {
?>

	<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, "Ver")) ? true : false; ?>

	<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, "Editar")) ? true : false; ?>





	<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, "Eliminar")) ? true : false; ?>

	<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, "VistaPreliminar")) ? true : false; ?>

	<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, "Imprimir")) ? true : false; ?>

	<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'], $GET_mod, "GenerarExcel")) ? true : false; ?>



	<script type="text/javascript" src="formularios/AlmacenCierre/js/JsAlmacenCierre.js"></script>
	<?php
	/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

	/**
	 *
	 * @author Ing. Jonathan Blanco Alave
	 */

	$POST_cam = ($_POST['Cam'] ?? '');
	$POST_fil = ($_POST['Fil'] ?? '');

	if ($_POST) {
		$_SESSION[$GET_mod . "Filtro"] = $POST_fil;
	} else {
		$POST_fil = (empty($_GET['Fil']) ? $_SESSION[$GET_mod . "Filtro"] : $_GET['Fil']);
	}


	$POST_ord = ($_POST['Ord'] ?? '');
	$POST_sen = ($_POST['Sen'] ?? '');
	$POST_pag = ($_POST['Pag'] ?? '');
	$POST_p = ($_POST['P'] ?? '');
	$POST_num = ($_POST['Num'] ?? '');

	if ($_POST) {
		$_SESSION[$GET_mod . "Num"] = $POST_num;
	} else {
		$POST_num =  $_SESSION[$GET_mod . "Num"];
	}

	$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
	$POST_acc = $_POST['Acc'] ?? '';


	/*
* Otras variables
*/


	$POST_Estado = $_POST['Estado'] ?? '';

	$POST_con = $_POST['Con'] ?? '';

	if (empty($POST_p)) {
		$POST_p = '1';
	}

	if (empty($POST_num)) {
		$POST_num = '10';
	}
	if (empty($POST_ord)) {
		$POST_ord = 'AciTiempoCreacion';
	}

	if (empty($POST_sen)) {
		$POST_sen = 'DESC';
	}

	if (empty($POST_pag)) {
		$POST_pag = '0,' . $POST_num;
	}

	/*
* Otras variables
*/


	if (empty($POST_est)) {
		$POST_est = 0;
	}


	if (empty($POST_con)) {
		$POST_con = "contiene";
	}

	include($InsProyecto->MtdFormulariosMsj('AlmacenCierre') . 'MsjAlmacenCierre.php');
	require_once($InsPoo->MtdPaqAlmacen() . 'ClsAlmacenCierre.php');

	$InsAlmacenCierre = new ClsAlmacenCierre();


	include($InsProyecto->MtdFormulariosAcc($GET_mod) . 'AccAlmacenCierre.php');

	//MtdObtenerAlmacenCierres($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 
	$ResAlmacenCierre = $InsAlmacenCierre->MtdObtenerAlmacenCierres("aci.AciId,per.PerNombre,per.PerApellidoPaterno,per.PerApellidoMaterno", $POST_con, $POST_fil, $POST_ord, $POST_sen, $POST_pag, $POST_est);
	$ArrAlmacenCierres = $ResAlmacenCierre['Datos'];
	$AlmacenCierresTotal = $ResAlmacenCierre['Total'];
	$AlmacenCierresTotalSeleccionado = $ResAlmacenCierre['TotalSeleccionado'];

	//$InsMensaje->MenResultado = $Resultado;
	//$InsMensaje->MtdImprimirResultado();

	/*
 * interface FrmAlmacenCierreListado {
    //put your code here  
}
*/

	?>
	<form id="FrmListado" name="FrmListado" enctype="multipart/form-data" method="POST" action="#">


		<div class="EstCapMenu">
			<?php
			if ($PrivilegioGenerarExcel) {
			?>
				<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div>

			<?php
			}
			?>


			<?php
			if ($PrivilegioImprimir) {
			?>
				<div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/submenu/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
			<?php
			}
			?>
			<?php
			if ($PrivilegioEliminar) {
			?>
				<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div>
			<?php
			}
			?>


		</div>

		<div class="EstCapContenido">


			<table width="100%" border="0" cellpadding="0" cellspacing="0">

				<tr>
					<td height="25"><span class="EstFormularioTitulo">LISTADO DE CIERRES DE ALMACEN</span></td>
				</tr>
				<tr>
					<td>
						Mostrando <b><?php echo $AlmacenCierresTotalSeleccionado; ?></b> de <b><?php echo $AlmacenCierresTotal; ?></b> registros.</td>
				</tr>
				<tr>
					<td align="right">

						<input type="hidden" name="Acc" id="Acc" value="" />
						<input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord; ?>" />
						<input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen; ?>" />
						<input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag; ?>" />
						<input type="hidden" name="P" id="P" value="<?php echo $POST_p; ?>" />

						<input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
						<span class="EstFormularioEtiqueta">Buscar:</span>

						<span class="EstFormularioContenido">
							<input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil; ?>" size="18" />
						</span>


						<select class="EstFormularioCombo" name="Con" id="Con">
							<option <?php if ($POST_con == "esigual") {
										echo 'selected="selected"';
									} ?> value="esigual">Es igual a</option>
							<option <?php if ($POST_con == "noesigual") {
										echo 'selected="selected"';
									} ?> value="noesigual">No es igual a</option>
							<option <?php if ($POST_con == "comienza") {
										echo 'selected="selected"';
									} ?> value="comienza">Comienza por</option>
							<option <?php if ($POST_con == "termina") {
										echo 'selected="selected"';
									} ?> value="termina">Termina con</option>
							<option <?php if ($POST_con == "contiene") {
										echo 'selected="selected"';
									} ?> value="contiene">Contiene</option>
							<option <?php if ($POST_con == "nocontiene") {
										echo 'selected="selected"';
									} ?> value="nocontiene">No Contiene</option>
						</select>



						<!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="AciId" <?php if ($POST_cam == "AciId") {
									echo 'selected="selected"';
								} ?>>Id</option>
        <option value="AciNumero" <?php if ($POST_cam == "AciNumero") {
										echo 'selected="selected"';
									} ?>>Nombre</option>
      </select>-->

						<!--      Estado
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="0" <?php if ($POST_est == 0) {
								echo 'selected="selected"';
							} ?>>Todos</option>
        <option value="1" <?php if ($POST_est == 1) {
								echo 'selected="selected"';
							} ?>>En actividad</option>
        <option value="2" <?php if ($POST_est == 2) {
								echo 'selected="selected"';
							} ?>>Sin actividad</option>        
        </select>-->

						<input class="EstFormularioBoton" name="btn_buscar" type="submit" onAcick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" />
					</td>
				</tr>
				<tr>
					<td>


						<div id="CapListado">

							<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">

								<thead class="EstTablaListadoHead">

									<tr>
										<th width="2%">#</th>
										<th width="2%">

											<input onAcick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />
										</th>

										<th width="4%"><?php
														if ($POST_ord == "AciId") {
															if ($POST_sen == "DESC") {
														?>
													<a href="javascript:FncOrdenar('AciId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
												<?php
															} else {
												?>
													<a href="javascript:FncOrdenar('AciId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]" width="15" height="15" align="absmiddle" /> </a>
												<?php
															}
														} else {

												?>
												<a href="javascript:FncOrdenar('AciId','ASC');"> Id. </a>
											<?php
														}
											?>
										</th>
										<th width="37%"><?php
														if ($POST_ord == "PerNombre") {
															if ($POST_sen == "DESC") {
														?>
													<a href="javascript:FncOrdenar('PerNombre','ASC');"> Personal <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
												<?php
															} else {
												?>
													<a href="javascript:FncOrdenar('PerNombre','DESC');"> Personal <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]" width="15" height="15" align="absmiddle" /></a>
												<?php
															}
														} else {


												?>
												<a href="javascript:FncOrdenar('PerNombre','ASC');"> Personal </a>
											<?php
														}
											?>
										</th>
										<th width="18%"><?php
														if ($POST_ord == "AciFechaInicio") {
															if ($POST_sen == "DESC") {
														?>
													<a href="javascript:FncOrdenar('AciFechaInicio','ASC');"> Fecha Inicio <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
												<?php
															} else {
												?>
													<a href="javascript:FncOrdenar('AciFechaInicio','DESC');"> Fecha Inicio <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]" width="15" height="15" align="absmiddle" /> </a>
												<?php
															}
														} else {


												?>
												<a href="javascript:FncOrdenar('AciFechaInicio','ASC');"> Fecha Inicio </a>
											<?php
														}
											?>
										</th>
										<th width="12%"><?php
														if ($POST_ord == "AciFechaFin") {
															if ($POST_sen == "DESC") {
														?>
													<a href="javascript:FncOrdenar('AciFechaFin','ASC');"> Fecha Termino <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
												<?php
															} else {
												?>
													<a href="javascript:FncOrdenar('AciFechaFin','DESC');"> Fecha Termino <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]" width="15" height="15" align="absmiddle" /></a>
												<?php
															}
														} else {


												?>
												<a href="javascript:FncOrdenar('AciFechaFin','ASC');"> Fecha Termino </a>
											<?php
														}
											?>
										</th>
										<th width="13%"> <?php
															if ($POST_ord == "AciTiempoCreacion") {
																if ($POST_sen == "DESC") {
															?>
													<a href="javascript:FncOrdenar('AciTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
												<?php
																} else {
												?>
													<a href="javascript:FncOrdenar('AciTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]" width="15" height="15" align="absmiddle" /></a>
												<?php
																}
															} else {

												?>
												<a href="javascript:FncOrdenar('AciTiempoCreacion','ASC');"> Fecha Creacion </a>
											<?php
															}
											?>
										</th>
										<th width="12%">Acciones</th>
									</tr>
								</thead>

								<tfoot class="EstTablaListadoFoot">
									<tr>
										<td colspan="8" align="center">

											Mostrar de
											<select class="EstFormularioCombo" onChange="javascript:FncListar(this.value);" name="Num" id="Num">
												<option <?php if ($POST_num == "5") {
															echo 'selected="selected"';
														} ?> value="5">5</option>
												<option <?php if ($POST_num == "10") {
															echo 'selected="selected"';
														} ?> value="10">10</option>
												<option <?php if ($POST_num == "15") {
															echo 'selected="selected"';
														} ?> value="15">15</option>
												<option <?php if ($POST_num == "20") {
															echo 'selected="selected"';
														} ?> value="20">20</option>
												<option <?php if ($POST_num == "25") {
															echo 'selected="selected"';
														} ?> value="25">25</option>
												<option <?php if ($POST_num == "30") {
															echo 'selected="selected"';
														} ?> value="30">30</option>
												<option <?php if ($POST_num == "50") {
															echo 'selected="selected"';
														} ?> value="50">50</option>
												<option <?php if ($POST_num == "100") {
															echo 'selected="selected"';
														} ?> value="100">100</option>
												<option <?php if ($POST_num == "125") {
															echo 'selected="selected"';
														} ?> value="125">125</option>
												<option <?php if ($POST_num == "150") {
															echo 'selected="selected"';
														} ?> value="150">150</option>

												<option <?php if ($POST_num == $AlmacenCierresTotal) {
															echo 'selected="selected"';
														} ?> value="<?php echo $AlmacenCierresTotal; ?>">Todos</option>
											</select>

											<?php

											$numxpag = $POST_num;

											//if(empty($POST_fil)){
											$tregistros = $AlmacenCierresTotal;
											//}else{
											//	$tregistros = ($AlmacenCierresTotalSeleccionado);
											//}

											$cant_paginas = ceil($tregistros / $numxpag);
											?>



											<?php
											if ($POST_p <> "1") {
											?>

												<a class="EstPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag; ?>','1');">
													Inicio </a>
											<?php
											}
											?>
											&nbsp;
											<?php
											if ($POST_p <= $cant_paginas & $POST_p <> "1") {

												$pagina = explode(",", $POST_pag);

											?>
												<a class="EstPaginacion" href="javascript:FncPaginar('<?php echo ($pagina[0] - $numxpag) ?>,<?php echo $numxpag; ?>','<?php echo ($POST_p - 1) ?>');">Anterior</a>
											<?php
											}
											?>

											&nbsp;

											<?php
											$xpag = 10;

											$inicio = 0;
											$fin = 0;

											if ($POST_p - $xpag > 0) {
												$inicio = $POST_p - $xpag;
											} else {
												$inicio = $POST_p - ($POST_p - $xpag * -1);
											}

											if ($POST_p + $xpag < $cant_paginas) {
												$fin = $POST_p + $xpag;
											} else {
												$fin = $POST_p + ($POST_p - $xpag * -1);
											}
											?>
											<?php
											$num = 0;

											for ($i = 1; $i <= $cant_paginas; $i++) {
											?>

												<?php
												if ($i >= $inicio and $i <= $fin) {
												?>

													<?php
													if ($POST_p == $i) {
													?>
														<span class="EstPaginaActual"><?php echo $i; ?></span>
													<?php
													} else {
													?>
														<a class="EstPaginacion" href="javascript:FncPaginar('<?php echo $num ?>,<?php echo $numxpag; ?>','<?php echo $i ?>');"><?php echo $i ?></a>
													<?php
													}
													?>

												<?php
												}
												?>

											<?php
												$num = $num + $numxpag;
											}
											?>

											&nbsp;
											<?php
											if ($POST_p < $cant_paginas) {
												$pagina = explode(",", $POST_pag);
											?>
												<a class="EstPaginacion" href="javascript:FncPaginar('<?php echo ($pagina[0] + $numxpag) ?>,<?php echo $numxpag; ?>','<?php echo ($POST_p + 1) ?>');">Siguiente</a>
											<?php
											}
											?>
											&nbsp;
											<?php
											if ($POST_p <> $cant_paginas) {
											?>
												<a class="EstPaginacion" href="javascript:FncPaginar('<?php echo ($num - $numxpag); ?>,<?php echo $numxpag; ?>','<?php echo ($i - 1); ?>');">Final</a>
											<?php
											}
											?>
											&nbsp;
											Pagina <?php echo $POST_p; ?> de <?php echo $cant_paginas; ?>

										</td>
									</tr>
								</tfoot>
								<tbody class="EstTablaListadoBody">
									<?php




									$pagina = explode(",", $POST_pag);
									$f = $pagina[0] + 1;

									foreach ($ArrAlmacenCierres as $dat) {

									?>



										<tr id="Fila_<?php echo $f; ?>">
											<td align="center"><?php echo $f; ?></td>
											<td align="center">

												<input onclick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->AciId; ?>" />
											</td>

											<td align="right" valign="middle"><?php echo $dat->AciId;  ?></td>
											<td align="right" valign="middle"><?php echo $dat->PerNombre; ?> <?php echo $dat->PerApellidoPaterno; ?> <?php echo $dat->PerApellidoMaterno; ?>

											</td>
											<td align="right" valign="middle"><?php echo $dat->AciFechaInicio; ?></td>
											<td align="right"><?php echo $dat->AciFechaFin; ?></td>

											<td align="right"><?php echo ($dat->AciTiempoCreacion); ?></td>
											<td align="center"><?php
																if ($PrivilegioEliminar) {
																?>
													<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->AciId; ?>');"> <img src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente" /></a>
												<?php
																}
												?>
												<?php
												/*if($PrivilegioEliminar){
?>
<a href="javascript:FncBorrarSeleccionado('<?php echo $dat->AciId;?>');"><img src="imagenes/borrar.gif" width="19" height="19" border="0" title="Borrar" alt="[Borrar]"   /></a>
<?php
}*/
												?>

												<?php
												if ($PrivilegioEditar) {
												?>
													<a href="principal.php?Mod=<?php echo $GET_mod; ?>&Form=Editar&Id=<?php echo $dat->AciId; ?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]" /></a>
												<?php
												}
												?>

												<?php
												if ($PrivilegioVer) {
												?>
													<a href="principal.php?Mod=<?php echo $GET_mod; ?>&Form=Ver&Id=<?php echo $dat->AciId; ?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]" /></a>
												<?php
												}
												?>
											</td>
										</tr>

									<?php $f++;
									}

									?>
								</tbody>
							</table>

						</div>

					</td>
				</tr>
			</table>


		</div>



	</form>


<?php
} else {
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>