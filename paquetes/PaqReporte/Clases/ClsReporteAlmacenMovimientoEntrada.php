<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteAlmacenMovimientoEntrada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteAlmacenMovimientoEntrada {



	public $AmoFecha;
	public $AmoComprobanteFecha;
	public $AmoComprobanteNumero;
	public $ProId;
	public $ProCodigoOriginal;
	public $ProNombre;
	public $ProReferencia;
	
	public $AmoPromedioVenta;
	
	public $AmoMovimientoSalida;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

    public function MtdObtenerReporteAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmoFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConStock=NULL,$oClienteClasificacion=NULL) {

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
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND  pro.RtiId = "'.$oProductoTipo.'"';		
		}	
		
		switch($oConStock){
			case 1:
				$cstock = ' HAVING  AmoTotalSaldo>0';
			break;
			
			case 2:
				$cstock = ' HAVING AmoTotalSaldo<=0';
			break;
			
			default:
				$cstock = '';
			break;
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amo.AmoId,

			DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			amo.AmoComprobanteNumero,

			pro.ProId,
			pro.ProCodigoOriginal,
			pro.ProNombre,
			pro.ProReferencia,
			
			

			CASE
			WHEN EXISTS (
				SELECT amd2.AmdId
	
				FROM tblamdalmacenmovimientodetalle amd2
				
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						
						LEFT JOIN tblclicliente cli
						ON amo2.CliId = cli.CliId
						
					WHERE amo2.AmoTipo = 2
					AND amd2.ProId = amd.ProId
					
					'.(!empty($oFechaInicio)?' AND DATE(amo2.AmoFecha) >= "'.$oFechaInicio.'"':'').'
					'.(!empty($oFechaFin)?' AND DATE(amo2.AmoFecha) <= "'.$oFechaFin.'"':'').'
					
					'.(!empty($oClienteClasificacion)?' AND cli.CliClasificacion = '.$oClienteClasificacion.'':'').'
					
				LIMIT 1
			) THEN "Si"
			ELSE "No"
			END AS AmoMovimientoSalida,
			

			@AmoFechaUltimaSalida :=(
				SELECT 
				amo2.AmoFecha
				FROM tblamdalmacenmovimientodetalle amd2
				
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
					
						LEFT JOIN tblclicliente cli
						ON amo2.CliId = cli.CliId
						
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId

					'.(!empty($oFechaInicio)?' AND DATE(amo2.AmoFecha) >= "'.$oFechaInicio.'"':'').'
					'.(!empty($oFechaFin)?' AND DATE(amo2.AmoFecha) <= "'.$oFechaFin.'"':'').'

					'.(!empty($oClienteClasificacion)?' AND cli.CliClasificacion = '.$oClienteClasificacion.'':'').'

				ORDER BY amo2.AmoFecha DESC
				LIMIT 1
			),
			
			
			(
				SELECT 
				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
					
						LEFT JOIN tblclicliente cli
						ON amo2.CliId = cli.CliId
							
				WHERE amo2.AmoTipo = 2
				AND amd2.ProId = amd.ProId 
				
				'.(!empty($oFechaInicio)?' AND DATE(amo2.AmoFecha) >= "'.$oFechaInicio.'"':'').'
				'.(!empty($oFechaFin)?' AND DATE(amo2.AmoFecha) <= "'.$oFechaFin.'"':'').'
					
				'.(!empty($oClienteClasificacion)?' AND cli.CliClasificacion = '.$oClienteClasificacion.'':'').'
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			) AS AmoFechaUltimaSalida,
			
			
			
			(
				SELECT 
				amd.AmdCantidad
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
					
						LEFT JOIN tblclicliente cli
						ON amo2.CliId = cli.CliId
							
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
						
						'.(!empty($oFechaInicio)?' AND DATE(amo2.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo2.AmoFecha) <= "'.$oFechaFin.'"':'').'
					
				 		'.(!empty($oClienteClasificacion)?' AND cli.CliClasificacion = '.$oClienteClasificacion.'':'').'
				
				
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			) AS AmoCantidadUltimaSalida,


			(TIMESTAMPDIFF(DAY, (IFNULL(@AmoFechaUltimaSalida,amo.AmoFecha)), "'.($oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos,
			(TIMESTAMPDIFF(DAY, (amo.AmoFecha), "'.$oFechaFin.' 00:00:00" ) ) AS AmoInicialDiaTranscurridos,

			SUM(amd.AmdCantidad) AS AmoTotalIngreso,

			@Ingresos:=(
					SELECT 
					SUM(IFNULL(amd3.AmdCantidadReal,0))
					FROM tblamdalmacenmovimientodetalle amd3
						LEFT JOIN tblamoalmacenmovimiento amo3
						ON amd3.AmoId = amo3.AmoId
							WHERE amo3.AmoEstado = 3 
							AND amo3.AmoTipo = 1
							AND amd3.ProId = pro.ProId
							
								
					'.(!empty($oFechaInicio)?' AND DATE(amo3.AmoFecha) >= "'.$oFechaInicio.'"':'').'
					'.(!empty($oFechaFin)?' AND DATE(amo3.AmoFecha) <= "'.$oFechaFin.'"':'').'
						

				) ,
				
				
				@Salidas:=(
					SELECT 
					SUM(IFNULL(amd3.AmdCantidadReal,0))
					FROM tblamdalmacenmovimientodetalle amd3
						LEFT JOIN tblamoalmacenmovimiento amo3
						ON amd3.AmoId = amo3.AmoId
							WHERE amo3.AmoEstado = 3 
							AND amo3.AmoTipo = 2
							AND amd3.ProId = pro.ProId
							
								
						'.(!empty($oFechaInicio)?' AND DATE(amo3.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo3.AmoFecha) <= "'.$oFechaFin.'"':'').'
						
							
				), 
				
				
				(
					IFNULL(@Ingresos,0) - IFNULL(@Salidas,0)
				) AS AmoTotalSaldo,
				
			
			
			
			(  IFNULL(@Salidas,0) / ( IFNULL( (TIMESTAMPDIFF(DAY, ("'.(!empty($oFechaInicio)?$oFechaInicio:date("Y-m-d")).'"), ("'.(!empty($oFechaFin)?$oFechaFin:date("Y-m-d")).'") ) ) ,0) /30) ) AS AmoPromedioVentaMensual,
			
			pro.RtiId,
			rti.RtiNombre,
			
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
			
			(
				SELECT 
				amd3.AmdCosto
				FROM tblamdalmacenmovimientodetalle amd3
					LEFT JOIN tblamoalmacenmovimiento amo3
					ON amd3.AmoId = amo3.AmoId
						WHERE amd3.AmdEstado = 3 
						AND amo3.AmoTipo = 1
						AND amd3.ProId = pro.ProId
						
						'.(!empty($oFechaInicio)?' AND DATE(amo3.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo3.AmoFecha) <= "'.$oFechaFin.'"':'').'
				
						ORDER BY amo3.AmoFecha DESC
						LIMIT 1
			)	AS AmdCostoCalculado
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
					LEFT JOIN tblproproducto pro
					ON amd.ProId = pro.ProId
						LEFT JOIN tblrtiproductotipo rti
						ON pro.RtiId = rti.RtiId
							LEFT JOIN tblumeunidadmedida ume
							ON pro.UmeId = ume.UmeId
							
			WHERE  amo.AmoTipo = 1 
			AND pro.ProValidarStock = 1
			'.$filtrar.$ptipo.$fecha ." GROUP BY pro.ProId ".$cstock.$orden."  ".$paginacion;	

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteAlmacenMovimientoEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteAlmacenMovimientoEntrada = new $InsReporteAlmacenMovimientoEntrada();
					
					 $ReporteAlmacenMovimientoEntrada->AmoId = $fila['AmoId'];
                    $ReporteAlmacenMovimientoEntrada->AmoFecha = $fila['NAmoFecha'];
                    $ReporteAlmacenMovimientoEntrada->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];
					$ReporteAlmacenMovimientoEntrada->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
					$ReporteAlmacenMovimientoEntrada->ProId = $fila['ProId'];
					$ReporteAlmacenMovimientoEntrada->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteAlmacenMovimientoEntrada->ProNombre = $fila['ProNombre'];
					$ReporteAlmacenMovimientoEntrada->ProReferencia = $fila['ProReferencia'];
					
					
					$ReporteAlmacenMovimientoEntrada->AmoMovimientoSalida = $fila['AmoMovimientoSalida'];
					
					$ReporteAlmacenMovimientoEntrada->AmoFechaUltimaSalida = $fila['AmoFechaUltimaSalida'];
					$ReporteAlmacenMovimientoEntrada->AmoCantidadUltimaSalida = $fila['AmoCantidadUltimaSalida'];
					
					
					$ReporteAlmacenMovimientoEntrada->AmoUltimaSalidaDiaTranscurridos = $fila['AmoUltimaSalidaDiaTranscurridos'];
					$ReporteAlmacenMovimientoEntrada->AmoInicialDiaTranscurridos = $fila['AmoInicialDiaTranscurridos'];
					
					
					$ReporteAlmacenMovimientoEntrada->AmoTotalIngreso = $fila['AmoTotalIngreso'];
					$ReporteAlmacenMovimientoEntrada->AmoTotalSaldo = $fila['AmoTotalSaldo'];
					
					
					$ReporteAlmacenMovimientoEntrada->AmoPromedioVentaMensual = round($fila['AmoPromedioVentaMensual']);
					
					$ReporteAlmacenMovimientoEntrada->RtiId = $fila['RtiId'];
					
					$ReporteAlmacenMovimientoEntrada->RtiNombre = $fila['RtiNombre'];
					
					
					$ReporteAlmacenMovimientoEntrada->UmeNombre = $fila['UmeNombre'];
					$ReporteAlmacenMovimientoEntrada->UmeAbreviacion = $fila['UmeAbreviacion'];
					$ReporteAlmacenMovimientoEntrada->AmdCostoCalculado = $fila['AmdCostoCalculado'];
					
					
                    $ReporteAlmacenMovimientoEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteAlmacenMovimientoEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
		
		
		    public function MtdObtenerReporteAlmacenMovimientoEntradasValor($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmoFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConStock=NULL) {

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
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND  pro.RtiId = "'.$oProductoTipo.'"';		
		}	
		
		switch($oConStock){
			case 1:
				$cstock = ' HAVING  AmoTotalSaldo>0';
			break;
			
			case 2:
				$cstock = ' HAVING AmoTotalSaldo<=0';
			break;
			
			default:
				$cstock = '';
			break;
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amo.AmoId,

			DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			amo.AmoComprobanteNumero,

			pro.ProId,
			pro.ProCodigoOriginal,
			pro.ProNombre,
			

			CASE
			WHEN EXISTS (
				SELECT amd2.AmdId
	
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
			
					WHERE amo2.AmoTipo = 2
					AND amd2.ProId = amd.ProId
	
				LIMIT 1
			) THEN "Si"
			ELSE "No"
			END AS AmoMovimientoSalida,
			






			@AmoFechaUltimaSalida :=(
				SELECT 
				amo2.AmoFecha
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			) ,
			
			
					
				
				
					
						
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
			
			
			
			(
				SELECT 
				amd.AmdCantidad
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			) AS AmoCantidadUltimaSalida,


			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.$oFechaFin.' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos,
			(TIMESTAMPDIFF(DAY, amo.AmoFecha, "'.$oFechaFin.' 00:00:00" ) ) AS AmoInicialDiaTranscurridos,

			
			SUM(amd.AmdCantidad) AS AmoTotalIngreso,

			@AmoTotalSaldoA:= (IFNULL(SUM(amd.AmdCantidad),0) - IFNULL((
				SELECT 
				amd.AmdCantidad
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			),0)) AS AmoTotalSaldo,
			
			pro.RtiId,
			rti.RtiNombre


			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
					LEFT JOIN tblproproducto pro
					ON amd.ProId = pro.ProId
						LEFT JOIN tblrtiproductotipo rti
						ON pro.RtiId = rti.RtiId

			WHERE  amo.AmoTipo = 1 '.$filtrar.$ptipo.$fecha ." GROUP BY pro.ProId ".$cstock.$orden."  ".$paginacion;	

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];						
			
		}
		
		
		
		
		 public function MtdObtenerAlmacenMovimientoEntradaEspeciales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oFechaInicioOrdenCompra=NULL,$oFechaFinOrdenCompra=NULL) {

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
					amd.AmdId

					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId

							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON amd.PcdId = pcd.PcdId
								
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
								
									LEFT JOIN tblclicliente cli
									ON pco.CliId = cli.CliId

					WHERE 
						amd.AmoId = amo.AmoId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" OR
						
						cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" OR
						cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliNumeroDocumento  LIKE "%'.$oFiltro.'%"
						
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
		
		
		if(!empty($oTipo)){
			$tipo = ' AND amo.AmoTipo = '.$oTipo;
		}
				
		if(!empty($oSubTipo)){

			$elementos = explode(",",$oSubTipo);


				$i=1;
				$stipo .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$stipo .= '  (amo.AmoSubTipo = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$stipo .= ' OR ';	
						}
				$i++;		
				}
				
				$stipo .= ' ) ';

		}
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(amo.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		/*if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}*/


		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND amo.AmoDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND amo.OcoId = "'.$oOrdenCompra.'"';
		}
		


		
		if(!empty($oPedidoCompra)){
			
			$pcompra = ' 
			AND EXISTS(
			
				SELECT 
				pcd.PcoId
				FROM tblamdalmacenmovimientodetalle amd
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
				WHERE amd.AmoId = amo.AmoId
				AND pcd.PcoId = "'.$oPedidoCompra.'"
				LIMIT 1
			)
							
			';
		}
		
		if(!empty($oPedidoCompraDetalle)){
			
			 $pcompradetalle = ' 
			AND EXISTS(

				SELECT
				amd.AmdId
				FROM tblamdalmacenmovimientodetalle amd
				WHERE 
				amo.AmoId = amd.AmoId
				AND amd.PcdId = "'.$oPedidoCompraDetalle.'"

				LIMIT 1

			)
			';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND amo.CliId = "'.$oCliente.'"';
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
		
		if($oCancelado){
			$cancelado = ' AND amo.AmoCancelado = '.$oCancelado;
		}
		
		
		if(!empty($oProveedor)){
			$proveedor = ' AND amo.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND pco.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oCondicionPago)){
			$cpago = ' AND amo.NpaId = "'.$oCondicionPago.'"';
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = ' AND amo.AlmId = "'.$oAlmacen.'"';
		}
		
		
		
		
		if(!empty($oFechaInicioOrdenCompra)){
			
			if(!empty($oFechaFinOrdenCompra)){
				$fechaoc = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicioOrdenCompra.'" AND DATE(oco.OcoFecha)<="'.$oFechaFinOrdenCompra.'"';
			}else{
				$fechaoc = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicioOrdenCompra.'"';
			}
			
		}else{
			if(!empty($oFechaFinOrdenCompra)){
				$fechaoc = ' AND DATE(oco.OcoFecha)<="'.$oFechaFinOrdenCompra.'"';		
			}			
		}
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId,				
				amo.AmoTipo,
				amo.AmoSubTipo,
				amo.PrvId,
				amo.CtiId,
				amo.TopId,
				
				amo.OcoId,	
				amo.NpaId,	
				amo.AmoCantidadDia,	
				
				
				amo.AlmId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.AmoDocumentoOrigen,
				
				amo.AmoGuiaRemisionNumero,
				DATE_FORMAT(amo.AmoGuiaRemisionFecha, "%d/%m/%Y") AS "NAmoGuiaRemisionFecha",
				amo.AmoGuiaRemisionFoto,
				
				amo.AmoComprobanteNumero,
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
				
				amo.MonId,
				amo.AmoTipoCambio,
				amo.AmoTipoCambioComercial,
				
				amo.AmoIncluyeImpuesto,
				amo.AmoPorcentajeImpuestoVenta,
						
				amo.AmoNacionalTotalRecargo,
				amo.AmoNacionalTotalFlete,
				amo.AmoNacionalTotalOtroCosto,
					
				amo.AmoInternacionalTotalAduana,
				amo.AmoInternacionalTotalTransporte,
				amo.AmoInternacionalTotalDesestiba,
				amo.AmoInternacionalTotalAlmacenaje,
				amo.AmoInternacionalTotalAdValorem,
				amo.AmoInternacionalTotalAduanaNacional,
				amo.AmoInternacionalTotalGastoAdministrativo,
				amo.AmoInternacionalTotalOtroCosto1,
				amo.AmoInternacionalTotalOtroCosto2,				
			
			
		amo.AmoInternacionalNumeroComprobante1,
		amo.AmoInternacionalNumeroComprobante2,
		amo.AmoInternacionalNumeroComprobante3,
		amo.AmoInternacionalNumeroComprobante4,
		amo.AmoInternacionalNumeroComprobante5,
		amo.AmoInternacionalNumeroComprobante6,
		amo.AmoInternacionalNumeroComprobante7,
		amo.AmoInternacionalNumeroComprobante8,
		amo.AmoInternacionalNumeroComprobante9,
		
		amo.AmoNacionalNumeroComprobante1,
		amo.AmoNacionalNumeroComprobante2,
		amo.AmoNacionalNumeroComprobante3,
		
		amo.AmoNacionalFoto1,
		amo.AmoNacionalFoto2,
		amo.AmoNacionalFoto3,

		amo.MonIdInternacional1,
		amo.MonIdInternacional2,
		amo.MonIdInternacional3,
		amo.MonIdInternacional4,
		amo.MonIdInternacional5,
		amo.MonIdInternacional6,
		amo.MonIdInternacional7,
		amo.MonIdInternacional8,
		amo.MonIdInternacional9,
		
		amo.MonIdNacional1,
		amo.MonIdNacional2,
		amo.MonIdNacional3,


		amo.PrvIdInternacional1,
		amo.PrvIdInternacional2,
		amo.PrvIdInternacional3,
		amo.PrvIdInternacional4,
		amo.PrvIdInternacional5,
		amo.PrvIdInternacional6,
		amo.PrvIdInternacional7,
		amo.PrvIdInternacional8,
		amo.PrvIdInternacional9,
		
		amo.PrvIdNacional1,
		amo.PrvIdNacional2,
		amo.PrvIdNacional3,

	pin1.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional1,
	pin2.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional2,
	pin3.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional3,
	pin4.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional4,
	pin5.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional5,
	pin6.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional6,
	pin7.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional7,
	pin8.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional8,
	pin9.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional9,	
			
	pin1.PrvNombre AS PrvNombreInternacional1,
	pin2.PrvNombre AS PrvNombreInternacional2,
	pin3.PrvNombre AS PrvNombreInternacional3,
	pin4.PrvNombre AS PrvNombreInternacional4,
	pin5.PrvNombre AS PrvNombreInternacional5,
	pin6.PrvNombre AS PrvNombreInternacional6,
	pin7.PrvNombre AS PrvNombreInternacional7,
	pin8.PrvNombre AS PrvNombreInternacional8,
	pin9.PrvNombre AS PrvNombreInternacional9,	
	
	pin1.TdoId AS TdoIdInternacional1,
	pin2.TdoId AS TdoIdInternacional2,
	pin3.TdoId AS TdoIdInternacional3,
	pin4.TdoId AS TdoIdInternacional4,
	pin5.TdoId AS TdoIdInternacional5,
	pin6.TdoId AS TdoIdInternacional6,
	pin7.TdoId AS TdoIdInternacional7,
	pin8.TdoId AS TdoIdInternacional8,
	pin9.TdoId AS TdoIdInternacional9,	
	
	

	pna1.PrvNumeroDocumento AS PrvNumeroDocumentoNacional1,
	pna2.PrvNumeroDocumento AS PrvNumeroDocumentoNacional2,
	pna3.PrvNumeroDocumento AS PrvNumeroDocumentoNacional3,
	
	pna1.PrvNombre AS PrvNombreNacional1,
	pna2.PrvNombre AS PrvNombreNacional2,
	pna3.PrvNombre AS PrvNombreNacional3,	
	
	pna1.TdoId AS TdoIdNacional1,
	pna2.TdoId AS TdoIdNacional2,
	pna3.TdoId AS TdoIdNacional3,	

				amo.AmoFoto,
				amo.AmoObservacion,
				
				amo.AmoSubTotal,
				amo.AmoImpuesto,				
				amo.AmoTotal,
				
				amo.AmoTotalInternacional,
				amo.AmoTotalNacional,
				
				amo.AmoCancelado,
				amo.AmoRevisado,
				amo.AmoCierre,
				amo.AmoEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",
				
				DATE_FORMAT(adddate(amo.AmoComprobanteFecha,amo.AmoCantidadDia), "%d/%m/%Y") AS AmoFechaVencimiento,
				DATEDIFF(DATE(NOW()),amo.AmoComprobanteFecha) AS AmoDiaTranscurrido,

				CASE
				WHEN EXISTS (
					SELECT 
					amo.AmoId 
					FROM tblamoalmacenmovimiento amo2
					WHERE amo2.AmoIdOrigen = amo.AmoId
					AND amo2.AmoEstado = 3 
					AND amo2.AmoTipo = 2
					AND amo2.AmoSubTipo = 5
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoNotaCreditoCompra,
				
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "AmoTotalItems",

				cti.CtiNombre,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,
				
				mon.MonSimbolo,
				
				npa.NpaNombre

				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblocoordencompra oco
					ON amo.OcoId = oco.OcoId
						LEFT JOIN tblpcopedidocompra pco
						ON oco.OcoId = pco.OcoId
						
						LEFT JOIN tblnpacondicionpago npa
						ON amo.NpaId = npa.NpaId
						
					LEFT JOIN tblcticomprobantetipo cti
					ON amo.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON amo.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
	
							LEFT JOIN tblprvproveedor pin1
							ON amo.PrvIdInternacional1 = pin1.PrvId
								LEFT JOIN tblprvproveedor pin2
								ON amo.PrvIdInternacional2 = pin2.PrvId
									LEFT JOIN tblprvproveedor pin3
									ON amo.PrvIdInternacional3 = pin3.PrvId
										LEFT JOIN tblprvproveedor pin4
										ON amo.PrvIdInternacional4 = pin4.PrvId
											LEFT JOIN tblprvproveedor pin5
											ON amo.PrvIdInternacional5 = pin5.PrvId
												LEFT JOIN tblprvproveedor pin6
												ON amo.PrvIdInternacional6 = pin6.PrvId
													LEFT JOIN tblprvproveedor pin7
													ON amo.PrvIdInternacional7 = pin7.PrvId
														LEFT JOIN tblprvproveedor pin8
														ON amo.PrvIdInternacional8 = pin8.PrvId
															LEFT JOIN tblprvproveedor pin9
															ON amo.PrvIdInternacional9 = pin9.PrvId
	
					LEFT JOIN tblprvproveedor pna1
					ON amo.PrvIdNacional1 = pna1.PrvId
						LEFT JOIN tblprvproveedor pna2
						ON amo.PrvIdNacional2 = pna2.PrvId
							LEFT JOIN tblprvproveedor pna3
							ON amo.PrvIdNacional3 = pna3.PrvId
						
				WHERE amo.AmoTipo = 1 '.$filtrar.$fecha.$tipo.$fechaoc.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$proveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoEntrada = new $InsAlmacenMovimientoEntrada();
                    $AlmacenMovimientoEntrada->AmoId = $fila['AmoId'];
					$AlmacenMovimientoEntrada->PrvId = $fila['PrvId'];		
					$AlmacenMovimientoEntrada->CtiId = $fila['CtiId'];	
					$AlmacenMovimientoEntrada->TopId = $fila['TopId'];	
						
					$AlmacenMovimientoEntrada->OcoId = $fila['OcoId'];
					
					$AlmacenMovimientoEntrada->NpaId = $fila['NpaId'];
					$AlmacenMovimientoEntrada->AmoCantidadDia = $fila['AmoCantidadDia'];							
					
				
					$AlmacenMovimientoEntrada->AlmId = $fila['AlmId'];
					$AlmacenMovimientoEntrada->AmoFecha = $fila['NAmoFecha'];
					$AlmacenMovimientoEntrada->AmoDocumentoOrigen = $fila['AmoDocumentoOrigen'];
					
					$AlmacenMovimientoEntrada->AmoGuiaRemisionNumero = $fila['AmoGuiaRemisionNumero'];
					list($AlmacenMovimientoEntrada->AmoGuiaRemisionNumeroSerie,$AlmacenMovimientoEntrada->AmoGuiaRemisionNumeroNumero) = explode("-",$AlmacenMovimientoEntrada->AmoGuiaRemisionNumero);
					$AlmacenMovimientoEntrada->AmoGuiaRemisionFecha = $fila['NAmoGuiaRemisionFecha'];
					$AlmacenMovimientoEntrada->AmoGuiaRemisionFoto = $fila['AmoGuiaRemisionFoto'];
					
					
					$AlmacenMovimientoEntrada->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
					list($AlmacenMovimientoEntrada->AmoComprobanteNumeroSerie,$AlmacenMovimientoEntrada->AmoComprobanteNumeroNumero) = explode("-",$AlmacenMovimientoEntrada->AmoComprobanteNumero);					
					$AlmacenMovimientoEntrada->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];
					
					$AlmacenMovimientoEntrada->MonId = $fila['MonId'];
					$AlmacenMovimientoEntrada->AmoTipoCambio = $fila['AmoTipoCambio'];
					$AlmacenMovimientoEntrada->AmoTipoCambioComercial = $fila['AmoTipoCambioComercial'];
					
					$AlmacenMovimientoEntrada->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					$AlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
					
					
					
					$AlmacenMovimientoEntrada->AmoFoto = $fila['AmoFoto'];
					$AlmacenMovimientoEntrada->AmoObservacion = $fila['AmoObservacion'];
		
					$AlmacenMovimientoEntrada->AmoNacionalTotalRecargo = $fila['AmoNacionalTotalRecargo'];
					$AlmacenMovimientoEntrada->AmoNacionalTotalFlete = $fila['AmoNacionalTotalFlete'];
					$AlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = $fila['AmoNacionalTotalOtroCosto'];
					
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAduana = $fila['AmoInternacionalTotalAduana'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalTransporte = $fila['AmoInternacionalTotalTransporte'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba = $fila['AmoInternacionalTotalDesestiba'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje = $fila['AmoInternacionalTotalAlmacenaje'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem = $fila['AmoInternacionalTotalAdValorem'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional = $fila['AmoInternacionalTotalAduanaNacional'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo = $fila['AmoInternacionalTotalGastoAdministrativo'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 = $fila['AmoInternacionalTotalOtroCosto1'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2 = $fila['AmoInternacionalTotalOtroCosto2'];
					


	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero1 = $fila['AmoInternacionalComprobanteNumero1'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero2 = $fila['AmoInternacionalComprobanteNumero2'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero3 = $fila['AmoInternacionalComprobanteNumero3'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero4 = $fila['AmoInternacionalComprobanteNumero4'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero5 = $fila['AmoInternacionalComprobanteNumero5'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero6 = $fila['AmoInternacionalComprobanteNumero6'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero7 = $fila['AmoInternacionalComprobanteNumero7'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero8 = $fila['AmoInternacionalComprobanteNumero8'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero9 = $fila['AmoInternacionalComprobanteNumero9'];
	
	$AlmacenMovimientoEntrada->AmoNacionalComprobanteNumero1 = $fila['AmoNacionalComprobanteNumero1'];
	$AlmacenMovimientoEntrada->AmoNacionalComprobanteNumero2 = $fila['AmoNacionalComprobanteNumero2'];
	$AlmacenMovimientoEntrada->AmoNacionalComprobanteNumero3 = $fila['AmoNacionalComprobanteNumero3'];
	
	$AlmacenMovimientoEntrada->AmoNacionalFoto1 = $fila['AmoNacionalFoto1'];
	$AlmacenMovimientoEntrada->AmoNacionalFoto2 = $fila['AmoNacionalFoto2'];
	$AlmacenMovimientoEntrada->AmoNacionalFoto3 = $fila['AmoNacionalFoto3'];
	
	$AlmacenMovimientoEntrada->MonIdInternacional1 = $fila['MonIdInternacional1'];
	$AlmacenMovimientoEntrada->MonIdInternacional2 = $fila['MonIdInternacional2'];
	$AlmacenMovimientoEntrada->MonIdInternacional3 = $fila['MonIdInternacional3'];
	$AlmacenMovimientoEntrada->MonIdInternacional4 = $fila['MonIdInternacional4'];
	$AlmacenMovimientoEntrada->MonIdInternacional5 = $fila['MonIdInternacional5'];
	$AlmacenMovimientoEntrada->MonIdInternacional6 = $fila['MonIdInternacional6'];
	$AlmacenMovimientoEntrada->MonIdInternacional7 = $fila['MonIdInternacional7'];
	$AlmacenMovimientoEntrada->MonIdInternacional8 = $fila['MonIdInternacional8'];
	$AlmacenMovimientoEntrada->MonIdInternacional9 = $fila['MonIdInternacional9'];
	
	$AlmacenMovimientoEntrada->MonIdNacional1 = $fila['MonIdNacional1'];
	$AlmacenMovimientoEntrada->MonIdNacional2 = $fila['MonIdNacional2'];
	$AlmacenMovimientoEntrada->MonIdNacional3 = $fila['MonIdNacional3'];
	
	
	
	
	$AlmacenMovimientoEntrada->PrvIdInternacional1 = $fila['PrvIdInternacional1'];
	$AlmacenMovimientoEntrada->PrvIdInternacional2 = $fila['PrvIdInternacional2'];
	$AlmacenMovimientoEntrada->PrvIdInternacional3 = $fila['PrvIdInternacional3'];
	$AlmacenMovimientoEntrada->PrvIdInternacional4 = $fila['PrvIdInternacional4'];
	$AlmacenMovimientoEntrada->PrvIdInternacional5 = $fila['PrvIdInternacional5'];
	$AlmacenMovimientoEntrada->PrvIdInternacional6 = $fila['PrvIdInternacional6'];
	$AlmacenMovimientoEntrada->PrvIdInternacional7 = $fila['PrvIdInternacional7'];
	$AlmacenMovimientoEntrada->PrvIdInternacional8 = $fila['PrvIdInternacional8'];
	$AlmacenMovimientoEntrada->PrvIdInternacional9 = $fila['PrvIdInternacional9'];
	
	$AlmacenMovimientoEntrada->PrvIdNacional1 = $fila['PrvIdNacional1'];
	$AlmacenMovimientoEntrada->PrvIdNacional2 = $fila['PrvIdNacional2'];
	$AlmacenMovimientoEntrada->PrvIdNacional3 = $fila['PrvIdNacional3'];
						
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional1 = $fila['PrvNumeroDocumentoInternacional1'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional2 = $fila['PrvNumeroDocumentoInternacional2'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional3 = $fila['PrvNumeroDocumentoInternacional3'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional4 = $fila['PrvNumeroDocumentoInternacional4'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional5 = $fila['PrvNumeroDocumentoInternacional5'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional6 = $fila['PrvNumeroDocumentoInternacional6'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional7 = $fila['PrvNumeroDocumentoInternacional7'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional8 = $fila['PrvNumeroDocumentoInternacional8'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional9 = $fila['PrvNumeroDocumentoInternacional9'];	
			
	$AlmacenMovimientoEntrada->PrvNombreInternacional1 = $fila['PrvNombreInternacional1'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional2 = $fila['PrvNombreInternacional2'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional3 = $fila['PrvNombreInternacional3'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional4 = $fila['PrvNombreInternacional4'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional5 = $fila['PrvNombreInternacional5'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional6 = $fila['PrvNombreInternacional6'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional7 = $fila['PrvNombreInternacional7'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional8 = $fila['PrvNombreInternacional8'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional9 = $fila['PrvNombreInternacional9'];
	
	$AlmacenMovimientoEntrada->TdoIdInternacional1 = $fila['TdoIdInternacional1'];
	$AlmacenMovimientoEntrada->TdoIdInternacional2 = $fila['TdoIdInternacional2'];
	$AlmacenMovimientoEntrada->TdoIdInternacional3 = $fila['TdoIdInternacional3'];
	$AlmacenMovimientoEntrada->TdoIdInternacional4 = $fila['TdoIdInternacional4'];
	$AlmacenMovimientoEntrada->TdoIdInternacional5 = $fila['TdoIdInternacional5'];
	$AlmacenMovimientoEntrada->TdoIdInternacional6 = $fila['TdoIdInternacional6'];
	$AlmacenMovimientoEntrada->TdoIdInternacional7 = $fila['TdoIdInternacional7'];
	$AlmacenMovimientoEntrada->TdoIdInternacional8 = $fila['TdoIdInternacional8'];
	$AlmacenMovimientoEntrada->TdoIdInternacional9 = $fila['TdoIdInternacional9'];	
	

	$AlmacenMovimientoEntrada->PrvNumeroDocumentoNacional1 = $fila['PrvNumeroDocumentoNacional1'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoNacional2 = $fila['PrvNumeroDocumentoNacional2'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoNacional3 = $fila['PrvNumeroDocumentoNacional3'];
	
	$AlmacenMovimientoEntrada->PrvNombreNacional1 = $fila['PrvNombreNacional1'];
	$AlmacenMovimientoEntrada->PrvNombreNacional2 = $fila['PrvNombreNacional2'];
	$AlmacenMovimientoEntrada->PrvNombreNacional3 = $fila['PrvNombreNacional3'];	
	
	$AlmacenMovimientoEntrada->TdoIdNacional1 = $fila['TdoIdNacional1'];
	$AlmacenMovimientoEntrada->TdoIdNacional2 = $fila['TdoIdNacional2'];
	$AlmacenMovimientoEntrada->TdoIdNacional3 = $fila['TdoIdNacional3'];	
	
					$AlmacenMovimientoEntrada->AmoSubTotal = $fila['AmoSubTotal'];			
					$AlmacenMovimientoEntrada->AmoImpuesto = $fila['AmoImpuesto'];
					$AlmacenMovimientoEntrada->AmoTotal = $fila['AmoTotal'];
					
					$AlmacenMovimientoEntrada->AmoValorTotal = $AlmacenMovimientoEntrada->AmoTotal;
					
					$AlmacenMovimientoEntrada->AmoTotalInternacional = $fila['AmoTotalInternacional'];
					$AlmacenMovimientoEntrada->AmoTotalNacional = $fila['AmoTotalNacional'];
							
							
					$AlmacenMovimientoEntrada->AmoCancelado = $fila['AmoCancelado'];	
					$AlmacenMovimientoEntrada->AmoRevisado = $fila['AmoRevisado'];
					$AlmacenMovimientoEntrada->AmoCierre = $fila['AmoCierre'];							
					$AlmacenMovimientoEntrada->AmoEstado = $fila['AmoEstado'];
					$AlmacenMovimientoEntrada->AmoTiempoCreacion = $fila['NAmoTiempoCreacion'];  
					$AlmacenMovimientoEntrada->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 

					$AlmacenMovimientoEntrada->AmoFechaVencimiento = $fila['AmoFechaVencimiento']; 
					$AlmacenMovimientoEntrada->AmoDiaTranscurrido = $fila['AmoDiaTranscurrido']; 

					$AlmacenMovimientoEntrada->AmoNotaCreditoCompra = $fila['AmoNotaCreditoCompra']; 
					
					$AlmacenMovimientoEntrada->AmoTotalItems = $fila['AmoTotalItems']; 
					
					$AlmacenMovimientoEntrada->CtiNombre = $fila['CtiNombre']; 
					
					$AlmacenMovimientoEntrada->TdoId = $fila['TdoId']; 
					

				
					$AlmacenMovimientoEntrada->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$AlmacenMovimientoEntrada->PrvNombre = $fila['PrvNombre']; 
					$AlmacenMovimientoEntrada->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$AlmacenMovimientoEntrada->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$AlmacenMovimientoEntrada->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$AlmacenMovimientoEntrada->TdoNombre = $fila['TdoNombre']; 

					$AlmacenMovimientoEntrada->MonSimbolo = $fila['MonSimbolo']; 
					
					$AlmacenMovimientoEntrada->NpaNombre = $fila['NpaNombre']; 
					
				
		
					switch($AlmacenMovimientoEntrada->AmoEstado){
					
						case 1:
							$Estado = "No Realizado";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$AlmacenMovimientoEntrada->AmoEstadoDescripcion = $Estado;
					
					
					switch($AlmacenMovimientoEntrada->AmoEstado){
					
						case 1:
							$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
						break;
					
						case 3:
							$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
						break;	
						
						default:
							$Estado = "";
						break;
					
					}
						$AlmacenMovimientoEntrada->AmoEstadoIcono = $Estado;
						
						


					switch($AlmacenMovimientoEntrada->AmoRevisado){
					
						case 1:
							$Revisado = "Revisado";
						break;
					
						case 3:
							$Revisado = "No Revisado";						
						break;	
		
						default:
							$Revisado = "";
						break;
					
					}
						
					$AlmacenMovimientoEntrada->AmoRevisadoDescripcion = $Revisado;
					
					
					switch($AlmacenMovimientoEntrada->AmoRevisado){
					
						case 1:
							$Revisado = '<img width="15" height="15" alt="[Revisado]" title="No Realizado" src="imagenes/iconos/revisado.png" />';
						break;
					
						case 3:
							$Revisado = '<img width="15" height="15" alt="[No Revisado]" title="Enviado" src="imagenes/iconos/norevisado.png" />';						
						break;	
						
						default:
							$Revisado = "";
						break;
					
					}
						
						
						
					$AlmacenMovimientoEntrada->AmoRevisadoIcono = $Revisado;




                    $AlmacenMovimientoEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		




  public function MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL) {

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
					
					
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
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
		
				
}
?>
