<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaDirectaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVentaDirectaDetalle {

    public $VddId;
	public $VdiId;
	public $ProId;
	public $UmeId;
	public $CrdId;

    public $VddCantidad;	
	public $VddCosto;
	public $VddUtilidad;
	public $VddValorTotal;
	public $VddPrecioVenta;
	
	public $VddImporte;	
	
	public $VddCodigoExterno;
	
	public $VddCantidadPedir;
	public $VddCantidadPedirFecha;
	public $VddNota;
	
	public $VddEstado;	
	public $VddTiempoCreacion;
	public $VddTiempoModificacion;
    public $VddEliminado;

	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;
	public $RtiId;
	public $UmeIdOrigen;
	
	public $UmeNombre;
	
	public $VdiFecha;
	
	public $PcdId;

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

	private function MtdGenerarVentaDirectaDetalleId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VddId,5),unsigned)) AS "MAXIMO"
			FROM tblvddventadirectadetalle vdd';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VddId = "VDD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VddId = "VDD-".$fila['MAXIMO'];					
			}
				
		}


		public function MtdObtenerVentaDirectaDetalle(){

        $sql = 'SELECT
			vdd.VddId,			
			vdd.VdiId,
			vdd.ProId,
			vdd.UmeId,
			vdd.CrdId,

			vdd.VddCantidad,
			vdd.VddCosto,
			vdd.VddValorTotal,
			vdd.VddUtilidad,
			
			vdd.VddPrecioBruto,
			vdd.VddDescuento,
			vdd.VddPrecioVenta,

			vdd.VddImporte,
			vdd.VddCodigoExterno,
			
			vdd.VddCantidadPedir,
			DATE_FORMAT(vdd.VddCantidadPedirFecha, "%d/%m/%Y") AS "NVddCantidadPedirFecha",
			
			vdd.VddPorcentajeUtilidad,
			vdd.VddPorcentajeOtroCosto,
			vdd.VddPorcentajeManoObra,
			vdd.VddPorcentajePedido,
			
			vdd.VddPorcentajeAdicional,
			vdd.VddPorcentajeDescuento,
			vdd.VddAdicional,
			
			vdd.VddTipoPedido,
			vdd.VddNota,
			vdd.VddEstado,
			DATE_FORMAT(vdd.VddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoCreacion",
	        DATE_FORMAT(vdd.VddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",

			ein.VveId,

			(
				SELECT 
				pcd.PcdId 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdId,
			

			(
				SELECT 
				pcd.PcdBOEstado 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOEstado,
			
			(
				SELECT 
				DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y")
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOFecha,

			(
				SELECT 
				amd.AmdId 
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdId,



			@ProIdPedido:=(
				SELECT 
				amd.ProId
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
					
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProIdPedido,

			@ProCodigoOriginalPedido:=(
				SELECT 
				pro.ProCodigoOriginal
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProCodigoOriginalPedido,

			IF(IFNULL(@ProIdPedido,vdd.ProId)<>vdd.ProId,"Si","No") AS VddReemplazo,


			@AmdCantidad:=(

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidad,
			
			@AmdCantidadEntrada:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidadEntrada,
			
			
			@PcdCantidad:=(
			
				SELECT 
				SUM(pcd.PcdCantidad)
				FROM tblpcdpedidocompradetalle pcd
				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS PcdCantidad,


			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PcdCantidad,0) 				
			) AS VddCantidadPendiente,
		
			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS VddCantidadPendiente2,
			

			
			(SELECT 
			SUM(amd.AmdCantidad)
			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE amo.AmoTipo = 1
					AND amd.AmdEstado = 3
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)

				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadLlegada,
			
			
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					ple.PleEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegar,
			
		
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					pld.PldEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegarReal,
		
		
			(SELECT 
			DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
			FROM tblpldpedidocomprallegadadetalle pld
					
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				LIMIT 1					
			) AS VddFechaPorLlegar,
			
			
			(
				SELECT 
				(amd.AmdEstado)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId

					AND amo.AmoEstado = 3
					ORDER BY amd.AmdTiempoCreacion DESC
				LIMIT 1

			) AS AmdEstado,
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			
			cli.CliTelefono,
			cli.CliCelular,
			cli.CliEmail,
			cli.CliDepartamento,
			
			cli.TdoId,
			tdo.TdoNombre,
			
			mon.MonNombre,
			mon.MonSimbolo,
			
			vdi.VdiTipoCambio,
			vdi.VdiTotal,
			DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
			vdi.VdiOrdenCompraNumero,
			
			lti.LtiNombre,
			lti.LtiAbreviatura,
			
			vdi.VdiIncluyeImpuesto,
			vdi.VdiTipoPedido,
			
			pro.ProUbicacion

			FROM tblvddventadirectadetalle vdd
			
				LEFT JOIN tblproproducto pro
				ON vdd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON vdd.UmeId = ume.UmeId				
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId
								
								LEFT JOIN tblclicliente cli
								ON vdi.CliId = cli.CliId
								
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId
									
										LEFT JOIN tblmonmoneda mon
										ON vdi.MonId = mon.MonId
										
        WHERE vdd.VddId = "'.$this->VddId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			
			 $this->VddId = $fila['VddId'];
                    $this->VdiId = $fila['VdiId'];
					$this->UmeId = $fila['UmeId'];
					$this->CrdId = $fila['CrdId'];
					
			        $this->VddCantidad = $fila['VddCantidad'];  
					$this->VddCosto = $fila['VddCosto'];  					
					$this->VddValorTotal = $fila['VddValorTotal'];  
					$this->VddUtilidad = $fila['VddUtilidad'];  					
					
					$this->VddPrecioBruto = $fila['VddPrecioBruto'];  	
					$this->VddDescuento = $fila['VddDescuento'];  	
					$this->VddPrecioVenta = $fila['VddPrecioVenta'];  	
				
					$this->VddImporte = $fila['VddImporte'];
					$this->VddCodigoExterno = $fila['VddCodigoExterno'];

					$this->VddCantidadPedir = $fila['VddCantidadPedir'];  
					$this->VddCantidadPedirFecha = $fila['NVddCantidadPedirFecha'];  
					
					$this->VddPorcentajeUtilidad = $fila['VddPorcentajeUtilidad'];  
					$this->VddPorcentajeOtroCosto = $fila['VddPorcentajeOtroCosto'];  
					$this->VddPorcentajeManoObra = $fila['VddPorcentajeManoObra'];  
					$this->VddPorcentajePedido = $fila['VddPorcentajePedido'];  
					$this->VddPorcentajeAdicional = $fila['VddPorcentajeAdicional'];  
					$this->VddPorcentajeDescuento = $fila['VddPorcentajeDescuento'];  
					$this->VddAdicional = $fila['VddAdicional'];  


					$this->VddTipoPedido = $fila['VddTipoPedido'];  
					$this->VddNota = $fila['VddNota'];  
					$this->VddEstado = $fila['VddEstado'];  
					$this->VddTiempoCreacion = $fila['NVddTiempoCreacion'];  
					$this->VddTiempoModificacion = $fila['NVddTiempoModificacion']; 					
					$this->ProId = $fila['ProId'];
					$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $this->ProNombre = (($fila['ProNombre']));
					$this->RtiId = (($fila['RtiId']));
					$this->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$this->UmeNombre = (($fila['UmeNombre']));
					
					$this->VdiFecha = (($fila['NVdiFecha']));
					
					$this->VveId = (($fila['VveId']));
					
					$this->PcdId = (($fila['PcdId']));
					
					$this->PcdBOEstado = (($fila['PcdBOEstado']));
					$this->PcdBOFecha = (($fila['PcdBOFecha']));

					$this->PcdCantidad = (($fila['PcdCantidad']));
					
					$this->ProIdPedido = (($fila['ProIdPedido']));
					$this->ProCodigoOriginalPedido = (($fila['ProCodigoOriginalPedido']));
					$this->VddReemplazo = (($fila['VddReemplazo']));
					//deb($VentaDirectaDetalle->VddReemplazo);

			
					$this->AmdId = (($fila['AmdId']));
					$this->AmdCantidad = (($fila['AmdCantidad']));
					$this->AmdCantidadEntrada = (($fila['AmdCantidadEntrada']));
					
					
					$this->VddCantidadPendiente = (($fila['VddCantidadPendiente']));
					$this->VddCantidadPendiente2 = (($fila['VddCantidadPendiente2']));
					//$VentaDirectaDetalle->VddCantidadConcretar = (($fila['VddCantidadConcretar']));
					$this->AmdEstado = (($fila['AmdEstado']));
					
					$this->VddCantidadLlegada = (($fila['VddCantidadLlegada']));
					$this->VddCantidadPorLlegar = (($fila['VddCantidadPorLlegar']));
					$this->VddCantidadPorLlegarReal = (($fila['VddCantidadPorLlegarReal']));

					$this->VddFechaPorLlegar = (($fila['VddFechaPorLlegar']));
					$this->AmdEstado = (($fila['AmdEstado']));

					$this->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$this->CliNombre = (($fila['CliNombre']));
					$this->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$this->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$this->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$this->CliTelefono = (($fila['CliTelefono']));
					$this->CliCelular = (($fila['CliCelular']));
					$this->CliEmail = (($fila['CliEmail']));
					$this->CliDepartamento = (($fila['CliDepartamento']));
					
					
					
					$this->TdoId = (($fila['TdoId']));
					$this->TdoNombre = (($fila['TdoNombre']));
					
					$this->MonNombre = (($fila['MonNombre']));
					$this->MonSimbolo = (($fila['MonSimbolo']));
					
					$this->VdiTipoCambio = (($fila['VdiTipoCambio']));
					$this->VdiTotal = (($fila['VdiTotal']));
					
					$this->VdiOrdenCompraFecha = (($fila['NVdiOrdenCompraFecha']));
					$this->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
						
					$this->LtiNombre = (($fila['LtiNombre']));
					$this->LtiAbreviatura = (($fila['LtiAbreviatura']));
					
					$this->VdiIncluyeImpuesto = (($fila['VdiIncluyeImpuesto']));
$this->VdiTipoPedido = (($fila['VdiTipoPedido']));

					$this->ProUbicacion = (($fila['ProUbicacion']));
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oConDespacho=NULL,$oConPendiente=false,$oPersonal=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$ventadirecta = '';
		$estado = '';
		$producto = '';
		$fechainicio = '';
		$fechafin = '';
		$moneda = '';
		$cliente = '';
		$conordencomprareferencia = '';
		$condespacho = '';
		$conpendiente = '';
		$personal = '';

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
		
		if(!empty($oVentaDirecta)){
			$amovimiento = ' AND vdd.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vdd.VddEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (vdd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
		
		
		switch($oConDespacho){
			
			case 1:
				$cdespacho = ' AND EXISTS (
				
				SELECT 
				(pld.PldId)
				FROM tblpldpedidocomprallegadadetalle pld
						
						LEFT JOIN tblplepedidocomprallegada ple
						ON pld.PleId = ple.PleId
						
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
					
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
						
					WHERE 
						pco.PcoEstado = 3
					AND pcd.VddId = vdd.VddId
					LIMIT 1	
				
				) ';
			break;
			
			case 2:
				$cdespacho = ' AND NOT EXISTS (
						
						SELECT 
				(pld.PldId)
				FROM tblpldpedidocomprallegadadetalle pld
						
						LEFT JOIN tblplepedidocomprallegada ple
						ON pld.PleId = ple.PleId
						
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
					
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
						
					WHERE 
						pco.PcoEstado = 3
					AND pcd.VddId = vdd.VddId
					LIMIT 1	
					
				) ';
			break;
			
			default:
			
			break;
		}
		
		
		if(($oConPendiente)){
			
			$cpendiente = ' AND 
			
			IFNULL((

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			),0) < vdd.VddCantidad 
			
			';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vdi.PerId = "'.$oPersonal.'"';
		}
	
			
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdd.VddId,			
			vdd.VdiId,
			vdd.ProId,
			vdd.UmeId,
			vdd.CrdId,

			vdd.VddCantidad,
			vdd.VddCosto,
			vdd.VddValorTotal,
			vdd.VddUtilidad,
			
			vdd.VddPrecioBruto,
			vdd.VddDescuento,
			vdd.VddPrecioVenta,

			vdd.VddImporte,
			vdd.VddCodigoExterno,
			
			vdd.VddCantidadPedir,
			DATE_FORMAT(vdd.VddCantidadPedirFecha, "%d/%m/%Y") AS "NVddCantidadPedirFecha",
			
			vdd.VddPorcentajeUtilidad,
			vdd.VddPorcentajeOtroCosto,
			vdd.VddPorcentajeManoObra,
			vdd.VddPorcentajePedido,
			
			vdd.VddPorcentajeAdicional,
			vdd.VddPorcentajeDescuento,
			
			(vdd.VddPrecioBruto*vdd.VddCantidad) AS VddImporteBruto,
			(vdd.VddDescuento/vdd.VddCantidad) AS VddDescuentoUnitario,
			
			vdd.VddAdicional,
			
			vdd.VddTipoPedido,
			vdd.VddNota,
			vdd.VddEstado,
			DATE_FORMAT(vdd.VddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoCreacion",
	        DATE_FORMAT(vdd.VddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",

			ein.VveId,

			(
				SELECT 
				pcd.PcdId 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdId,
			

			(
				SELECT 
				pcd.PcdBOEstado 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOEstado,
			
			(
				SELECT 
				DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y")
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOFecha,

			(
				SELECT 
				amd.AmdId 
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdId,



			@ProIdPedido:=(
				SELECT 
				amd.ProId
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
					
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProIdPedido,

			@ProCodigoOriginalPedido:=(
				SELECT 
				pro.ProCodigoOriginal
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProCodigoOriginalPedido,

			IF(IFNULL(@ProIdPedido,vdd.ProId)<>vdd.ProId,"Si","No") AS VddReemplazo,


			@AmdCantidad:=(

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidad,
			
			@AmdCantidadEntrada:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidadEntrada,
			
			
			@PcdCantidad:=(
			
				SELECT 
				SUM(pcd.PcdCantidad)
				FROM tblpcdpedidocompradetalle pcd
				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS PcdCantidad,


			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PcdCantidad,0) 				
			) AS VddCantidadPendiente,
		
			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS VddCantidadPendiente2,
			

			
			(SELECT 
			SUM(amd.AmdCantidad)
			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE amo.AmoTipo = 1
					AND amd.AmdEstado = 3
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)

				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadLlegada,
			
			
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					ple.PleEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegar,
			
		
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					pld.PldEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegarReal,
		
		
			(SELECT 
			DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
			FROM tblpldpedidocomprallegadadetalle pld
					
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				LIMIT 1					
			) AS VddFechaPorLlegar,
			
			
			(
				SELECT 
				(amd.AmdEstado)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId

					AND amo.AmoEstado = 3
					ORDER BY amd.AmdTiempoCreacion DESC
				LIMIT 1

			) AS AmdEstado,
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			
			cli.CliTelefono,
			cli.CliCelular,
			cli.CliEmail,
			cli.CliDepartamento,
			
			cli.TdoId,
			tdo.TdoNombre,
			
			mon.MonNombre,
			mon.MonSimbolo,
			
			vdi.VdiTipoCambio,
			vdi.VdiTotal,
			DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
			vdi.VdiOrdenCompraNumero,
			
			lti.LtiNombre,
			lti.LtiAbreviatura,
			
			vdi.VdiIncluyeImpuesto,
			vdi.VdiTipoPedido,
			
			pro.ProUbicacion

			FROM tblvddventadirectadetalle vdd
				LEFT JOIN tblproproducto pro
				ON vdd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON vdd.UmeId = ume.UmeId				
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId
								
								LEFT JOIN tblclicliente cli
								ON vdi.CliId = cli.CliId
								
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId
									
										LEFT JOIN tblmonmoneda mon
										ON vdi.MonId = mon.MonId
								
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$fecha.$cpendiente.$moneda.$cliente.$coreferencia.$cdespacho.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirectaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirectaDetalle = new $InsVentaDirectaDetalle();
                    $VentaDirectaDetalle->VddId = $fila['VddId'];
                    $VentaDirectaDetalle->VdiId = $fila['VdiId'];
					$VentaDirectaDetalle->UmeId = $fila['UmeId'];
					$VentaDirectaDetalle->CrdId = $fila['CrdId'];
					
			        $VentaDirectaDetalle->VddCantidad = $fila['VddCantidad'];  
					$VentaDirectaDetalle->VddCosto = $fila['VddCosto'];  					
					$VentaDirectaDetalle->VddValorTotal = $fila['VddValorTotal'];  
					$VentaDirectaDetalle->VddUtilidad = $fila['VddUtilidad'];  					
					
					$VentaDirectaDetalle->VddPrecioBruto = $fila['VddPrecioBruto'];  	
					$VentaDirectaDetalle->VddDescuento = $fila['VddDescuento'];  	
					$VentaDirectaDetalle->VddPrecioVenta = $fila['VddPrecioVenta'];  	
				
					$VentaDirectaDetalle->VddImporte = $fila['VddImporte'];
					$VentaDirectaDetalle->VddCodigoExterno = $fila['VddCodigoExterno'];

					$VentaDirectaDetalle->VddCantidadPedir = $fila['VddCantidadPedir'];  
					$VentaDirectaDetalle->VddCantidadPedirFecha = $fila['NVddCantidadPedirFecha'];  


					$VentaDirectaDetalle->VddEstado = $fila['VddEstado'];  
					$VentaDirectaDetalle->VddTiempoCreacion = $fila['NVddTiempoCreacion'];  
					$VentaDirectaDetalle->VddTiempoModificacion = $fila['NVddTiempoModificacion']; 					
					$VentaDirectaDetalle->ProId = $fila['ProId'];
					$VentaDirectaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$VentaDirectaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $VentaDirectaDetalle->ProNombre = (($fila['ProNombre']));
					$VentaDirectaDetalle->RtiId = (($fila['RtiId']));
					$VentaDirectaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$VentaDirectaDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$VentaDirectaDetalle->VdiFecha = (($fila['NVdiFecha']));
					
					$VentaDirectaDetalle->VveId = (($fila['VveId']));
					
					
					
					
					$VentaDirectaDetalle->PcdId = (($fila['PcdId']));
					
					$VentaDirectaDetalle->PcdBOEstado = (($fila['PcdBOEstado']));
					$VentaDirectaDetalle->PcdBOFecha = (($fila['PcdBOFecha']));

			
			
					$VentaDirectaDetalle->PcdCantidad = (($fila['PcdCantidad']));
					
					$VentaDirectaDetalle->ProIdPedido = (($fila['ProIdPedido']));
					$VentaDirectaDetalle->ProCodigoOriginalPedido = (($fila['ProCodigoOriginalPedido']));
					$VentaDirectaDetalle->VddReemplazo = (($fila['VddReemplazo']));
					//deb($VentaDirectaDetalle->VddReemplazo);

					$VentaDirectaDetalle->AmdId = (($fila['AmdId']));
					$VentaDirectaDetalle->AmdCantidad = (($fila['AmdCantidad']));
					$VentaDirectaDetalle->AmdCantidadEntrada = (($fila['AmdCantidadEntrada']));
					
					
					$VentaDirectaDetalle->VddCantidadPendiente = (($fila['VddCantidadPendiente']));
					$VentaDirectaDetalle->VddCantidadPendiente2 = (($fila['VddCantidadPendiente2']));
					//$VentaDirectaDetalle->VddCantidadConcretar = (($fila['VddCantidadConcretar']));
					$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));
					
					$VentaDirectaDetalle->VddCantidadLlegada = (($fila['VddCantidadLlegada']));
					$VentaDirectaDetalle->VddCantidadPorLlegar = (($fila['VddCantidadPorLlegar']));
					$VentaDirectaDetalle->VddCantidadPorLlegarReal = (($fila['VddCantidadPorLlegarReal']));

					$VentaDirectaDetalle->VddFechaPorLlegar = (($fila['VddFechaPorLlegar']));
					$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));

					$VentaDirectaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VentaDirectaDetalle->CliNombre = (($fila['CliNombre']));
					$VentaDirectaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VentaDirectaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$VentaDirectaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$VentaDirectaDetalle->CliTelefono = (($fila['CliTelefono']));
					$VentaDirectaDetalle->CliCelular = (($fila['CliCelular']));
					$VentaDirectaDetalle->CliEmail = (($fila['CliEmail']));
					$VentaDirectaDetalle->CliDepartamento = (($fila['CliDepartamento']));
					
					
					
					$VentaDirectaDetalle->TdoId = (($fila['TdoId']));
					$VentaDirectaDetalle->TdoNombre = (($fila['TdoNombre']));
					
					$VentaDirectaDetalle->MonNombre = (($fila['MonNombre']));
					$VentaDirectaDetalle->MonSimbolo = (($fila['MonSimbolo']));
					
					$VentaDirectaDetalle->VdiTipoCambio = (($fila['VdiTipoCambio']));
					$VentaDirectaDetalle->VdiTotal = (($fila['VdiTotal']));
					
					$VentaDirectaDetalle->VdiOrdenCompraFecha = (($fila['NVdiOrdenCompraFecha']));
					$VentaDirectaDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
						
					$VentaDirectaDetalle->LtiNombre = (($fila['LtiNombre']));
					$VentaDirectaDetalle->LtiAbreviatura = (($fila['LtiAbreviatura']));
					
					$VentaDirectaDetalle->VdiIncluyeImpuesto = (($fila['VdiIncluyeImpuesto']));
$VentaDirectaDetalle->VdiTipoPedido = (($fila['VdiTipoPedido']));

					$VentaDirectaDetalle->ProUbicacion = (($fila['ProUbicacion']));

                    $VentaDirectaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirectaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVentaDirectaDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (VddId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VddId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblvddventadirectadetalle 
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
	
	
	public function MtdRegistrarVentaDirectaDetalle() {
	
			$this->MtdGenerarVentaDirectaDetalleId();
			
			$sql = 'INSERT INTO tblvddventadirectadetalle (
			VddId,
			VdiId,	
			ProId,
			UmeId,
			CrdId,

			VddCantidad,			
			
			VddCosto,		
			VddValorTotal,
			VddUtilidad,
			
			VddPrecioBruto,
			VddDescuento,
			VddPrecioVenta,
			
			VddImporte,
			VddCodigoExterno,
			
			VddCantidadPedir,
			VddCantidadPedirFecha,
			
			VddPorcentajeUtilidad,
			VddPorcentajeOtroCosto,
			VddPorcentajeManoObra,
			VddPorcentajePedido,
			
			VddPorcentajeAdicional,
			VddPorcentajeDescuento,
			
			VddAdicional,
			
			VddEntregado,
			VddTipoPedido,
			VddEstado,
			VddTiempoCreacion,
			VddTiempoModificacion
			) 
			VALUES (
			"'.($this->VddId).'", 
			"'.($this->VdiId).'", 
			"'.($this->ProId).'", 
			"'.($this->UmeId).'", 
			'.(empty($this->CrdId)?'NULL, ':'"'.$this->CrdId.'",').'
			
			'.($this->VddCantidad).',
			
			'.($this->VddCosto).', 
			'.($this->VddValorTotal).',
			'.($this->VddUtilidad).',
			
			'.($this->VddPrecioBruto).',
			'.($this->VddDescuento).',
			'.($this->VddPrecioVenta).',			
			'.($this->VddImporte).', 
			
			"'.($this->VddCodigoExterno).'", 
			
			'.($this->VddCantidadPedir).', 
			'.(empty($this->VddCantidadPedirFecha)?'NULL, ':'"'.$this->VddCantidadPedirFecha.'",').'
			
		'.($this->VddPorcentajeUtilidad).',
			'.($this->VddPorcentajeOtroCosto).',
			'.($this->VddPorcentajeManoObra).',			
			'.($this->VddPorcentajePedido).', 
			
			'.($this->VddPorcentajeAdicional).',			
			'.($this->VddPorcentajeDescuento).',
			
			'.($this->VddAdicional).', 
		
			
			
			
			2,
			"'.($this->VddTipoPedido).'", 
			'.($this->VddEstado).',
			"'.($this->VddTiempoCreacion).'",
			"'.($this->VddTiempoModificacion).'");';
		
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
	
	public function MtdEditarVentaDirectaDetalle() {

		$sql = 'UPDATE tblvddventadirectadetalle SET 	
		UmeId = "'.($this->UmeId).'",
		VddCantidad = '.($this->VddCantidad).',
		
		VddCosto = '.($this->VddCosto).',		
		VddValorTotal = '.($this->VddValorTotal).',
		VddUtilidad = '.($this->VddUtilidad).',
		
		VddPrecioBruto = '.($this->VddPrecioBruto).',		
		VddDescuento = '.($this->VddDescuento).',		
		VddPrecioVenta = '.($this->VddPrecioVenta).',			
		VddImporte = '.($this->VddImporte).',
		
		VddCantidadPedir = '.($this->VddCantidadPedir).',
		'.(empty($this->VddCantidadPedirFecha)?'VddCantidadPedirFecha = NULL, ':'VddCantidadPedirFecha = "'.$this->VddCantidadPedirFecha.'",').'

		VddPorcentajeUtilidad = '.($this->VddPorcentajeUtilidad).',		
		VddPorcentajeOtroCosto = '.($this->VddPorcentajeOtroCosto).',		
		VddPorcentajeManoObra = '.($this->VddPorcentajeManoObra).',			
		VddPorcentajePedido = '.($this->VddPorcentajePedido).',
		
		VddPorcentajeAdicional = '.($this->VddPorcentajeAdicional).',			
		VddPorcentajeDescuento = '.($this->VddPorcentajeDescuento).',
		VddAdicional = '.($this->VddAdicional).',
	
			
		VddTipoPedido = "'.($this->VddTipoPedido).'",
		VddEstado = '.($this->VddEstado).',
		VddTiempoModificacion = "'.($this->VddTiempoModificacion).'"			
		WHERE VddId = "'.($this->VddId).'";';
				
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
	
	
	public function MtdConfirmarVentaDirectaDetalle() {

		$sql = 'UPDATE tblvddventadirectadetalle SET 	
		VddEntregado = '.($this->VddEntregado).',
		VddTiempoModificacion = "'.($this->VddTiempoModificacion).'"			
		WHERE VddId = "'.($this->VddId).'";';
				
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
	
	public function MtdSeguimientoVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL) {

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
		
		if(!empty($oVentaDirecta)){
			$amovimiento = ' AND vdd.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vdd.VddEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (vdd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
		
			
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdd.VddId,			
			vdd.VdiId,
			vdd.ProId,
			vdd.UmeId,
			vdd.CrdId,

			vdd.VddCantidad,
			vdd.VddCosto,
			vdd.VddValorTotal,
			vdd.VddUtilidad,
			vdd.VddPrecioVenta,
			vdd.VddImporte,
			vdd.VddCodigoExterno,
			
			vdd.VddCantidadPedir,
			DATE_FORMAT(vdd.VddCantidadPedirFecha, "%d/%m/%Y") AS "NVddCantidadPedirFecha",
			
			vdd.VddEstado,
			DATE_FORMAT(vdd.VddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoCreacion",
	        DATE_FORMAT(vdd.VddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",

			ein.VveId,

			(
				SELECT 
				pcd.PcdId 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdId,
			

			(
				SELECT 
				pcd.PcdBOEstado 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOEstado,
			
			(
				SELECT 
				DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y")
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOFecha,

			(
				SELECT 
				amd.AmdId 
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdId,



			@ProIdPedido:=(
				SELECT 
				amd.ProId
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
					
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProIdPedido,

			@ProCodigoOriginalPedido:=(
				SELECT 
				pro.ProCodigoOriginal
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProCodigoOriginalPedido,
			
			
			IF(IFNULL(@ProIdPedido,vdd.ProId)<>vdd.ProId,"Si","No") AS VddReemplazo,

			@AmdCantidad:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
					
				LIMIT 1

			) AS AmdCantidad,
			
			

			@AmdCantidadEntrada:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
					
				LIMIT 1

			) AS AmdCantidadEntrada,
			
			

			
			
			
			@PcdCantidad:=(
			
				SELECT 
				SUM(pcd.PcdCantidad)
				FROM tblpcdpedidocompradetalle pcd
				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
				LIMIT 1

			) AS PcdCantidad,

			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PcdCantidad,0) 				
			) AS VddCantidadPendiente,
		
			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS VddCantidadPendiente2,
			
			(SELECT 
			SUM(amd.AmdCantidad)
			FROM tblamdalmacenmovimientodetalle amd
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
						
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
					
				WHERE amo.AmoTipo = 1
					AND amd.AmdEstado = 3
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)

				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadLlegada,
			
			@VddCantidadPorLlegar:=(SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegar,
			
			
			(SELECT 
			DATE_FORMAT(ple.PleFecha, "%d/%m/%Y") 
			FROM tblpldpedidocomprallegadadetalle pld
					
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				LIMIT 1					
			) AS VddFechaPorLlegar,
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			cli.TdoId,
			tdo.TdoNombre,
			
			mon.MonNombre,
			mon.MonSimbolo,
			
			vdi.VdiTipoCambio,
			vdi.VdiTotal,
			DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
			vdi.VdiOrdenCompraNumero,
			
			lti.LtiNombre,
			lti.LtiAbreviatura,
			
			vdi.VdiIncluyeImpuesto

			FROM tblvddventadirectadetalle vdd
				LEFT JOIN tblproproducto pro
				ON vdd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON vdd.UmeId = ume.UmeId				
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId
								
								LEFT JOIN tblclicliente cli
								ON vdi.CliId = cli.CliId
								
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId
									
										LEFT JOIN tblmonmoneda mon
										ON vdi.MonId = mon.MonId
								
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$fecha.$moneda.$cliente.$coreferencia.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirectaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirectaDetalle = new $InsVentaDirectaDetalle();
                    $VentaDirectaDetalle->VddId = $fila['VddId'];
                    $VentaDirectaDetalle->VdiId = $fila['VdiId'];
					$VentaDirectaDetalle->UmeId = $fila['UmeId'];
					$VentaDirectaDetalle->CrdId = $fila['CrdId'];
					
			        $VentaDirectaDetalle->VddCantidad = $fila['VddCantidad'];  
					$VentaDirectaDetalle->VddCosto = $fila['VddCosto'];  					
					$VentaDirectaDetalle->VddValorTotal = $fila['VddValorTotal'];  
					$VentaDirectaDetalle->VddUtilidad = $fila['VddUtilidad'];  					
					$VentaDirectaDetalle->VddPrecioVenta = $fila['VddPrecioVenta'];  					
					$VentaDirectaDetalle->VddImporte = $fila['VddImporte'];
					$VentaDirectaDetalle->VddCodigoExterno = $fila['VddCodigoExterno'];

					$VentaDirectaDetalle->VddCantidadPedir = $fila['VddCantidadPedir'];  
					$VentaDirectaDetalle->VddCantidadPedirFecha = $fila['NVddCantidadPedirFecha'];  


					$VentaDirectaDetalle->VddEstado = $fila['VddEstado'];  
					$VentaDirectaDetalle->VddTiempoCreacion = $fila['NVddTiempoCreacion'];  
					$VentaDirectaDetalle->VddTiempoModificacion = $fila['NVddTiempoModificacion']; 					
					$VentaDirectaDetalle->ProId = $fila['ProId'];
					$VentaDirectaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$VentaDirectaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $VentaDirectaDetalle->ProNombre = (($fila['ProNombre']));
					$VentaDirectaDetalle->RtiId = (($fila['RtiId']));
					$VentaDirectaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$VentaDirectaDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$VentaDirectaDetalle->VdiFecha = (($fila['NVdiFecha']));
					
					$VentaDirectaDetalle->VveId = (($fila['VveId']));
					
					
					
					
					$VentaDirectaDetalle->PcdId = (($fila['PcdId']));
					
					$VentaDirectaDetalle->PcdBOEstado = (($fila['PcdBOEstado']));
					$VentaDirectaDetalle->PcdBOFecha = (($fila['PcdBOFecha']));

			
			
					$VentaDirectaDetalle->PcdCantidad = (($fila['PcdCantidad']));
					
					$VentaDirectaDetalle->ProIdPedido = (($fila['ProIdPedido']));
					$VentaDirectaDetalle->ProCodigoOriginalPedido = (($fila['ProCodigoOriginalPedido']));
					$VentaDirectaDetalle->VddReemplazo = (($fila['VddReemplazo']));
					//deb($VentaDirectaDetalle->VddReemplazo);

					$VentaDirectaDetalle->AmdId = (($fila['AmdId']));
					$VentaDirectaDetalle->AmdCantidad = (($fila['AmdCantidad']));
					$VentaDirectaDetalle->AmdCantidadEntrada = (($fila['AmdCantidadEntrada']));
					
					
					$VentaDirectaDetalle->VddCantidadPendiente = (($fila['VddCantidadPendiente']));
					$VentaDirectaDetalle->VddCantidadPendiente2 = (($fila['VddCantidadPendiente2']));
					//$VentaDirectaDetalle->VddCantidadConcretar = (($fila['VddCantidadConcretar']));
					$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));
					
					$VentaDirectaDetalle->VddCantidadLlegada = (($fila['VddCantidadLlegada']));
					$VentaDirectaDetalle->VddCantidadPorLlegar = (($fila['VddCantidadPorLlegar']));
					$VentaDirectaDetalle->VddCantidadPorLlegarReal = (($fila['VddCantidadPorLlegarReal']));

					$VentaDirectaDetalle->VddFechaPorLlegar = (($fila['VddFechaPorLlegar']));
					$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));

					$VentaDirectaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VentaDirectaDetalle->CliNombre = (($fila['CliNombre']));
					$VentaDirectaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VentaDirectaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$VentaDirectaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					$VentaDirectaDetalle->TdoId = (($fila['TdoId']));
					$VentaDirectaDetalle->TdoNombre = (($fila['TdoNombre']));
					
					$VentaDirectaDetalle->MonNombre = (($fila['MonNombre']));
					$VentaDirectaDetalle->MonSimbolo = (($fila['MonSimbolo']));
					
					$VentaDirectaDetalle->VdiTipoCambio = (($fila['VdiTipoCambio']));
					$VentaDirectaDetalle->VdiTotal = (($fila['VdiTotal']));
					
					$VentaDirectaDetalle->VdiOrdenCompraFecha = (($fila['NVdiOrdenCompraFecha']));
					$VentaDirectaDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
						
					$VentaDirectaDetalle->LtiNombre = (($fila['LtiNombre']));
					$VentaDirectaDetalle->LtiAbreviatura = (($fila['LtiAbreviatura']));
	

                    $VentaDirectaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirectaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		
		
		
		public function MtdSeguimientoVentaDirectaDetallesaa($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL) {

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
		
		if(!empty($oVentaDirecta)){
			$amovimiento = ' AND vdd.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vdd.VddEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (vdd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
		
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdd.VddId,			
			vdd.VdiId,
			vdd.ProId,
			vdd.UmeId,
			vdd.CrdId,

			vdd.VddCantidad,
			vdd.VddCosto,
			vdd.VddValorTotal,
			vdd.VddUtilidad,
			vdd.VddPrecioVenta,
			vdd.VddImporte,
			vdd.VddCodigoExterno,
			
			vdd.VddCantidadPedir,
			DATE_FORMAT(vdd.VddCantidadPedirFecha, "%d/%m/%Y") AS "NVddCantidadPedirFecha",
			
			vdd.VddEstado,
			DATE_FORMAT(vdd.VddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoCreacion",
	        DATE_FORMAT(vdd.VddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",

			ein.VveId,

			(
				SELECT 
				pcd.PcdId 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdId,
			

			(
				SELECT 
				pcd.PcdBOEstado 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOEstado,
			
			(
				SELECT 
				DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y")
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOFecha,

			(
				SELECT 
				amd.AmdId 
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdId,



			@ProIdPedido:=(
				SELECT 
				amd.ProId
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
					
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProIdPedido,

			@ProCodigoOriginalPedido:=(
				SELECT 
				pro.ProCodigoOriginal
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProCodigoOriginalPedido,
			
			
			IF(IFNULL(@ProIdPedido,vdd.ProId)<>vdd.ProId,"Si","No") AS VddReemplazo,

			@AmdCantidad:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidad,
			
			

			@AmdCantidadEntrada:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidadEntrada,
			
			
			@PcdCantidad:=(
			
				SELECT 
				SUM(pcd.PcdCantidad)
				FROM tblpcdpedidocompradetalle pcd
				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
				LIMIT 1

			) AS PcdCantidad,

			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PcdCantidad,0) 				
			) AS VddCantidadPendiente,
		
			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS VddCantidadPendiente2,
			
			
			(SELECT 
			SUM(amd.AmdCantidad)
			FROM tblamdalmacenmovimientodetalle amd
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
						
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
					
				WHERE amo.AmoTipo = 1
					AND amo.AmoEstado = 3
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)

				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadLlegada,
			

			(SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegar,
			
			
			(SELECT 
			(ple.PleFecha)
			FROM tblpldpedidocomprallegadadetalle pld
					
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				LIMIT 1					
			) AS VddFechaPorLlegar,
			
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			cli.TdoId,
			tdo.TdoNombre,
			
			mon.MonNombre,
			mon.MonSimbolo,
			
			vdi.VdiTipoCambio,
			vdi.VdiTotal,
			DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
			vdi.VdiOrdenCompraNumero,
			
			lti.LtiNombre,
			lti.LtiAbreviatura

			FROM tblvddventadirectadetalle vdd
				LEFT JOIN tblproproducto pro
				ON vdd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON vdd.UmeId = ume.UmeId				
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId
								
								LEFT JOIN tblclicliente cli
								ON vdi.CliId = cli.CliId
								
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId
									
										LEFT JOIN tblmonmoneda mon
										ON vdi.MonId = mon.MonId
								
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$fecha.$moneda.$cliente.$coreferencia.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirectaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirectaDetalle = new $InsVentaDirectaDetalle();
                    $VentaDirectaDetalle->VddId = $fila['VddId'];
                    $VentaDirectaDetalle->VdiId = $fila['VdiId'];
					$VentaDirectaDetalle->UmeId = $fila['UmeId'];
					$VentaDirectaDetalle->CrdId = $fila['CrdId'];
					
			        $VentaDirectaDetalle->VddCantidad = $fila['VddCantidad'];  
					$VentaDirectaDetalle->VddCosto = $fila['VddCosto'];  					
					$VentaDirectaDetalle->VddValorTotal = $fila['VddValorTotal'];  
					$VentaDirectaDetalle->VddUtilidad = $fila['VddUtilidad'];  					
					$VentaDirectaDetalle->VddPrecioVenta = $fila['VddPrecioVenta'];  					
					$VentaDirectaDetalle->VddImporte = $fila['VddImporte'];
					$VentaDirectaDetalle->VddCodigoExterno = $fila['VddCodigoExterno'];

					$VentaDirectaDetalle->VddCantidadPedir = $fila['VddCantidadPedir'];  
					$VentaDirectaDetalle->VddCantidadPedirFecha = $fila['NVddCantidadPedirFecha'];  


					$VentaDirectaDetalle->VddEstado = $fila['VddEstado'];  
					$VentaDirectaDetalle->VddTiempoCreacion = $fila['NVddTiempoCreacion'];  
					$VentaDirectaDetalle->VddTiempoModificacion = $fila['NVddTiempoModificacion']; 					
					$VentaDirectaDetalle->ProId = $fila['ProId'];
					$VentaDirectaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$VentaDirectaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $VentaDirectaDetalle->ProNombre = (($fila['ProNombre']));
					$VentaDirectaDetalle->RtiId = (($fila['RtiId']));
					$VentaDirectaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$VentaDirectaDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$VentaDirectaDetalle->VdiFecha = (($fila['NVdiFecha']));
					
					$VentaDirectaDetalle->VveId = (($fila['VveId']));
					
					
					
					
					$VentaDirectaDetalle->PcdId = (($fila['PcdId']));
					
					$VentaDirectaDetalle->PcdBOEstado = (($fila['PcdBOEstado']));
					$VentaDirectaDetalle->PcdBOFecha = (($fila['PcdBOFecha']));

			
			
					$VentaDirectaDetalle->PcdCantidad = (($fila['PcdCantidad']));
					
					$VentaDirectaDetalle->ProIdPedido = (($fila['ProIdPedido']));
					$VentaDirectaDetalle->ProCodigoOriginalPedido = (($fila['ProCodigoOriginalPedido']));
					$VentaDirectaDetalle->VddReemplazo = (($fila['VddReemplazo']));
					//deb($VentaDirectaDetalle->VddReemplazo);

			
					$VentaDirectaDetalle->AmdId = (($fila['AmdId']));
					$VentaDirectaDetalle->AmdCantidad = (($fila['AmdCantidad']));
					
					$VentaDirectaDetalle->VddCantidadPendiente = (($fila['VddCantidadPendiente']));
					$VentaDirectaDetalle->VddCantidadPendiente2 = (($fila['VddCantidadPendiente2']));
					$VentaDirectaDetalle->VddCantidadConcretar = (($fila['VddCantidadConcretar']));
					
					$VentaDirectaDetalle->AmoEstado = (($fila['AmoEstado']));
					
					
					$VentaDirectaDetalle->VddCantidadLlegada = (($fila['VddCantidadLlegada']));
					$VentaDirectaDetalle->VddCantidadPorLlegar = (($fila['VddCantidadPorLlegar']));
					$VentaDirectaDetalle->VddFechaPorLlegar = (($fila['VddFechaPorLlegar']));
					
					
					$VentaDirectaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VentaDirectaDetalle->CliNombre = (($fila['CliNombre']));
					$VentaDirectaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VentaDirectaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$VentaDirectaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					$VentaDirectaDetalle->TdoId = (($fila['TdoId']));
					$VentaDirectaDetalle->TdoNombre = (($fila['TdoNombre']));
					
					$VentaDirectaDetalle->MonNombre = (($fila['MonNombre']));
					$VentaDirectaDetalle->MonSimbolo = (($fila['MonSimbolo']));
					
					$VentaDirectaDetalle->VdiTipoCambio = (($fila['VdiTipoCambio']));
					$VentaDirectaDetalle->VdiTotal = (($fila['VdiTotal']));
					
					$VentaDirectaDetalle->VdiOrdenCompraFecha = (($fila['NVdiOrdenCompraFecha']));
					$VentaDirectaDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
						
					$VentaDirectaDetalle->LtiNombre = (($fila['LtiNombre']));
					$VentaDirectaDetalle->LtiAbreviatura = (($fila['LtiAbreviatura']));
	

                    $VentaDirectaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirectaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		*/
		
		
		
		public function MtdEditarVentaDirectaDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblvddventadirectadetalle SET 
			'.$oCampo.' = "'.($oDato).'"
			
			WHERE VddId = "'.($oId).'";';

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