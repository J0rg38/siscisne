<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenMovimientoSalidaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenMovimientoSalidaDetalle {

    public $AmdId;
	public $AmoId;
	public $ProId;
	public $UmeId;
	
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
	public $UmeAbreviacion;
	
	public $FaaAccion;
	public $FaaNivel;
	public $FaaVerificar1;
	public $FaaVerificar2;

				
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarAlmacenMovimientoSalidaDetalleId() {
			
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
		
		
   public function MtdObtenerAlmacenMovimientoSalidaDetalle(){

		$sql = 'SELECT
			 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			amd.FaaId,
			amd.FapId,
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			
			faa.PmtId,
			
			faa.FaaAccion,
			faa.FaaNivel,
			faa.FaaVerificar1
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId
								LEFT JOIN tblpmtplanmantenimientotarea pmt
								ON faa.PmtId = pmt.PmtId

		WHERE amd.AmdId = "'.$this->AmdId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->AmdId = $fila['AmdId'];
			$this->AmoId = $fila['AmoId'];
			$this->UmeId = $fila['UmeId'];
			
			$this->FaaId = $fila['FaaId'];
			$this->FapId = $fila['FapId'];
			
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
			$this->UmeAbreviacion = (($fila['UmeAbreviacion']));
			
			$this->AmoFecha = (($fila['NAmoFecha']));
			
			$this->PmtId = (($fila['PmtId']));
			
			$this->FaaAccion = (($fila['FaaAccion']));
			$this->FaaNivel = (($fila['FaaNivel']));
			$this->FaaVerificar1 = (($fila['FaaVerificar1']));
					
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	

    public function MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL) {

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
		
		if(!empty($oAlmacenMovimientoSalida)){
			$amovimiento = ' AND amd.AmoId = "'.$oAlmacenMovimientoSalida.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		
		if(!empty($oAlmacenMovimientoSalidaEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oAlmacenMovimientoSalidaEstado.') ';
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
			
			amd.FaaId,
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,
			
			amd.AlmId,
			DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
			
			amd.AmdCompraOrigen,
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
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
			SELECT 

			CONCAT(fta.FtaNumero,"-",fac.FacId)
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdFactura,
			

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
			) AS AmdBoleta,
			
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
				LIMIT 1

			) AS BdeCantidad,
			
			
			(
			IFNULL(amd.AmdCantidad,0) - IFNULL(@FdeCantidad,0) - IFNULL(@BdeCantidad,0) 				
			) AS AmdCantidadPendienteFacturar,
			
			amd.AmdReingreso,
			
			amo.AmoTipo,
			amo.AmoSubTipo
			
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
									LEFT JOIN tblpmtplanmantenimientotarea pmt
									ON faa.PmtId = pmt.PmtId
			WHERE   amo.AmoTipo = 2 
		
			'.$amovimiento.$fecha.$estado.$producto.$filtrar.$amestado.$vmarca.$almacen.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoSalidaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoSalidaDetalle = new $InsAlmacenMovimientoSalidaDetalle();
                    $AlmacenMovimientoSalidaDetalle->AmdId = $fila['AmdId'];
                    $AlmacenMovimientoSalidaDetalle->AmoId = $fila['AmoId'];
					$AlmacenMovimientoSalidaDetalle->UmeId = $fila['UmeId'];
					
					$AlmacenMovimientoSalidaDetalle->FaaId = $fila['FaaId'];
					$AlmacenMovimientoSalidaDetalle->FapId = $fila['FapId'];
					
					$AlmacenMovimientoSalidaDetalle->AmdCosto = $fila['AmdCosto'];  
			        $AlmacenMovimientoSalidaDetalle->AmdCantidad = $fila['AmdCantidad'];  
					$AlmacenMovimientoSalidaDetalle->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$AlmacenMovimientoSalidaDetalle->AmdValorTotal = $fila['AmdValorTotal'];  
					$AlmacenMovimientoSalidaDetalle->AmdUtilidad = $fila['AmdUtilidad'];  					
					$AlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $fila['AmdPrecioVenta'];  					

					$AlmacenMovimientoSalidaDetalle->AmdImporte = $fila['AmdImporte'];
				
					$AlmacenMovimientoSalidaDetalle->AlmId = $fila['AlmId'];
					$AlmacenMovimientoSalidaDetalle->AmdFecha = $fila['NAmdFecha'];
					
					
					$AlmacenMovimientoSalidaDetalle->AmdCompraOrigen = $fila['AmdCompraOrigen'];
					$AlmacenMovimientoSalidaDetalle->AmdEstado = $fila['AmdEstado'];
					$AlmacenMovimientoSalidaDetalle->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$AlmacenMovimientoSalidaDetalle->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$AlmacenMovimientoSalidaDetalle->ProId = $fila['ProId'];
					$AlmacenMovimientoSalidaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$AlmacenMovimientoSalidaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $AlmacenMovimientoSalidaDetalle->ProNombre = (($fila['ProNombre']));
					$AlmacenMovimientoSalidaDetalle->RtiId = (($fila['RtiId']));
					$AlmacenMovimientoSalidaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$AlmacenMovimientoSalidaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					$AlmacenMovimientoSalidaDetalle->UmeNombre = (($fila['UmeNombre']));
					$AlmacenMovimientoSalidaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$AlmacenMovimientoSalidaDetalle->AmoFecha = (($fila['NAmoFecha']));
					
					$AlmacenMovimientoSalidaDetalle->PmtId = (($fila['PmtId']));
					
					$AlmacenMovimientoSalidaDetalle->FaaAccion = (($fila['FaaAccion']));
					$AlmacenMovimientoSalidaDetalle->FaaNivel = (($fila['FaaNivel']));
					$AlmacenMovimientoSalidaDetalle->FaaVerificar1 = (($fila['FaaVerificar1']));
					$AlmacenMovimientoSalidaDetalle->FaaVerificar2 = (($fila['FaaVerificar2']));
					
					$AlmacenMovimientoSalidaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$AlmacenMovimientoSalidaDetalle->CliNombre = (($fila['CliNombre']));
					$AlmacenMovimientoSalidaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$AlmacenMovimientoSalidaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$AlmacenMovimientoSalidaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$AlmacenMovimientoSalidaDetalle->TopNombre = (($fila['TopNombre']));
					
					$AlmacenMovimientoSalidaDetalle->FinId = (($fila['FinId']));
					
					$AlmacenMovimientoSalidaDetalle->MinNombre = (($fila['MinNombre']));
					
					$AlmacenMovimientoSalidaDetalle->AmdFactura = (($fila['AmdFactura']));
					$AlmacenMovimientoSalidaDetalle->AmdFacturaFechaEmision = (($fila['AmdFacturaFechaEmision']));
					
					$AlmacenMovimientoSalidaDetalle->AmdBoleta = (($fila['AmdBoleta']));
					$AlmacenMovimientoSalidaDetalle->AmdBoletaFechaEmision = (($fila['AmdBoletaFechaEmision']));
			
			
					$AlmacenMovimientoSalidaDetalle->VdiId = (($fila['VdiId']));
					
					
					$AlmacenMovimientoSalidaDetalle->FdeCantidad = (($fila['FdeCantidad']));
					$AlmacenMovimientoSalidaDetalle->BdeCantidad = (($fila['BdeCantidad']));
					$AlmacenMovimientoSalidaDetalle->AmdCantidadPendienteFacturar = (($fila['AmdCantidadPendienteFacturar']));
			
					$AlmacenMovimientoSalidaDetalle->AmdReingreso = (($fila['AmdReingreso']));
					
					$AlmacenMovimientoSalidaDetalle->AmoTipo = (($fila['AmoTipo']));
					$AlmacenMovimientoSalidaDetalle->AmoSubTipo = (($fila['AmoSubTipo']));
			
                    $AlmacenMovimientoSalidaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoSalidaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		




    public function MtdObtenerAlmacenMovimientoSalidaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {

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
		
		if(!empty($oAlmacenMovimientoSalida)){
			$amovimiento = ' AND amd.AmoId = "'.$oAlmacenMovimientoSalida.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}

		if(!empty($oAlmacenMovimientoSalidaEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oAlmacenMovimientoSalidaEstado.') ';
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
											ON fin.CliId = cli.CliId
								
								LEFT JOIN tbltoptipooperacion top
								ON amo.TopId = top.TopId
	
								LEFT JOIN tblfaafichaaccionmantenimiento faa
								ON amd.FaaId = faa.FaaId
									LEFT JOIN tblpmtplanmantenimientotarea pmt
									ON faa.PmtId = pmt.PmtId
			WHERE   amo.AmoTipo = 2 '.$ano.$mes.$amovimiento.$estado.$producto.$filtrar.$amestado.$vmarca.$ptipo.$orden.$paginacion;	
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
				
		
	//Accion eliminar	 
	
	public function MtdEliminarAlmacenMovimientoSalidaDetalle($oElementos) {

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
	public function MtdActualizarEstadoAlmacenMovimientoSalidaDetalle($oElementos,$oEstado) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$actualizar .= '  (AmdId = "'.($elemento).'")';	
					}else{
						$actualizar .= '  (AmdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 
				AmdEstado = '.$oEstado.'
				WHERE '.$actualizar;
							
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
	
	public function MtdRegistrarAlmacenMovimientoSalidaDetalle() {
	
			$this->MtdGenerarAlmacenMovimientoSalidaDetalleId();
			
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
			
			'.(empty($this->FaaId)?'NULL, ':'"'.$this->FaaId.'",').'
			'.(empty($this->FapId)?'NULL, ':'"'.$this->FapId.'",').'
			'.(empty($this->VddId)?'NULL, ':'"'.$this->VddId.'",').'
			
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
	
	public function MtdEditarAlmacenMovimientoSalidaDetalle() {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			ProId = "'.($this->ProId).'",
			UmeId = "'.trim($this->UmeId).'",
			AmdCosto = '.($this->AmdCosto).',
			AmdCostoExtraTotal = '.($this->AmdCostoExtraTotal).',
			AmdCantidad = '.($this->AmdCantidad).',
			AmdCantidadReal = '.($this->AmdCantidadReal).',
			
			AmdValorTotal = '.($this->AmdValorTotal).',
			AmdUtilidad = '.($this->AmdUtilidad).',
			AmdPrecioVenta = '.($this->AmdPrecioVenta).',	
			
			AlmId = "'.trim($this->AlmId).'",
			AmdFecha = "'.trim($this->AmdFecha).'",
			AmdEstado = '.($this->AmdEstado).',
			AmdImporte = '.($this->AmdImporte).'
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
	
	
	
		public function MtdEditarAlmacenMovimientoSalidaDetalleDato($oCampo,$oDato,$oAlmacenMovimientoSalidaDetalleId) {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE AmdId = "'.($oAlmacenMovimientoSalidaDetalleId).'";';
					
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
		
		
}
?>