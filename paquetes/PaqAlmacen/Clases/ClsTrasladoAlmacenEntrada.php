<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoAlmacenEntrada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoAlmacenEntrada {

    public $TaeId;
	public $TaeTipo;
	public $TaeSubTipo;
	public $PrvId;
	public $CtiId;
	public $TopId;
	
	public $OcoId;
	
	public $NpaId;
	public $TaeCantidadDia;
	
	public $AlmId;
	public $TaeFecha;
	public $TaeDocumentoOrigen;
	
	public $TaeGuiaRemisionNumero;
	public $TaeGuiaRemisionNumeroSerie;
	public $TaeGuiaRemisionNumeroNumero;
	public $TaeGuiaRemisionFecha;
	public $TaeGuiaRemisionFoto;
	
	public $TaeComprobanteNumero;
	public $TaeComprobanteNumeroSerie;
	public $TaeComprobanteNumeroNumero;
	public $TaeComprobanteFecha;


	public $MonId;
	public $TaeTipoCambio;

	public $TaeIncluyeImpuesto;
	public $TaePorcentajeImpuestoVenta;
	
	public $TaeFoto;
    public $TaeObservacion;
	
	public $TaeInternacionalTotalAduana;
	public $TaeInternacionalTotalTransporte;
	public $TaeInternacionalTotalDesestiba;
	public $TaeInternacionalTotalAlmacenaje;
	public $TaeInternacionalTotalAdValorem;
	public $TaeInternacionalTotalAduanaNacional;
	public $TaeInternacionalTotalGastoAdministrativo;
	public $TaeInternacionalTotalOtroCosto1;
	public $TaeInternacionalTotalOtroCosto2;	
	
	public $TaeNacionalTotalRecargo;
	public $TaeNacionalTotalFlete;
	public $TaeNacionalTotalOtroCosto;


	public $TaeInternacionalNumeroComprobante1;
	public $TaeInternacionalNumeroComprobante2;
	public $TaeInternacionalNumeroComprobante3;
	public $TaeInternacionalNumeroComprobante4;
	public $TaeInternacionalNumeroComprobante5;
	public $TaeInternacionalNumeroComprobante6;
	public $TaeInternacionalNumeroComprobante7;
	public $TaeInternacionalNumeroComprobante8;
	public $TaeInternacionalNumeroComprobante9;

	public $TaeNacionalNumeroComprobante1;
	public $TaeNacionalNumeroComprobante2;
	public $TaeNacionalNumeroComprobante3;
	
	public $TaeNacionalFoto1;
	public $TaeNacionalFoto2;
	public $TaeNacionalFoto3;

	public $MonIdInternacional1;
	public $MonIdInternacional2;
	public $MonIdInternacional3;
	public $MonIdInternacional4;
	public $MonIdInternacional5;
	public $MonIdInternacional6;
	public $MonIdInternacional7;
	public $MonIdInternacional8;
	public $MonIdInternacional9;

	public $MonIdNacional1;
	public $MonIdNacional2;
	public $MonIdNacional3;
	
		
	public $PrvIdInternacional1;
	public $PrvIdInternacional2;
	public $PrvIdInternacional3;
	public $PrvIdInternacional4;
	public $PrvIdInternacional5;
	public $PrvIdInternacional6;
	public $PrvIdInternacional7;
	public $PrvIdInternacional8;
	public $PrvIdInternacional9;

	public $PrvIdNacional1;
	public $PrvIdNacional2;
	public $PrvIdNacional3;

	public $PrvNumeroDocumentoInternacional1;
	public $PrvNumeroDocumentoInternacional2;
	public $PrvNumeroDocumentoInternacional3;
	public $PrvNumeroDocumentoInternacional4;
	public $PrvNumeroDocumentoInternacional5;
	public $PrvNumeroDocumentoInternacional6;
	public $PrvNumeroDocumentoInternacional7;
	public $PrvNumeroDocumentoInternacional8;
	public $PrvNumeroDocumentoInternacional9;	
			
	public $PrvNombreInternacional1;
	public $PrvNombreInternacional2;
	public $PrvNombreInternacional3;
	public $PrvNombreInternacional4;
	public $PrvNombreInternacional5;
	public $PrvNombreInternacional6;
	public $PrvNombreInternacional7;
	public $PrvNombreInternacional8;
	public $PrvNombreInternacional9;	
	
	public $TdoIdInternacional1;
	public $TdoIdInternacional2;
	public $TdoIdInternacional3;
	public $TdoIdInternacional4;
	public $TdoIdInternacional5;
	public $TdoIdInternacional6;
	public $TdoIdInternacional7;
	public $TdoIdInternacional8;
	public $TdoIdInternacional9;	
	
	

	public $PrvNumeroDocumentoNacional1;
	public $PrvNumeroDocumentoNacional2;
	public $PrvNumeroDocumentoNacional3;
	
	public $PrvNombreNacional1;
	public $PrvNombreNacional2;
	public $PrvNombreNacional3;	

	public $TdoIdDocumentoNacional1;
	public $TdoIdNacional2;
	public $TdoIdNacional3;
	
		
		
	public $TaeSubTotal;
	public $TaeImpuesto;
	public $TaeTotal;
	

	public $TaeValorTotal;
	
	public $TaeTotalInternacional;
	public $TaeTotalNacional;
			
	public $TaeCancelado;
	
	public $TaeRevisado;
	
	public $TaeEstado;
	public $TaeTiempoCreacion;
	public $TaeTiempoModificacion;
    public $TaeEliminado;

	public $CtiNombre;
	
	public $TdoId;
	public $PrvNombre;
	public $PrvNumeroDocumento;
	
	public $TdoNombre;
	
	public $MonSimbolo;
	
	public $TrasladoAlmacenEntradaDetalle;
	public $TrasladoAlmacenEntradaExtorno;
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

	public function MtdGenerarTrasladoAlmacenEntradaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(amo.AmoId,5),unsigned)) AS "MAXIMO"
		FROM tblamoalmacenmovimiento amo
		WHERE amo.AmoTipo = 1';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->TaeId = "TAE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->TaeId = "TAE-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerTrasladoAlmacenEntrada(){

        $sql = 'SELECT 
        amo.AmoId AS TaeId,   
		amo.AmoTipo AS TaeTipo,
		amo.AmoSubTipo AS TaeSubTipo,
		amo.PrvId,
		amo.CtiId,
		amo.TopId,

		amo.AlmId,
		DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "TaeFecha",
		
		amo.AmoGuiaRemisionNumero AS TaeGuiaRemisionNumero,
		DATE_FORMAT(amo.AmoGuiaRemisionFecha, "%d/%m/%Y") AS "TaeGuiaRemisionNumero",
		amo.AmoGuiaRemisionFoto AS TaeGuiaRemisionFoto,
		
		amo.AmoComprobanteNumero AS TaeComprobanteNumero,
		DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "TaeComprobanteFecha",
		
		amo.MonId,
	
		amo.AmoFoto AS TaeFoto,
		amo.AmoObservacion AS TaeObservacion,

		amo.AmoEstado AS TaeEstado,
		DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TaeTiempoCreacion",
        DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TaeTiempoModificacion",
		
		cti.CtiNombre,
		
		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.PrvNumeroDocumento,
		prv.TdoId,
				
		mon.MonSimbolo
		
        FROM tblamoalmacenmovimiento amo
		
			LEFT JOIN tblcticomprobantetipo cti
			ON amo.CtiId = cti.CtiId
				LEFT JOIN tblprvproveedor prv
				ON amo.PrvId = prv.PrvId
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId		
						
        WHERE amo.AmoId = "'.$this->TaeId.'" AND amo.AmoTipo = 1 ;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			//MtdObtenerTrasladoAlmacenEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TedId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oTrasladoAlmacenEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL) 
			$InsTrasladoAlmacenEntradaDetalle = new ClsTrasladoAlmacenEntradaDetalle();
			$ResTrasladoAlmacenEntradaDetalle =  $InsTrasladoAlmacenEntradaDetalle->MtdObtenerTrasladoAlmacenEntradaDetalles(NULL,NULL,NULL,NULL,NULL,1,NULL,$fila['TaeId']);

			//$InsTrasladoAlmacenEntradaExtorno = new ClsTrasladoAlmacenEntradaExtorno();
//			$ResTrasladoAlmacenEntradaExtorno =  $InsTrasladoAlmacenEntradaExtorno->MtdObtenerTrasladoAlmacenEntradaExtornos(NULL,NULL,NULL,NULL,1,NULL,$fila['TaeId']);
				
			$this->TaeId = $fila['TaeId'];
			$this->PrvId = $fila['PrvId'];		
			$this->CtiId = $fila['CtiId'];		
			$this->TopId = $fila['TopId'];		
		
			$this->AlmId = $fila['AlmId'];
			$this->TaeFecha = $fila['TaeFecha'];

			$this->TaeGuiaRemisionNumero = $fila['TaeGuiaRemisionNumero'];
			list($this->TaeGuiaRemisionNumeroSerie,$this->TaeGuiaRemisionNumeroNumero) = explode("-",$this->TaeGuiaRemisionNumero);
			$this->TaeGuiaRemisionFecha = $fila['TaeGuiaRemisionFecha'];
			$this->TaeGuiaRemisionFoto = $fila['TaeGuiaRemisionFoto'];
			
			$this->TaeComprobanteNumero = $fila['TaeComprobanteNumero'];
			list($this->TaeComprobanteNumeroSerie,$this->TaeComprobanteNumeroNumero) = explode("-",$this->TaeComprobanteNumero);
			$this->TaeComprobanteFecha = $fila['TaeComprobanteFecha'];

			$this->TaeFoto = $fila['TaeFoto'];
			$this->TaeObservacion = $fila['TaeObservacion'];

			$this->TaeEstado = $fila['TaeEstado'];
			$this->TaeTiempoCreacion = $fila['TaeTiempoCreacion']; 
			$this->TaeTiempoModificacion = $fila['TaeTiempoModificacion']; 	
			
			$this->TrasladoAlmacenEntradaDetalle = 	$ResTrasladoAlmacenEntradaDetalle['Datos'];	

			$this->CtiNombre = $fila['CtiNombre']; 	
			
			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
			$this->PrvNombre = $fila['PrvNombre']; 	
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId']; 	
			$this->TdoNombre = $fila['TdoNombre'];


			switch($this->TaeEstado){
			
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
				
			$this->TaeEstadoDescripcion = $Estado;
			
			
			switch($this->TaeEstado){
			
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
				
			$this->TaeEstadoIcono = $Estado;




		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTrasladoAlmacenEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFecha="AmoFecha",$oProveedor=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {

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

		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		

		if(!empty($oProveedor)){
			$proveedor = ' AND amo.PrvId = "'.$oProveedor.'"';
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = ' AND amo.AlmId = "'.$oAlmacen.'"';
		}
		
		if(!empty($oSubTipo)){
			$stipo = ' AND amo.AmoSubTipo = "'.$oSubTipo.'"';
		}
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId AS TaeId,				
				amo.AmoTipo AS TaeTipo,
				amo.AmoSubTipo AS TaeSubTipo,
				amo.PrvId,
				amo.CtiId,
				amo.TopId,
				
				amo.AlmId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "TaeFecha",

				amo.AmoGuiaRemisionNumero AS "TaeGuiaRemisionNumero",
				DATE_FORMAT(amo.AmoGuiaRemisionFecha, "%d/%m/%Y") AS "TaeGuiaRemisionFecha",
				amo.AmoGuiaRemisionFoto AS "TaeGuiaRemisionFoto",
				
				amo.AmoComprobanteNumero AS TaeComprobanteNumero,
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "TaeComprobanteFecha",
				
				amo.AmoFoto AS TaeFoto,
				amo.AmoObservacion AS TaeObservacion,
				
				amo.AmoCierre AS TaeCierre,
				amo.AmoEstado AS TaeEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TaeTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TaeTiempoModificacion",
				
				DATE_FORMAT(adddate(amo.AmoComprobanteFecha,amo.AmoCantidadDia), "%d/%m/%Y") AS TaeFechaVencimiento,
				DATEDIFF(DATE(NOW()),amo.AmoComprobanteFecha) AS TaeDiaTranscurrido,

				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "TaeTotalItems",

				cti.CtiNombre,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre
			
				FROM tblamoalmacenmovimiento amo
					
					LEFT JOIN tblcticomprobantetipo cti
					ON amo.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON amo.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
							
				WHERE amo.AmoTipo = 1
			   '.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$proveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoAlmacenEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoAlmacenEntrada = new $InsTrasladoAlmacenEntrada();
                    $TrasladoAlmacenEntrada->TaeId = $fila['TaeId'];
					$TrasladoAlmacenEntrada->PrvId = $fila['PrvId'];		
					$TrasladoAlmacenEntrada->CtiId = $fila['CtiId'];	
					$TrasladoAlmacenEntrada->TopId = $fila['TopId'];	

					$TrasladoAlmacenEntrada->AlmId = $fila['AlmId'];
					$TrasladoAlmacenEntrada->TaeFecha = $fila['TaeFecha'];
					$TrasladoAlmacenEntrada->TaeDocumentoOrigen = $fila['TaeDocumentoOrigen'];
					
					$TrasladoAlmacenEntrada->TaeGuiaRemisionNumero = $fila['TaeGuiaRemisionNumero'];
					list($TrasladoAlmacenEntrada->TaeGuiaRemisionNumeroSerie,$TrasladoAlmacenEntrada->TaeGuiaRemisionNumeroNumero) = explode("-",$TrasladoAlmacenEntrada->TaeGuiaRemisionNumero);
					$TrasladoAlmacenEntrada->TaeGuiaRemisionFecha = $fila['TaeGuiaRemisionFecha'];
					$TrasladoAlmacenEntrada->TaeGuiaRemisionFoto = $fila['TaeGuiaRemisionFoto'];
					
					$TrasladoAlmacenEntrada->TaeComprobanteNumero = $fila['TaeComprobanteNumero'];
					list($TrasladoAlmacenEntrada->TaeComprobanteNumeroSerie,$TrasladoAlmacenEntrada->TaeComprobanteNumeroNumero) = explode("-",$TrasladoAlmacenEntrada->TaeComprobanteNumero);					
					$TrasladoAlmacenEntrada->TaeComprobanteFecha = $fila['TaeComprobanteFecha'];
					
					
					
					$TrasladoAlmacenEntrada->TaeFoto = $fila['TaeFoto'];
					$TrasladoAlmacenEntrada->TaeObservacion = $fila['TaeObservacion'];
					
					$TrasladoAlmacenEntrada->TaeCierre = $fila['TaeCierre'];			
					$TrasladoAlmacenEntrada->TaeEstado = $fila['TaeEstado'];
					$TrasladoAlmacenEntrada->TaeTiempoCreacion = $fila['TaeTiempoCreacion'];  
					$TrasladoAlmacenEntrada->TaeTiempoModificacion = $fila['TaeTiempoModificacion']; 

					$TrasladoAlmacenEntrada->TaeFechaVencimiento = $fila['TaeFechaVencimiento']; 
					$TrasladoAlmacenEntrada->TaeDiaTranscurrido = $fila['TaeDiaTranscurrido']; 

					$TrasladoAlmacenEntrada->TaeTotalItems = $fila['TaeTotalItems']; 
					
					$TrasladoAlmacenEntrada->CtiNombre = $fila['CtiNombre']; 
					
					$TrasladoAlmacenEntrada->TdoId = $fila['TdoId']; 
					
					$TrasladoAlmacenEntrada->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$TrasladoAlmacenEntrada->PrvNombre = $fila['PrvNombre']; 
					$TrasladoAlmacenEntrada->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$TrasladoAlmacenEntrada->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$TrasladoAlmacenEntrada->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$TrasladoAlmacenEntrada->TdoNombre = $fila['TdoNombre']; 

					switch($TrasladoAlmacenEntrada->TaeEstado){
					
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
						
					$TrasladoAlmacenEntrada->TaeEstadoDescripcion = $Estado;
					
					
					switch($TrasladoAlmacenEntrada->TaeEstado){
					
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
						$TrasladoAlmacenEntrada->TaeEstadoIcono = $Estado;
						
						


					switch($TrasladoAlmacenEntrada->TaeRevisado){
					
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
						
					$TrasladoAlmacenEntrada->TaeRevisadoDescripcion = $Revisado;
					
					
					switch($TrasladoAlmacenEntrada->TaeRevisado){
					
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
						
						
						
					$TrasladoAlmacenEntrada->TaeRevisadoIcono = $Revisado;




                    $TrasladoAlmacenEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoAlmacenEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		




    public function MtdObtenerTrasladoAlmacenEntradasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFecha="AmoFecha",$oProveedor=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {

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

		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		

		if(!empty($oProveedor)){
			$proveedor = ' AND amo.PrvId = "'.$oProveedor.'"';
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = ' AND amo.AlmId = "'.$oAlmacen.'"';
		}
		
		if(!empty($oSubTipo)){
			$stipo = ' AND amo.AmoSubTipo = "'.$oSubTipo.'"';
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
		
		
		
		
		
			 $sql = 'SELECT
		
				'.$funcion.' AS "RESULTADO"
					
				FROM tblamoalmacenmovimiento amo
					
					LEFT JOIN tblcticomprobantetipo cti
					ON amo.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON amo.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
							
				WHERE amo.AmoTipo = 1
			   '.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$proveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
			   
			   	
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarTrasladoAlmacenEntrada($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsTrasladoAlmacenEntradaDetalle = new ClsTrasladoAlmacenEntradaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){

					$ResTrasladoAlmacenEntradaDetalle = $InsTrasladoAlmacenEntradaDetalle->MtdObtenerTrasladoAlmacenEntradaDetalles(NULL,NULL,NULL,'TedId','DESC',1,NULL,$elemento);
					$ArrTrasladoAlmacenEntradaDetalles = $ResTrasladoAlmacenEntradaDetalle['Datos'];

					if(!empty($ArrTrasladoAlmacenEntradaDetalles)){
						$amdetalle = '';

						foreach($ArrTrasladoAlmacenEntradaDetalles as $DatTrasladoAlmacenEntradaDetalle){
							$amdetalle .= '#'.$DatTrasladoAlmacenEntradaDetalle->TedId;
						}

						if(!$InsTrasladoAlmacenEntradaDetalle->MtdEliminarTrasladoAlmacenEntradaDetalle($amdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->TaeId = $elemento;
						$this->MtdObtenerTrasladoAlmacenEntrada();


						$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE  (AmoId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							if(!empty($this->OcoId)){
								$InsOrdenCompra = new ClsOrdenCompra();
								$InsOrdenCompra->MtdActualizarEstadoOrdenCompra($this->OcoId,3);
							}
							
							$this->MtdAuditarTrasladoAlmacenEntrada(3,"Se elimino la Transferencia de Almacen",$aux);		
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
	public function MtdActualizarEstadoTrasladoAlmacenEntrada($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsTrasladoAlmacenEntrada = new ClsTrasladoAlmacenEntrada();
		//$InsTrasladoAlmacenEntradaDetalles = new ClsTrasladoAlmacenEntradaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE AmoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarTrasladoAlmacenEntrada(2,"Se actualizo el Estado dla Transferencia de Almacen",$elemento);
				
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
	
	
	
	public function MtdActualizarRevisadoTrasladoAlmacenEntrada($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoRevisado = '.$oRevisado.' WHERE AmoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
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
	
	public function MtdVerificarExisteTrasladoAlmacenEntrada($oCampo,$oDato,$oProveedor=NULL){

		$Respuesta =   NULL;

		if($oProveedor){
			$proveedor = ' AND PrvId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT 
			AmoId
			FROM tblamoalmacenmovimiento
			WHERE '.$oCampo.' = "'.$oDato.'" '.$proveedor.' LIMIT 1;';

			$resultado = $this->InsMysql->MtdConsultar($sql);

			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['TaeId'];
	
			}
			
			return $Respuesta;
	
		}
	
	
	
	public function MtdRegistrarTrasladoAlmacenEntrada() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarTrasladoAlmacenEntradaId();
			
			$sql = 'INSERT INTO tblamoalmacenmovimiento (
			AmoId,	
			
			PrvId,
			CtiId,
			TopId,
			
			CprId,
			VdiId,
			
			LtiId,
			
			AmoTipo,
			AmoSubTipo,
			
			AlmId,
			AmoIdOrigen,
			TalId,
			PprId,
			
			AmoFecha,
			AmoDocumentoOrigen,
			
			AmoGuiaRemisionNumero,
			AmoGuiaRemisionFecha,
			AmoGuiaRemisionFoto,
			
			AmoComprobanteNumero,
			AmoComprobanteFecha,
			MonId,
			AmoTipoCambio,
			AmoIncluyeImpuesto,
			AmoPorcentajeImpuestoVenta,
					
			AmoFoto,
			AmoObservacion,
			
			AmoSubTotal,
			AmoImpuesto,				
			AmoTotal,
				
			AmoTotalInternacional,
			AmoTotalNacional,
			
			AmoCancelado,
			AmoRevisado,
			AmoFacturable,
			
			AmoCierre,
			AmoEstado,			
			AmoTiempoCreacion,
			AmoTiempoModificacion) 
			VALUES (
			"'.($this->TaeId).'", 
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'NULL, ':'"'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			NULL,
			NULL,
			
			NULL,
			
			1,
			8,
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			NULL,
			NULL,
			NULL,
			
			"'.($this->TaeFecha).'", 
			0,
			"'.($this->TaeGuiaRemisionNumero).'", 
			'.(empty($this->TaeGuiaRemisionFecha)?'NULL, ':'"'.$this->TaeGuiaRemisionFecha.'",').'
			"'.($this->TaeGuiaRemisionFoto).'",
			
			"'.($this->TaeComprobanteNumero).'", 
			'.(empty($this->TaeComprobanteFecha)?'NULL, ':'"'.$this->TaeComprobanteFecha.'",').'
			"'.($this->MonId).'", 
			NULL,
			0,
			0,


			"'.($this->TaeFoto).'",
			"'.($this->TaeObservacion).'",

			0,
			0,
			0,
			
			0,
			0,
			2,
			2,
			1,
			
			2,
			'.($this->TaeEstado).',
			"'.($this->TaeTiempoCreacion).'", 			
								
			"'.($this->TaeTiempoModificacion).'");';			
		
			
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			
			if(!$resultado) {							
				$error = true;
			} 




			if(!$error){			
			
				if (!empty($this->TrasladoAlmacenEntradaDetalle)){		
						
					$validar = 0;				
					$InsTrasladoAlmacenEntradaDetalle = new ClsTrasladoAlmacenEntradaDetalle();		
					
					foreach ($this->TrasladoAlmacenEntradaDetalle as $DatTrasladoAlmacenEntradaDetalle){
					
						$InsTrasladoAlmacenEntradaDetalle->TaeId = $this->TaeId;
						$InsTrasladoAlmacenEntradaDetalle->ProId = $DatTrasladoAlmacenEntradaDetalle->ProId;
						$InsTrasladoAlmacenEntradaDetalle->UmeId = $DatTrasladoAlmacenEntradaDetalle->UmeId;
						$InsTrasladoAlmacenEntradaDetalle->TedIdAnterior = $DatTrasladoAlmacenEntradaDetalle->TedIdAnterior;
						$InsTrasladoAlmacenEntradaDetalle->TedIdOrigen = $DatTrasladoAlmacenEntradaDetalle->TedIdOrigen;
					
						$InsTrasladoAlmacenEntradaDetalle->TedCantidad = $DatTrasladoAlmacenEntradaDetalle->TedCantidad;
						$InsTrasladoAlmacenEntradaDetalle->TedCantidadReal = $DatTrasladoAlmacenEntradaDetalle->TedCantidadReal;
						$InsTrasladoAlmacenEntradaDetalle->TedUbicacion = $DatTrasladoAlmacenEntradaDetalle->TedUbicacion;
						
						$InsTrasladoAlmacenEntradaDetalle->TedEstado = $DatTrasladoAlmacenEntradaDetalle->TedEstado;									
						$InsTrasladoAlmacenEntradaDetalle->TedTiempoCreacion = $DatTrasladoAlmacenEntradaDetalle->TedTiempoCreacion;
						$InsTrasladoAlmacenEntradaDetalle->TedTiempoModificacion = $DatTrasladoAlmacenEntradaDetalle->TedTiempoModificacion;						
						$InsTrasladoAlmacenEntradaDetalle->TedEliminado = $DatTrasladoAlmacenEntradaDetalle->TedEliminado;
						
						$InsTrasladoAlmacenEntradaDetalle->AlmId = $this->AlmId;
						$InsTrasladoAlmacenEntradaDetalle->TedFecha = $this->TaeFecha;
						
						if($InsTrasladoAlmacenEntradaDetalle->MtdRegistrarTrasladoAlmacenEntradaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_TAE_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->TrasladoAlmacenEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
							
							
							
			
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarTrasladoAlmacenEntrada(1,"Se registro la Transferencia de Almacen",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarTrasladoAlmacenEntrada() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblamoalmacenmovimiento SET
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
			
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
			AmoFecha = "'.($this->TaeFecha).'",
		
			AmoGuiaRemisionNumero = "'.($this->TaeGuiaRemisionNumero).'",
			'.(empty($this->TaeGuiaRemisionFecha)?'AmoGuiaRemisionFecha = NULL, ':'AmoGuiaRemisionFecha = "'.$this->TaeGuiaRemisionFecha.'",').'
			AmoGuiaRemisionFoto = "'.($this->TaeGuiaRemisionFoto).'",
			
			AmoComprobanteNumero = "'.($this->TaeComprobanteNumero).'",
			'.(empty($this->TaeComprobanteFecha)?'AmoComprobanteFecha = NULL, ':'AmoComprobanteFecha = "'.$this->TaeComprobanteFecha.'",').'
		
			AmoFoto = "'.($this->TaeFoto).'",
			AmoObservacion = "'.($this->TaeObservacion).'",
			
			AmoEstado = '.($this->TaeEstado).'
			WHERE AmoId = "'.($this->TaeId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			


			
			if(!$error){
			
				if (!empty($this->TrasladoAlmacenEntradaDetalle)){		
						
						
					$validar = 0;				
					$InsTrasladoAlmacenEntradaDetalle = new ClsTrasladoAlmacenEntradaDetalle();
							
					foreach ($this->TrasladoAlmacenEntradaDetalle as $DatTrasladoAlmacenEntradaDetalle){
						
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTrasladoAlmacenEntradaDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsTrasladoAlmacenEntradaDetalle->TedId = $DatTrasladoAlmacenEntradaDetalle->TedId;
						$InsTrasladoAlmacenEntradaDetalle->TaeId = $this->TaeId;
						$InsTrasladoAlmacenEntradaDetalle->ProId = $DatTrasladoAlmacenEntradaDetalle->ProId;
						$InsTrasladoAlmacenEntradaDetalle->UmeId = $DatTrasladoAlmacenEntradaDetalle->UmeId;
						$InsTrasladoAlmacenEntradaDetalle->TedIdAnterior = $DatTrasladoAlmacenEntradaDetalle->TedIdAnterior;
						$InsTrasladoAlmacenEntradaDetalle->TedIdOrigen = $DatTrasladoAlmacenEntradaDetalle->TedIdOrigen;
						
						$InsTrasladoAlmacenEntradaDetalle->TedCantidad = $DatTrasladoAlmacenEntradaDetalle->TedCantidad;
						$InsTrasladoAlmacenEntradaDetalle->TedCantidadReal = $DatTrasladoAlmacenEntradaDetalle->TedCantidadReal;
						$InsTrasladoAlmacenEntradaDetalle->TedUbicacion = $DatTrasladoAlmacenEntradaDetalle->TedUbicacion;

						$InsTrasladoAlmacenEntradaDetalle->TedEstado = $DatTrasladoAlmacenEntradaDetalle->TedEstado;		
						$InsTrasladoAlmacenEntradaDetalle->TedTiempoCreacion = $DatTrasladoAlmacenEntradaDetalle->TedTiempoCreacion;
						$InsTrasladoAlmacenEntradaDetalle->TedTiempoModificacion = $DatTrasladoAlmacenEntradaDetalle->TedTiempoModificacion;
						$InsTrasladoAlmacenEntradaDetalle->TedEliminado = $DatTrasladoAlmacenEntradaDetalle->TedEliminado;
						
						$InsTrasladoAlmacenEntradaDetalle->AlmId = $this->AlmId;
						$InsTrasladoAlmacenEntradaDetalle->TedFecha = $this->TaeFecha;
						
						if(empty($InsTrasladoAlmacenEntradaDetalle->TedId)){
							if($InsTrasladoAlmacenEntradaDetalle->TedEliminado<>2){
								if($InsTrasladoAlmacenEntradaDetalle->MtdRegistrarTrasladoAlmacenEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_TAE_201';
									$Resultado.='# : '.$InsProducto->ProCodigoOriginal;
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsTrasladoAlmacenEntradaDetalle->TedEliminado==2){
								if($InsTrasladoAlmacenEntradaDetalle->MtdEliminarTrasladoAlmacenEntradaDetalle($InsTrasladoAlmacenEntradaDetalle->TedId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_TAE_203';
									$Resultado.='# : '.$InsProducto->ProCodigoOriginal;
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsTrasladoAlmacenEntradaDetalle->MtdEditarTrasladoAlmacenEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_TAE_202';
									$Resultado.='# : '.$InsProducto->ProCodigoOriginal;
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->TrasladoAlmacenEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarTrasladoAlmacenEntrada(2,"Se edito la Transferencia de Almacen",$this);		
				return true;
			}	
				
		}
		
		
	
		public function MtdEditarTrasladoAlmacenEntradaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblamoalmacenmovimiento SET 
			'.$oCampo.' = "'.($oDato).'",
			AmoTiempoModificacion = NOW()
			WHERE AmoId = "'.($oId).'";';
			
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

		private function MtdAuditarTrasladoAlmacenEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->TaeId;

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
		
		
		
}
?>