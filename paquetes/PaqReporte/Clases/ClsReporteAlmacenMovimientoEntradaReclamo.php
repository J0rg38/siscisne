<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteAlmacenMovimientoEntradaReclamo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteAlmacenMovimientoEntradaReclamo {

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


    public function MtdObtenerReporteAlmacenMovimientoEntradaReclamos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oConReclamo=0) {

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

			amo.AmoTotal,

			prv.PrvNombreCompleto,
			prv.PrvNumeroDocumento,

			top.TopNombre,

			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			amo.AmoTipoCambio,
			
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

			oco.OcoTipo,
			
			amo.MonId,
			
			mon.MonNombre,
			mon.MonAbreviacion,
			mon.MonSimbolo,
			
			rde.RecId,
			DATE_FORMAT(rec.RecFechaEmision, "%d/%m/%Y") AS "NRecFechaEmision",
			
			rde.RdeCantidad

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
						
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
								
							LEFT JOIN tbltoptipooperacion top
							ON amo.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON amo.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON amo.CtiId = cti.CtiId
							
								LEFT JOIN tblrdereclamodetalle rde
								ON rde.AmdId = amd.AmdId
								
									LEFT JOIN tblrecreclamo rec
									ON rde.RecId = rec.RecId
								
							
			WHERE  amo.AmoTipo = 1 AND amd.AmdEstado <> 3 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteAlmacenMovimientoEntradaReclamo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteAlmacenMovimientoEntradaReclamo = new $InsReporteAlmacenMovimientoEntradaReclamo();
                    $ReporteAlmacenMovimientoEntradaReclamo->AmdId = $fila['AmdId'];
                    $ReporteAlmacenMovimientoEntradaReclamo->AmoId = $fila['AmoId'];
					$ReporteAlmacenMovimientoEntradaReclamo->UmeId = $fila['UmeId'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdIdAnterior = $fila['AmdIdAnterior'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdCosto = $fila['AmdCosto'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdCostoAnterior = $fila['AmdCostoAnterior'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdCostoExtraTotal = $fila['AmdCostoExtraTotal'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdCostoExtraUnitario = $fila['AmdCostoExtraUnitario'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdValorTotal = $fila['AmdValorTotal'];
			        $ReporteAlmacenMovimientoEntradaReclamo->AmdCantidad = $fila['AmdCantidad'];  
					$ReporteAlmacenMovimientoEntradaReclamo->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmdImporte = $fila['AmdImporte'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdCostoPromedio = $fila['AmdCostoPromedio'];
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalAduana = $fila['AmdInternacionalTotalAduana'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalTransporte = $fila['AmdInternacionalTotalTransporte'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalDesestiba = $fila['AmdInternacionalTotalDesestiba'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalAlmacenaje = $fila['AmdInternacionalTotalAlmacenaje'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalAdValorem = $fila['AmdInternacionalTotalAdValorem'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalAduanaNacional = $fila['AmdInternacionalTotalAduanaNacional'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalGastoAdministrativo = $fila['AmdInternacionalTotalGastoAdministrativo'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalOtroCosto1 = $fila['AmdInternacionalTotalOtroCosto1'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdInternacionalTotalOtroCosto2 = $fila['AmdInternacionalTotalOtroCosto2'];
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmdNacionalTotalRecargo = $fila['AmdNacionalTotalRecargo'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdNacionalTotalFlete = $fila['AmdNacionalTotalFlete'];
					$ReporteAlmacenMovimientoEntradaReclamo->AmdNacionalTotalOtroCosto = $fila['AmdNacionalTotalOtroCosto'];
			
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmdEstado = $fila['AmdEstado'];  
					$ReporteAlmacenMovimientoEntradaReclamo->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$ReporteAlmacenMovimientoEntradaReclamo->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$ReporteAlmacenMovimientoEntradaReclamo->ProId = $fila['ProId'];	
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmoFecha = $fila['NAmoFecha'];	
					$ReporteAlmacenMovimientoEntradaReclamo->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];	
					$ReporteAlmacenMovimientoEntradaReclamo->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];	
					$ReporteAlmacenMovimientoEntradaReclamo->AmoTipoCambio = $fila['AmoTipoCambio'];
					
					$ReporteAlmacenMovimientoEntradaReclamo->CtiNombre = $fila['CtiNombre'];
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmoTotal = $fila['AmoTotal'];
	
                    $ReporteAlmacenMovimientoEntradaReclamo->ProNombre = (($fila['ProNombre']));
					$ReporteAlmacenMovimientoEntradaReclamo->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$ReporteAlmacenMovimientoEntradaReclamo->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));					
					$ReporteAlmacenMovimientoEntradaReclamo->RtiId = (($fila['RtiId']));
					$ReporteAlmacenMovimientoEntradaReclamo->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$ReporteAlmacenMovimientoEntradaReclamo->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					$ReporteAlmacenMovimientoEntradaReclamo->UmeNombre = (($fila['UmeNombre']));
					$ReporteAlmacenMovimientoEntradaReclamo->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$ReporteAlmacenMovimientoEntradaReclamo->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$ReporteAlmacenMovimientoEntradaReclamo->TopNombre = (($fila['TopNombre']));

					$ReporteAlmacenMovimientoEntradaReclamo->AmoComprobanteNumero = (($fila['AmoComprobanteNumero']));
					$ReporteAlmacenMovimientoEntradaReclamo->AmoComprobanteFecha = (($fila['NAmoComprobanteFecha']));

					$ReporteAlmacenMovimientoEntradaReclamo->PcoFecha = (($fila['NPcoFecha']));
					$ReporteAlmacenMovimientoEntradaReclamo->CliNombreCompleto = (($fila['CliNombreCompleto']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->CliNombre = (($fila['CliNombre']));
					$ReporteAlmacenMovimientoEntradaReclamo->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$ReporteAlmacenMovimientoEntradaReclamo->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->PcoId = (($fila['PcoId']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->PcdAno = (($fila['PcdAno']));
					$ReporteAlmacenMovimientoEntradaReclamo->PcdModelo = (($fila['PcdModelo']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->OcoId = (($fila['OcoId']));

					$ReporteAlmacenMovimientoEntradaReclamo->TopId = (($fila['TopId']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->AmoFechaUltimaSalida = (($fila['AmoFechaUltimaSalida']));
					$ReporteAlmacenMovimientoEntradaReclamo->AmoUltimaSalidaDiaTranscurridos = (($fila['AmoUltimaSalidaDiaTranscurridos']));

					$ReporteAlmacenMovimientoEntradaReclamo->OcoTipo = (($fila['OcoTipo']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->MonId = (($fila['MonId']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->MonNombre = (($fila['MonNombre']));
					$ReporteAlmacenMovimientoEntradaReclamo->MonAbreviacion = (($fila['MonAbreviacion']));
					$ReporteAlmacenMovimientoEntradaReclamo->MonSimbolo = (($fila['MonSimbolo']));
					
					$ReporteAlmacenMovimientoEntradaReclamo->RecId = (($fila['RecId']));
					$ReporteAlmacenMovimientoEntradaReclamo->RecFechaEmision = (($fila['NRecFechaEmision']));
					$ReporteAlmacenMovimientoEntradaReclamo->RdeCantidad = (($fila['RdeCantidad']));

			
                    $ReporteAlmacenMovimientoEntradaReclamo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteAlmacenMovimientoEntradaReclamo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
			
		
}
?>