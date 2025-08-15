<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenCompra
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenCompra {

    public $OcoId;
	public $OcoTipo;
	public $OcoAno;
	public $OcoMes;
	public $OcoCodigoDealer;
	public $OcoVIN;
	public $OcoOrdenTrabajo;
	
	public $PrvId;
	
	public $OcoFecha;
	public $OcoFechaLlegadaEstimada;
	public $OcoHora;
	
	public $MonId;
	public $OcoTipoCambio;
	public $VmaId;
	
    public $OcoObservacion;
	public $OcoRespuestaProveedor;
	public $OcoProcesadoProveedor;
	
	public $OcoTotal;
	public $OcoTieneETA;
	
	public $OcoEstado;
	public $OcoTiempoCreacion;
	public $OcoTiempoModificacion;
    public $OcoEliminado;

	public  $OcoTotalPedidos;
	
	public $TdoId;
	public $PrvNombre;
	public $PrvNumeroDocumento;
	
	public $MonNombre;
	public $MonSimbolo;
		
	public $OrdenCompraDetalle;
	public $OrdenCompraPedido;

    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	public function MtdGenerarOrdenCompraId() {


//$sql = 'SELECT	
//			MAX(CONVERT(SUBSTR(cpr.CprId,13),unsigned)) AS "MAXIMO"
//			FROM tblcprcotizacionproducto cpr
//			WHERE YEAR(cpr.CprFecha) = ("'.$this->CprAno.'")
//			AND MONTH(cpr.CprFecha) = ("'.$this->CprMes.'")';
//			
////echo "<br>";			
//			$resultado = $this->InsMysql->MtdConsultar($sql);                       
//			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//			
//			if(empty($fila['MAXIMO'])){			
//				$this->CprId = "CTR-".$this->CprAno."-".$this->CprMes."-00001";
//			}else{
//				$fila['MAXIMO']++;
//				$this->CprId = "CTR-".$this->CprAno."-".$this->CprMes."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
//			}
//			
			
			//echo strlen($this->OcoTipo);
			
			switch(strlen($this->OcoTipo)){
				case 4:
//echo "444444";
				$sql = 'SELECT	
				MAX(CONVERT(SUBSTR(oco.OcoId,18),unsigned)) AS "MAXIMO"
				FROM tblocoordencompra oco
				WHERE oco.OcoTipo = "'.$this->OcoTipo.'"
				AND oco.OcoAno = "'.$this->OcoAno.'"
				AND oco.OcoMes = "'.$this->OcoMes.'";';

				break;
				
				case 5:


//echo "555555555";
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(oco.OcoId,19),unsigned)) AS "MAXIMO"
			FROM tblocoordencompra oco
				WHERE oco.OcoTipo = "'.$this->OcoTipo.'"
				AND oco.OcoAno = "'.$this->OcoAno.'"
				AND oco.OcoMes = "'.$this->OcoMes.'";';

				break;
				
				case 0:

					$sql = 'SELECT	
					MAX(CONVERT(SUBSTR(oco.OcoId,14),unsigned)) AS "MAXIMO"
					FROM tblocoordencompra oco
						WHERE oco.OcoTipo = "'.$this->OcoTipo.'"
						AND oco.OcoAno = "'.$this->OcoAno.'"
						AND oco.OcoMes = "'.$this->OcoMes.'";';

				break;
				
				default:

					$sql = 'SELECT	
					MAX(CONVERT(SUBSTR(oco.OcoId,17),unsigned)) AS "MAXIMO"
					FROM tblocoordencompra oco
						WHERE oco.OcoTipo = "'.$this->OcoTipo.'"
						AND oco.OcoAno = "'.$this->OcoAno.'"
						AND oco.OcoMes = "'.$this->OcoMes.'";';

				
				break;
				
			}
			//$sql = 'SELECT	
//			MAX(CONVERT(SUBSTR(oco.OcoId,18),unsigned)) AS "MAXIMO"
//			FROM tblocoordencompra oco
//				WHERE oco.OcoTipo = "'.$this->OcoTipo.'"
//				AND YEAR(oco.OcoFecha) = "'.$this->OcoAno.'"
//				AND MONTH(oco.OcoFecha) = "'.$this->OcoMes.'";';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

			if(empty($fila['MAXIMO'])){			
				$this->OcoId = "CYC-".$this->OcoTipo."-".$this->OcoAno."-".$this->OcoMes."-001";
			}else{
				$fila['MAXIMO']++;
				$this->OcoId = "CYC-".$this->OcoTipo."-".$this->OcoAno."-".$this->OcoMes."-".str_pad($fila['MAXIMO'], 3, "0", STR_PAD_LEFT);;					
			}
				
	}
		
    public function MtdObtenerOrdenCompra($oCompleto=true){

       $sql = 'SELECT 
        oco.OcoId,  
		oco.VmaId,
		
		oco.OcoTipo,
		oco.OcoAno,
		oco.OcoMes,
		oco.OcoCodigoDealer,
		
		oco.OcoVIN,
		oco.OcoOrdenTrabajo,
			
		oco.PrvId,

		DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
		DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
		
		oco.OcoHora,

		oco.MonId,
		oco.OcoTipoCambio,
		oco.VmaId,
		
		oco.OcoObservacion,
		oco.OcoRespuestaProveedor,
		oco.OcoProcesadoProveedor,
	
		oco.OcoTieneETA,
		
		oco.OcoIncluyeImpuesto,
		oco.OcoPorcentajeImpuestoVenta,
		
		
		oco.OcoSubTotal,
		oco.OcoImpuesto,
		oco.OcoTotal,
		
	
		
		oco.OcoEstado,
		DATE_FORMAT(oco.OcoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOcoTiempoCreacion",
        DATE_FORMAT(oco.OcoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOcoTiempoModificacion",
		
		(SELECT count(pco.PcoId) FROM tblpcopedidocompra pco WHERE pco.OcoId = oco.OcoId AND pco.OcoId IS NOT NULL) AS OcoTotalPedidos,
		
		prv.TdoId,
		
		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,

		mon.MonNombre,
		mon.MonSimbolo

        FROM tblocoordencompra oco
			LEFT JOIN tblprvproveedor prv
			ON oco.PrvId = prv.PrvId
				LEFT JOIN tblmonmoneda mon
				ON oco.MonId = mon.MonId

        WHERE oco.OcoId = "'.$this->OcoId.'"';
		
		//CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombreCompleto,
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			

			$this->OcoId = $fila['OcoId'];
			$this->VmaId = $fila['VmaId'];
			
			$this->OcoTipo = $fila['OcoTipo'];
			$this->OcoAno = $fila['OcoAno'];
			$this->OcoMes = $fila['OcoMes'];
			$this->OcoCodigoDealer = $fila['OcoCodigoDealer'];
			
			$this->OcoVIN = $fila['OcoVIN'];
			$this->OcoOrdenTrabajo = $fila['OcoOrdenTrabajo'];

			$this->PrvId = $fila['PrvId'];
			$this->OcoFecha = $fila['NOcoFecha'];
			$this->OcoFechaLlegadaEstimada = $fila['NOcoFechaLlegadaEstimada'];
			
			
			$this->OcoHora = $fila['OcoHora'];
			
			$this->MonId = $fila['MonId'];
			$this->OcoTipoCambio = $fila['OcoTipoCambio'];
			$this->VmaId = $fila['VmaId'];

			$this->OcoObservacion = $fila['OcoObservacion'];
			$this->OcoRespuestaProveedor = $fila['OcoRespuestaProveedor'];
			$this->OcoProcesadoProveedor = $fila['OcoProcesadoProveedor'];
			
			
			$this->OcoTieneETA = $fila['OcoTieneETA'];
			
		
			
			$this->OcoIncluyeImpuesto = $fila['OcoIncluyeImpuesto'];
			$this->OcoPorcentajeImpuestoVenta = $fila['OcoPorcentajeImpuestoVenta'];
				
			$this->OcoSubTotal = $fila['OcoSubTotal'];
			$this->OcoImpuesto = $fila['OcoImpuesto'];
			$this->OcoTotal = $fila['OcoTotal'];

			$this->OcoEstado = $fila['OcoEstado'];
			$this->OcoTiempoCreacion = $fila['NOcoTiempoCreacion']; 
			$this->OcoTiempoModificacion = $fila['NOcoTiempoModificacion']; 	

			$this->OcoTotalPedidos = $fila['OcoTotalPedidos'];

			//$ResOrdenCompraDetalle =  $InsOrdenCompraDetalle->MtdObtenerOrdenCompraDetalles(NULL,NULL,NULL,NULL,NULL,$this->OcoId);
			//$this->OrdenCompraDetalle = 	$ResOrdenCompraDetalle['Datos'];	
				
			if($oCompleto){

	
				$InsOrdenCompraPedido = new ClsOrdenCompraPedido();
				
				$ResOrdenCompraPedido =  $InsOrdenCompraPedido->MtdObtenerOrdenCompraPedidos(NULL,NULL,NULL,NULL,NULL,$this->OcoId);
				$this->OrdenCompraPedido = 	$ResOrdenCompraPedido['Datos'];	
				
				
				$InsOrdenCompraDetalle = new ClsOrdenCompraDetalle();
				//MtdObtenerOrdenCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCompra=NULL,$oEstado=NULL,$oProducto=NULL) 
				$ResOrdenCompraDetalle =  $InsOrdenCompraDetalle->MtdObtenerOrdenCompraDetalles(NULL,NULL,"OcoId,PcdId","ASC",NULL,$this->OcoId);
				$this->OrdenCompraDetalle = $ResOrdenCompraDetalle['Datos'];	
				
			}
			



			$this->TdoId = $fila['TdoId']; 	
			$this->PrvNombreCompleto = $fila['PrvNombreCompleto'];
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];

			switch($this->OcoEstado){
			
				case 1:
					$Estado = "Pendiente";
				break;
			
				case 3:
					$Estado = "O.C. Enviado";						
				break;	

				case 4:
					$Estado = "Alm. Huachipa";						
				break;	
				
				case 5:
					$Estado = "c/ Entrada Parcial";	
				break;

				case 6:
					$Estado = "c/ Entrada Total";						
				break;
				
				default:
					$Estado = "";
				break;
			
			}
				
			$this->OcoEstadoDescripcion = $Estado;
			
			
			switch($this->OcoEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.gif" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				case 31:
					$Estado = '<img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />';						
				break;

				case 4:
					$Estado = '<img width="15" height="15" alt="[Alm. Huachipa]" title="Alm. Huachipa" src=" imagenes/estado/almacen.png" />';						
				break;	
				
				case 5:
					$Estado = "c/ Entrada Parcial";	
				break;
				
				case 6:
					$Estado = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />';						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$this->OcoEstadoIcono = $Estado;

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerOrdenCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oTipo=NULL,$oConSaldo=0,$oProveedor=NULL,$oMoneda=NULL,$oProcesado=NULL,$oVehiculoMarca=NULL) {

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
					pcd.PcdId
					
					FROM tblpcdpedidocompradetalle pcd
						
						LEFT JOIN tblproproducto pro
						ON pcd.ProId = pro.ProId
						
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								
								LEFT JOIN tblclicliente cli
								ON pco.CliId = cli.CliId
					WHERE 
					
						pco.OcoId = oco.OcoId
						AND
						(
							pro.ProNombre LIKE "%'.$oFiltro.'%" 
							OR pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%" 
							OR pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 

							OR cli.CliNombreCompleto LIKE "%'.$oFiltro.'%" 
							OR cli.CliNombre LIKE "%'.$oFiltro.'%" 
							OR cli.CliApellidoPaterno LIKE "%'.$oFiltro.'%" 
							OR cli.CliApellidoMaterno LIKE "%'.$oFiltro.'%" 
							OR cli.CliNumeroDocumento LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicio.'" AND DATE(oco.OcoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(oco.OcoFecha)<="'.$oFechaFin.'"';		
			}			
		}

	//	if(!empty($oEstado)){
//			$estado = ' AND oco.OcoEstado = '.$oEstado;
//		}
		
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (oco.OcoEstado = '.($elemento).')';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}

		if(!empty($oTipo)){

			$elementos = explode(",",$oTipo);


				$i=1;
				$tipo .= ' AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){						
							$tipo .= '  (oco.OcoTipo = "'.($elemento).'")';	
						}else{
							$tipo .= '  (oco.OcoTipo = "'.($elemento).'")  OR';	
						}
					}
				$i++;
		
				}
				
				$tipo .= ' ) ';
		
		}

		if(!empty($oConSaldo)){
			if($oConSaldo==1){
				$csaldo = ' AND (oco.OcoEstado = 3 OR EXISTS (SELECT (ocd.OcdId) FROM tblocdordencompradetalle ocd WHERE ocd.OcoId = oco.OcoId AND ocd.OcdSaldo>0))';
			}elseif($oConSaldo==2){
//				$csaldo = ' AND (oco.OcoEstado = 3 OR EXISTS (SELECT (ocd.OcdId) FROM tblocdordencompradetalle ocd WHERE ocd.OcoId = oco.OcoId AND ocd.OcdSaldo>0))';
			}
		}
		
		
			if(!empty($oProveedor)){
				$proveedor = ' AND (oco.PrvId) = "'.$oProveedor.'"';		
			}			
		
		
			if(!empty($oMoneda)){
				$moneda = ' AND (oco.MonId) = "'.$oMoneda.'"';		
			}	

			if(!empty($oProcesado)){
				$procesado = ' AND (oco.OcoProcesadoProveedor) = '.$oProcesado.' ';		
			}	

			if(!empty($oVehiculoMarca)){
				$vmarca = ' AND (oco.VmaId) = '.$oVehiculoMarca.' ';		
			}	

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				oco.OcoId,
				oco.OcoTipo,
				oco.OcoMes,
				oco.OcoAno,
				oco.OcoCodigoDealer,
								
								
				oco.OcoVIN,
				oco.OcoOrdenTrabajo,
			
				oco.PrvId,
				
				DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
				DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
				DATEDIFF(DATE(NOW()),oco.OcoFecha) AS OcoDiaTranscurrido,
				
				oco.OcoHora,
				
				oco.MonId,
				oco.OcoTipoCambio,
				oco.VmaId,
				
				oco.OcoObservacion,
				oco.OcoRespuestaProveedor,
				oco.OcoProcesadoProveedor,
				
				
				oco.OcoTieneETA,
				
				oco.OcoIncluyeImpuesto,
				oco.OcoPorcentajeImpuestoVenta,
				
				oco.OcoSubTotal,
				oco.OcoImpuesto,
				oco.OcoTotal,
				
				oco.OcoEstado,
				DATE_FORMAT(oco.OcoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOcoTiempoCreacion",
	        	DATE_FORMAT(oco.OcoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOcoTiempoModificacion",
				
				(SELECT count(pco.PcoId) FROM tblpcopedidocompra pco WHERE pco.OcoId = oco.OcoId AND pco.OcoId IS NOT NULL) AS OcoTotalPedidos,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				
				
				
				
				
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(pcd.PcdCantidad,0) 

							- IFNULL(

								(
									SELECT 
									SUM(amd.AmdCantidad)
									FROM tblamdalmacenmovimientodetalle amd

										LEFT JOIN tblamoalmacenmovimiento amo
										ON amd.AmoId = amo.AmoId

									WHERE amd.PcdId = pcd.PcdId
										AND amo.AmoEstado = 3
									LIMIT 1
								)
													
							,0)
							
							+
							
							IFNULL(

								(
									SELECT 
									SUM(nod.NodCantidad)
									FROM tblnodnotacreditocompradetalle nod

										LEFT JOIN tblamdalmacenmovimientodetalle amd
										ON nod.AmdId = amd.AmdId

											LEFT JOIN tblnccnotacreditocompra ncc
											ON nod.NccId = ncc.NccId

									WHERE amd.PcdId = pcd.PcdId
										AND amd.AmdEstado = 3
										AND nod.NodEstado = 3
									LIMIT 1
								)
													
							,0)
							
						)  AS PcdCantidadPendiente

					FROM tblpcdpedidocompradetalle pcd
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

					WHERE pco.OcoId = oco.OcoId
						AND pcd.PcdEstado = 3
						HAVING PcdCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarAlmacenMovimientoEntrada,
				
				
				
				
				
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(pcd.PcdCantidad,0) 

							- IFNULL(

								(
									SELECT 
									SUM(pld.PldCantidad)
									FROM tblpldpedidocomprallegadadetalle pld

										LEFT JOIN tblplepedidocomprallegada ple
										ON pld.PleId = ple.PleId

									WHERE pld.PcdId = pcd.PcdId
										AND ple.PleEstado = 3
									LIMIT 1
								)
													
							,0)
							
							
							- IFNULL(

								(
									SELECT 
									SUM(amd.AmdCantidad)
									FROM tblamdalmacenmovimientodetalle amd

										LEFT JOIN tblamoalmacenmovimiento amo
										ON amd.AmoId = amo.AmoId

									WHERE amd.PcdId = pcd.PcdId
										AND amo.AmoEstado = 3
									LIMIT 1
								)
													
							,0)
							
						)  AS PldCantidadPendiente

					FROM tblpcdpedidocompradetalle pcd
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

					WHERE pco.OcoId = oco.OcoId
						HAVING PldCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarPedidoCompraLlegada,
				
				
				








				CASE
				WHEN EXISTS (
					
					SELECT 
					pco.PcoId
					FROM tblpcopedidocompra pco
					WHERE pco.OcoId = oco.OcoId
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OcoPedidoCompra,
				
				CASE
				WHEN EXISTS (
					
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.OcoId = oco.OcoId
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OcoAlmacenMovimientoEntrada,
				
				
				(
				SELECT 
				CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoPaterno,"")," ", IFNULL(per.PerApellidoMaterno,"")) 	
				FROM tblcprcotizacionproducto cpr
					LEFT JOIN tblvdiventadirecta vdi
					ON vdi.CprId = cpr.CprId
						LEFT JOIN tblpcopedidocompra pco
						ON pco.VdiId = vdi.VdiId
							LEFT JOIN tblperpersonal per
							ON cpr.PerId = per.PerId
				WHERE pco.OcoId = oco.OcoId
				LIMIT 1
				
				) AS OcoCotizadorNombre,
				
				vma.VmaNombre
				
				FROM tblocoordencompra oco
					LEFT JOIN tblprvproveedor prv
					ON oco.PrvId = prv.PrvId
						LEFT JOIN tblmonmoneda mon
						ON oco.MonId = mon.MonId
							LEFT JOIN tblvmavehiculomarca vma
							ON oco.VmaId = vma.VmaId
							
				WHERE 2 = 2 '.$filtrar.$fecha.$tipo.$estado.$csaldo.$proveedor.$moneda.$procesado.$orden.$paginacion;
				//CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombre,							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

/*
,		

				
				CASE oco.OcoTipo
				   when "STK" then DATE_FORMAT(adddate(oco.OcoFecha,7), "%d/%m/%Y")
				   when "YRUSH" then DATE_FORMAT(adddate(oco.OcoFecha,3), "%d/%m/%Y")
				   when "ZVOR" then DATE_FORMAT(adddate(oco.OcoFecha,45), "%d/%m/%Y")
				END as OcoFechaLlegadaEstimada
				*/
			$Respuesta['Datos'] = array();
			
            $InsOrdenCompra = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenCompra = new $InsOrdenCompra();
                    $OrdenCompra->OcoId = $fila['OcoId'];
					$OrdenCompra->OcoTipo = $fila['OcoTipo'];
					$OrdenCompra->OcoMes = $fila['OcoMes'];
					$OrdenCompra->OcoAno = $fila['OcoAno'];
					$OrdenCompra->OcoCodigoDealer = $fila['OcoCodigoDealer'];
					
					$OrdenCompra->OcoVIN = $fila['OcoVIN'];
					$OrdenCompra->OcoOrdenTrabajo = $fila['OcoOrdenTrabajo'];
				
					$OrdenCompra->PrvId = $fila['PrvId'];	
					
					$OrdenCompra->OcoFecha = $fila['NOcoFecha'];
					$OrdenCompra->OcoFechaLlegadaEstimada = $fila['NOcoFechaLlegadaEstimada'];
					$OrdenCompra->OcoDiaTranscurrido = $fila['OcoDiaTranscurrido'];
					
					
					$OrdenCompra->OcoHora = $fila['OcoHora'];
					
					$OrdenCompra->MonId = $fila['MonId'];
					$OrdenCompra->OcoTipoCambio = $fila['OcoTipoCambio'];
					
					$OrdenCompra->OcoObservacion = $fila['OcoObservacion'];
					$OrdenCompra->OcoRespuestaProveedor = $fila['OcoRespuestaProveedor'];
					$OrdenCompra->OcoProcesadoProveedor = $fila['OcoProcesadoProveedor'];
					
				
					$OrdenCompra->OcoTieneETA = $fila['OcoTieneETA'];
					
					
					$OrdenCompra->OcoIncluyeImpuesto = $fila['OcoIncluyeImpuesto'];
					$OrdenCompra->OcoPorcentajeImpuestoVenta = $fila['OcoPorcentajeImpuestoVenta'];
					
					$OrdenCompra->OcoSubTotal = $fila['OcoSubTotal'];
					$OrdenCompra->OcoImpuesto = $fila['OcoImpuesto'];
					$OrdenCompra->OcoTotal = $fila['OcoTotal'];
					
					$OrdenCompra->OcoEstado = $fila['OcoEstado'];
					$OrdenCompra->OcoTiempoCreacion = $fila['NOcoTiempoCreacion'];
					$OrdenCompra->OcoTiempoModificacion = $fila['NOcoTiempoModificacion'];

					$OrdenCompra->OcoTotalPedidos = $fila['OcoTotalPedidos'];

					$OrdenCompra->TdoId = $fila['TdoId']; 

					$OrdenCompra->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$OrdenCompra->PrvNombre = $fila['PrvNombre']; 
					$OrdenCompra->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$OrdenCompra->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					$OrdenCompra->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$OrdenCompra->MonNombre = $fila['MonNombre']; 
					$OrdenCompra->MonSimbolo = $fila['MonSimbolo'];
					$OrdenCompra->VmaId = $fila['VmaId'];
					
					$OrdenCompra->VdiGenerarAlmacenMovimientoEntrada = $fila['VdiGenerarAlmacenMovimientoEntrada']; 
					$OrdenCompra->VdiGenerarPedidoCompraLlegada = $fila['VdiGenerarPedidoCompraLlegada']; 
					
					
					$OrdenCompra->OcoPedidoCompra = $fila['OcoPedidoCompra']; 
					$OrdenCompra->OcoAlmacenMovimientoEntrada = $fila['OcoAlmacenMovimientoEntrada']; 
					
					$OrdenCompra->OcoCotizadorNombre = $fila['OcoCotizadorNombre']; 
					
					$OrdenCompra->VmaNombre = $fila['VmaNombre']; 
					
					//$OrdenCompra->OcoFechaLlegadaEstimada = $fila['OcoFechaLlegadaEstimada']; 
					
					
			switch($OrdenCompra->OcoEstado){
			
			
				case 1:
					$Estado = "Pendiente";
				break;
			
				case 3:
					$Estado = "O.C. Enviado";						
				break;
				
				case 31:
					$Estado = "Correo Enviado";						
				break;	

				case 4:
					$Estado = "Alm. Huachipa";						
				break;	
				
				case 5:
					$Estado = "c/ Entrada Parcial";	
				break;

				case 6:
					$Estado = "Anulado";						
				break;
				
				default:
					$Estado = "";
				break;
					
			}
				
			$OrdenCompra->OcoEstadoDescripcion = $Estado;
			
			
			switch($OrdenCompra->OcoEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.gif" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				case 31:
					$Estado = '<img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />';						
				break;

				case 4:
					$Estado = '<img width="15" height="15" alt="[Alm. Huachipa]" title="Alm. Huachipa" src=" imagenes/estado/almacen.png" />';						
				break;	
				
				case 5:
					$Estado = "c/ Entrada Parcial";	
				break;
				
				case 6:
					$Estado = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />';						
				break;
				
				default:
					$Estado = "";
				break;
			
			}
				
			$OrdenCompra->OcoEstadoIcono = $Estado;
			

                    $OrdenCompra->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenCompra;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}



    public function MtdObtenerOrdenComprasValor($oFuncion="SUM",$oParametro="OcoId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oTipo=NULL,$oConSaldo=0,$oProveedor=NULL,$oMoneda=NULL,$oVehiculoMarca=NULL) {

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
					pcd.PcdId
					
					FROM tblpcdpedidocompradetalle pcd
						
						LEFT JOIN tblproproducto pro
						ON pcd.ProId = pro.ProId
						
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								
								LEFT JOIN tblclicliente cli
								ON pco.CliId = cli.CliId
					WHERE 
					
						pco.OcoId = oco.OcoId
						AND
						(
							pro.ProNombre LIKE "%'.$oFiltro.'%" 
							OR pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%" 
							OR pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 

							OR cli.CliNombreCompleto LIKE "%'.$oFiltro.'%" 
							OR cli.CliNombre LIKE "%'.$oFiltro.'%" 
							OR cli.CliApellidoPaterno LIKE "%'.$oFiltro.'%" 
							OR cli.CliApellidoMaterno LIKE "%'.$oFiltro.'%" 
							OR cli.CliNumeroDocumento LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicio.'" AND DATE(oco.OcoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(oco.OcoFecha)<="'.$oFechaFin.'"';		
			}			
		}

	//	if(!empty($oEstado)){
//			$estado = ' AND oco.OcoEstado = '.$oEstado;
//		}
		
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (oco.OcoEstado = '.($elemento).')';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}

		if(!empty($oTipo)){

			$elementos = explode(",",$oTipo);


				$i=1;
				$tipo .= ' AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){						
							$tipo .= '  (oco.OcoTipo = "'.($elemento).'")';	
						}else{
							$tipo .= '  (oco.OcoTipo = "'.($elemento).'")  OR';	
						}
					}
				$i++;
		
				}
				
				$tipo .= ' ) ';
		
		}

		if(!empty($oConSaldo)){
			if($oConSaldo==1){
				$csaldo = ' AND (oco.OcoEstado = 3 OR EXISTS (SELECT (ocd.OcdId) FROM tblocdordencompradetalle ocd WHERE ocd.OcoId = oco.OcoId AND ocd.OcdSaldo>0))';
			}elseif($oConSaldo==2){
//				$csaldo = ' AND (oco.OcoEstado = 3 OR EXISTS (SELECT (ocd.OcdId) FROM tblocdordencompradetalle ocd WHERE ocd.OcoId = oco.OcoId AND ocd.OcdSaldo>0))';
			}
		}
		
			if(!empty($oProveedor)){
				$proveedor = ' AND (oco.PrvId) = "'.$oProveedor.'"';		
			}	
			
			if(!empty($oVehiculoMarca)){
				$vmarca = ' AND (oco.VmaId) = "'.$oVehiculoMarca.'"';		
			}			
		
			if(!empty($oMoneda)){
				$moneda = ' AND (oco.MonId) = "'.$oMoneda.'"';		
			}			
		
			if(!empty($oMes)){
				$mes = ' AND MONTH(oco.OcoFecha) ="'.($oMes).'"';
			}
			
			if(!empty($oAno)){
				$ano = ' AND YEAR(oco.OcoFecha) ="'.($oAno).'"';
			}
			
			if(!empty($oFuncion) & !empty($oParametro)){		
				$funcion = $oFuncion.'('.$oParametro.')';			
			}	
			
			$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
				
				FROM tblocoordencompra oco
					LEFT JOIN tblprvproveedor prv
					ON oco.PrvId = prv.PrvId
						LEFT JOIN tblmonmoneda mon
						ON oco.MonId = mon.MonId
				WHERE 1 = 1 '.$mes.$ano.$filtrar.$fecha.$tipo.$vmarca.$estado.$csaldo.$proveedor.$moneda.$orden.$paginacion;

			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
			
		}
		
		
		
	//Accion eliminar	 
	public function MtdEliminarOrdenCompra($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsOrdenCompraDetalle = new ClsOrdenCompraDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){

					$sql = 'DELETE FROM tblocoordencompra WHERE  (OcoId = "'.($elemento).'" ) ';
													
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarOrdenCompra(3,"Se elimino la Orden de Compra",$elemento);		
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
	public function MtdActualizarEstadoOrdenCompra($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsOrdenCompra = new ClsOrdenCompra();
		$InsOrdenCompraDetalles = new ClsOrdenCompraDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
	

					$sql = 'UPDATE tblocoordencompra SET OcoEstado = '.$oEstado.' WHERE OcoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						if($oEstado == 3){
							
							$this->MtdNotificarOrdenCompraRegistro($elemento,"jblanco@cyc.com.pe,aliendo@cyc.com.pe,iquezada@cyc.com.pe,scanepam@cyc.com.pe,cchoque@cyc.com.pe");						
						}



							$this->OcoId = $elemento;
							$this->MtdObtenerOrdenCompra();
							
							$Total = 0;
							
							if(!empty($this->OrdenCompraPedido)){
								
								foreach($this->OrdenCompraPedido as $DatOrdenCompraPedido){
									
									$Total += $DatOrdenCompraPedido->PcoTotal;
								}
								
								$InsOrdenCompra->MtdEditarOrdenCompraDato("OcoTotal",$Total,$this->OcoId);
							}
							
							

						$this->MtdAuditarOrdenCompra(2,"Se actualizo el Estado de la Orden de Compra",$elemento);
				
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
	
	
	public function MtdRegistrarOrdenCompra() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarOrdenCompraId();
		
		
	/*		if(empty($this->PrvId)){
				
				if(!empty($this->PrvNombre)){
					
					$InsProveedor = new ClsProveedor();
					$InsProveedor->TdoId = $this->TdoId;
					$InsProveedor->PrvNombre = $this->PrvNombre;
					$InsProveedor->PrvNumeroDocumento = $this->PrvNumeroDocumento;
					$InsProveedor->PrvEstado = 1;
					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvEliminado = 1;
	
					if(!$InsProveedor->MtdRegistrarProveedorOrdenCompra()){
						$error = true;
						$Resultado.='#ERR_PRV_101';
					}else{
						$this->PrvId = $InsProveedor->PrvId;	
					}
					
				}
				
			}*/
		
		$this->InsMysql->MtdTransaccionIniciar();		
			
			$sql = 'INSERT INTO tblocoordencompra (
			OcoId,
			OcoTipo,
			OcoAno,
			OcoMes,
			OcoCodigoDealer,
			OcoVIN,
			OcoOrdenTrabajo,
			
			PrvId,

			OcoFecha,
			OcoFechaLlegadaEstimada,
			
			OcoHora,

			MonId,
			OcoTipoCambio,
			VmaId,
			
			OcoObservacion,
			
			OcoRespuestaProveedor,
			OcoProcesadoProveedor,

			OcoTieneETA,
			
			OcoIncluyeImpuesto,
			OcoPorcentajeImpuestoVenta,
			
			OcoSubTotal,
			OcoImpuesto,
			OcoTotal,
			
			OcoEstado,			
			OcoTiempoCreacion,
			OcoTiempoModificacion
			) 
			VALUES (
			"'.($this->OcoId).'", 
			"'.($this->OcoTipo).'", 
			"'.($this->OcoAno).'",
			"'.($this->OcoMes).'",
			
			"'.($this->OcoCodigoDealer).'",
			
			"'.($this->OcoVIN).'",
			"'.($this->OcoOrdenTrabajo).'",
			 	
			'.(empty($this->PrvId)?"NULL,":'"'.$this->PrvId.'",').'
			
			"'.($this->OcoFecha).'", 
			'.(empty($this->OcoFechaLlegadaEstimada)?"NULL,":'"'.$this->OcoFechaLlegadaEstimada.'",').'
			
			"'.($this->OcoHora).'", 
			
			"'.($this->MonId).'", 
			'.(empty($this->OcoTipoCambio)?"NULL,":''.$this->OcoTipoCambio.',').'
			'.(empty($this->VmaId)?"NULL,":'"'.$this->VmaId.'",').'
			
			"'.($this->OcoObservacion).'",
			"",
			2,
			
			"N", 	
			
			'.($this->OcoIncluyeImpuesto).',
			'.($this->OcoPorcentajeImpuestoVenta).',
			
			'.($this->OcoSubTotal).',
			'.($this->OcoImpuesto).',
			'.($this->OcoTotal).',
			
			'.($this->OcoEstado).',
			"'.($this->OcoTiempoCreacion).'", 				
			"'.($this->OcoTiempoModificacion).'");';
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
								
			if(!$error){
				
				if (!empty($this->OrdenCompraPedido)){		

					$validar = 0;				
					$InsPedidoCompra = new ClsPedidoCompra();		

					foreach ($this->OrdenCompraPedido as $DatPedidoCompra){

						if($InsPedidoCompra->MtdEditarPedidoCompraDato("OcoId",$this->OcoId,$DatPedidoCompra->PcoId)){
							$validar++;	
						}else{
							$Resultado.='#ERR_OCO_211';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					

					if(count($this->OrdenCompraPedido) <> $validar ){
						$error = true;
					}					
								
				}				
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarOrdenCompra(1,"Se registro la OrdenCompra",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarOrdenCompra() {

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

			/*if(empty($this->PrvId)){
				
				if(!empty($this->PrvNombre)){
					
					$InsProveedor = new ClsProveedor();
					$InsProveedor->TdoId = $this->TdoId;
					$InsProveedor->PrvNombre = $this->PrvNombre;
					$InsProveedor->PrvNumeroDocumento = $this->PrvNumeroDocumento;
					$InsProveedor->PrvEstado = 1;
					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvEliminado = 1;
					
					if(!$InsProveedor->MtdRegistrarProveedorOrdenCompra()){
						$error = true;
						$Resultado.='#ERR_PRV_101';
					}else{
						$this->PrvId = $InsProveedor->PrvId;	
					}
					
				}
				
			}*/
			
			//deb($this->OcoFechaLlegadaEstimada);
		
			$sql = 'UPDATE tblocoordencompra SET
			OcoCodigoDealer = "'.($this->OcoCodigoDealer).'",		
			
			OcoVIN = "'.($this->OcoVIN).'",		
			OcoOrdenTrabajo = "'.($this->OcoOrdenTrabajo).'",		
				
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			
			OcoFecha = "'.($this->OcoFecha).'",
			'.(empty($this->OcoFechaLlegadaEstimada)?'OcoFechaLlegadaEstimada = NULL, ':'OcoFechaLlegadaEstimada = "'.$this->OcoFechaLlegadaEstimada.'",').'
			
			OcoHora = "'.($this->OcoHora).'",
			
			MonId = "'.($this->MonId).'",
			'.(empty($this->OcoTipoCambio)?'OcoTipoCambio = NULL, ':'OcoTipoCambio = '.$this->OcoTipoCambio.',').'
			'.(empty($this->VmaId)?'VmaId = NULL, ':'VmaId = "'.$this->VmaId.'",').'
			
			OcoObservacion = "'.($this->OcoObservacion).'",
			OcoProcesadoProveedor = '.($this->OcoProcesadoProveedor).',
			
			OcoIncluyeImpuesto = '.($this->OcoIncluyeImpuesto).',
			OcoPorcentajeImpuestoVenta = '.($this->OcoPorcentajeImpuestoVenta).',
			
			OcoSubTotal = '.($this->OcoSubTotal).',
			OcoImpuesto = '.($this->OcoImpuesto).',
			OcoTotal = '.($this->OcoTotal).',
			
						
			OcoEstado = '.($this->OcoEstado).',
			OcoTiempoModificacion = "'.($this->OcoTiempoModificacion).'"
			WHERE OcoId = "'.($this->OcoId).'";';			
		
		
			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			

//			if(!$error){
//			
//				if (!empty($this->OrdenCompraDetalle)){		
//						
//						
//					$validar = 0;				
//					$InsOrdenCompraDetalle = new ClsOrdenCompraDetalle();
//							
//					foreach ($this->OrdenCompraDetalle as $DatOrdenCompraDetalle){
//										
//						$InsOrdenCompraDetalle->OcdId = $DatOrdenCompraDetalle->OcdId;
//						$InsOrdenCompraDetalle->OcoId = $this->OcoId;
//						$InsOrdenCompraDetalle->PcdId = $DatOrdenCompraDetalle->PcdId;
//	
//						$InsOrdenCompraDetalle->OcdCodigoOtro = $DatOrdenCompraDetalle->OcdCodigoOtro;
//						$InsOrdenCompraDetalle->OcdAno = $DatOrdenCompraDetalle->OcdAno;
//						$InsOrdenCompraDetalle->OcdModelo = $DatOrdenCompraDetalle->OcdModelo;
//
//						$InsOrdenCompraDetalle->OcdPrecio = $DatOrdenCompraDetalle->OcdPrecio;
//						$InsOrdenCompraDetalle->OcdCantidad = $DatOrdenCompraDetalle->OcdCantidad;
//						$InsOrdenCompraDetalle->OcdSaldo = $DatOrdenCompraDetalle->OcdSaldo;
//						
//						$InsOrdenCompraDetalle->OcdImporte = $DatOrdenCompraDetalle->OcdImporte;
//						$InsOrdenCompraDetalle->OcdEstado = $this->OcoEstado;		
//						$InsOrdenCompraDetalle->OcdTiempoCreacion = $DatOrdenCompraDetalle->OcdTiempoCreacion;
//						$InsOrdenCompraDetalle->OcdTiempoModificacion = $DatOrdenCompraDetalle->OcdTiempoModificacion;
//						$InsOrdenCompraDetalle->OcdEliminado = $DatOrdenCompraDetalle->OcdEliminado;
//						
//						if(empty($InsOrdenCompraDetalle->OcdId)){
//							if($InsOrdenCompraDetalle->OcdEliminado<>2){
//								if($InsOrdenCompraDetalle->MtdRegistrarOrdenCompraDetalle()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_OCO_201';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsOrdenCompraDetalle->OcdEliminado==2){
//								if($InsOrdenCompraDetalle->MtdEliminarOrdenCompraDetalle($InsOrdenCompraDetalle->OcdId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_OCO_203';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsOrdenCompraDetalle->MtdEditarOrdenCompraDetalle()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_OCO_202';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->OrdenCompraDetalle) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}	
			
			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarOrdenCompra(2,"Se edito la Orden de Compra",$this);		
				return true;
			}	
				
		}
				
		public function FncRecalcularTotalOrdenCompra($oOrdenCompraId){
			
			$this->OcoId = $oOrdenCompraId;
			$this->MtdObtenerOrdenCompra(true);
			
			$Total = 0;
			
			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
					
					$InsPedidoCompra1 = new ClsPedidoCompra();
					$InsPedidoCompra1->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra1->MtdObtenerPedidoCompra();
					//deb($InsPedidoCompra->PedidoCompraDetalle);
					if(!empty($InsPedidoCompra1->PedidoCompraDetalle)){
						foreach($InsPedidoCompra1->PedidoCompraDetalle as $DatPedidoCompraDetalle){
		
							$Total += $DatPedidoCompraDetalle->PcdImporte;
		
						}
					}
					
				}
				
				$this->MtdEditarOrdenCompraDato("OcoTotal",$Total,$oOrdenCompraId);
				
			}
			
		}
		
		//
//		public function MtdEditarOrdenCompraDato($oCampo,$oDato,$oOrdenCompraId) {
//
//		global $Resultado;
//		$error = false;
//
//			//$this->InsMysql->MtdTransaccionIniciar();
//
//			$sql = 'UPDATE tblocoordencompra SET
//			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
//			OcoTiempoModificacion = NOW()
//			WHERE OcoId = "'.($oOrdenCompraId).'";';		
//			
//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//			
//			if(!$resultado) {							
//				$error = true;
//			} 			
//
//			if($error) {		
//				//$this->InsMysql->MtdTransaccionDeshacer();					
//				return false;
//			} else {			
//				//$this->InsMysql->MtdTransaccionHacer();				
//				$this->MtdAuditarOrdenCompra(2,"Se edito la Orden de Compra",$this);		
//				return true;
//			}	
//				
//		}	


		
		private function MtdAuditarOrdenCompra($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->OcoId;

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



		
		public function MtdEditarOrdenCompraDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblocoordencompra SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			OcoTiempoModificacion = NOW()
			WHERE OcoId = "'.($oId).'";';
			
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






		public function MtdNotificarOrdenCompraRegistro($oOrdenCompra,$oDestinatario,$oConAdjunto=NULL){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->OcoId = $oOrdenCompra;
			$this->MtdObtenerOrdenCompra();
			
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "Datos de la Orden de Compra .";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->OcoId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Proveedor: <b>".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->OcoFecha."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";

			if(!empty($this->OrdenCompraPedido)){
				foreach($this->OrdenCompraPedido as $DatOrdenCompraPedido){


					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();
					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					$mensaje .= "<table>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Cliente: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					


					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Ord. Venta: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiId;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Fecha: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiFecha;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "O.C. Ref.: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiOrdenCompraNumero;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Fecha: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiOrdenCompraFecha;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";		

									
					$mensaje .= "</table>";
									
									
									


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
						$mensaje .= "Prom. Mensual";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";

					
					$i = 1;
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							$mensaje .= "<tr>";
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
								$mensaje .= "</td>";
								
									
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraDetalle->ProPromedioMensual,2);
								$mensaje .= "</td>";
				
								
				
								
							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					

					
				}
			}
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
						
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno,$mensaje);
			
		}


		public function MtdGenerarExcelOrdenCompra($oOrdenCompra,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			
			$Generado = true;
			
			if(!empty($oOrdenCompra)){

				$this->OcoId = $oOrdenCompra;
				$this->MtdObtenerOrdenCompra();
					
					
				$objPHPExcel = new PHPExcel();
					
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenCompra".(($this->OcoTipo<>"ALM")?"GM":"").".xls");
					
					// Set document properties
					$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												 ->setLastModifiedBy("Maarten Balliauw")
												 ->setTitle("PHPExcel Test Document")
												 ->setSubject("PHPExcel Test Document")
												 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
												 ->setKeywords("office PHPExcel php")
												 ->setCategory("Test result file");
					
					// Miscellaneous glyphs, UTF-8
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F8', 'ORDEN DE COMPRA PERU - C&C');
					$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true)->setSize(14);
								
																				   
												   
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F9', $this->OcoId);
					$objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true)->setSize(14);		
					
					
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C11', 'CÓDIGO SAP');
					$objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
						
						
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
								
								
								
								
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C12', 'Codigo Dealer');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E12', '8001200006');
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C13', 'Fecha');
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E13', $this->OcoFecha);
					
					
					$objPHPExcel->getActiveSheet()->getStyle('C12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('E12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
						
						
						
						
					$objPHPExcel->getActiveSheet()->getStyle('C13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('D13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('E13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					
					
						
					
					
					
					$objPHPExcel->getActiveSheet()->getStyle("C12")->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle("D12")->getAlignment()->setWrapText(true);
					
					$objPHPExcel->getActiveSheet()->getStyle("C13")->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle("D13")->getAlignment()->setWrapText(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
					
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C14', 'Hora');	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E14', $this->OcoHora);						
							
							
					$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					
					$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);	
									
									
									
									
									
									
									
								$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G13', 'VIN');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H13', $this->OcoVIN);						
						
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G14', 'O.T.');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H14', $this->OcoOrdenTrabajo);						
				
					
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
					$objPHPExcel->getActiveSheet()->getStyle('C17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('C17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								
													
													
													
						
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('D17', 'GM PN Replace');		
					$objPHPExcel->getActiveSheet()->getStyle('D17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('D17')->getFont()->setBold(true);	
					$objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								                             
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E16', 'DEALER');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E17', 'Cantidad de Pedido');
					$objPHPExcel->getActiveSheet()->getStyle('E17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 							   
												  
													
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('F16', 'GM');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('F17', 'Partes a Atender');
					$objPHPExcel->getActiveSheet()->getStyle('F17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('F17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												   
															
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('G16', 'GM');	
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('G17', 'B/O');
					$objPHPExcel->getActiveSheet()->getStyle('G17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					
					$objPHPExcel->getActiveSheet()->getStyle('G17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
													
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('H16', 'GM');			
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('H17', 'Descripcion');
					$objPHPExcel->getActiveSheet()->getStyle('H17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('H17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('I17', 'Año');
					$objPHPExcel->getActiveSheet()->getStyle('I17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('I17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('I17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('J17', 'Modelo');
					$objPHPExcel->getActiveSheet()->getStyle('J17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('J17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('J17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
												   
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('K16', 'GM');	
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('K17', 'Precio');
					$objPHPExcel->getActiveSheet()->getStyle('K17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('K17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   							   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('L17', 'Total');
					$objPHPExcel->getActiveSheet()->getStyle('L17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);			
					$objPHPExcel->getActiveSheet()->getStyle('L17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					$objPHPExcel->getActiveSheet()->getStyle('C17:L17')->applyFromArray(
						array('fill' 	=> array(
													'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
													'color'		=> array('rgb' => '8DB4E3')
												)
													
							 )
						);
					
					
					
					
					$fila = 18;
					$indice = 1;
					
					
					$TotalReal = 0;
					$Total = 0;
					if(!empty($this->OrdenCompraDetalle)){
						foreach($this->OrdenCompraDetalle as $DatOrdenCompraDetalle){
							
							$TotalReal += $DatOrdenCompraDetalle->OcdImporte;
								
									if($this->MonId<>$EmpresaMonedaId){
										$DatOrdenCompraDetalle->OcdImporte = round($DatOrdenCompraDetalle->OcdImporte / $DatOrdenCompraDetalle->PcoTipoCambio,2);
										$DatOrdenCompraDetalle->OcdPrecio = round($DatOrdenCompraDetalle->OcdPrecio  / $DatOrdenCompraDetalle->PcoTipoCambio,2);
									}
											
											
									//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $indice);
									
									//C
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatOrdenCompraDetalle->OcdCodigo);
									$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//D
										
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
						
						
						
									//E
						
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatOrdenCompraDetalle->OcdCantidad);
									$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//F
									
									$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//G
									
									$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//H
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatOrdenCompraDetalle->ProNombre);
									$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//I
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatOrdenCompraDetalle->OcdAno);
									$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//J
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatOrdenCompraDetalle->OcdModelo);
									$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//K
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatOrdenCompraDetalle->OcdPrecio);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
										
									//L
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $DatOrdenCompraDetalle->OcdImporte);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
									
									$Total += $DatOrdenCompraDetalle->OcdImporte;
									
									$fila++;
									$indice++;
								
								
					
							
						}
						
					}
					
					$objPHPExcel->getActiveSheet()->getStyle('C'.$fila.':K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
					
					
					//
					//$objPHPExcel->getActiveSheet()->getStyle('B20:L'.$fila)->applyFromArray(
					//	array(
					//		  'borders' => array(
					//		  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
					//								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
					//								
					//								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
					//								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
					//							)
					//		 )
					//	);
						
					//$objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray(
					//	array('fill' 	=> array(
					//								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
					//								'color'		=> array('argb' => 'FFFFFF00')
					//							),
					//		 )
					//	);
						
					//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, "TOTAL:");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $Total);
					
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
					
					$this->MtdEditarOrdenCompraDato("OcoTotal",$TotalReal,$this->OcoId);
					
					
					//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
					//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
					//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
					
					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle('Ord. Comp. GM ');
					
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/".$this->OcoId.".xls");
					
					
					
					
			}else{
				
				$Generado = false;
					
			}

			return $Generado;
		
		}
		
				
		
		public function MtdEnviarCorreoPedidoOrdenCompra($oOrdenCompra,$oDestinatario,$oRuta=""){

global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->OcoId = $oOrdenCompra;
			$this->MtdObtenerOrdenCompra();

			$mensaje = "";
			$mensaje .= "<br>";
			$mensaje .= "<b>Estimado Sr. Bernardo.-</b>";
			$mensaje .= "<br><br>";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes, envio pedido adjunto ".$this->OcoTipo." - ";
			}else{
				$mensaje .= "Buenos dias, envio pedido adjunto ".$this->OcoTipo." - ";
			}
			
			$mensaje .= "<br><br>";
			$mensaje .= "Estare a la espera de su pronta respuesta.";
			$mensaje .= "<br><br>";
			$mensaje .= "Saludos";
			
			$mensaje .= "<br><br>";
			$mensaje .= "Atte.";
			
			$mensaje .= "<br><br>";
			$mensaje .= $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno;
			
			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";

			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,"SISTEMA CYC","PEDIDO: ".$this->OcoId,$mensaje,$oRuta."generados/",$this->OcoId.".xls");
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");

		}
		
		
		
		
		public function MtdEnviarCorreoConsultaETA($oOrdenCompra,$oDestinatario,$oRuta=""){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->OcoId = $oOrdenCompra;
			$this->MtdObtenerOrdenCompra();

			$mensaje = "";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Estimados Señores.-</b>";
			$mensaje .= "<br><br>";
			
			$mensaje .= "Se solicita nos informen el estado de la siguiente orden de compra <b>".$this->OcoId."</b> con fecha <b>".$this->OcoFecha."</b>";
			$mensaje .= "<br>";
			
			
			if(!empty($this->OrdenCompraPedido)){
				foreach($this->OrdenCompraPedido as $DatOrdenCompraPedido){


					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();
					
			$mensaje .= "<br>";
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
						
						
		
					$mensaje .= "</tr>";

					
					$i = 1;
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							$mensaje .= "<tr>";
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
								$mensaje .= "</td>";
							
							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					

					
				}
			}
			
			
			
			
			
			$mensaje .= "<br><br>";
			$mensaje .= "Estaremos a la espera de su pronta respuesta.";
			$mensaje .= "<br><br>";
			//$mensaje .= "Saludos";
			
			$mensaje .= "<br><br>";
			$mensaje .= "Atte.";
			
			$mensaje .= "<br><br>";
			$mensaje .= $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno;
			
			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";

			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,"SISTEMA CYC","ETA: ".$this->OcoId,$mensaje,NULL,NULL);
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");

		}




//
//		public function MtdNotificarOrdenCompraPendienteAtencion($oDestinatario,$oFechaInicio=NULL,$oFechaFin=NULL){
//		
//			global $EmpresaMonedaId;
//			
//			$Enviar = false;
//			
//			$mensaje .= "------------------------------------------------";	
//			$mensaje .= "<br>";	
//			$mensaje .= "AVISO DE ORDENES PENDIENTES DE ATENCION:";	
//			$mensaje .= "<br>";	
//			$mensaje .= "------------------------------------------------";	
//			
//			$mensaje .= "<br>";	
//			$mensaje .= "<br>";	
//
//		
//			$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
//			$mensaje .= "<br>";	
//			
//			
//			$mensaje .= "<hr>";
//			$mensaje .= "<br>";
//			
//			
//				$mensaje .= "<br>";
//
//		$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
//		$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,"OcoFecha","ASC",NULL,NULL,3,NULL,FncCambiaFechaAMysql($oFechaInicio),FncCambiaFechaAMysql($oFechaFin),NULL,NULL,NULL);
//		$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
//
//
//				if(!empty($ArrPedidoCompraDetalles)){
//				
//					
//					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
//					
//					$mensaje .= "<tr>";
//					
//						$mensaje .= "<td width='2%'>";
//						$mensaje .= "<b>#</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>ORD. COMPRA</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td>";
//						$mensaje .= "<b>FECHA</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>FECHA LLEGADA APROX.</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>DIAS TRANSCURRIDOS</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>COD. ORIGINAL</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>CANT.</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>PRODUCTO</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>AÑO</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>MODELO</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='20%'>";
//						$mensaje .= "<b>CLIENTE</b>";
//						$mensaje .= "</td>";
//						
//					$mensaje .= "</tr>";
//					
//					
//							
//				$c = 1;	
//				
//			foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
//
//				if($DatPedidoCompraDetalle->PcdCantidadPendienteLlegada>0){
//						
//						$mensaje .= "<tr>";
//									
//							$mensaje .= "<td>";
//							$mensaje .= $c;
//							$mensaje .= "</td>";
//			
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->OcoId;
//							$mensaje .= "</td>";
//							
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->OcoFecha;
//							$mensaje .= "</td>";
//		
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->OcoFechaLlegadaEstimada;
//							$mensaje .= "</td>";
//							
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->OcoDiaTranscurrido;
//							$mensaje .= "</td>";
//		
//							
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
//							$mensaje .= "</td>";
//		
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->PcdCantidadPendienteLlegada;
//							$mensaje .= "</td>";
//							
//							
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->ProNombre;
//							$mensaje .= "</td>";
//									
//							$mensaje .= "<td>";
//							$mensaje .= $DatAlmacenMovimientoEntrada->PcdAno;
//							$mensaje .= "</td>";
//							
//							$mensaje .= "<td>";
//							$mensaje .= $DatAlmacenMovimientoEntrada->PcdModelo;
//							$mensaje .= "</td>";
//										
//							$mensaje .= "<td>";
//							$mensaje .= $DatPedidoCompraDetalle->CliNombre." ".$DatPedidoCompraDetalle->CliApellidoPaterno." ".$DatPedidoCompraDetalle->CliApellidoMaterno;
//							$mensaje .= "</td>";
//								
//						$mensaje .= "</tr>";
//
//					$c++;			
//					
//				
//					$Enviar = true;
//					
//					}
//					
//					
//							
//				}
//				
//
//					
//						
//					$mensaje .= "</table>";
//					
//					
//				}
//				
//			
//			
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
//			
//			
//			echo $mensaje;
//			
//			if($Enviar){
//				
//				$InsCorreo = new ClsCorreo();	
//				//$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"AVISO: FACTURAS C/ CREDITO - ".$ProveedorNombre,$mensaje);
//				
//			}
//				
//				
//				
//				
//		}
		
		
		

}
?>