<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteFichaIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteProductoCompra {

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


public function MtdObtenerReporteProductoHistoriaCostos($oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oMoneda=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
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

		if(!empty($oProducto)){
			$producto = ' AND amd.ProId = "'.$oProducto.'" ';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'" ';
		}

		
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					
					pro.ProMarca,
					pro.ProReferencia,
					DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
					DATE_FORMAT(amo.AmoComprobanteNumero, "%d/%m/%Y") AS "NAmoComprobanteNumero",
					
					IF(amo.AmoIncluyeImpuesto=1,(amd.AmdCosto/((amo.AmoPorcentajeImpuestoVenta/100)+1)),amd.AmdCosto) AS AmdCosto,
					
					amo.MonId,
					amo.AmoTipoCambio,
					amo.AmoIncluyeImpuesto,

					mon.MonSimbolo
					
					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
									
									LEFT JOIN tblmonmoneda mon
									ON amo.MonId = mon.MonId
				WHERE amo.AmoEstado = 3 
				AND amo.AmoTipo = 1
				AND amo.AmoSubTipo = 1 
				AND amd.AmdCosto > 0				
				'.$filtrar.$fecha.$producto.$moneda.$cliente.$cfingreso.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoCompra = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProductoCompra = new $InsReporteProductoCompra();
                    $ReporteProductoCompra->ProId = $fila['ProId'];
					$ReporteProductoCompra->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProductoCompra->ProNombre = $fila['ProNombre'];
					$ReporteProductoCompra->ProMarca = $fila['ProMarca'];
					$ReporteProductoCompra->ProReferencia = $fila['ProReferencia'];
					$ReporteProductoCompra->AmdFecha = $fila['NAmdFecha'];
					$ReporteProductoCompra->AmoComprobanteNumero = $fila['NAmoComprobanteNumero'];
						
					$ReporteProductoCompra->AmdCosto = $fila['AmdCosto'];
					$ReporteProductoCompra->MonId = $fila['MonId'];
					$ReporteProductoCompra->AmoTipoCambio = $fila['AmoTipoCambio'];
					$ReporteProductoCompra->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					
					$ReporteProductoCompra->MonSimbolo = $fila['MonSimbolo'];
					
					
                    $ReporteProductoCompra->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProductoCompra;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	

}
?>