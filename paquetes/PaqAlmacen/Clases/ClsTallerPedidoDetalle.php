<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTallerPedidoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTallerPedidoDetalle {

    public $AmdId;
	public $AmoId;
	public $ProId;
	public $UmeId;
	
	public $VddId;
	public $FaaId;
	public $FapId;
	
    public $AmdCantidad;	
	public $AmdCantidadReal;
	public $AmdCosto;

	public $AmdValorTotal;
	public $AmdUtilidad;
	public $AmdPrecioVenta;
	
	public $AmdImporte;	
	public $AmdEstado;	
	public $AmdTiempoCreacion;
	public $AmdTiempoModificacion;
    public $AmdEliminado;
	

	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;
	public $RtiId;
	public $UmeIdOrigen;
	
	public $UmeNombre;
	
	public $FaaAccion;
	public $FaaNivel;
	public $FaaVerificar1;
	public $FaaVerificar2;
	
	//public $FichaAccionMantenimiento;
	public $FichaAccionProducto;
					
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarTallerPedidoDetalleId() {
			
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
		
		
   public function MtdObtenerTallerPedidoDetalle(){

		$sql = 'SELECT
			 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			amd.VddId,
			amd.FaaId,
			amd.FapId,
			
			amd.AlmId,
			DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,
			amd.AmdEstad,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			
			faa.PmtId,
			
			faa.FaaAccion,
			faa.FaaNivel,
			faa.FaaVerificar1,
			
			amd.AmdReingreso
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId

		WHERE amd.AmdId = "'.$this->AmdId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->AmdId = $fila['AmdId'];
			$this->AmoId = $fila['AmoId'];
			$this->UmeId = $fila['UmeId'];
			
			
			
			$this->VddId = $fila['VddId'];
			$this->FaaId = $fila['FaaId'];
			$this->FapId = $fila['FapId'];
			
			$this->AlmId = $fila['AlmId'];
			$this->AmdFecha = $fila['NAmdFecha'];
		
			
			$this->AmdCosto = $fila['AmdCosto'];  
			$this->AmdCantidad = $fila['AmdCantidad'];  
			$this->AmdCantidadReal = $fila['AmdCantidadReal'];  
			
			$this->AmdValorTotal = $fila['AmdValorTotal'];  
			$this->AmdUtilidad = $fila['AmdUtilidad'];  					
			$this->AmdPrecioVenta = $fila['AmdPrecioVenta'];  					
			
			$this->AmdImporte = $fila['AmdImporte'];
			$this->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
			$this->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
			$this->ProId = $fila['ProId'];
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
			$this->ProNombre = (($fila['ProNombre']));
			$this->RtiId = (($fila['RtiId']));
			$this->UmeIdOrigen = (($fila['UmeIdOrigen']));
			
			$this->UmeNombre = (($fila['UmeNombre']));
			
			$this->AmoFecha = (($fila['NAmoFecha']));
			
			$this->PmtId = (($fila['PmtId']));
			
			$this->FaaAccion = (($fila['FaaAccion']));
			$this->FaaNivel = (($fila['FaaNivel']));
			$this->FaaVerificar1 = (($fila['FaaVerificar1']));
			
			$this->AmdReingreso = (($fila['AmdReingreso']));
					
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	


    public function MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL,$oFichaAccion=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oTallerPedido)){
			$amovimiento = ' AND amd.AmoId = "'.$oTallerPedido.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		
		if(!empty($oTallerPedidoEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oTallerPedidoEstado.') ';
		}



		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			
			AND 
			
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		

		if(!empty($oProductoTipo)){
			$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
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

			if(!empty($oVentaDirectaDetalle)){
				$vdetalle = ' AND (amd.VddId = "'.$oVentaDirectaDetalle.'") ';
			}
			
			if(!empty($oFichaAccion)){
				$faccion = ' AND (amo.FccId = "'.$oFichaAccion.'") ';
			}
			
				
			if(!empty($oSucursal)){
				$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
			}
			
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
		  	amd.VddId,
			amd.FaaId,
			amd.FapId,
			
			amd.AlmId,
			DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,
			
			amd.AmdCierre,
			
			amo.AmoCierre,
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			pro.ProTienePromocion,
			
			ume2.UmeNombre  AS "UmeNombreOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			
			faa.PmtId,
			
			faa.FaaAccion,
			faa.FaaNivel,
			faa.FaaVerificar1,
			faa.FaaVerificar2,
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			cli.CliNumeroDocumento,
			
			top.TopNombre,
			fin.FinId,
			
			min.MinNombre,
			
			
			(
		

				IFNULL(
					(
						SELECT 
						CONCAT(fta.FtaNumero,"-",fac.FacId) 
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE amd.AmoId = fac.AmoId
						AND fac.FacEstado <> 6 LIMIT 1
					),
						IFNULL(
						(
							SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
							AND fac.FacEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS AmdFactura,
			
			
			
			
			
			
					(
		

				IFNULL(
					(
						SELECT 
						CONCAT(bta.BtaNumero,"-",bol.BolId) 
						FROM tblbolboleta bol
							LEFT JOIN tblbtaboletatalonario bta
							ON bol.BtaId = bta.BtaId
						WHERE amd.AmoId = bol.AmoId
						AND bol.BolEstado <> 6 LIMIT 1
					),
						IFNULL(
						(
							SELECT 
							CONCAT(bta.BtaNumero,"-",bol.BolId) 
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
									LEFT JOIN tblbdeboletadetalle bde
									ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
									
							WHERE amd.AmdId = bde.AmdId
							AND bol.BolEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS AmdBoleta,
			
			
			
			
			
			
			(
			SELECT 

			CONCAT(fta.FtaNumero,"-",fac.FacId)
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdFacturaX,
			

			(
			SELECT 

			DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdFacturaFechaEmision,
			
			
			
			
			
			(
			SELECT 

			CONCAT(bta.BtaNumero,"-",bol.BolId)
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
			WHERE bol.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdBoletaX,
			
			(
			SELECT 

			DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
			WHERE bol.AmoId = amd.AmoId 
			LIMIT 1
			) AS AmdBoletaFechaEmision,
			
			
			
			
			
			vdd.VdiId,
			
			
			@FdeCantidad:=(
			
				SELECT 
				SUM(fde.FdeCantidad)
				FROM tblfdefacturadetalle fde
				
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
						
				WHERE fde.AmdId = amd.AmdId
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
														AND ncr.NcrEstado <> 6
AND ncr.NcrMotivoCodigo<> "04"
													)
													
													
				LIMIT 1

			) AS FdeCantidad,
			
			
			@BdeCantidad:=(
			
				SELECT 
				SUM(bde.BdeCantidad)
				FROM tblbdeboletadetalle bde
				
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
						
				WHERE bde.AmdId = amd.AmdId
					AND bol.BolEstado <> 6
					
					AND NOT EXISTS(
						SELECT 	
						ncr.NcrId
						FROM tblncrnotacredito ncr
						WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
						AND ncr.NcrEstado <> 6
						AND ncr.NcrMotivoCodigo<> "04"
					)
					
				LIMIT 1

			) AS BdeCantidad,
			
			
			(
			IFNULL(amd.AmdCantidad,0) - IFNULL(@FdeCantidad,0) - IFNULL(@BdeCantidad,0) 				
			) AS AmdCantidadPendienteFacturar,
			
			amd.AmdReingreso,
			amd.AmdCompraOrigen,
			
			CASE
			
			WHEN (
			
				EXISTS (
					SELECT 
					bde.BdeId
					FROM tblbdeboletadetalle bde
						LEFT JOIN tblbolboleta bol
						ON bol.BolId = bde.BolId AND bol.BtaId = bde.BtaId					
					WHERE bde.AmdId = amd.AmdId
					AND bol.BolEstado <> 6
					LIMIT 1
				) OR 
			
				EXISTS (
					SELECT 
					fde.FdeId
					FROM tblfdefacturadetalle fde
						LEFT JOIN tblfacfactura fac
						ON fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
					WHERE fde.AmdId = amd.AmdId
					AND fac.FacEstado <> 6
					LIMIT 1
				)
				
			)
			
			THEN 1
			ELSE 2
			END AS AmdFacturado,
			
			pro.ProTienePromocion,
			
			suc.SucNombre
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
				
					LEFT JOIN tblvddventadirectadetalle vdd
					ON amd.VddId = vdd.VddId
					
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId		

						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId

							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
							
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
									
										LEFT JOIN tblminmodalidadingreso min
										ON fim.MinId = min.MinId
				
											LEFT JOIN tblclicliente cli
											ON amo.CliId = cli.CliId
								
								LEFT JOIN tbltoptipooperacion top
								ON amo.TopId = top.TopId
	
								LEFT JOIN tblfaafichaaccionmantenimiento faa
								ON amd.FaaId = faa.FaaId
									LEFT JOIN tblfapfichaaccionproducto fap
									ON fap.FaaId = faa.FaaId
									
									LEFT JOIN tblpmtplanmantenimientotarea pmt
									ON faa.PmtId = pmt.PmtId
										
										LEFT JOIN tblsucsucursal suc
										ON amo.SucId = suc.SucId
									
			WHERE   amo.AmoTipo = 2 
			AND amo.AmoSubTipo = 2
		
			'.$amovimiento.$fecha.$estado.$producto.$sucursal.$filtrar.$faccion.$amestado.$vmarca.$ptipo.$vdetalle.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTallerPedidoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TallerPedidoDetalle = new $InsTallerPedidoDetalle();
                    $TallerPedidoDetalle->AmdId = $fila['AmdId'];
                    $TallerPedidoDetalle->AmoId = $fila['AmoId'];
					$TallerPedidoDetalle->UmeId = $fila['UmeId'];
					
					
					//deb($fila['FapId']);
					
					$TallerPedidoDetalle->VddId = $fila['VddId'];
					$TallerPedidoDetalle->FaaId = $fila['FaaId'];
					$TallerPedidoDetalle->FapId = $fila['FapId'];
					
					$TallerPedidoDetalle->AlmId = $fila['AlmId'];
					$TallerPedidoDetalle->AmdFecha = $fila['NAmdFecha'];
			
					$TallerPedidoDetalle->AmdCosto = $fila['AmdCosto'];  
			        $TallerPedidoDetalle->AmdCantidad = $fila['AmdCantidad'];  
					$TallerPedidoDetalle->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$TallerPedidoDetalle->AmdValorTotal = $fila['AmdValorTotal'];  
					$TallerPedidoDetalle->AmdUtilidad = $fila['AmdUtilidad'];  					
					$TallerPedidoDetalle->AmdPrecioVenta = $fila['AmdPrecioVenta'];  					

					$TallerPedidoDetalle->AmdImporte = $fila['AmdImporte'];
					$TallerPedidoDetalle->AmdCierre = $fila['AmdCierre'];
					
					
					
					
					
					$TallerPedidoDetalle->AmdEstado = $fila['AmdEstado'];
					$TallerPedidoDetalle->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$TallerPedidoDetalle->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$TallerPedidoDetalle->ProId = $fila['ProId'];
					$TallerPedidoDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$TallerPedidoDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $TallerPedidoDetalle->ProNombre = (($fila['ProNombre']));
					$TallerPedidoDetalle->RtiId = (($fila['RtiId']));
					$TallerPedidoDetalle->ProTienePromocion = (($fila['ProTienePromocion']));
					
					
					$TallerPedidoDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$TallerPedidoDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					
					$TallerPedidoDetalle->UmeNombre = (($fila['UmeNombre']));
					$TallerPedidoDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$TallerPedidoDetalle->AmoFecha = (($fila['NAmoFecha']));
					
					$TallerPedidoDetalle->PmtId = (($fila['PmtId']));
					
					$TallerPedidoDetalle->FaaAccion = (($fila['FaaAccion']));
					$TallerPedidoDetalle->FaaNivel = (($fila['FaaNivel']));
					$TallerPedidoDetalle->FaaVerificar1 = (($fila['FaaVerificar1']));
					$TallerPedidoDetalle->FaaVerificar2 = (($fila['FaaVerificar2']));
					
					$TallerPedidoDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$TallerPedidoDetalle->CliNombre = (($fila['CliNombre']));
					$TallerPedidoDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$TallerPedidoDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$TallerPedidoDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$TallerPedidoDetalle->TopNombre = (($fila['TopNombre']));
					
					$TallerPedidoDetalle->FinId = (($fila['FinId']));
					
					$TallerPedidoDetalle->MinNombre = (($fila['MinNombre']));
					
					$TallerPedidoDetalle->AmdFactura = (($fila['AmdFactura']));
					$TallerPedidoDetalle->AmdFacturaFechaEmision = (($fila['AmdFacturaFechaEmision']));
					
					$TallerPedidoDetalle->AmdBoleta = (($fila['AmdBoleta']));
					$TallerPedidoDetalle->AmdBoletaFechaEmision = (($fila['AmdBoletaFechaEmision']));
			
					$TallerPedidoDetalle->VdiId = (($fila['VdiId']));
					
					$TallerPedidoDetalle->FdeCantidad = (($fila['FdeCantidad']));
					$TallerPedidoDetalle->BdeCantidad = (($fila['BdeCantidad']));
					$TallerPedidoDetalle->AmdCantidadPendienteFacturar = (($fila['AmdCantidadPendienteFacturar']));
			
					$TallerPedidoDetalle->AmdReingreso = (($fila['AmdReingreso']));
					$TallerPedidoDetalle->AmdCompraOrigen = (($fila['AmdCompraOrigen']));
					
					$TallerPedidoDetalle->AmdFacturado = (($fila['AmdFacturado']));
					
					$TallerPedidoDetalle->AmoCierre = (($fila['AmoCierre']));
					
					$TallerPedidoDetalle->ProTienePromocion = (($fila['ProTienePromocion']));
					
					$TallerPedidoDetalle->SucNombre = (($fila['SucNombre']));
			
					
                    $TallerPedidoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TallerPedidoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		




   public function MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oModalidadIngreso=NULL,$oPersonal=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		if(!empty($oTallerPedido)){
			$amovimiento = ' AND amd.AmoId = "'.$oTallerPedido.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}



		if(!empty($oTallerPedidoEstado)){
			$tpestado = ' AND ( amo.AmoEstado = "'.$oTallerPedidoEstado.'" ) ';
		}
		
		
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			AND 
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
		
		if(!empty($oModalidadIngreso)){
			$mingreso = ' AND ( fim.MinId = "'.$oModalidadIngreso.'" ) ';
		}	
		
		if(!empty($oPersonal)){
			$personal = ' AND ( fin.PerId = "'.$oPersonal.'" ) ';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ( fin.SucId = "'.$oSucursal.'" ) ';
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
	
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) = "'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) = "'.($oAno).'"';
		}
		
		
		
			$sql = '
			SELECT
				'.$funcion.' AS "RESULTADO"

			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId
							
									LEFT JOIN tblfapfichaaccionproducto fap
									ON fap.FaaId = faa.FaaId

			WHERE  amo.AmoTipo = 2  
				AND amo.AmoSubTipo = 2 
			'.$ano.$mes.$amovimiento.$estado.$producto.$mingreso.$fecha.$personal.$sucursal.$filtrar.$tpestado.$vmarca.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarTallerPedidoDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (AmdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AmdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblamdalmacenmovimientodetalle 
				WHERE '.$eliminar;
							
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
	
	
	public function MtdRegistrarTallerPedidoDetalle() {
	
			$error = false;
	
			$this->MtdGenerarTallerPedidoDetalleId();

			
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
			AmdIdOrigen,
			
			AmdCosto,
			AmdCostoAnterior,
			AmdCostoExtraTotal,
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
			
			AmdReingreso,
			AmdCompraOrigen,
			
			AlmId,
			AmdFecha,
			
			
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			"'.($this->AmdId).'", 
			"'.($this->AmoId).'", 
			"'.($this->ProId).'", 
			'.(empty($this->UmeId)?'NULL, ':'"'.$this->UmeId.'",').'

			'.(empty($this->FaaId)?'NULL, ':'"'.$this->FaaId.'",').'
			'.(empty($this->FapId)?'NULL, ':'"'.$this->FapId.'",').'
			'.(empty($this->VddId)?'NULL, ':'"'.$this->VddId.'",').'
			
			NULL,
			
			NULL,
			NULL,
			
			NULL,
			NULL,
			
			'.($this->AmdCosto).', 
			0,
			'.($this->AmdCostoExtraTotal).', 
			'.($this->AmdCantidad).',
			'.($this->AmdCantidadReal).',
			
			'.($this->AmdValorTotal).',
			'.($this->AmdUtilidad).',
			'.($this->AmdPrecioVenta).',
			
			'.($this->AmdImporte).', 
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			
			"'.($this->AmdReingreso).'",
			"'.($this->AmdCompraOrigen).'",
			
			"'.($this->AlmId).'",
			"'.($this->AmdFecha).'",
			'.($this->AmdEstado).',
			"'.($this->AmdTiempoCreacion).'",
			"'.($this->AmdTiempoModificacion).'");';
		
			
			if(!$error){

				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
			}
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarTallerPedidoDetalle() {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			ProId = "'.($this->ProId).'",
			UmeId = "'.($this->UmeId).'",

			AlmId = "'.($this->AlmId).'",
			AmdFecha = "'.($this->AmdFecha).'",

			AmdCosto = '.($this->AmdCosto).',
			AmdCostoExtraTotal = '.($this->AmdCostoExtraTotal).',
			AmdCantidad = '.($this->AmdCantidad).',
			AmdCantidadReal = '.($this->AmdCantidadReal).',
			
			AmdValorTotal = '.($this->AmdValorTotal).',
			AmdUtilidad = '.($this->AmdUtilidad).',
			AmdPrecioVenta = '.($this->AmdPrecioVenta).',	
			
			AmdImporte = '.($this->AmdImporte).',
			
			AmdReingreso = "'.($this->AmdReingreso).'",
			AmdCompraOrigen = "'.($this->AmdCompraOrigen).'",
			AmdEstado = '.($this->AmdEstado).',	
			AmdTiempoModificacion = "'.($this->AmdTiempoModificacion).'"
			
			WHERE AmdId = "'.($this->AmdId).'";';
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			//'.(empty($this->FapId)?'FapId = NULL, ':'FapId = "'.$this->FapId.'",').'
//			if(!empty($this->FichaAccionMantenimiento)){
//				
//				$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
//				$InsFichaAccionMantenimiento->FaaId = $this->FichaAccionMantenimiento->FaaId;
//				$InsFichaAccionMantenimiento->FaaVerificar2 = $this->FichaAccionMantenimiento->FaaVerificar2;
//				$InsFichaAccionMantenimiento->FaaAccion = $this->FichaAccionMantenimiento->FaaAccion;
//
//				$InsFichaAccionMantenimiento->MtdEditarFichaAccionMantenimientoAccion();
//				$InsFichaAccionMantenimiento->MtdEditarFichaAccionMantenimientoVerificar2();
//				
//			}
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
	
//	
	
	
}
?>