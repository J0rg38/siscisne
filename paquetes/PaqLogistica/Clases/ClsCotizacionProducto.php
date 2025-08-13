<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionProducto {

    public $CprId;
	public $CprAno;
	public $CprMes;
	
	public $CliId;
	public $LtiId;
	public $CprFecha;
	
	public $CliIdSeguro;
	
	public $EinId;
	public $PerId;
	public $FinId;
	
	public $CprVIN;
	public $CprMarca;
	public $CprModelo;
	public $CprPlaca;
	public $CprAnoModelo;
	
	public $MonId;
	public $CprTipoCambio;
	
	public $CprIncluyeImpuesto;
	public $CprPorcentajeImpuestoVenta;
	
    public $CprObservacion;
	
	public $CprTelefono;
	public $CprDireccion;
	public $CprEmail;
	public $CprRepresentante;
	public $CprAsegurado;
	
	public $CprManoObra;
	public $CprPorcentajeDescuento;
	public $CprVigencia;
	public $CprTiempoEntrega;
	
	public $CprPlanchadoTotal;
	public $CprPintadoTotal;
	public $CprCentradoTotal;
	public $CprTareaTotal;	
	public $CprProductoTotal;
	
	public $CprDescuento;
	public $CprSubTotal;
	public $CprImpuesto;
	public $CprTotal;
	
	public $CprVerificar;
	public $CprFirmaDigital;
	public $CprNotificar;
	public $CprEstado;
	public $CprTiempoCreacion;
	public $CprTiempoModificacion;
    public $CprEliminado;

	public $CprPlanchado;
	public $CprPintado;
	public $CprRepuesto;

	public $TdoId;
	
	public $CliNombreCompleto;
	public $CliNombre;
	public $CliNumeroDocumento;
	public $TdoNombre;
	public $LtiNombre;
	
	public $MonNombre;
	public $MonSimbolo;
				
	public $EinVIN;
	public $EinPlaca;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $PerFirma;
	public $PerEmail;
	public $PerCelular;
	public $PerTelefono;
	
	public $CotizacionProductoDetalle;
	public $CotizacionProductoPlanchado;
	public $CotizacionProductoPintado;
	public $CotizacionProductoCentrado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarCotizacionProductoId() {

		$sql = 'SELECT	
			suc.SucSiglas AS SIGLA,
			MAX(CONVERT(SUBSTR(cpr.CprId,13),unsigned)) AS "MAXIMO"
			FROM tblcprcotizacionproducto cpr
				LEFT JOIN tblsucsucursal suc
					ON cpr.SucId = suc.SucId
			WHERE YEAR(cpr.CprFecha) = ("'.$this->CprAno.'")
			AND MONTH(cpr.CprFecha) = ("'.$this->CprMes.'")
			AND cpr.SucId = "'.$this->SucId.'"
			';
			
//echo "<br>";			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CprId = "CTR-".$this->CprAno."-".$this->CprMes."-00001-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);;
			}else{
				$fila['MAXIMO']++;
				$this->CprId = "CTR-".$this->CprAno."-".$this->CprMes."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT)."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);	
			}
				
		}
		
    public function MtdObtenerCotizacionProducto($oCompleto=true){

        $sql = 'SELECT 
        cpr.CprId,
cpr.SucId,
				
		cpr.CliId,
		cpr.LtiId,

		DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
		DATE_FORMAT(cpr.CprHora, "%H:%i") AS "NCprHora",
		cpr.CliIdSeguro,
		
		cpr.EinId,
		cpr.PerId,
		cpr.FinId,
		
		
		cpr.CprVIN,
		cpr.CprMarca,
		cpr.CprModelo,
		cpr.CprPlaca,
		cpr.CprAnoModelo,
	
		cpr.MonId,
		cpr.CprTipoCambio,
		
		cpr.CprIncluyeImpuesto,
		cpr.CprPorcentajeImpuestoVenta,
		cpr.CprPorcentajeMargenUtilidad,
		cpr.CprPorcentajeOtroCosto,
		cpr.CprPorcentajeManoObra,
		
		cpr.CprObservacion,
cpr.CprObservacionImpresa,

		cpr.CprTelefono,
		cpr.CprDireccion,
		cpr.CprEmail,
		cpr.CprRepresentante,
		cpr.CprAsegurado,
	
		cpr.CprManoObra,
		cpr.CprPorcentajeDescuento,
		cpr.CprVigencia,
		cpr.CprTiempoEntrega,
		DATE_FORMAT(adddate(cpr.CprFecha,cpr.CprTiempoEntrega), "%d/%m/%Y") AS CprFechaEntrega,
	
		cpr.CprPlanchadoTotal,
		cpr.CprPintadoTotal,
		cpr.CprProductoTotal,
		
		cpr.CprDescuento,
		cpr.CprSubTotal,
		cpr.CprImpuesto,
		cpr.CprTotal,

		cpr.CprVerificar,
		cpr.CprFirmaDigital,
		cpr.CprNotificar,
		
		cpr.CprVentaPerdida,
		cpr.CprVentaPerdidaMotivo,
		
		
		cpr.CprNivelInteres,
		cpr.CprEstado,
CprNivelInteres,
		DATE_FORMAT(cpr.CprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoCreacion",
        DATE_FORMAT(cpr.CprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoModificacion",


				CASE
				WHEN EXISTS (
					SELECT 
					crd.CrdId 
					FROM tblcrdcotizacionproductodetalle crd
					WHERE crd.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprRepuesto,
				
				
						CASE
					WHEN EXISTS (
						SELECT 
						crd.CrdId 
						FROM tblcrdcotizacionproductodetalle crd
						WHERE crd.CprId = cpr.CprId 
						AND crd.CrdEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprRepuestoVerificado,
					
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "L" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPlanchado,
				
						CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "L" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPlanchadoVerificado,
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "I" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPintado,

				CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "I" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPintadoVerificado,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "C" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprCentrado,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "C" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprCentradoVerificado,
					
					
					
					
					


				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "Z" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprTarea,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "Z" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprTareaVerificado,
					
					
					


				CASE
				WHEN EXISTS (
					SELECT 
					vdi.VdiId
					FROM tblvdiventadirecta vdi
					WHERE vdi.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprVentaDirecta,
				
				
		cli.TdoId,
		
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
		
		cli.CliNumeroDocumento,
		tdo.TdoNombre,
		lti.LtiNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		ein.EinVIN,
		ein.EinPlaca,
		
		ein.VmaId,
		vma.VmaNombre,

		ein.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,

		ein.VveId,		
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerFirma,
		per.PerEmail,
		per.PerCelular,
		per.PerTelefono,
		
		seg.CliNombre AS CliNombreSeguro,
		seg.CliApellidoPaterno AS CliApellidoPaternoSeguro,
		seg.CliApellidoMaterno AS CliApellidoMaternoSeguro
		
        FROM tblcprcotizacionproducto cpr
			LEFT JOIN tblclicliente cli
			ON cpr.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId
					LEFT JOIN tbllticlientetipo lti
					ON cpr.LtiId = lti.LtiId
					
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						LEFT JOIN tblmonmoneda mon
						ON cpr.MonId = mon.MonId
							LEFT JOIN tbleinvehiculoingreso ein
							ON cpr.EinId = ein.EinId
						
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId

									LEFT JOIN tblperpersonal per
									ON cpr.PerId = per.PerId
									
        WHERE cpr.CprId = "'.$this->CprId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->CprId = $fila['CprId'];
			$this->SucId = $fila['SucId'];

			$this->CliId = $fila['CliId'];		
			$this->LtiId = $fila['LtiId'];
			$this->CprFecha = $fila['NCprFecha'];
			$this->CprHora = $fila['NCprHora'];
			
			$this->CliIdSeguro = $fila['CliIdSeguro'];
			
			$this->EinId = $fila['EinId'];
			$this->PerId = $fila['PerId'];
			$this->FinId = $fila['FinId'];
			
			
			$this->CprVIN = $fila['CprVIN'];
			$this->CprMarca = $fila['CprMarca'];
			$this->CprModelo = $fila['CprModelo'];
			$this->CprPlaca = $fila['CprPlaca'];
			$this->CprAnoModelo = $fila['CprAnoModelo'];

			$this->MonId = $fila['MonId'];
			$this->CprTipoCambio = $fila['CprTipoCambio'];

			$this->CprIncluyeImpuesto = $fila['CprIncluyeImpuesto'];
			$this->CprPorcentajeImpuestoVenta = $fila['CprPorcentajeImpuestoVenta'];

			$this->CprPorcentajeMargenUtilidad = $fila['CprPorcentajeMargenUtilidad'];
			$this->CprPorcentajeOtroCosto = $fila['CprPorcentajeOtroCosto'];
			$this->CprPorcentajeManoObra = $fila['CprPorcentajeManoObra'];
			
			$this->CprObservacion = $fila['CprObservacion'];
			$this->CprObservacionImpresa = $fila['CprObservacionImpresa'];
			
			$this->CprTelefono = $fila['CprTelefono'];
			$this->CprDireccion = $fila['CprDireccion'];
			$this->CprEmail = $fila['CprEmail'];
			$this->CprRepresentante = $fila['CprRepresentante'];
			$this->CprAsegurado = $fila['CprAsegurado'];



			$this->CprManoObra = $fila['CprManoObra'];
			$this->CprPorcentajeDescuento = $fila['CprPorcentajeDescuento'];
			$this->CprVigencia = $fila['CprVigencia'];
			$this->CprTiempoEntrega = $fila['CprTiempoEntrega'];
			$this->CprFechaEntrega = $fila['CprFechaEntrega'];



			$this->CprPlanchadoTotal = $fila['CprPlanchadoTotal'];
			$this->CprPintadoTotal = $fila['CprPintadoTotal'];
			$this->CprProductoTotal = $fila['CprProductoTotal'];
			
			$this->CprDescuento = $fila['CprDescuento'];
			$this->CprSubTotal = $fila['CprSubTotal'];
			$this->CprImpuesto = $fila['CprImpuesto'];
			$this->CprTotal = $fila['CprTotal'];

			$this->CprVerificar = $fila['CprVerificar'];
			$this->CprFirmaDigital = $fila['CprFirmaDigital'];
			
			$this->CprNotificar = $fila['CprNotificar'];
			
			
			$this->CprVentaPerdida = $fila['CprVentaPerdida'];
			$this->CprVentaPerdidaMotivo = $fila['CprVentaPerdidaMotivo'];
			
			$this->CprNivelInteres = $fila['CprNivelInteres'];
			
			$this->CprEstado = $fila['CprEstado'];
			$this->CprTiempoCreacion = $fila['NCprTiempoCreacion']; 
			$this->CprTiempoModificacion = $fila['NCprTiempoModificacion']; 
			
			$this->CprRepuesto = $fila['CprRepuesto'];
			$this->CprRepuestoVerificado = $fila['CprRepuestoVerificado'];
			$this->CprPlanchado = $fila['CprPlanchado'];
			$this->CprPlanchadoVerificado = $fila['CprPlanchadoVerificado'];
			$this->CprPintado = $fila['CprPintado'];
			$this->CprPintadoVerificado = $fila['CprPintadoVerificado'];
			$this->CprCentrado = $fila['CprCentrado'];
			$this->CprCentradoVerificado = $fila['CprCentradoVerificado'];
			$this->CprTarea = $fila['CprTarea'];
			$this->CprTareaVerificado = $fila['CprTareaVerificado'];
			
			$this->CprVentaDirecta = $fila['CprVentaDirecta'];	
			
			$this->TdoId = $fila['TdoId']; 	
			
			
			$this->CliNombre = $fila['CliNombre']; 	
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoNombre = $fila['TdoNombre'];
			$this->LtiNombre = $fila['LtiNombre'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];


			$this->EinVIN = $fila['EinVIN'];
			$this->EinPlaca = $fila['EinPlaca'];

			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];

			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre'];

			$this->VtiId = $fila['VtiId'];
			$this->VtiNombre = $fila['VtiNombre'];

			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerFirma = $fila['PerFirma'];
			
			$this->PerEmail = $fila['PerEmail'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerTelefono = $fila['PerTelefono'];
			
			$this->CliNombreSeguro = $fila['CliNombreSeguro'];
			$this->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
			$this->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];

	
		
			if($oCompleto){
				
			
				$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
				$ResCotizacionProductoDetalle =  $InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalles(NULL,NULL,NULL,NULL,NULL,$this->CprId);
				
				$this->CotizacionProductoDetalle = 	$ResCotizacionProductoDetalle['Datos'];	
	
				$InsCotizacionProductoPlanchadoPintado = new ClsCotizacionProductoPlanchadoPintado();
				$ResCotizacionProductoPlanchado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"L");			
				$this->CotizacionProductoPlanchado = 	$ResCotizacionProductoPlanchado['Datos'];	
	
				$ResCotizacionProductoPintado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"I");			
				$this->CotizacionProductoPintado = 	$ResCotizacionProductoPintado['Datos'];	
				
				$ResCotizacionProductoCentrado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"C");			
				$this->CotizacionProductoCentrado = 	$ResCotizacionProductoCentrado['Datos'];	
				
				$ResCotizacionProductoTarea =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"Z");			
				$this->CotizacionProductoTarea = 	$ResCotizacionProductoTarea['Datos'];	
				
				$InsCotizacionProductoFoto = new ClsCotizacionProductoFoto();
				//MtdObtenerCotizacionProductoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {
				$ResCotizacionProductoFoto =  $InsCotizacionProductoFoto->MtdObtenerCotizacionProductoFotos(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,NULL);
				$this->CotizacionProductoFoto = 	$ResCotizacionProductoFoto['Datos'];
							
			}
			switch($this->CprEstado){
			
			  case 1:
				  $Estado = "Emitido";
			  break;
			
			  case 2:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Enviado]";
			  break;
			
			  case 3:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisando]";
			  break;	
			
			  case 4:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Por Facturar]";
			  break;
			
			  case 5:
				  $Estado = "<img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
			  break;
			  
			  
			  case 6:
				  $Estado = "<img src='imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='ANULADO' > [Anulado]";
			  break;
			
			  default:
				  $Estado = "";
			  break;					
			
			}
			
			$this->CprEstadoDescripcion = $Estado;
			

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCotizacionProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oVehiculoIngreso=NULL,$oPersonal=NULL,$oCliente=NULL,$oTieneFichaIngreso=NULL,$oSucursal=NULL,$oVentaPerdida=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$estado = '';
		$moneda = '';
		$fichaIngreso = '';
		$vehiculoIngreso = '';
		$personal = '';
		$cliente = '';
		$tieneFichaIngreso = '';
		$sucursal = '';
		$ventaPerdida = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					crd.CrdId
					FROM tblcrdcotizacionproductodetalle crd
						LEFT JOIN tblproproducto pro
						ON crd.ProId = pro.ProId
						
					WHERE 
						crd.CprId = cpr.CprId AND
						(
						crd.CrdDescripcion LIKE "%'.$oFiltro.'%" OR
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						crd.CrdCodigo  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						
						)
						
					) ';
					
					
				$filtrar .= '  ) ';

			
				
	
		}


		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'" AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND cpr.CprEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cpr.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND cpr.FinId = "'.$oFichaIngreso.'"';
		}
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND cpr.EinId = "'.$oVehiculoIngreso.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND cpr.PerId = "'.$oPersonal.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND cpr.CliId = "'.$oCliente.'"';
		}
				
		if($oTieneFichaIngreso){
			switch($oTieneFichaIngreso){
				case "FichaIngresoSi":
					$tfingreso = ' AND cpr.FinId IS NOT NULL ';
				break;
				
				case "FichaIngresoNo":
					$tfingreso = ' AND cpr.FinId IS  NULL ';
				break;
				
				default:
					$tfingreso = ' ';
				break;
			}
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cpr.SucId = "'.$oSucursal.'"';
		}
		
		
		if(!empty($oVentaPerdida)){
			$vperdida = ' AND cpr.CprVentaPerdida = "'.$oVentaPerdida.'"';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cpr.CprId,
cpr.SucId,	
				
				cpr.CliId,
				cpr.LtiId,
				
				cpr.CliIdSeguro,
				
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
				DATE_FORMAT(cpr.CprHora, "%H:%i") AS "NCprHora",
				
				cpr.EinId,
				cpr.PerId,
				cpr.FinId,
				
				
				cpr.CprVIN,
				cpr.CprMarca,
				cpr.CprModelo,
				cpr.CprPlaca,
				cpr.CprAnoModelo,
				
				cpr.MonId,
				cpr.CprTipoCambio,
				
				cpr.CprIncluyeImpuesto,
				cpr.CprPorcentajeImpuestoVenta,
				cpr.CprPorcentajeMargenUtilidad,
			  	cpr.CprPorcentajeManoObra,
				cpr.CprPorcentajeOtroCosto,
			  
				cpr.CprObservacion,
cpr.CprObservacionImpresa,

				cpr.CprTelefono,
				cpr.CprDireccion,
				cpr.CprEmail,
				cpr.CprRepresentante,
				cpr.CprAsegurado,
				
				cpr.CprManoObra,
				cpr.CprPorcentajeDescuento,
				cpr.CprVigencia,
				cpr.CprTiempoEntrega,
				DATE_FORMAT(adddate(cpr.CprFecha,cpr.CprTiempoEntrega), "%d/%m/%Y") AS CprFechaEntrega,
			
			cpr.CprPlanchadoTotal,
			cpr.CprPintadoTotal,
			cpr.CprProductoTotal,
					
				cpr.CprDescuento,
				cpr.CprSubTotal,
				cpr.CprImpuesto,				
				cpr.CprTotal,
				
				cpr.CprFirmaDigital,
				cpr.CprVerificar,
				
				cpr.CprNotificar,
				
					cpr.CprVentaPerdida,
		cpr.CprVentaPerdidaMotivo,
				cpr.CprEstado,
CprNivelInteres,
				DATE_FORMAT(cpr.CprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoCreacion",
	        	DATE_FORMAT(cpr.CprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoModificacion",
				
				

				
				CASE
				WHEN EXISTS (
					SELECT 
					crd.CrdId 
					FROM tblcrdcotizacionproductodetalle crd
					WHERE crd.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprRepuesto,
				
				
						CASE
					WHEN EXISTS (
						SELECT 
						crd.CrdId 
						FROM tblcrdcotizacionproductodetalle crd
						WHERE crd.CprId = cpr.CprId 
						AND crd.CrdEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprRepuestoVerificado,
					
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "L" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPlanchado,
				
						CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "L" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPlanchadoVerificado,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "I" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPintado,
				
				
						
					CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "I" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPintadoVerificado,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "C" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprCentrado,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "C" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprCentradoVerificado,
					
					
					
					
					
					
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "Z" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprTarea,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "Z" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprTareaVerificado,
					
					
					


				CASE
				WHEN EXISTS (
					SELECT 
					vdi.VdiId
					FROM tblvdiventadirecta vdi
					WHERE vdi.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprVentaDirecta,
				
				
		cli.TdoId,
		
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
		
		cli.CliNumeroDocumento,
		tdo.TdoNombre,
		lti.LtiNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		ein.EinVIN,
		ein.EinPlaca,
		
		ein.VmaId,
		vma.VmaNombre,

		ein.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,

		ein.VveId,		
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerFirma,
		per.PerEmail,
		per.PerCelular,
		per.PerTelefono,
		
		seg.CliNombre AS CliNombreSeguro,
		seg.CliApellidoPaterno AS CliApellidoPaternoSeguro,
		seg.CliApellidoMaterno AS CliApellidoMaternoSeguro
		
        FROM tblcprcotizacionproducto cpr
			LEFT JOIN tblclicliente cli
			ON cpr.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId
					LEFT JOIN tbllticlientetipo lti
					ON cpr.LtiId = lti.LtiId
					
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						LEFT JOIN tblmonmoneda mon
						ON cpr.MonId = mon.MonId
							LEFT JOIN tbleinvehiculoingreso ein
							ON cpr.EinId = ein.EinId
						
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId

									LEFT JOIN tblperpersonal per
									ON cpr.PerId = per.PerId
									
        WHERE cpr.CprId = "'.$this->CprId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->CprId = $fila['CprId'];
			$this->SucId = $fila['SucId'];

			$this->CliId = $fila['CliId'];		
			$this->LtiId = $fila['LtiId'];
			$this->CprFecha = $fila['NCprFecha'];
			$this->CprHora = $fila['NCprHora'];
			
			$this->CliIdSeguro = $fila['CliIdSeguro'];
			
			$this->EinId = $fila['EinId'];
			$this->PerId = $fila['PerId'];
			$this->FinId = $fila['FinId'];
			
			
			$this->CprVIN = $fila['CprVIN'];
			$this->CprMarca = $fila['CprMarca'];
			$this->CprModelo = $fila['CprModelo'];
			$this->CprPlaca = $fila['CprPlaca'];
			$this->CprAnoModelo = $fila['CprAnoModelo'];

			$this->MonId = $fila['MonId'];
			$this->CprTipoCambio = $fila['CprTipoCambio'];

			$this->CprIncluyeImpuesto = $fila['CprIncluyeImpuesto'];
			$this->CprPorcentajeImpuestoVenta = $fila['CprPorcentajeImpuestoVenta'];

			$this->CprPorcentajeMargenUtilidad = $fila['CprPorcentajeMargenUtilidad'];
			$this->CprPorcentajeOtroCosto = $fila['CprPorcentajeOtroCosto'];
			$this->CprPorcentajeManoObra = $fila['CprPorcentajeManoObra'];
			
			$this->CprObservacion = $fila['CprObservacion'];
			$this->CprObservacionImpresa = $fila['CprObservacionImpresa'];
			
			$this->CprTelefono = $fila['CprTelefono'];
			$this->CprDireccion = $fila['CprDireccion'];
			$this->CprEmail = $fila['CprEmail'];
			$this->CprRepresentante = $fila['CprRepresentante'];
			$this->CprAsegurado = $fila['CprAsegurado'];



			$this->CprManoObra = $fila['CprManoObra'];
			$this->CprPorcentajeDescuento = $fila['CprPorcentajeDescuento'];
			$this->CprVigencia = $fila['CprVigencia'];
			$this->CprTiempoEntrega = $fila['CprTiempoEntrega'];
			$this->CprFechaEntrega = $fila['CprFechaEntrega'];



			$this->CprPlanchadoTotal = $fila['CprPlanchadoTotal'];
			$this->CprPintadoTotal = $fila['CprPintadoTotal'];
			$this->CprProductoTotal = $fila['CprProductoTotal'];
			
			$this->CprDescuento = $fila['CprDescuento'];
			$this->CprSubTotal = $fila['CprSubTotal'];
			$this->CprImpuesto = $fila['CprImpuesto'];
			$this->CprTotal = $fila['CprTotal'];

			$this->CprVerificar = $fila['CprVerificar'];
			$this->CprFirmaDigital = $fila['CprFirmaDigital'];
			
			$this->CprNotificar = $fila['CprNotificar'];
			
			
			$this->CprVentaPerdida = $fila['CprVentaPerdida'];
			$this->CprVentaPerdidaMotivo = $fila['CprVentaPerdidaMotivo'];
			
			$this->CprNivelInteres = $fila['CprNivelInteres'];
			
			$this->CprEstado = $fila['CprEstado'];
			$this->CprTiempoCreacion = $fila['NCprTiempoCreacion']; 
			$this->CprTiempoModificacion = $fila['NCprTiempoModificacion']; 
			
			$this->CprRepuesto = $fila['CprRepuesto'];
			$this->CprRepuestoVerificado = $fila['CprRepuestoVerificado'];
			$this->CprPlanchado = $fila['CprPlanchado'];
			$this->CprPlanchadoVerificado = $fila['CprPlanchadoVerificado'];
			$this->CprPintado = $fila['CprPintado'];
			$this->CprPintadoVerificado = $fila['CprPintadoVerificado'];
			$this->CprCentrado = $fila['CprCentrado'];
			$this->CprCentradoVerificado = $fila['CprCentradoVerificado'];
			$this->CprTarea = $fila['CprTarea'];
			$this->CprTareaVerificado = $fila['CprTareaVerificado'];
			
			$this->CprVentaDirecta = $fila['CprVentaDirecta'];	
			
			$this->TdoId = $fila['TdoId']; 	
			
			
			$this->CliNombre = $fila['CliNombre']; 	
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoNombre = $fila['TdoNombre'];
			$this->LtiNombre = $fila['LtiNombre'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];


			$this->EinVIN = $fila['EinVIN'];
			$this->EinPlaca = $fila['EinPlaca'];

			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];

			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre'];

			$this->VtiId = $fila['VtiId'];
			$this->VtiNombre = $fila['VtiNombre'];

			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerFirma = $fila['PerFirma'];
			
			$this->PerEmail = $fila['PerEmail'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerTelefono = $fila['PerTelefono'];
			
			$this->CliNombreSeguro = $fila['CliNombreSeguro'];
			$this->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
			$this->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];

	
		
			if($oCompleto){
				
			
				$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
				$ResCotizacionProductoDetalle =  $InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalles(NULL,NULL,NULL,NULL,NULL,$this->CprId);
				
				$this->CotizacionProductoDetalle = 	$ResCotizacionProductoDetalle['Datos'];	
	
				$InsCotizacionProductoPlanchadoPintado = new ClsCotizacionProductoPlanchadoPintado();
				$ResCotizacionProductoPlanchado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"L");			
				$this->CotizacionProductoPlanchado = 	$ResCotizacionProductoPlanchado['Datos'];	
	
				$ResCotizacionProductoPintado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"I");			
				$this->CotizacionProductoPintado = 	$ResCotizacionProductoPintado['Datos'];	
				
				$ResCotizacionProductoCentrado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"C");			
				$this->CotizacionProductoCentrado = 	$ResCotizacionProductoCentrado['Datos'];	
				
				$ResCotizacionProductoTarea =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"Z");			
				$this->CotizacionProductoTarea = 	$ResCotizacionProductoTarea['Datos'];	
				
				$InsCotizacionProductoFoto = new ClsCotizacionProductoFoto();
				//MtdObtenerCotizacionProductoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {
				$ResCotizacionProductoFoto =  $InsCotizacionProductoFoto->MtdObtenerCotizacionProductoFotos(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,NULL);
				$this->CotizacionProductoFoto = 	$ResCotizacionProductoFoto['Datos'];
							
			}
			switch($this->CprEstado){
			
			  case 1:
				  $Estado = "Emitido";
			  break;
			
			  case 2:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Enviado]";
			  break;
			
			  case 3:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisando]";
			  break;	
			
			  case 4:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Por Facturar]";
			  break;
			
			  case 5:
				  $Estado = "<img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
			  break;
			  
			  
			  case 6:
				  $Estado = "<img src='imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='ANULADO' > [Anulado]";
			  break;
			
			  default:
				  $Estado = "";
			  break;					
			
			}
			
			$this->CprEstadoDescripcion = $Estado;
			

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCotizacionProducto($oCompleto=true){

        $sql = 'SELECT 
        cpr.CprId,
cpr.SucId,
				
		cpr.CliId,
		cpr.LtiId,

		DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
		DATE_FORMAT(cpr.CprHora, "%H:%i") AS "NCprHora",
		cpr.CliIdSeguro,
		
		cpr.EinId,
		cpr.PerId,
		cpr.FinId,
		
		
		cpr.CprVIN,
		cpr.CprMarca,
		cpr.CprModelo,
		cpr.CprPlaca,
		cpr.CprAnoModelo,
	
		cpr.MonId,
		cpr.CprTipoCambio,
		
		cpr.CprIncluyeImpuesto,
		cpr.CprPorcentajeImpuestoVenta,
		cpr.CprPorcentajeMargenUtilidad,
		cpr.CprPorcentajeOtroCosto,
		cpr.CprPorcentajeManoObra,
		
		cpr.CprObservacion,
cpr.CprObservacionImpresa,

		cpr.CprTelefono,
		cpr.CprDireccion,
		cpr.CprEmail,
		cpr.CprRepresentante,
		cpr.CprAsegurado,
	
		cpr.CprManoObra,
		cpr.CprPorcentajeDescuento,
		cpr.CprVigencia,
		cpr.CprTiempoEntrega,
		DATE_FORMAT(adddate(cpr.CprFecha,cpr.CprTiempoEntrega), "%d/%m/%Y") AS CprFechaEntrega,
	
		cpr.CprPlanchadoTotal,
		cpr.CprPintadoTotal,
		cpr.CprProductoTotal,
		
		cpr.CprDescuento,
		cpr.CprSubTotal,
		cpr.CprImpuesto,
		cpr.CprTotal,

		cpr.CprVerificar,
		cpr.CprFirmaDigital,
		cpr.CprNotificar,
		
		cpr.CprVentaPerdida,
		cpr.CprVentaPerdidaMotivo,
		
		
		cpr.CprNivelInteres,
		cpr.CprEstado,
CprNivelInteres,
		DATE_FORMAT(cpr.CprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoCreacion",
        DATE_FORMAT(cpr.CprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoModificacion",


				CASE
				WHEN EXISTS (
					SELECT 
					crd.CrdId 
					FROM tblcrdcotizacionproductodetalle crd
					WHERE crd.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprRepuesto,
				
				
						CASE
					WHEN EXISTS (
						SELECT 
						crd.CrdId 
						FROM tblcrdcotizacionproductodetalle crd
						WHERE crd.CprId = cpr.CprId 
						AND crd.CrdEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprRepuestoVerificado,
					
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "L" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPlanchado,
				
						CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "L" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPlanchadoVerificado,
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "I" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPintado,

				CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "I" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPintadoVerificado,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "C" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprCentrado,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "C" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprCentradoVerificado,
					
					
					
					
					


				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "Z" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprTarea,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "Z" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprTareaVerificado,
					
					
					


				CASE
				WHEN EXISTS (
					SELECT 
					vdi.VdiId
					FROM tblvdiventadirecta vdi
					WHERE vdi.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprVentaDirecta,
				
				
		cli.TdoId,
		
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
		
		cli.CliNumeroDocumento,
		tdo.TdoNombre,
		lti.LtiNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		ein.EinVIN,
		ein.EinPlaca,
		
		ein.VmaId,
		vma.VmaNombre,

		ein.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,

		ein.VveId,		
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerFirma,
		per.PerEmail,
		per.PerCelular,
		per.PerTelefono,
		
		seg.CliNombre AS CliNombreSeguro,
		seg.CliApellidoPaterno AS CliApellidoPaternoSeguro,
		seg.CliApellidoMaterno AS CliApellidoMaternoSeguro
		
        FROM tblcprcotizacionproducto cpr
			LEFT JOIN tblclicliente cli
			ON cpr.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId
					LEFT JOIN tbllticlientetipo lti
					ON cpr.LtiId = lti.LtiId
					
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						LEFT JOIN tblmonmoneda mon
						ON cpr.MonId = mon.MonId
							LEFT JOIN tbleinvehiculoingreso ein
							ON cpr.EinId = ein.EinId
						
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId

									LEFT JOIN tblperpersonal per
									ON cpr.PerId = per.PerId
									
        WHERE cpr.CprId = "'.$this->CprId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->CprId = $fila['CprId'];
			$this->SucId = $fila['SucId'];

			$this->CliId = $fila['CliId'];		
			$this->LtiId = $fila['LtiId'];
			$this->CprFecha = $fila['NCprFecha'];
			$this->CprHora = $fila['NCprHora'];
			
			$this->CliIdSeguro = $fila['CliIdSeguro'];
			
			$this->EinId = $fila['EinId'];
			$this->PerId = $fila['PerId'];
			$this->FinId = $fila['FinId'];
			
			
			$this->CprVIN = $fila['CprVIN'];
			$this->CprMarca = $fila['CprMarca'];
			$this->CprModelo = $fila['CprModelo'];
			$this->CprPlaca = $fila['CprPlaca'];
			$this->CprAnoModelo = $fila['CprAnoModelo'];

			$this->MonId = $fila['MonId'];
			$this->CprTipoCambio = $fila['CprTipoCambio'];

			$this->CprIncluyeImpuesto = $fila['CprIncluyeImpuesto'];
			$this->CprPorcentajeImpuestoVenta = $fila['CprPorcentajeImpuestoVenta'];

			$this->CprPorcentajeMargenUtilidad = $fila['CprPorcentajeMargenUtilidad'];
			$this->CprPorcentajeOtroCosto = $fila['CprPorcentajeOtroCosto'];
			$this->CprPorcentajeManoObra = $fila['CprPorcentajeManoObra'];
			
			$this->CprObservacion = $fila['CprObservacion'];
			$this->CprObservacionImpresa = $fila['CprObservacionImpresa'];
			
			$this->CprTelefono = $fila['CprTelefono'];
			$this->CprDireccion = $fila['CprDireccion'];
			$this->CprEmail = $fila['CprEmail'];
			$this->CprRepresentante = $fila['CprRepresentante'];
			$this->CprAsegurado = $fila['CprAsegurado'];



			$this->CprManoObra = $fila['CprManoObra'];
			$this->CprPorcentajeDescuento = $fila['CprPorcentajeDescuento'];
			$this->CprVigencia = $fila['CprVigencia'];
			$this->CprTiempoEntrega = $fila['CprTiempoEntrega'];
			$this->CprFechaEntrega = $fila['CprFechaEntrega'];



			$this->CprPlanchadoTotal = $fila['CprPlanchadoTotal'];
			$this->CprPintadoTotal = $fila['CprPintadoTotal'];
			$this->CprProductoTotal = $fila['CprProductoTotal'];
			
			$this->CprDescuento = $fila['CprDescuento'];
			$this->CprSubTotal = $fila['CprSubTotal'];
			$this->CprImpuesto = $fila['CprImpuesto'];
			$this->CprTotal = $fila['CprTotal'];

			$this->CprVerificar = $fila['CprVerificar'];
			$this->CprFirmaDigital = $fila['CprFirmaDigital'];
			
			$this->CprNotificar = $fila['CprNotificar'];
			
			
			$this->CprVentaPerdida = $fila['CprVentaPerdida'];
			$this->CprVentaPerdidaMotivo = $fila['CprVentaPerdidaMotivo'];
			
			$this->CprNivelInteres = $fila['CprNivelInteres'];
			
			$this->CprEstado = $fila['CprEstado'];
			$this->CprTiempoCreacion = $fila['NCprTiempoCreacion']; 
			$this->CprTiempoModificacion = $fila['NCprTiempoModificacion']; 
			
			$this->CprRepuesto = $fila['CprRepuesto'];
			$this->CprRepuestoVerificado = $fila['CprRepuestoVerificado'];
			$this->CprPlanchado = $fila['CprPlanchado'];
			$this->CprPlanchadoVerificado = $fila['CprPlanchadoVerificado'];
			$this->CprPintado = $fila['CprPintado'];
			$this->CprPintadoVerificado = $fila['CprPintadoVerificado'];
			$this->CprCentrado = $fila['CprCentrado'];
			$this->CprCentradoVerificado = $fila['CprCentradoVerificado'];
			$this->CprTarea = $fila['CprTarea'];
			$this->CprTareaVerificado = $fila['CprTareaVerificado'];
			
			$this->CprVentaDirecta = $fila['CprVentaDirecta'];	
			
			$this->TdoId = $fila['TdoId']; 	
			
			
			$this->CliNombre = $fila['CliNombre']; 	
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoNombre = $fila['TdoNombre'];
			$this->LtiNombre = $fila['LtiNombre'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];


			$this->EinVIN = $fila['EinVIN'];
			$this->EinPlaca = $fila['EinPlaca'];

			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];

			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre'];

			$this->VtiId = $fila['VtiId'];
			$this->VtiNombre = $fila['VtiNombre'];

			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerFirma = $fila['PerFirma'];
			
			$this->PerEmail = $fila['PerEmail'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerTelefono = $fila['PerTelefono'];
			
			$this->CliNombreSeguro = $fila['CliNombreSeguro'];
			$this->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
			$this->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];

	
		
			if($oCompleto){
				
			
				$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
				$ResCotizacionProductoDetalle =  $InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalles(NULL,NULL,NULL,NULL,NULL,$this->CprId);
				
				$this->CotizacionProductoDetalle = 	$ResCotizacionProductoDetalle['Datos'];	
	
				$InsCotizacionProductoPlanchadoPintado = new ClsCotizacionProductoPlanchadoPintado();
				$ResCotizacionProductoPlanchado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"L");			
				$this->CotizacionProductoPlanchado = 	$ResCotizacionProductoPlanchado['Datos'];	
	
				$ResCotizacionProductoPintado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"I");			
				$this->CotizacionProductoPintado = 	$ResCotizacionProductoPintado['Datos'];	
				
				$ResCotizacionProductoCentrado =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"C");			
				$this->CotizacionProductoCentrado = 	$ResCotizacionProductoCentrado['Datos'];	
				
				$ResCotizacionProductoTarea =  $InsCotizacionProductoPlanchadoPintado->MtdObtenerCotizacionProductoPlanchadoPintados(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,"Z");			
				$this->CotizacionProductoTarea = 	$ResCotizacionProductoTarea['Datos'];	
				
				$InsCotizacionProductoFoto = new ClsCotizacionProductoFoto();
				//MtdObtenerCotizacionProductoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {
				$ResCotizacionProductoFoto =  $InsCotizacionProductoFoto->MtdObtenerCotizacionProductoFotos(NULL,NULL,NULL,NULL,NULL,$this->CprId,NULL,NULL);
				$this->CotizacionProductoFoto = 	$ResCotizacionProductoFoto['Datos'];
							
			}
			switch($this->CprEstado){
			
			  case 1:
				  $Estado = "Emitido";
			  break;
			
			  case 2:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Enviado]";
			  break;
			
			  case 3:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisando]";
			  break;	
			
			  case 4:
				  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Por Facturar]";
			  break;
			
			  case 5:
				  $Estado = "<img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
			  break;
			  
			  
			  case 6:
				  $Estado = "<img src='imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='ANULADO' > [Anulado]";
			  break;
			
			  default:
				  $Estado = "";
			  break;					
			
			}
			
			$this->CprEstadoDescripcion = $Estado;
			

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCotizacionProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oVehiculoIngreso=NULL,$oPersonal=NULL,$oCliente=NULL,$oTieneFichaIngreso=NULL,$oSucursal=NULL,$oVentaPerdida=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$estado = '';
		$moneda = '';
		$fichaIngreso = '';
		$vehiculoIngreso = '';
		$personal = '';
		$cliente = '';
		$tieneFichaIngreso = '';
		$sucursal = '';
		$ventaPerdida = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					crd.CrdId
					FROM tblcrdcotizacionproductodetalle crd
						LEFT JOIN tblproproducto pro
						ON crd.ProId = pro.ProId
						
					WHERE 
						crd.CprId = cpr.CprId AND
						(
						crd.CrdDescripcion LIKE "%'.$oFiltro.'%" OR
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						crd.CrdCodigo  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						
						)
						
					) ';
					
					
				$filtrar .= '  ) ';

			
				
	
		}


		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'" AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND cpr.CprEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cpr.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND cpr.FinId = "'.$oFichaIngreso.'"';
		}
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND cpr.EinId = "'.$oVehiculoIngreso.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND cpr.PerId = "'.$oPersonal.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND cpr.CliId = "'.$oCliente.'"';
		}
				
		if($oTieneFichaIngreso){
			switch($oTieneFichaIngreso){
				case "FichaIngresoSi":
					$tfingreso = ' AND cpr.FinId IS NOT NULL ';
				break;
				
				case "FichaIngresoNo":
					$tfingreso = ' AND cpr.FinId IS  NULL ';
				break;
				
				default:
					$tfingreso = ' ';
				break;
			}
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cpr.SucId = "'.$oSucursal.'"';
		}
		
		
		if(!empty($oVentaPerdida)){
			$vperdida = ' AND cpr.CprVentaPerdida = "'.$oVentaPerdida.'"';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cpr.CprId,
cpr.SucId,	
				
				cpr.CliId,
				cpr.LtiId,
				
				cpr.CliIdSeguro,
				
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
				DATE_FORMAT(cpr.CprHora, "%H:%i") AS "NCprHora",
				
				cpr.EinId,
				cpr.PerId,
				cpr.FinId,
				
				
				cpr.CprVIN,
				cpr.CprMarca,
				cpr.CprModelo,
				cpr.CprPlaca,
				cpr.CprAnoModelo,
				
				cpr.MonId,
				cpr.CprTipoCambio,
				
				cpr.CprIncluyeImpuesto,
				cpr.CprPorcentajeImpuestoVenta,
				cpr.CprPorcentajeMargenUtilidad,
			  	cpr.CprPorcentajeManoObra,
				cpr.CprPorcentajeOtroCosto,
			  
				cpr.CprObservacion,
cpr.CprObservacionImpresa,

				cpr.CprTelefono,
				cpr.CprDireccion,
				cpr.CprEmail,
				cpr.CprRepresentante,
				cpr.CprAsegurado,
				
				cpr.CprManoObra,
				cpr.CprPorcentajeDescuento,
				cpr.CprVigencia,
				cpr.CprTiempoEntrega,
				DATE_FORMAT(adddate(cpr.CprFecha,cpr.CprTiempoEntrega), "%d/%m/%Y") AS CprFechaEntrega,
			
			cpr.CprPlanchadoTotal,
			cpr.CprPintadoTotal,
			cpr.CprProductoTotal,
					
				cpr.CprDescuento,
				cpr.CprSubTotal,
				cpr.CprImpuesto,				
				cpr.CprTotal,
				
				cpr.CprFirmaDigital,
				cpr.CprVerificar,
				
				cpr.CprNotificar,
				
					cpr.CprVentaPerdida,
		cpr.CprVentaPerdidaMotivo,
				cpr.CprEstado,
CprNivelInteres,
				DATE_FORMAT(cpr.CprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoCreacion",
	        	DATE_FORMAT(cpr.CprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoModificacion",
				
				

				
				CASE
				WHEN EXISTS (
					SELECT 
					crd.CrdId 
					FROM tblcrdcotizacionproductodetalle crd
					WHERE crd.CprId = cpr.CprId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprRepuesto,
				
				
						CASE
					WHEN EXISTS (
						SELECT 
						crd.CrdId 
						FROM tblcrdcotizacionproductodetalle crd
						WHERE crd.CprId = cpr.CprId 
						AND crd.CrdEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprRepuestoVerificado,
					
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "L" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPlanchado,
				
						CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "L" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPlanchadoVerificado,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "I" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprPintado,
				
				
						
					CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "I" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprPintadoVerificado,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "C" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprCentrado,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "C" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprCentradoVerificado,
					
					
					
					
					
					
				CASE
				WHEN EXISTS (
					SELECT 
					cpp.CppId 
					FROM tblcppcotizacionproductoplanchadopintado cpp 
					WHERE cpp.CprId = cpr.CprId AND cpp.CppTipo = "Z" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprTarea,
				
				
							CASE
					WHEN EXISTS (
						SELECT 
						cpp.CppId 
						FROM tblcppcotizacionproductoplanchadopintado cpp 
						WHERE cpp.CprId = cpr.CprId 
						AND cpp.CppTipo = "Z" 
						AND cpp.CppEstado = 1
						LIMIT 1
					) THEN "Si"
					ELSE "No"
					END AS CprTareaVerificado,
					







				CASE
				WHEN EXISTS (
					SELECT 
					vdi.VdiId
					FROM tblvdiventadirecta vdi
					WHERE vdi.CprId = cpr.CprId 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CprVentaDirecta,

				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(crd.CrdCantidad,0) - IFNULL(

								(
									SELECT 
									SUM(vdd.VddCantidad)
									FROM tblvddventadirectadetalle vdd
									
										LEFT JOIN tblvdiventadirecta vdi
										ON vdd.VdiId = vdi.VdiId
											
									WHERE vdd.CrdId = crd.CrdId
										AND vdi.VdiEstado = 3
									LIMIT 1
								)

							,0)
							
						)  AS CrdCantidadPendiente

					FROM tblcrdcotizacionproductodetalle crd
						LEFT JOIN tblvddventadirectadetalle vdd
						ON vdd.CrdId = crd.CrdId

					WHERE crd.CprId = cpr.CprId
						HAVING CrdCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarVentaDirecta,
				
				(SELECT COUNT(crd.CrdId) FROM tblcrdcotizacionproductodetalle crd WHERE crd.CprId = cpr.CprId ) AS "CprTotalItems",
		
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
				cli.CliNumeroDocumento,
				tdo.TdoNombre,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				ein.EinVIN,
				ein.EinPlaca,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				seg.CliNombre AS CliNombreSeguro,
				seg.CliApellidoPaterno AS CliApellidoPaternoSeguro,
				seg.CliApellidoMaterno AS CliApellidoMaternoSeguro,
				seg.CliArchivo AS CliFotoSeguro
				
				FROM tblcprcotizacionproducto cpr
					LEFT JOIN tblclicliente cli
					ON cpr.CliId = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cpr.LtiId = lti.LtiId
							
							LEFT JOIN tblclicliente seg
								ON cpr.CliIdSeguro = seg.CliId
						
						
								LEFT JOIN tblmonmoneda mon
								ON cpr.MonId = mon.MonId
									LEFT JOIN	tbleinvehiculoingreso ein
									ON cpr.EinId = ein.EinId
								
										LEFT JOIN tblvmavehiculomarca vma
										ON ein.VmaId = vma.VmaId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON ein.VmoId = vmo.VmoId
												LEFT JOIN tblvvevehiculoversion vve
												ON ein.VveId = vve.VveId
												
												
													LEFT JOIN tblperpersonal per
									ON cpr.PerId = per.PerId
									
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$stipo.$estado.$moneda.$fingreso.$vingreso.$cliente .$tfingreso .$personal.$orden.$paginacion;											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionProducto = new $InsCotizacionProducto();
                    $CotizacionProducto->CprId = $fila['CprId'];
					$CotizacionProducto->SucId = $fila['SucId'];
					
					
					$CotizacionProducto->CliId = $fila['CliId'];
					$CotizacionProducto->LtiId = $fila['LtiId'];
					$CotizacionProducto->CprFecha = $fila['NCprFecha'];
					$CotizacionProducto->CprHora = $fila['NCprHora'];
					
					$CotizacionProducto->EinId = $fila['EinId'];
					$CotizacionProducto->PerId = $fila['PerId'];
					$CotizacionProducto->FinId = $fila['FinId'];
					
					$CotizacionProducto->CprVIN = $fila['CprVIN'];
					$CotizacionProducto->CprMarca = $fila['CprMarca'];
					$CotizacionProducto->CprModelo = $fila['CprModelo'];
					$CotizacionProducto->CprPlaca = $fila['CprPlaca'];
					$CotizacionProducto->CprAnoModelo = $fila['CprAnoModelo'];
					
					$CotizacionProducto->MonId = $fila['MonId'];
					$CotizacionProducto->CprTipoCambio = $fila['CprTipoCambio'];
					
					$CotizacionProducto->CprIncluyeImpuesto = $fila['CprIncluyeImpuesto'];
					$CotizacionProducto->CprPorcentajeImpuestoVenta = $fila['CprPorcentajeImpuestoVenta'];
					$CotizacionProducto->CprPorcentajeMargenUtilidad = $fila['CprPorcentajeMargenUtilidad'];
					$CotizacionProducto->CprPorcentajeOtroCosto = $fila['CprPorcentajeOtroCosto'];
					$CotizacionProducto->CprPorcentajeManoObra = $fila['CprPorcentajeManoObra'];
									
					$CotizacionProducto->CprObservacion = $fila['CprObservacion'];
					$CotizacionProducto->CprObservacionImpresa = $fila['CprObservacionImpresa'];
					
					$CotizacionProducto->CprTelefono = $fila['CprTelefono'];
					$CotizacionProducto->CprDireccion = $fila['CprDireccion'];
					$CotizacionProducto->CprEmail = $fila['CprEmail'];
					$CotizacionProducto->CprRepresentante = $fila['CprRepresentante'];
					$CotizacionProducto->CprAsegurado = $fila['CprAsegurado'];



					$CotizacionProducto->CprManoObra = $fila['CprManoObra'];
					$CotizacionProducto->CprPorcentajeDescuento = $fila['CprPorcentajeDescuento'];							
					$CotizacionProducto->CprVigencia = $fila['CprVigencia'];
					$CotizacionProducto->CprTiempoEntrega = $fila['CprTiempoEntrega'];
					$CotizacionProducto->CprFechaEntrega = $fila['CprFechaEntrega'];
				
					$CotizacionProducto->CprPlanchadoTotal = $fila['CprPlanchadoTotal'];
					$CotizacionProducto->CprPintadoTotal = $fila['CprPintadoTotal'];
					$CotizacionProducto->CprProductoTotal = $fila['CprProductoTotal'];
					
					$CotizacionProducto->CprDescuento = $fila['CprDescuento'];
					$CotizacionProducto->CprSubTotal = $fila['CprSubTotal'];			
					$CotizacionProducto->CprImpuesto = $fila['CprImpuesto'];
					$CotizacionProducto->CprTotal = $fila['CprTotal'];

					$CotizacionProducto->CprFirmaDigital = $fila['CprFirmaDigital'];
					$CotizacionProducto->CprVerificar = $fila['CprVerificar'];
				
				
				
				
					$CotizacionProducto->CprNotificar = $fila['CprNotificar'];
					
					$CotizacionProducto->CprVentaPerdida = $fila['CprVentaPerdida'];
					$CotizacionProducto->CprVentaPerdidaMotivo = $fila['CprVentaPerdidaMotivo'];
				$CotizacionProducto->CprNivelInteres = $fila['CprNivelInteres'];
					
					$CotizacionProducto->CprEstado = $fila['CprEstado'];
					$CotizacionProducto->CprTiempoCreacion = $fila['NCprTiempoCreacion'];  
					$CotizacionProducto->CprTiempoModificacion = $fila['NCprTiempoModificacion']; 
					$CotizacionProducto->CprTotalItems = $fila['CprTotalItems'];
					
					$CotizacionProducto->CprRepuesto = $fila['CprRepuesto'];
					$CotizacionProducto->CprRepuestoVerificado = $fila['CprRepuestoVerificado'];
					$CotizacionProducto->CprPlanchado = $fila['CprPlanchado'];
					$CotizacionProducto->CprPlanchadoVerificado = $fila['CprPlanchadoVerificado'];
					$CotizacionProducto->CprPintado = $fila['CprPintado'];
					$CotizacionProducto->CprPintadoVerificado = $fila['CprPintadoVerificado'];
					$CotizacionProducto->CprCentrado = $fila['CprCentrado'];
					$CotizacionProducto->CprCentradoVerificado = $fila['CprCentradoVerificado'];
					$CotizacionProducto->CprTarea = $fila['CprTarea'];
					$CotizacionProducto->CprTareaVerificado = $fila['CprTareaVerificado'];
					
					$CotizacionProducto->CprVentaDirecta = $fila['CprVentaDirecta'];
					
					$CotizacionProducto->VdiGenerarVentaDirecta = $fila['VdiGenerarVentaDirecta'];

				
					$CotizacionProducto->TdoId = $fila['TdoId']; 
					$CotizacionProducto->CliNombre = $fila['CliNombre']; 
					$CotizacionProducto->CliNumeroDocumento = $fila['CliNumeroDocumento']; 

					$CotizacionProducto->TdoNombre = $fila['TdoNombre']; 
					$CotizacionProducto->LtiNombre = $fila['LtiNombre']; 
					$CotizacionProducto->LtiAbreviatura = $fila['LtiAbreviatura']; 


					$CotizacionProducto->MonSimbolo = $fila['MonSimbolo']; 
					$CotizacionProducto->MonNombre = $fila['MonNombre']; 

					$CotizacionProducto->EinVIN = $fila['EinVIN'];
					$CotizacionProducto->EinPlaca = $fila['EinPlaca'];
					
					$CotizacionProducto->VmaNombre = $fila['VmaNombre'];
					$CotizacionProducto->VmoNombre = $fila['VmoNombre'];
					$CotizacionProducto->VveNombre = $fila['VveNombre'];
					
					$CotizacionProducto->PerNombre = $fila['PerNombre'];
					$CotizacionProducto->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$CotizacionProducto->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$CotizacionProducto->CliNombreSeguro = $fila['CliNombreSeguro'];
					$CotizacionProducto->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
					$CotizacionProducto->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];
					$CotizacionProducto->CliFotoSeguro = $fila['CliFotoSeguro'];
	
					/*switch($CotizacionProducto->CprEstado){
						
					  case 1:
						  $Estado = "Emitido";
					  break;
					  
					  case 2:
						  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Enviado]";
					  break;
				  
					  case 3:
						  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisando]";
					  break;	
					  
					  case 4:
						  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Por Facturar]";
					  break;

					  
					  case 5:
						  $Estado = "<img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
					  break;
					  
					   case 6:
				 		 $Estado = "<img src='imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='ANULADO' > [Anulado]";
					  break;

					  default:
						  $Estado = "";
					  break;					
	
					}*/
					
					switch($CotizacionProducto->CprEstado){
						
					  case 1:
						  $Estado = "Emitido";
					  break;
					  
					  case 2:
						  $Estado = "Enviado";
					  break;
				  
					  case 3:
						  $Estado = "Revisando";
					  break;	
					  
					  case 4:
						  $Estado = "Por Facturar";
					  break;

					  
					  case 5:
						  $Estado = "Facturado";
					  break;
					  
					   case 6:
				 		 $Estado = "Anulado";
					  break;

					  default:
						  $Estado = "";
					  break;					
	
					}
					
					$CotizacionProducto->CprEstadoDescripcion = $Estado;
				
				
                    $CotizacionProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarCotizacionProducto($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){

					$ResCotizacionProductoDetalle = $InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalles(NULL,NULL,'CrdId','Desc',NULL,$elemento);
					$ArrCotizacionProductoDetalles = $ResCotizacionProductoDetalle['Datos'];

					if(!empty($ArrCotizacionProductoDetalles)){
						$detalle = '';

						foreach($ArrCotizacionProductoDetalles as $DatCotizacionProductoDetalle){
							$detalle .= '#'.$DatCotizacionProductoDetalle->CrdId;
						}

						if(!$InsCotizacionProductoDetalle->MtdEliminarCotizacionProductoDetalle($detalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblcprcotizacionproducto WHERE  (CprId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarCotizacionProducto(3,"Se elimino la Cotizacion",$elemento);		
						}
					}
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoCotizacionProducto($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tblcprcotizacionproducto SET CprEstado = '.$oEstado.' WHERE CprId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						switch($oEstado){
							
						  case 1:
							  $Auditoria = "Se actualizo el Estado de la Cotizacion a: Emitido";
						  break;
						  
						  case 2:
							  $Auditoria = "Se actualizo el Estado de la Cotizacion a: Almacen [Enviado]";
						  break;
					  
						  case 3:
							  $Auditoria = "Se actualizo el Estado de la Cotizacion a: Almacen [Revisando]";
						  break;	
						  
						  case 4:
							  $Auditoria = "Se actualizo el Estado de la Cotizacion a: Almacen [Por Facturar]";
						  break;
						  
						  case 5:
							  $Auditoria = "Se actualizo el Estado de la Cotizacion a: Contabilidad [Facturado]";
						  break;
	
							case 6:
							  $Auditoria = "Se actualizo el Estado de la Cotizacion a: Anulado";
						  break;
						  
						  default:
							  $Auditoria = "Error";
						  break;					
		
						}

						$this->CprId = $elemento;						
						$this->MtdAuditarCotizacionProducto(2,$Auditoria,$elemento);

					}
				}
			$i++;
	
			}

		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	
	//Accion eliminar	 
	public function MtdActualizarVentaPerdidaCotizacionProducto($oElementos,$oEstado,$oMotivo,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tblcprcotizacionproducto 
					SET CprVentaPerdida = '.$oEstado.',
					CprVentaPerdidaMotivo = "'.$oMotivo.'"					
					WHERE CprId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
					
						//$Auditoria = "Se actualizo el Estado de la Cotizacion a: Emitido";
//						  
//
//						$this->CprId = $elemento;						
//						$this->MtdAuditarCotizacionProducto(2,$Auditoria,$elemento);

					}
				}
			$i++;
	
			}

		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarNivelInteresCotizacionProducto($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsCotizacionProducto = new ClsCotizacionProducto();
//		$InsCotizacionProductoObsequios = new ClsCotizacionProductoObsequio();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblcprcotizacionproducto SET CprNivelInteres = '.$oEstado.' WHERE CprId = "'.$aux[0].'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarCotizacionProducto(2,"Se actualizo el Nivel de Interes de la Cotizacion de Producto",$aux);
				
					}

					
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
					
	
	public function MtdRegistrarCotizacionProducto() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarCotizacionProductoId();
		
		$this->InsMysql->MtdTransaccionIniciar();		


		if(empty($this->EinId)){
		
			if(!empty($this->CprVIN)){
		
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$this->CprVIN,'EinId','ASC','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"EinFechaRecepcion",NULL,NULL);
				$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
				
				if(!empty($ArrVehiculoIngresos)){
					
					foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
						$this->EinId = $DatVehiculoIngreso->EinId;
					}
					
				}else{
		
					/*$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->EinId = NULL;
					$InsVehiculoIngreso->EinVIN = $this->CprVIN;
					$InsVehiculoIngreso->EinPlaca = $this->CprPlaca;
					$InsVehiculoIngreso->EinAnoModelo = $this->CprAnoModelo;
					$InsVehiculoIngreso->EinAnoFabricacion = $this->CprAnoFabricacion;
					$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
					$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");		
		
					if($InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeCotizacionProducto()){
						$this->EinId = $InsVehiculoIngreso->EinId;
					}*/
					
				}
					
			}
		
		}
		
				
		
			$sql = 'INSERT INTO tblcprcotizacionproducto (
			CprId,	
			SucId,	
							
			CliId,
			LtiId,
			CprFecha,
			CprHora,
			
			CliIdSeguro,
			
			EinId,
			PerId,
			FinId,
			
			CprVIN,
			CprMarca,
			CprModelo,
			CprPlaca,
			CprAnoModelo,
			
			MonId,
			CprTipoCambio,
			
			CprIncluyeImpuesto,
			CprPorcentajeImpuestoVenta,
			CprPorcentajeMargenUtilidad,
			CprPorcentajeOtroCosto,
			CprPorcentajeManoObra,
			
			CprObservacion,
			CprObservacionImpresa,
			
			CprTelefono,
			CprDireccion,
			CprEmail,
			CprRepresentante,
			CprAsegurado,

			CprManoObra,
			CprPorcentajeDescuento,
			CprVigencia,
			CprTiempoEntrega,
					
			CprPlanchadoTotal,
			CprPintadoTotal,
			CprProductoTotal,
					
			CprDescuento,
			CprSubTotal,
			CprImpuesto,				
			CprTotal,
			
			CprFirmaDigital,
			CprVerificar,
			CprNotificar,
			
			CprVentaPerdida,
			CprVentaPerdidaMotivo,
			
			
			CprNivelInteres,
			CprEstado,			
			CprTiempoCreacion,
			CprTiempoModificacion) 
			VALUES (
			"'.($this->CprId).'", 
			"'.($this->SucId).'", 
			'.(empty($this->CliId)?"NULL,":'"'.$this->CliId.'",').'
			'.(empty($this->LtiId)?"NULL,":'"'.$this->LtiId.'",').'
			"'.($this->CprFecha).'", 
			"'.($this->CprHora).'", 
			
			'.(empty($this->CliIdSeguro)?"NULL,":'"'.$this->CliIdSeguro.'",').'
			
			'.(empty($this->EinId)?"NULL,":'"'.$this->EinId.'",').'
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			'.(empty($this->FinId)?"NULL,":'"'.$this->FinId.'",').'
			
			"'.($this->CprVIN).'", 
			"'.($this->CprMarca).'", 
			"'.($this->CprModelo).'", 
			"'.($this->CprPlaca).'", 
			"'.($this->CprAnoModelo).'", 
			
			"'.($this->MonId).'", 
			'.(empty($this->CprTipoCambio)?"NULL,":''.$this->CprTipoCambio.',').'
			
			'.($this->CprIncluyeImpuesto).',
			'.($this->CprPorcentajeImpuestoVenta).',
			'.($this->CprPorcentajeMargenUtilidad).',
			'.($this->CprPorcentajeOtroCosto).',
			'.($this->CprPorcentajeManoObra).',
			
			"'.($this->CprObservacion).'",
			"'.($this->CprObservacionImpresa).'",
			
			"'.($this->CprTelefono).'",
			"'.($this->CprDireccion).'",
			"'.($this->CprEmail).'",
			"'.($this->CprRepresentante).'",
			"'.($this->CprAsegurado).'",

			'.($this->CprManoObra).',
			'.($this->CprPorcentajeDescuento).',
			
			"'.($this->CprVigencia).'",
			"'.($this->CprTiempoEntrega).'",

			'.($this->CprPlanchadoTotal).',
			'.($this->CprPintadoTotal).',
			'.($this->CprProductoTotal).',
			
			
			'.($this->CprDescuento).',
			'.($this->CprSubTotal).',
			'.($this->CprImpuesto).',
			'.($this->CprTotal).',
			
			'.($this->CprFirmaDigital).',
			'.($this->CprVerificar).',
			'.($this->CprNotificar).',
			
			"'.($this->CprVentaPerdida).'",
			"'.($this->CprVentaPerdidaMotivo).'",
			
			
			
			'.($this->CprNivelInteres).',
			'.($this->CprEstado).',
			"'.($this->CprTiempoCreacion).'", 				
			"'.($this->CprTiempoModificacion).'");';			

			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
				if(!$resultado) {							
					$error = true;
				} 
			}

			if(!$error){


				if(!empty($this->EinId) and !empty($this->CliId)){
					
					
					//$InsVehiculoIngreso = new ClsVehiculoIngreso();
//					if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
//						$error = true;
//					}
					
//					$InsVehiculoIngresoCliente = new ClsCotizacionProductoFoto();
//					$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','ASC',NULL,$this->EinId,$this->CliId);
//						
//					$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
//						
//					if(empty($ArrVehiculoIngresoClientes)){
//						
//						$InsVehiculoIngresoCliente->CliId = $this->CliId;
//						$InsVehiculoIngresoCliente->EinId = $this->EinId;
//						$InsVehiculoIngresoCliente->VicEstado = 1;
//						$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
//						$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
//						$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();
//
//					}
					
				}
				
				
						
						
			}

			if(!$error){			
			
				if (!empty($this->CotizacionProductoDetalle)){		
						
					$validar = 0;	
					foreach ($this->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
						
						$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();		
						$InsCotizacionProductoDetalle->CprId = $this->CprId;
						$InsCotizacionProductoDetalle->ProId = $DatCotizacionProductoDetalle->ProId;
						$InsCotizacionProductoDetalle->UmeId = $DatCotizacionProductoDetalle->UmeId;
						
						$InsCotizacionProductoDetalle->CrdCodigo = $DatCotizacionProductoDetalle->CrdCodigo;
						$InsCotizacionProductoDetalle->CrdDescripcion = $DatCotizacionProductoDetalle->CrdDescripcion;
						
						$InsCotizacionProductoDetalle->CrdPorcentajeUtilidad = $DatCotizacionProductoDetalle->CrdPorcentajeUtilidad;
						$InsCotizacionProductoDetalle->CrdPorcentajeOtroCosto = $DatCotizacionProductoDetalle->CrdPorcentajeOtroCosto;
						$InsCotizacionProductoDetalle->CrdPorcentajeManoObra = $DatCotizacionProductoDetalle->CrdPorcentajeManoObra;
						$InsCotizacionProductoDetalle->CrdPorcentajePedido = $DatCotizacionProductoDetalle->CrdPorcentajePedido;
						
						$InsCotizacionProductoDetalle->CrdPorcentajeAdicional = $DatCotizacionProductoDetalle->CrdPorcentajeAdicional;
						$InsCotizacionProductoDetalle->CrdPorcentajeDescuento = $DatCotizacionProductoDetalle->CrdPorcentajeDescuento;					

						$InsCotizacionProductoDetalle->CrdCosto = $DatCotizacionProductoDetalle->CrdCosto;
						$InsCotizacionProductoDetalle->CrdValorVenta = $DatCotizacionProductoDetalle->CrdValorVenta;
						$InsCotizacionProductoDetalle->CrdAdicional = $DatCotizacionProductoDetalle->CrdAdicional;
						$InsCotizacionProductoDetalle->CrdDescuento = $DatCotizacionProductoDetalle->CrdDescuento;
						
						$InsCotizacionProductoDetalle->CrdPrecioBruto = $DatCotizacionProductoDetalle->CrdPrecioBruto;
						$InsCotizacionProductoDetalle->CrdDescuento = $DatCotizacionProductoDetalle->CrdDescuento;
						$InsCotizacionProductoDetalle->CrdPrecio = $DatCotizacionProductoDetalle->CrdPrecio;

						$InsCotizacionProductoDetalle->CrdCantidad = $DatCotizacionProductoDetalle->CrdCantidad;
						$InsCotizacionProductoDetalle->CrdCantidadReal = $DatCotizacionProductoDetalle->CrdCantidadReal;
						$InsCotizacionProductoDetalle->CrdImporte = $DatCotizacionProductoDetalle->CrdImporte;
						
						$InsCotizacionProductoDetalle->CrdTipoPedido = $DatCotizacionProductoDetalle->CrdTipoPedido;
						$InsCotizacionProductoDetalle->CrdObservacion = $DatCotizacionProductoDetalle->CrdObservacion;
						
						$InsCotizacionProductoDetalle->CrdEstado = $DatCotizacionProductoDetalle->CrdEstado;								
						$InsCotizacionProductoDetalle->CrdTiempoCreacion = $DatCotizacionProductoDetalle->CrdTiempoCreacion;
						$InsCotizacionProductoDetalle->CrdTiempoModificacion = $DatCotizacionProductoDetalle->CrdTiempoModificacion;						
						$InsCotizacionProductoDetalle->CrdEliminado = $DatCotizacionProductoDetalle->CrdEliminado;
						
						if($InsCotizacionProductoDetalle->MtdRegistrarCotizacionProductoDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPR_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->CotizacionProductoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
		if(!$error){			
			
				if (!empty($this->CotizacionProductoPlanchado)){		
						
					$validar = 0;				
					

					$InsCotizacionProductoPlanchado = new ClsCotizacionProductoPlanchadoPintado();		
											
					foreach ($this->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){

						$InsCotizacionProductoPlanchado->CprId = $this->CprId;
						$InsCotizacionProductoPlanchado->CppDescripcion = $DatCotizacionProductoPlanchado->CppDescripcion;
						$InsCotizacionProductoPlanchado->CppPrecio = 0;
						$InsCotizacionProductoPlanchado->CppCantidad = 1;
						$InsCotizacionProductoPlanchado->CppImporte = $DatCotizacionProductoPlanchado->CppImporte;
						$InsCotizacionProductoPlanchado->CppTipo = "L";
						$InsCotizacionProductoPlanchado->CppEstado = $DatCotizacionProductoPlanchado->CppEstado;							
						$InsCotizacionProductoPlanchado->CppTiempoCreacion = $DatCotizacionProductoPlanchado->CppTiempoCreacion;
						$InsCotizacionProductoPlanchado->CppTiempoModificacion = $DatCotizacionProductoPlanchado->CppTiempoModificacion;						
						$InsCotizacionProductoPlanchado->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;
						
						if($InsCotizacionProductoPlanchado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPR_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->CotizacionProductoPlanchado) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){			
			
				if (!empty($this->CotizacionProductoPintado)){		
						
					$validar = 0;				
						

						$InsCotizacionProductoPintado = new ClsCotizacionProductoPlanchadoPintado();	
											
					foreach ($this->CotizacionProductoPintado as $DatCotizacionProductoPintado){
					

						$DatCotizacionProductoPintado->CprId = $this->CprId;
						$DatCotizacionProductoPintado->CppDescripcion = $DatCotizacionProductoPintado->CppDescripcion;
						$DatCotizacionProductoPintado->CppPrecio = 0;
						$DatCotizacionProductoPintado->CppCantidad = 1;
						$DatCotizacionProductoPintado->CppImporte = $DatCotizacionProductoPintado->CppImporte;
						$DatCotizacionProductoPintado->CppTipo = "I";
						$DatCotizacionProductoPintado->CppEstado = $DatCotizacionProductoPintado->CppEstado;							
						$DatCotizacionProductoPintado->CppTiempoCreacion = $DatCotizacionProductoPintado->CppTiempoCreacion;
						$DatCotizacionProductoPintado->CppTiempoModificacion = $DatCotizacionProductoPintado->CppTiempoModificacion;						
						$DatCotizacionProductoPintado->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;

						if($DatCotizacionProductoPintado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPR_401';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->CotizacionProductoPintado) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			



			if(!$error){			
			
				if (!empty($this->CotizacionProductoCentrado)){		
						
					$validar = 0;				
						

						$InsCotizacionProductoCentrado = new ClsCotizacionProductoPlanchadoPintado();	
											
					foreach ($this->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){
					

						$DatCotizacionProductoCentrado->CprId = $this->CprId;
						$DatCotizacionProductoCentrado->CppDescripcion = $DatCotizacionProductoCentrado->CppDescripcion;
						$DatCotizacionProductoCentrado->CppPrecio = 0;
						$DatCotizacionProductoCentrado->CppCantidad = 1;
						$DatCotizacionProductoCentrado->CppImporte = $DatCotizacionProductoCentrado->CppImporte;
						$DatCotizacionProductoCentrado->CppTipo = "C";
						$DatCotizacionProductoCentrado->CppEstado = $DatCotizacionProductoCentrado->CppEstado;							
						$DatCotizacionProductoCentrado->CppTiempoCreacion = $DatCotizacionProductoCentrado->CppTiempoCreacion;
						$DatCotizacionProductoCentrado->CppTiempoModificacion = $DatCotizacionProductoCentrado->CppTiempoModificacion;						
						$DatCotizacionProductoCentrado->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;

						if($DatCotizacionProductoCentrado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPR_501';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->CotizacionProductoCentrado) <> $validar ){
						$error = true;
					}					
		
				}				
			}
			
			
			
			
			if(!$error){			
			
				if (!empty($this->CotizacionProductoTarea)){		
						
					$validar = 0;				
						

						$InsCotizacionProductoTarea = new ClsCotizacionProductoPlanchadoPintado();	
											
					foreach ($this->CotizacionProductoTarea as $DatCotizacionProductoTarea){
					

						$DatCotizacionProductoTarea->CprId = $this->CprId;
						$DatCotizacionProductoTarea->CppDescripcion = $DatCotizacionProductoTarea->CppDescripcion;
						$DatCotizacionProductoTarea->CppPrecio = 0;
						$DatCotizacionProductoTarea->CppCantidad = 1;
						$DatCotizacionProductoTarea->CppImporte = $DatCotizacionProductoTarea->CppImporte;
						$DatCotizacionProductoTarea->CppTipo = "Z";
						$DatCotizacionProductoTarea->CppEstado = $DatCotizacionProductoTarea->CppEstado;							
						$DatCotizacionProductoTarea->CppTiempoCreacion = $DatCotizacionProductoTarea->CppTiempoCreacion;
						$DatCotizacionProductoTarea->CppTiempoModificacion = $DatCotizacionProductoTarea->CppTiempoModificacion;						
						$DatCotizacionProductoTarea->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;

						if($DatCotizacionProductoTarea->MtdRegistrarCotizacionProductoPlanchadoPintado()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPR_601';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->CotizacionProductoTarea) <> $validar ){
						$error = true;
					}					
		
				}				
			}
			
			
			
	if(!$error){			
			
				if (!empty($this->CotizacionProductoFoto)){		
						
					$validar = 0;			
					
					foreach ($this->CotizacionProductoFoto as $DatCotizacionProductoFoto){
						
						$InsCotizacionProductoFoto = new ClsCotizacionProductoFoto();		
						$InsCotizacionProductoFoto->VdiId = $this->VdiId;
						$InsCotizacionProductoFoto->CpfArchivo = $DatCotizacionProductoFoto->CpfArchivo;
						$InsCotizacionProductoFoto->CpfTipo = $DatCotizacionProductoFoto->CpfTipo;									
						$InsCotizacionProductoFoto->CpfEstado = $DatCotizacionProductoFoto->CpfEstado;								
						$InsCotizacionProductoFoto->CpfTiempoCreacion = $DatCotizacionProductoFoto->VifTiempoCreacion;
						$InsCotizacionProductoFoto->CpfTiempoModificacion = $DatCotizacionProductoFoto->VifTiempoModificacion;						
						$InsCotizacionProductoFoto->CpfEliminado = $DatCotizacionProductoFoto->VifEliminado;
						
						if($InsCotizacionProductoFoto->MtdRegistrarCotizacionProductoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPR_701';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->CotizacionProductoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}			
			
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarCotizacionProducto(1,"Se registro la Cotizacion",$this);			
				return true;
			}			
					
	}
	
	
	
	public function MtdCotizacionProductoActualizarProductoUso($oCotizacionProductoId) {
			
			if(!empty($oCotizacionProductoId)){
				
				$this->CprId  = $oCotizacionProductoId;
				$this->MtdObtenerCotizacionProducto(true);
	
				if(!empty($this->EinId)){
					
					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->EinId = $this->EinId;
					$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);
					
					if(!empty($this->CotizacionProductoDetalle) and !empty($InsVehiculoIngreso->VveId)){
						foreach($this->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
	
							$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();
							$ResProductoVehiculoVersion = $InsProductoVehiculoVersion->MtdObtenerProductoVehiculoVersiones(NULL,NULL,"PvvId","ASC",NULL,$DatCotizacionProductoDetalle->ProId,$InsVehiculoIngreso->VveId);
							$ArrProductoVersiones = $ResProductoVehiculoVersion['Datos'];
							
							if(empty($ArrProductoVersiones)){
								
								
								$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();
								$InsProductoVehiculoVersion->ProId = $DatCotizacionProductoDetalle->ProId;
								$InsProductoVehiculoVersion->VveId = $InsVehiculoIngreso->VveId;
								$InsProductoVehiculoVersion->PvvTiempoCreacion = date("Y-m-d H:i:s");
								$InsProductoVehiculoVersion->PvvTiempoModificacion = date("Y-m-d H:i:s");
								$InsProductoVehiculoVersion->PvvEliminado = 1;
								
								if($InsProductoVehiculoVersion->MtdRegistrarProductoVehiculoVersion()){
							
								}
								
							}

							
						}
				
					}
						
				}else{
				
				
					if(!empty($this->CotizacionProductoDetalle)){
						foreach($this->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
								
							$InsProducto = new ClsProducto();
							$InsProducto->ProId = $DatCotizacionProductoDetalle->ProId;
							$InsProducto->MtdObtenerProducto(false);
							
							$InsProducto->MtdEditarProductoDato("ProReferencia",$InsProducto->ProReferencia." ".(!empty($this->CprMarca)?' '.$this->CprMarca:'').(!empty($this->CprModelo)?' '.$this->CprModelo:'').(!empty($this->CprAnoModelo)?' '.$this->CprAnoModelo:''),$DatCotizacionProductoDetalle->ProId);
							
						}
					}
					
						
						
							
				}

			}
		
		}
		
		
	public function MtdEditarCotizacionProducto() {

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		if(empty($this->EinId)){
		
			if(!empty($this->CprVIN)){
		
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$this->CprVIN,'EinId','ASC','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"EinFechaRecepcion",NULL,NULL);
				$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
				
				if(!empty($ArrVehiculoIngresos)){
					
					foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
						$this->EinId = $DatVehiculoIngreso->EinId;
					}
					
				}else{
		
					/*
					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->EinId = NULL;
					$InsVehiculoIngreso->EinVIN = $this->CprVIN;
					$InsVehiculoIngreso->EinPlaca = $this->CprPlaca;
					$InsVehiculoIngreso->EinAnoModelo = $this->CprAnoModelo;
					$InsVehiculoIngreso->EinAnoFabricacion = $this->CprAnoFabricacion;
					$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
					$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");		
		
					if($InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeCotizacionProducto()){
						$this->EinId = $InsVehiculoIngreso->EinId;
					}*/
					
				}
							
		
			}
		
		}
			
			
			
		$sql = 'UPDATE tblcprcotizacionproducto SET
		'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
		'.(empty($this->LtiId)?'LtiId = NULL, ':'LtiId = "'.$this->LtiId.'",').'
		CprFecha = "'.($this->CprFecha).'",
		
		'.(empty($this->CliIdSeguro)?'CliIdSeguro = NULL, ':'CliIdSeguro = "'.$this->CliIdSeguro.'",').'
		
		'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		
		'.(empty($this->FinId)?'FinId = NULL, ':'FinId = "'.$this->FinId.'",').'
		
		CprVIN = "'.($this->CprVIN).'",
		CprMarca = "'.($this->CprMarca).'",
		CprModelo = "'.($this->CprModelo).'",
		CprPlaca = "'.($this->CprPlaca).'",
		CprAnoModelo = "'.($this->CprAnoModelo).'",
		
		MonId = "'.($this->MonId).'",			
		'.(empty($this->CprTipoCambio)?'CprTipoCambio = NULL, ':'CprTipoCambio = '.$this->CprTipoCambio.',').'
		
		CprIncluyeImpuesto = '.($this->CprIncluyeImpuesto).',
		CprPorcentajeImpuestoVenta = '.($this->CprPorcentajeImpuestoVenta).',	
		CprPorcentajeMargenUtilidad = '.($this->CprPorcentajeMargenUtilidad).',	
		CprPorcentajeOtroCosto = '.($this->CprPorcentajeOtroCosto).',
		CprPorcentajeManoObra = '.($this->CprPorcentajeManoObra).',
		
		CprObservacion = "'.($this->CprObservacion).'",
		CprObservacionImpresa = "'.($this->CprObservacionImpresa).'",
		
		CprTelefono = "'.($this->CprTelefono).'",
		CprDireccion = "'.($this->CprDireccion).'",
		CprEmail = "'.($this->CprEmail).'",
		CprRepresentante = "'.($this->CprRepresentante).'",
		CprAsegurado = "'.($this->CprAsegurado).'",
		
		
		CprManoObra = '.($this->CprManoObra).',
		CprPorcentajeDescuento = '.($this->CprPorcentajeDescuento).',
		
		
		CprVigencia = "'.($this->CprVigencia).'",
		CprTiempoEntrega = "'.($this->CprTiempoEntrega).'",
		
		CprPlanchadoTotal = '.($this->CprPlanchadoTotal).',
		CprPintadoTotal = '.($this->CprPintadoTotal).',
		CprProductoTotal = '.($this->CprProductoTotal).',
		
		CprDescuento = '.($this->CprDescuento).',
		CprSubTotal = '.($this->CprSubTotal).',
		CprImpuesto = '.($this->CprImpuesto).',
		CprTotal = '.($this->CprTotal).',	
		
		CprFirmaDigital = '.($this->CprFirmaDigital).',			
		CprVerificar = '.($this->CprVerificar).',			
		
		CprVentaPerdida = "'.($this->CprVentaPerdida).'",
		CprVentaPerdidaMotivo = "'.($this->CprVentaPerdidaMotivo).'",
				
		CprNotificar = '.($this->CprNotificar).',
		CprEstado = '.($this->CprEstado).'
		WHERE CprId = "'.($this->CprId).'";';			
		
			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			
			
			if(!$error){

				if(!empty($this->EinId) and !empty($this->CliId)){
					
//					$InsVehiculoIngreso = new ClsVehiculoIngreso();
//					if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
//						$error = true;
//					}
					
					
//					$InsVehiculoIngresoCliente = new ClsCotizacionProductoFoto();
//					$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','ASC',NULL,$this->EinId,$this->CliId);
//						
//					$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
//						
//					if(empty($ArrVehiculoIngresoClientes)){
//						
//						$InsVehiculoIngresoCliente->CliId = $this->CliId;
//						$InsVehiculoIngresoCliente->EinId = $this->EinId;
//						$InsVehiculoIngresoCliente->VicEstado = 1;
//						$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
//						$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
//						$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();
//
//					}
					
				}
				
				
						
						
			}
			
//			if(!$error){
//				if(!empty($this->EinId) and !empty($this->CliId)){
//					$InsVehiculoIngreso = new ClsVehiculoIngreso();
//					if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
//						$error = true;
//					}
//				}
//			}
			
			if(!$error){

				if (!empty($this->CotizacionProductoDetalle)){		
						
					$validar = 0;	
					foreach ($this->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
						
						$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
						$InsCotizacionProductoDetalle->CrdId = $DatCotizacionProductoDetalle->CrdId;
						$InsCotizacionProductoDetalle->CprId = $this->CprId;
						$InsCotizacionProductoDetalle->ProId = $DatCotizacionProductoDetalle->ProId;
						$InsCotizacionProductoDetalle->UmeId = $DatCotizacionProductoDetalle->UmeId;

						$InsCotizacionProductoDetalle->CrdCodigo = $DatCotizacionProductoDetalle->CrdCodigo;
						$InsCotizacionProductoDetalle->CrdDescripcion = $DatCotizacionProductoDetalle->CrdDescripcion;
						
						$InsCotizacionProductoDetalle->CrdPorcentajeUtilidad = $DatCotizacionProductoDetalle->CrdPorcentajeUtilidad;
						$InsCotizacionProductoDetalle->CrdPorcentajeOtroCosto = $DatCotizacionProductoDetalle->CrdPorcentajeOtroCosto;
						$InsCotizacionProductoDetalle->CrdPorcentajeManoObra = $DatCotizacionProductoDetalle->CrdPorcentajeManoObra;
						$InsCotizacionProductoDetalle->CrdPorcentajePedido = $DatCotizacionProductoDetalle->CrdPorcentajePedido;
						
						$InsCotizacionProductoDetalle->CrdPorcentajeAdicional = $DatCotizacionProductoDetalle->CrdPorcentajeAdicional;
						$InsCotizacionProductoDetalle->CrdPorcentajeDescuento = $DatCotizacionProductoDetalle->CrdPorcentajeDescuento;
						
			
						$InsCotizacionProductoDetalle->CrdCosto = $DatCotizacionProductoDetalle->CrdCosto;
						$InsCotizacionProductoDetalle->CrdValorVenta = $DatCotizacionProductoDetalle->CrdValorVenta;
						$InsCotizacionProductoDetalle->CrdAdicional = $DatCotizacionProductoDetalle->CrdAdicional;
						$InsCotizacionProductoDetalle->CrdDescuento = $DatCotizacionProductoDetalle->CrdDescuento;
						
						$InsCotizacionProductoDetalle->CrdPrecioBruto = $DatCotizacionProductoDetalle->CrdPrecioBruto;
						$InsCotizacionProductoDetalle->CrdDescuento = $DatCotizacionProductoDetalle->CrdDescuento;
						$InsCotizacionProductoDetalle->CrdPrecio = $DatCotizacionProductoDetalle->CrdPrecio;

						$InsCotizacionProductoDetalle->CrdCantidad = $DatCotizacionProductoDetalle->CrdCantidad;
						$InsCotizacionProductoDetalle->CrdCantidadReal = $DatCotizacionProductoDetalle->CrdCantidadReal;
						$InsCotizacionProductoDetalle->CrdImporte = $DatCotizacionProductoDetalle->CrdImporte;
						
						$InsCotizacionProductoDetalle->CrdTipoPedido = $DatCotizacionProductoDetalle->CrdTipoPedido;
						$InsCotizacionProductoDetalle->CrdObservacion = $DatCotizacionProductoDetalle->CrdObservacion;
						$InsCotizacionProductoDetalle->CrdEstado = $DatCotizacionProductoDetalle->CrdEstado;
						$InsCotizacionProductoDetalle->CrdTiempoCreacion = $DatCotizacionProductoDetalle->CrdTiempoCreacion;
						$InsCotizacionProductoDetalle->CrdTiempoModificacion = $DatCotizacionProductoDetalle->CrdTiempoModificacion;
						$InsCotizacionProductoDetalle->CrdEliminado = $DatCotizacionProductoDetalle->CrdEliminado;
						
						if(empty($InsCotizacionProductoDetalle->CrdId)){
							if($InsCotizacionProductoDetalle->CrdEliminado<>2){
								if($InsCotizacionProductoDetalle->MtdRegistrarCotizacionProductoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionProductoDetalle->CrdEliminado==2){
								if($InsCotizacionProductoDetalle->MtdEliminarCotizacionProductoDetalle($InsCotizacionProductoDetalle->CrdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPR_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionProductoDetalle->MtdEditarCotizacionProductoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionProductoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error){

				if (!empty($this->CotizacionProductoPlanchado)){		
						
					$validar = 0;
					$InsCotizacionProductoPlanchado = new ClsCotizacionProductoPlanchadoPintado();

					foreach ($this->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){

						$InsCotizacionProductoPlanchado->CppId = $DatCotizacionProductoPlanchado->CppId;
						$InsCotizacionProductoPlanchado->CprId = $this->CprId;
						$InsCotizacionProductoPlanchado->CppDescripcion = $DatCotizacionProductoPlanchado->CppDescripcion;						
						$InsCotizacionProductoPlanchado->CppPrecio = 0;
						$InsCotizacionProductoPlanchado->CppCantidad = 1;
						$InsCotizacionProductoPlanchado->CppImporte = $DatCotizacionProductoPlanchado->CppImporte;
						$InsCotizacionProductoPlanchado->CppTipo = "L";
						$InsCotizacionProductoPlanchado->CppEstado = $DatCotizacionProductoPlanchado->CppEstado;
						$InsCotizacionProductoPlanchado->CppTiempoCreacion = $DatCotizacionProductoPlanchado->CppTiempoCreacion;
						$InsCotizacionProductoPlanchado->CppTiempoModificacion = $DatCotizacionProductoPlanchado->CppTiempoModificacion;
						$InsCotizacionProductoPlanchado->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;
						
						if(empty($InsCotizacionProductoPlanchado->CppId)){
							if($InsCotizacionProductoPlanchado->CppEliminado<>2){
								if($InsCotizacionProductoPlanchado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionProductoPlanchado->CppEliminado==2){
								if($InsCotizacionProductoPlanchado->MtdEliminarCotizacionProductoPlanchadoPintado($InsCotizacionProductoPlanchado->CppId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPR_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionProductoPlanchado->MtdEditarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionProductoPlanchado) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
				
		if(!$error){

				if (!empty($this->CotizacionProductoPintado)){		
						
					$validar = 0;				
					$InsCotizacionProductoPintado = new ClsCotizacionProductoPlanchadoPintado();

					foreach ($this->CotizacionProductoPintado as $DatCotizacionProductoPlanchado){

						$InsCotizacionProductoPintado->CppId = $DatCotizacionProductoPlanchado->CppId;
						$InsCotizacionProductoPintado->CprId = $this->CprId;
						$InsCotizacionProductoPintado->CppDescripcion = $DatCotizacionProductoPlanchado->CppDescripcion;						
						$InsCotizacionProductoPintado->CppPrecio = 0;
						$InsCotizacionProductoPintado->CppCantidad = 1;
						$InsCotizacionProductoPintado->CppImporte = $DatCotizacionProductoPlanchado->CppImporte;
						$InsCotizacionProductoPintado->CppTipo = "I";
						$InsCotizacionProductoPintado->CppEstado = $DatCotizacionProductoPlanchado->CppEstado;
						$InsCotizacionProductoPintado->CppTiempoCreacion = $DatCotizacionProductoPlanchado->CppTiempoCreacion;
						$InsCotizacionProductoPintado->CppTiempoModificacion = $DatCotizacionProductoPlanchado->CppTiempoModificacion;
						$InsCotizacionProductoPintado->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;
						
						if(empty($InsCotizacionProductoPintado->CppId)){
							if($InsCotizacionProductoPintado->CppEliminado<>2){
								if($InsCotizacionProductoPintado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_401';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionProductoPintado->CppEliminado==2){
								if($InsCotizacionProductoPintado->MtdEliminarCotizacionProductoPlanchadoPintado($InsCotizacionProductoPintado->CppId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPR_403';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionProductoPintado->MtdEditarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_402';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionProductoPintado) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if(!$error){

				if (!empty($this->CotizacionProductoCentrado)){		
						
					$validar = 0;				
					$InsCotizacionProductoCentrado = new ClsCotizacionProductoPlanchadoPintado();

					foreach ($this->CotizacionProductoCentrado as $DatCotizacionProductoPlanchado){

						$InsCotizacionProductoCentrado->CppId = $DatCotizacionProductoPlanchado->CppId;
						$InsCotizacionProductoCentrado->CprId = $this->CprId;
						$InsCotizacionProductoCentrado->CppDescripcion = $DatCotizacionProductoPlanchado->CppDescripcion;						
						$InsCotizacionProductoCentrado->CppPrecio = 0;
						$InsCotizacionProductoCentrado->CppCantidad = 1;
						$InsCotizacionProductoCentrado->CppImporte = $DatCotizacionProductoPlanchado->CppImporte;
						$InsCotizacionProductoCentrado->CppTipo = "C";
						$InsCotizacionProductoCentrado->CppEstado = $DatCotizacionProductoPlanchado->CppEstado;
						$InsCotizacionProductoCentrado->CppTiempoCreacion = $DatCotizacionProductoPlanchado->CppTiempoCreacion;
						$InsCotizacionProductoCentrado->CppTiempoModificacion = $DatCotizacionProductoPlanchado->CppTiempoModificacion;
						$InsCotizacionProductoCentrado->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;
						
						if(empty($InsCotizacionProductoCentrado->CppId)){
							if($InsCotizacionProductoCentrado->CppEliminado<>2){
								if($InsCotizacionProductoCentrado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_501';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionProductoCentrado->CppEliminado==2){
								if($InsCotizacionProductoCentrado->MtdEliminarCotizacionProductoPlanchadoPintado($InsCotizacionProductoCentrado->CppId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPR_503';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionProductoCentrado->MtdEditarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_502';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionProductoCentrado) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if(!$error){

				if (!empty($this->CotizacionProductoTarea)){		
						
					$validar = 0;				
					$InsCotizacionProductoTarea = new ClsCotizacionProductoPlanchadoPintado();

					foreach ($this->CotizacionProductoTarea as $DatCotizacionProductoPlanchado){

						$InsCotizacionProductoTarea->CppId = $DatCotizacionProductoPlanchado->CppId;
						$InsCotizacionProductoTarea->CprId = $this->CprId;
						$InsCotizacionProductoTarea->CppDescripcion = $DatCotizacionProductoPlanchado->CppDescripcion;						
						$InsCotizacionProductoTarea->CppPrecio = 0;
						$InsCotizacionProductoTarea->CppCantidad = 1;
						$InsCotizacionProductoTarea->CppImporte = $DatCotizacionProductoPlanchado->CppImporte;
						$InsCotizacionProductoTarea->CppTipo = "Z";
						$InsCotizacionProductoTarea->CppEstado = $DatCotizacionProductoPlanchado->CppEstado;
						$InsCotizacionProductoTarea->CppTiempoCreacion = $DatCotizacionProductoPlanchado->CppTiempoCreacion;
						$InsCotizacionProductoTarea->CppTiempoModificacion = $DatCotizacionProductoPlanchado->CppTiempoModificacion;
						$InsCotizacionProductoTarea->CppEliminado = $DatCotizacionProductoPlanchado->CppEliminado;
						
						if(empty($InsCotizacionProductoTarea->CppId)){
							if($InsCotizacionProductoTarea->CppEliminado<>2){
								if($InsCotizacionProductoTarea->MtdRegistrarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_601';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionProductoTarea->CppEliminado==2){
								if($InsCotizacionProductoTarea->MtdEliminarCotizacionProductoPlanchadoPintado($InsCotizacionProductoTarea->CppId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPR_603';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionProductoTarea->MtdEditarCotizacionProductoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_602';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionProductoTarea) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			if(!$error){

				if (!empty($this->CotizacionProductoFoto)){		

					$validar = 0;	
					foreach ($this->CotizacionProductoFoto as $DatCotizacionProductoFoto){

						$InsCotizacionProductoFoto = new ClsCotizacionProductoFoto();
						$InsCotizacionProductoFoto->CpfId = $DatCotizacionProductoFoto->CpfId;
						$InsCotizacionProductoFoto->CprId = $this->CprId;
						$InsCotizacionProductoFoto->CpfArchivo = $DatCotizacionProductoFoto->CpfArchivo;
						$InsCotizacionProductoFoto->CpfTipo = $DatCotizacionProductoFoto->CpfTipo;
						$InsCotizacionProductoFoto->CpfEstado = $DatCotizacionProductoFoto->CpfEstado;
						$InsCotizacionProductoFoto->CpfTiempoCreacion = $DatCotizacionProductoFoto->CpfTiempoCreacion;
						$InsCotizacionProductoFoto->CpfTiempoModificacion = $DatCotizacionProductoFoto->CpfTiempoModificacion;
						$InsCotizacionProductoFoto->CpfEliminado = $DatCotizacionProductoFoto->CpfEliminado;
						
						if(empty($InsCotizacionProductoFoto->CpfId)){
							if($InsCotizacionProductoFoto->CpfEliminado<>2){
								if($InsCotizacionProductoFoto->MtdRegistrarCotizacionProductoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_701';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionProductoFoto->CpfEliminado==2){
								if($InsCotizacionProductoFoto->MtdEliminarCotizacionProductoFoto($InsCotizacionProductoFoto->CpfId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPR_703';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionProductoFoto->MtdEditarCotizacionProductoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPR_702';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionProductoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarCotizacionProducto(2,"Se edito la Cotizacion",$this);		
				return true;
			}	
				
		}	
		
	

		
	public function MtdEditarCotizacionProductoDato($oCampo,$oDato,$oId) {

		global $Resultado;
		$error = false;


		$sql = 'UPDATE tblcprcotizacionproducto SET
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'

		CprTiempoModificacion = NOW()
		WHERE CprId = "'.($oId).'";';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			


			if($error) {
				return false;
			} else {	
				return true;
			}	
				
	}	
		
		
		
		private function MtdAuditarCotizacionProducto($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->CprId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		


public function MtdNotificarCotizacionProductoRegistro($oCotizacionProducto,$oDestinatario,$oConCodigo=false){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->CprId = $oCotizacionProducto;
			$this->MtdObtenerCotizacionProducto();
			
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Cotizacion.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->CprId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->CprFecha."</b>";	
			$mensaje .= "<br>";	

			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cod. Original";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Nombre";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Cantidad";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Importe";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
				$i = 1;	
			if(!empty($this->CotizacionProductoDetalle)){
				foreach($this->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
					
							$mensaje .= "<tr>";
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";

								$mensaje .= "<td>";				
								if($oConCodigo){
									$mensaje .= $DatCotizacionProductoDetalle->ProCodigoOriginal;									
								}else{
									$mensaje .= "-";
								}
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatCotizacionProductoDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatCotizacionProductoDetalle->CrdCantidad,2);
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatCotizacionProductoDetalle->CrdImporte,2);
								$mensaje .= "</td>";
				
							$mensaje .= "</tr>";
							$i++;				
							
					
				}
			}
			$mensaje .= "</table>";
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			echo $mensaje;
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: COT. Nro.: ".$this->CprId.(!empty($this->CprOrdenCompraNumero)?" - O.C. REF: ".$this->CprOrdenCompraNumero." ":"")." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
				
				
				
		}

}
?>