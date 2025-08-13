<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenMovimientoEntradaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenMovimientoEntradaDetalle {

	public $AmdId;
	public $AmoId;
	public $ProId;
	public $UmeId;
    public $AmdCantidad;	
	public $AmdCantidadReal;
	public $AmdIdAnterior;
	public $AmdCosto;
	public $AmdCostoAnterior;
	public $AmdCostoExtraTotal;
	public $AmdCostoExtraUnitario;
	public $AmdImporte;	
	public $AmdCostoPromedio;

	public $AmdInternacionalTotalAduana;
	public $AmdInternacionalTotalTransporte;
	public $AmdInternacionalTotalDesestiba;
	public $AmdInternacionalTotalAlmacenaje;
	public $AmdInternacionalTotalAdValorem;
	public $AmdInternacionalTotalAduanaNacional;
	public $AmdInternacionalTotalGastoAdministrativo;
	public $AmdInternacionalTotalOtroCosto1;
	public $AmdInternacionalTotalOtroCosto2;

	public $AmdNacionalTotalRecargo;
	public $AmdNacionalTotalFlete;
	public $AmdNacionalTotalOtroCosto;	

	public $AmdEstado;	
	public $AmdTiempoCreacion;
	public $AmdTiempoModificacion;
	public $AmdEliminado;

	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $RtiId;
	public $UmeIdOrigen;
	public $UmeNombre;
	public $UmeAbreviacion;

	public $AmoFecha;
	public $AmoComprobanteNumero;
	public $AmoComprobanteFecha;
	public $CtiNombre;
	
	public $AmoTotalNacional;
	public $AmoTotalInternacional;
	
	public $AmoSubTotal;
	
	public $PrvNombreCompleto;
	public $PrvNumeroDocumento;
	
	public $TopNombre;
	

	
	// public $AmdId;
//	public $AmoId;
//	public $ProId;
//	public $UmeId;
//    public $AmdCantidad;	
//	public $AmdCantidadReal;
//	public $AmdCosto;
//	public $AmdCostoAnterior;
//	public $AmdCostoTotal;
//	public $AmdImporte;	
//	public $AmdEstado;	
//	public $AmdTiempoCreacion;
//	public $AmdTiempoModificacion;
//    public $AmdEliminado;
//	
//	public $ProNombre;
//	public $ProCodigoOriginal;
//	public $ProCodigoAlternativo;
//	public $RtiId;
//	public $UmeIdOrigen;
//	
//	public $UmeNombre;
	
	
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarAlmacenMovimientoEntradaDetalleId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) AS "MAXIMO"
			FROM tblamdalmacenmovimientodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AmdId = "AMD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->AmdId = "AMD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenId=NULL) {

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
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oAlmacenMovimientoEntrada)){
			$amovimiento = ' AND amd.AmoId = "'.$oAlmacenMovimientoEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}
		
		switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND amo.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND amo.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}	
		
		if(!empty($oPedidoCompraDetalleId)){
			$pcdetalle = ' AND (amd.PcdId = "'.$oPedidoCompraDetalleId.'") ';
		}	
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (pcd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}
		
		if(!empty($oAlmacenId)){
			$almacen = ' AND (amo.AlmId = "'.$oAlmacenId.'") ';
		}	
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			amd.AmdIdAnterior,
			amd.AmdCosto,
			amd.AmdCostoAnterior,
			amd.AmdCostoExtraTotal,
			amd.AmdCostoExtraUnitario,
			amd.AmdValorTotal,
			amd.AmdCantidad,
			amd.AmdCantidadReal,
			amd.AmdImporte,
			amd.AmdCostoPromedio,

			amd.AmdInternacionalTotalAduana,
			amd.AmdInternacionalTotalTransporte,
			amd.AmdInternacionalTotalDesestiba,
			amd.AmdInternacionalTotalAlmacenaje,
			amd.AmdInternacionalTotalAdValorem,
			amd.AmdInternacionalTotalAduanaNacional,
			amd.AmdInternacionalTotalGastoAdministrativo,
			amd.AmdInternacionalTotalOtroCosto1,
			amd.AmdInternacionalTotalOtroCosto2,

			amd.AmdNacionalTotalRecargo,
			amd.AmdNacionalTotalFlete,
			amd.AmdNacionalTotalOtroCosto,
			
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS UmeIdOrigen,
			ume2.UmeNombre AS UmeNombreOrigen,

			ume.UmeNombre,
			ume.UmeAbreviacion,

			DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			cti.CtiNombre,

			amo.AmoTotalNacional,
			amo.AmoTotalInternacional,
			amo.AmoSubTotal,

			prv.PrvNombreCompleto,
			prv.PrvNumeroDocumento,

			top.TopNombre,

			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",

			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			cli.CliNombreCompleto,

			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,

			pcd.PcoId,

			pcd.PcdAno,
			pcd.PcdModelo,
			
			
			
			pco.OcoId,

			amo.TopId,

			(
				SELECT 
				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			) AS AmoFechaUltimaSalida,

			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos,

			oco.OcoTipo,
			
			amo.AmoTipo,
			amo.AmoSubTipo

			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblpcdpedidocompradetalle pcd
				ON amd.PcdId = pcd.PcdId
					
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
						LEFT JOIN tblocoordencompra oco
						ON pco.OcoId = oco.OcoId
						
						LEFT JOIN tblclicliente cli
						ON pco.CliId = cli.CliId
				
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId	
						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId
									
						LEFT  JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tbltoptipooperacion top
							ON amo.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON amo.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON amo.CtiId = cti.CtiId
			WHERE  amo.AmoTipo = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoEntradaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoEntradaDetalle = new $InsAlmacenMovimientoEntradaDetalle();
                    $AlmacenMovimientoEntradaDetalle->AmdId = $fila['AmdId'];
                    $AlmacenMovimientoEntradaDetalle->AmoId = $fila['AmoId'];
					$AlmacenMovimientoEntradaDetalle->UmeId = $fila['UmeId'];
					$AlmacenMovimientoEntradaDetalle->AmdIdAnterior = $fila['AmdIdAnterior'];
					$AlmacenMovimientoEntradaDetalle->AmdCosto = $fila['AmdCosto'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $fila['AmdCostoAnterior'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal = $fila['AmdCostoExtraTotal'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario = $fila['AmdCostoExtraUnitario'];
					$AlmacenMovimientoEntradaDetalle->AmdValorTotal = $fila['AmdValorTotal'];
			        $AlmacenMovimientoEntradaDetalle->AmdCantidad = $fila['AmdCantidad'];  
					$AlmacenMovimientoEntradaDetalle->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$AlmacenMovimientoEntradaDetalle->AmdImporte = $fila['AmdImporte'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoPromedio = $fila['AmdCostoPromedio'];
					
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana = $fila['AmdInternacionalTotalAduana'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte = $fila['AmdInternacionalTotalTransporte'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba = $fila['AmdInternacionalTotalDesestiba'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje = $fila['AmdInternacionalTotalAlmacenaje'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem = $fila['AmdInternacionalTotalAdValorem'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional = $fila['AmdInternacionalTotalAduanaNacional'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo = $fila['AmdInternacionalTotalGastoAdministrativo'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1 = $fila['AmdInternacionalTotalOtroCosto1'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2 = $fila['AmdInternacionalTotalOtroCosto2'];
					
					$AlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo = $fila['AmdNacionalTotalRecargo'];
					$AlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete = $fila['AmdNacionalTotalFlete'];
					$AlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto = $fila['AmdNacionalTotalOtroCosto'];
			
					
					$AlmacenMovimientoEntradaDetalle->AmdEstado = $fila['AmdEstado'];  
					$AlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$AlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$AlmacenMovimientoEntradaDetalle->ProId = $fila['ProId'];	
					
					$AlmacenMovimientoEntradaDetalle->AmoFecha = $fila['NAmoFecha'];	
					$AlmacenMovimientoEntradaDetalle->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];	
					$AlmacenMovimientoEntradaDetalle->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];	
					$AlmacenMovimientoEntradaDetalle->CtiNombre = $fila['CtiNombre'];
					
					$AlmacenMovimientoEntradaDetalle->AmoTotalNacional = $fila['AmoTotalNacional'];
					$AlmacenMovimientoEntradaDetalle->AmoTotalInternacional = $fila['AmoTotalInternacional'];
					$AlmacenMovimientoEntradaDetalle->AmoSubTotal = $fila['AmoSubTotal'];
	
                    $AlmacenMovimientoEntradaDetalle->ProNombre = (($fila['ProNombre']));
					$AlmacenMovimientoEntradaDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$AlmacenMovimientoEntradaDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));					
					$AlmacenMovimientoEntradaDetalle->RtiId = (($fila['RtiId']));
					$AlmacenMovimientoEntradaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$AlmacenMovimientoEntradaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					$AlmacenMovimientoEntradaDetalle->UmeNombre = (($fila['UmeNombre']));
					$AlmacenMovimientoEntradaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$AlmacenMovimientoEntradaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$AlmacenMovimientoEntradaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$AlmacenMovimientoEntradaDetalle->TopNombre = (($fila['TopNombre']));

					$AlmacenMovimientoEntradaDetalle->AmoComprobanteNumero = (($fila['AmoComprobanteNumero']));
					$AlmacenMovimientoEntradaDetalle->AmoComprobanteFecha = (($fila['NAmoComprobanteFecha']));

					$AlmacenMovimientoEntradaDetalle->PcoFecha = (($fila['NPcoFecha']));
					$AlmacenMovimientoEntradaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					
					$AlmacenMovimientoEntradaDetalle->CliNombre = (($fila['CliNombre']));
					$AlmacenMovimientoEntradaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$AlmacenMovimientoEntradaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$AlmacenMovimientoEntradaDetalle->PcoId = (($fila['PcoId']));
					
					$AlmacenMovimientoEntradaDetalle->PcdAno = (($fila['PcdAno']));
					$AlmacenMovimientoEntradaDetalle->PcdModelo = (($fila['PcdModelo']));
					
					$AlmacenMovimientoEntradaDetalle->OcoId = (($fila['OcoId']));

					$AlmacenMovimientoEntradaDetalle->TopId = (($fila['TopId']));
					
					$AlmacenMovimientoEntradaDetalle->AmoFechaUltimaSalida = (($fila['AmoFechaUltimaSalida']));
					$AlmacenMovimientoEntradaDetalle->AmoUltimaSalidaDiaTranscurridos = (($fila['AmoUltimaSalidaDiaTranscurridos']));

					$AlmacenMovimientoEntradaDetalle->OcoTipo = (($fila['OcoTipo']));
					
					$AlmacenMovimientoEntradaDetalle->AmoTipo = (($fila['AmoTipo']));
					$AlmacenMovimientoEntradaDetalle->AmoSubTipo = (($fila['AmoSubTipo']));

			
                    $AlmacenMovimientoEntradaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoEntradaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL) {

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
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oAlmacenMovimientoEntrada)){
			$amovimiento = ' AND amd.AmoId = "'.$oAlmacenMovimientoEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}
		
		switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND amo.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND amo.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}	
		
		if(!empty($oPedidoCompraDetalleId)){
			$pcdetalle = ' AND (amd.PcdId = "'.$oPedidoCompraDetalleId.'") ';
		}	
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (pcd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}	
		



		if(!empty($oAlmacenMovimientoEntradaEstado)){
			$amestado = ' AND (amo.AmoEstado = "'.$oAlmacenMovimientoEntradaEstado.'") ';
		}
		
		
	
		if(!empty($oVehiculoMarca)){

			$elementos = explode(",",$oVehiculoMarca);

				$i=1;
				$vmarca .= ' AND (';
				$elementos = array_filter($elementos);

				foreach($elementos as $elemento){
						$vmarca .= '  

						(
							EXISTS (
								
								SELECT
								pvv.PvvId
								FROM tblpvvproductovehiculoversion pvv
									LEFT JOIN tblvvevehiculoversion vve
									ON pvv.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
								WHERE vmo.VmaId = "'.$elemento.'"
								AND amd.ProId = pvv.ProId
							)
							
							OR
							
							pro.VmaId = "'.$elemento.'"
						)
			
						
						';	
						if($i<>count($elementos)){						
							$vmarca .= ' OR ';	
						}
				$i++;		
				}
				
				$vmarca .= ' ) ';

		}
		
		
		//
//		if(!empty($oVehiculoMarca)){
//			
//			$vmarca = '
//			AND 
//			
//			(
//				EXISTS (
//					
//					SELECT
//					pvv.PvvId
//					FROM tblpvvproductovehiculoversion pvv
//						LEFT JOIN tblvvevehiculoversion vve
//						ON pvv.VveId = vve.VveId
//							LEFT JOIN tblvmovehiculomodelo vmo
//							ON vve.VmoId = vmo.VmoId
//					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
//					AND amd.ProId = pvv.ProId
//				)
//				
//				OR
//				
//				pro.VmaId = "'.$oVehiculoMarca.'"
//			)
//			';
//		}
		
		
		//if(!empty($oProductoTipo)){
		//	$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
		//}
		

		if(!empty($oProductoTipo)){

			$elementos = explode(",",$oProductoTipo);

				$i=1;
				$ptipo .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$ptipo .= '  (pro.RtiId = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$ptipo .= ' OR ';	
						}
				$i++;		
				}
				
				$ptipo .= ' ) ';

		}
		
		
		//if(!empty($oDiasInactivoInicio)){
//			$dinactivo = ' HAVING AmoUltimaSalidaDiaTranscurridos '.$AmoUltimaSalidaDiaTranscurridos.'") ';
//		}
			
	
		if(!empty($oDiasInactivoInicio)){
			
			if(!empty($oDiasInactivoFin)){
				
				$dinactivo .= ' AND  (
				
				(
					TIMESTAMPDIFF(DAY, 
				
					
						
					IFNULL( 
				
					(		
						
						SELECT 
						amo2.AmoFecha
						FROM tblamdalmacenmovimientodetalle amd2
							LEFT JOIN tblamoalmacenmovimiento amo2
							ON amd2.AmoId = amo2.AmoId
								WHERE amo2.AmoTipo = 2
								AND amd2.ProId = amd.ProId
								
								
				';

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}	
				
				
				$dinactivo .= '
						ORDER BY amo2.AmoFecha DESC
						LIMIT 1
						
						)
					,amo.AmoFecha

 					)
		
					
				
					, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) 
					)
					
				) >="'.$oDiasInactivoInicio.'" AND 
				
				
				(
				
				TIMESTAMPDIFF(DAY, 
			
					
					IFNULL( 
				
					(	
						SELECT 
						amo2.AmoFecha
						FROM tblamdalmacenmovimientodetalle amd2
							LEFT JOIN tblamoalmacenmovimiento amo2
							ON amd2.AmoId = amo2.AmoId
								WHERE amo2.AmoTipo = 2
								AND amd2.ProId = amd.ProId
								
								
					';
	
			if(!empty($oFechaInicio)){
				
				if(!empty($oFechaFin)){
					$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
				}else{
					$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
				}
				
			}else{
				if(!empty($oFechaFin)){
					$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
				}			
			}	
			
			
						$dinactivo .= '					
								
								
						ORDER BY amo2.AmoFecha DESC
						LIMIT 1
		
				
					)
				,amo.AmoFecha

 				)
				
				
				, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) 
				) <="'.$oDiasInactivoFin.'"
				
				';
			}else{
				
				$dinactivo = ' AND  
				
			(TIMESTAMPDIFF(DAY, 
			
					
					IFNULL( 
				
					(	
					
					SELECT 
					amo2.AmoFecha
					FROM tblamdalmacenmovimientodetalle amd2
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amd2.AmoId = amo2.AmoId
							WHERE amo2.AmoTipo = 2
							AND amd2.ProId = amd.ProId
							
			
			';

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}	
		
		
					$dinactivo .= '			
					
					
							
							
					ORDER BY amo2.AmoFecha DESC
					LIMIT 1
	
				)
				,amo.AmoFecha

 				)
			
				, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) )	
				
				
				 >="'.$oDiasInactivoInicio.'"';
			}
			
		}else{
			
			if(!empty($oDiasInactivoFin)){
				
				$dinactivo = ' AND  
				
				
					(TIMESTAMPDIFF(DAY, 
				
					IFNULL( 
				
					(	
	
						SELECT 
						amo2.AmoFecha
						FROM tblamdalmacenmovimientodetalle amd2
							LEFT JOIN tblamoalmacenmovimiento amo2
							ON amd2.AmoId = amo2.AmoId
								WHERE amo2.AmoTipo = 2
								AND amd2.ProId = amd.ProId
								
			
			
			';

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}	
		
		
					$dinactivo .= '			
					
					
								
								
						ORDER BY amo2.AmoFecha DESC
						LIMIT 1
	)
				,amo.AmoFecha

 				)
					
				
					, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) )
				
					<="'.$oDiasInactivoFin.'"';		
			}
						
		}
			
//			if(!empty($oDiasInactivoInicio)){
//			
//			if(!empty($oDiasInactivoFin)){
//				$dinactivo = ' HAVING  AmoUltimaSalidaDiaTranscurridos >="'.$oDiasInactivoInicio.'" AND AmoUltimaSalidaDiaTranscurridos <="'.$oDiasInactivoFin.'"';
//			}else{
//				$dinactivo = ' HAVING  AmoUltimaSalidaDiaTranscurridos >="'.$oDiasInactivoInicio.'"';
//			}
//			
//		}else{
//			
//			if(!empty($oDiasInactivoFin)){
//				$dinactivo = ' HAVING  AmoUltimaSalidaDiaTranscurridos <="'.$oDiasInactivoFin.'"';		
//			}
//						
//		}	
		
		
		if(!empty($oProducto)){
			$producto = ' AND pro.ProId = "'.$oProducto.'" ';		
		}		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
		
	/*	@AmoFechaUltimaSalida :=(
				SELECT 
				amo2.AmoFecha
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			),
			
			
			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos*/
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblpcdpedidocompradetalle pcd
				ON amd.PcdId = pcd.PcdId
					
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
					
						LEFT JOIN tblclicliente cli
						ON pco.CliId = cli.CliId
				
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId	
						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId
									
						LEFT  JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tbltoptipooperacion top
							ON amo.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON amo.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON amo.CtiId = cti.CtiId

			WHERE  amo.AmoTipo = 1 '.$ano.$mes.$amovimiento.$producto.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
					
//							(
//				SELECT 
//				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
//				FROM tblamdalmacenmovimientodetalle amd2
//					LEFT JOIN tblamoalmacenmovimiento amo2
//					ON amd2.AmoId = amo2.AmoId
//						WHERE amo2.AmoTipo = 2
//						AND amd2.ProId = amd.ProId
//				ORDER BY amo2.AmoFecha DESC
//				LIMIT 1
//
//			) AS AmoFechaUltimaSalida,
//			
//
//
//
//			IFNULL(
//				(SELECT 
//				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
//				FROM tblamdalmacenmovimientodetalle amd2
//					LEFT JOIN tblamoalmacenmovimiento amo2
//					ON amd2.AmoId = amo2.AmoId
//						WHERE amo2.AmoTipo = 2
//						AND amd2.ProId = amd.ProId
//				ORDER BY amo2.AmoFecha DESC
//				LIMIT 1),NOW()
//			) 
//			
//						
//			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos
//			
//			
//			
//			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}		
		
	//Accion eliminar	 
	
	public function MtdEliminarAlmacenMovimientoEntradaDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
//					if($i==count($elementos)){						
//						$eliminar .= '  (AmdId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (AmdId = "'.($elemento).'")  OR';	
//					}	

					if(!$error) {		
						$sql = 'DELETE FROM tblamdalmacenmovimientodetalle WHERE  (AmdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
//				$sql = 'DELETE FROM tblamdalmacenmovimientodetalle 
//				WHERE '.$eliminar;
//							
//				$error = false;
//	
//				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//				
//				if(!$resultado) {						
//					$error = true;
//				} 	
//				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	


	public function MtdRegistrarAlmacenMovimientoEntradaDetalle() {
	
			$this->MtdGenerarAlmacenMovimientoEntradaDetalleId();
			
			$sql = 'INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId,	
			ProId,
			UmeId,
			
			FaaId,
			FapId,
			VddId,
			PcdId,
			
			TadId,
			PpdId,
			
			AmdIdAnterior,
			AmdCosto,
			AmdCostoAnterior,
			AmdCostoExtraTotal,
			AmdCostoExtraUnitario,
			AmdCantidad,
			AmdCantidadReal,
			
			AmdValorTotal,
			AmdUtilidad,
			AmdPrecioVenta,
			
			AmdImporte,
			AmdCostoPromedio,
			AmdInternacionalTotalAduana,
			AmdInternacionalTotalTransporte,
			AmdInternacionalTotalDesestiba,
			AmdInternacionalTotalAlmacenaje,
			AmdInternacionalTotalAdValorem,
			AmdInternacionalTotalAduanaNacional,
			AmdInternacionalTotalGastoAdministrativo,
			AmdInternacionalTotalOtroCosto1,
			AmdInternacionalTotalOtroCosto2,
		
			AmdNacionalTotalRecargo,
			AmdNacionalTotalFlete,
			AmdNacionalTotalOtroCosto,
			
			AlmId,
			AmdFecha,
			
			AmdCierre,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			"'.($this->AmdId).'", 
			"'.($this->AmoId).'", 
			"'.($this->ProId).'",
			"'.trim($this->UmeId).'",
			
			NULL,
			NULL,
			NULL,
			'.(empty($this->PcdId)?'NULL, ':'"'.$this->PcdId.'",').'
			
			
			NULL,
			NULL,
			
			
			'.(empty($this->AmdIdAnterior)?'NULL, ':'"'.$this->AmdIdAnterior.'",').'
			'.($this->AmdCosto).',
			'.($this->AmdCostoAnterior).',
			'.($this->AmdCostoExtraTotal).',
			'.($this->AmdCostoExtraUnitario).',
			'.($this->AmdCantidad).',
			'.($this->AmdCantidadReal).',
			'.($this->AmdValorTotal).',
			0.00,
			0.00,

			'.($this->AmdImporte).',
			'.($this->AmdCostoPromedio).',
			'.($this->AmdInternacionalTotalAduana).',
			'.($this->AmdInternacionalTotalTransporte).',
			'.($this->AmdInternacionalTotalDesestiba).',
			'.($this->AmdInternacionalTotalAlmacenaje).',
			'.($this->AmdInternacionalTotalAdValorem).',
			'.($this->AmdInternacionalTotalAduanaNacional).',
			'.($this->AmdInternacionalTotalGastoAdministrativo).',
			'.($this->AmdInternacionalTotalOtroCosto1).',
			'.($this->AmdInternacionalTotalOtroCosto2).',
			
			'.($this->AmdNacionalTotalRecargo).',
			'.($this->AmdNacionalTotalFlete).',
			'.($this->AmdNacionalTotalOtroCosto).',
						
			"'.($this->AlmId).'",
			"'.($this->AmdFecha).'",
			
			2,
			'.($this->AmdEstado).',
			"'.($this->AmdTiempoCreacion).'",
			"'.($this->AmdTiempoModificacion).'");';					
		
			$error = false;

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
	
	public function MtdEditarAlmacenMovimientoEntradaDetalle() {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			UmeId = "'.trim($this->UmeId).'",
			
		ProId = "'.trim($this->ProId).'",
			
			'.(empty($this->AmdIdAnterior)?'AmdIdAnterior = NULL, ':'AmdIdAnterior = "'.$this->AmdIdAnterior.'",').'
			
			AmdCosto = '.($this->AmdCosto).',
			AmdCostoAnterior = '.($this->AmdCostoAnterior).',
			AmdCostoExtraTotal = '.($this->AmdCostoExtraTotal).',
			AmdCostoExtraUnitario = '.($this->AmdCostoExtraUnitario).',
			AmdCantidad = '.($this->AmdCantidad).',
			AmdCantidadReal = '.($this->AmdCantidadReal).',
			AmdImporte = '.($this->AmdImporte).',
			
			AmdCostoPromedio = '.($this->AmdCostoPromedio).',
			AmdValorTotal = '.($this->AmdValorTotal).',
			
			
			AmdInternacionalTotalAduana = '.($this->AmdInternacionalTotalAduana).',
			AmdInternacionalTotalTransporte = '.($this->AmdInternacionalTotalTransporte).',
			AmdInternacionalTotalDesestiba = '.($this->AmdInternacionalTotalDesestiba).',
			AmdInternacionalTotalAlmacenaje = '.($this->AmdInternacionalTotalAlmacenaje).',
			AmdInternacionalTotalAdValorem = '.($this->AmdInternacionalTotalAdValorem).',
			AmdInternacionalTotalAduanaNacional = '.($this->AmdInternacionalTotalAduanaNacional).',
			AmdInternacionalTotalGastoAdministrativo = '.($this->AmdInternacionalTotalGastoAdministrativo).',
			AmdInternacionalTotalOtroCosto1 = '.($this->AmdInternacionalTotalOtroCosto1).',
			AmdInternacionalTotalOtroCosto2 = '.($this->AmdInternacionalTotalOtroCosto2).',

			AmdNacionalTotalRecargo = '.($this->AmdNacionalTotalRecargo).',
			AmdNacionalTotalFlete = '.($this->AmdNacionalTotalFlete).',
			AmdNacionalTotalOtroCosto = '.($this->AmdNacionalTotalOtroCosto).',
			
			AlmId = "'.($this->AlmId).'",
			AmdFecha = "'.($this->AmdFecha).'",
			AmdEstado = '.($this->AmdEstado).'
			WHERE AmdId = "'.($this->AmdId).'";';
					
			$error = false;

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
		
		
	//public function MtdEditarProductoDato($oCampo,$oDato,$oProductoId) {


	public function MtdEditarAlmacenMovimientoEntradaDetalleDato($oCampo,$oDato,$oAlmacenMovimientoEntradaDetalleId) {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE AmdId = "'.($oAlmacenMovimientoEntradaDetalleId).'";';
					
			$error = false;

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
			
		
		 public function MtdObtenerUltimoAlmacenMovimientoEntradaDetalleId($oProductoId,$oFecha){

		$sql = 'SELECT
			 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha"
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId

		WHERE amd.ProId = "'.$oProductoId.'" 
		AND amo.AmoTipo = 1
		AND amo.AmoFecha < "'.$oFecha.'"
		ORDER BY amo.AmoFecha DESC LIMIT 1';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			$Respuesta = $fila['AmdId'];

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
		
		
	 public function MtdVerificarExisteUltimoAlmacenMovimientoEntradaDetalleId($oAlmacenMovimientoEntradaDetalleId){
		
		$Existe = false;
		
		$sql = 'SELECT
			 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha"
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId

		WHERE amd.AmdId = "'.$oAlmacenMovimientoEntradaDetalleId.'" 
	
		';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['AmdId'])){
				$Existe = true;		
			}

		}
		
        
		return $Existe;

    }
		
		/*public function MtdEditarAlmacenMovimientoEntradaDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE AmdId = "'.($oId).'";';
			
			$error = false;

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
*/
}
?>