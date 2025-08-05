<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCliente
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsClientePago {

    public $CpaId;
    public $FpaId;
	public $MonId;
	public $CueId;
	public $CpaFecha;
	public $CpaTransaccionNumero;
	public $CpaTipoCambio;
	public $CpaMonto;
	public $CpaEstado;
	public $CpaObservacion;
    public $CpaTiempoCreacion;
    public $CpaTiempoModificacion;
    public $CpaEliminado;
    public $InsMysql;
	
	public $ClientePagoComprobante;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	public function MtdGenerarClientePagoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CpaId,5),unsigned)) AS "MAXIMO"
			FROM tblcpaclientepago';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CpaId = "CPA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CpaId = "CPA-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerClientePago($oCompleto=true){

        $sql = 'SELECT 
		cpa.CpaId,
		cpa.FpaId,
		cpa.MonId,
		cpa.CueId,
		DATE_FORMAT(cpa.CpaFecha, "%d/%m/%Y") AS "NCpaFecha",
		cpa.CpaTransaccionNumero,
		cpa.CpaTipoCambio,
		cpa.CpaMonto,
		cpa.CpaEstado,
		cpa.CpaObservacion,
		DATE_FORMAT(cpa.CpaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCpaTiempoCreacion",
        DATE_FORMAT(cpa.CpaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCpaTiempoModificacion"
        FROM tblcpaclientepago cpa
        WHERE cpa.CpaId = "'.$this->CpaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CpaId = $fila['CpaId'];
			
			$this->FpaId = $fila['FpaId'];
			$this->MonId = $fila['MonId'];
			$this->CueId = $fila['CueId'];
			$this->CpaFecha = $fila['NCpaFecha'];
			$this->CpaTransaccionNumero = $fila['CpaTransaccionNumero'];
			$this->CpaTipoCambio = $fila['CpaTipoCambio'];
			$this->CpaMonto = $fila['CpaMonto'];
			$this->CpaEstado = $fila['CpaEstado'];
			$this->CpaObservacion = $fila['CpaObservacion'];
			$this->CpaTiempoCreacion = $fila['NCpaTiempoCreacion'];
			$this->CpaTiempoModificacion = $fila['NCpaTiempoModificacion']; 
		
			if($oCompleto){
				
				//MtdObtenerClientePagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CpcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oClientePago=NULL)
				$InsClientePagoComprobante = new ClsClientePagoComprobante();
				$ResClientePagoComprobante =  $InsClientePagoComprobante->MtdObtenerClientePagoComprobantes(NULL,NULL,"CpcId","ASC",NULL,$this->CpaId);			
				$this->ClientePagoComprobante = $ResClientePagoComprobante['Datos'];	
				
			}
				
			
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerClientePagos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFormaPago=NULL,$oMoneda=NULL,$oCuenta=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oFacturaExportacion=NULL,$oFacturaExportacionTalonario=NULL) {

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
		
		if(!empty($oFormaPago)){
			$fpago = ' AND cpa.FpaId = "'.($oFormaPago).'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cpa.MonId = "'.($oMoneda).'"';
		}
		
		if(!empty($oCuenta)){
			$cuenta = ' AND cpa.CueId = "'.($oCuenta).'"';
		}
		
		
		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			
			$factura = ' AND EXISTS (
				SELECT 
				cpc.CpcId 
				FROM tblcpcclientepagocomprobante cpc
				WHERE cpc.CpaId = cpa.CpaId
				AND cpc.FacId = "'.$oFactura.'"
				AND cpc.FtaId = "'.$oFacturaTalonario.'"
			)';
		}
		
		
		
		if(!empty($oBoleta) and !empty($oBoletaTalonario)){
			
			$boleta = ' AND EXISTS (
				SELECT 
				cpc.CpcId 
				FROM tblcpcclientepagocomprobante cpc
				WHERE cpc.CpaId = cpa.CpaId
				AND cpc.BolId = "'.$oBoleta.'"
				AND cpc.BtaId = "'.$oBoletaTalonario.'"
			)';
		}
		
		
		if(!empty($oFacturaExportacion) and !empty($oFacturaExportacionTalonario)){
			
			$fexportacion = ' AND EXISTS (
				SELECT 
				cpc.CpcId 
				FROM tblcpcclientepagocomprobante cpc
				WHERE cpc.CpaId = cpa.CpaId
				AND cpc.FexId = "'.$oFacturaExportacion.'"
				AND cpc.FetId = "'.$oFacturaExportacionTalonario.'"
			)';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cpa.CpaId,
				cpa.FpaId,
				cpa.MonId,
				cpa.CueId,
				DATE_FORMAT(cpa.CpaFecha, "%d/%m/%Y") AS "NCpaFecha",
				cpa.CpaTransaccionNumero,
				cpa.CpaTipoCambio,
				cpa.CpaMonto,
				cpa.CpaEstado,
				cpa.CpaObservacion,
				DATE_FORMAT(cpa.CpaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCpaTiempoCreacion",
                DATE_FORMAT(cpa.CpaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCpaTiempoModificacion",
				
				fpa.FpaNombre,
				
				cue.CueNumero,
				
				mon.MonSimbolo,
				mon.MonNombre,
				
				ban.BanNombre
				
				FROM tblcpaclientepago cpa
					LEFT JOIN tblfpaformapago fpa
					ON cpa.FpaId = fpa.FpaId
						LEFT JOIN tblcuecuenta cue
						ON cpa.CueId = cue.CueId
							LEFT JOIN tblbanbanco ban
							ON cue.BanId = ban.BanId
								LEFT JOIN tblmonmoneda mon
								ON cpa.MonId = mon.MonId
							
				WHERE 1 = 1 '.$filtrar.$fpago.$moneda.$cuenta.$factura.$boleta.$fexportacion.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCliente = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Cliente = new $InsCliente();
                    $Cliente->CpaId = $fila['CpaId'];
					
					$Cliente->FpaId = $fila['FpaId'];
					$Cliente->MonId = $fila['MonId'];
					$Cliente->CueId = $fila['CueId'];
					$Cliente->CpaFecha = $fila['NCpaFecha'];
					$Cliente->CpaTransaccionNumero = $fila['CpaTransaccionNumero'];
					$Cliente->CpaTipoCambio = $fila['CpaTipoCambio'];
					$Cliente->CpaMonto = $fila['CpaMonto'];
					$Cliente->CpaEstado = $fila['CpaEstado'];
					$Cliente->CpaObservacion = $fila['CpaObservacion'];
				
                    $Cliente->CpaTiempoCreacion = $fila['NCpaTiempoCreacion'];
					$Cliente->CpaTiempoModificacion = $fila['NCpaTiempoModificacion'];
					
					$Cliente->FpaNombre = $fila['FpaNombre'];
					
					$Cliente->CueNumero = $fila['CueNumero'];
					
					$Cliente->MonSimbolo = $fila['MonSimbolo'];
					$Cliente->MonNombre = $fila['MonNombre'];
					
					$Cliente->BanNombre = $fila['BanNombre'];
					
				
                    $Cliente->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Cliente;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarClientePago($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CpaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CpaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblcpaclientepago WHERE '.$eliminar;

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarClientePago($oTransaccion=true) {


		
		global $Resultado;
		$error = false;
	
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();			
		}

			$this->MtdGenerarClientePagoId();
		
			$sql = 'INSERT INTO tblcpaclientepago (
			CpaId,
			
			FpaId,
			MonId,
			CueId,
			CpaFecha,
			CpaTransaccionNumero,
			CpaTipoCambio,
			CpaMonto,
			CpaEstado,
			CpaObservacion,
			CpaTiempoCreacion,
			CpaTiempoModificacion
			) 
			VALUES (
			"'.($this->CpaId).'", 
			"'.($this->FpaId).'", 
			"'.($this->MonId).'", 

			'.(empty($this->CueId)?"NULL,":'"'.$this->CueId.'",').'
			
			"'.($this->CpaFecha).'", 
			"'.($this->CpaTransaccionNumero).'", 
			
			'.(empty($this->CpaTipoCambio)?"NULL,":''.$this->CpaTipoCambio.',').'
			
			'.($this->CpaMonto).', 
			'.($this->CpaEstado).', 
			"'.($this->CpaObservacion).'", 
			"'.($this->CpaTiempoCreacion).'", 
			"'.($this->CpaTiempoModificacion).'");';	

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			

			if(!$error){			
			
				if (!empty($this->ClientePagoComprobante)){		
						
					$validar = 0;				
						

						$InsClientePagoComprobante = new ClsClientePagoComprobante();	
											
					foreach ($this->ClientePagoComprobante as $DatClientePagoComprobante){
					

						$DatClientePagoComprobante->CpaId = $this->CpaId;
						
						$DatClientePagoComprobante->FacId = $DatClientePagoComprobante->FacId;
						$DatClientePagoComprobante->FtaId = $DatClientePagoComprobante->FtaId;
						
						$DatClientePagoComprobante->BolId = $DatClientePagoComprobante->BolId;
						$DatClientePagoComprobante->BtaId = $DatClientePagoComprobante->BtaId;
						
						$DatClientePagoComprobante->FexId = $DatClientePagoComprobante->FexId;
						$DatClientePagoComprobante->FetId = $DatClientePagoComprobante->FetId;
						
						$DatClientePagoComprobante->CpcEstado = $DatClientePagoComprobante->CpcEstado;							
						$DatClientePagoComprobante->CpcTiempoCreacion = $DatClientePagoComprobante->CpcTiempoCreacion;
						$DatClientePagoComprobante->CpcTiempoModificacion = $DatClientePagoComprobante->CpcTiempoModificacion;						
						$DatClientePagoComprobante->CpcEliminado = $DatClientePagoPlanchado->CpcEliminado;

						if($DatClientePagoComprobante->MtdRegistrarClientePagoComprobante()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CPA_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->ClientePagoComprobante) <> $validar ){
						$error = true;
					}					
		
				}				
			}
			
			
			
			
			if($error) {	
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {				
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionHacer();		
				}
				
				$this->MtdAuditarClientePago(1,"Se registro el Pago de Cliente",$this);			
				return true;
			}			
			
	}
	
	public function MtdEditarClientePago() {
		
		
		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();
		
		
			$sql = 'UPDATE tblcpaclientepago SET 
			
			FpaId = "'.($this->FpaId).'",
			MonId = "'.($this->MonId).'",
			'.(empty($this->CueId)?'CueId = NULL, ':'CueId = "'.$this->CueId.'",').'
			CpaFecha = "'.($this->CpaFecha).'",
			CpaTransaccionNumero = "'.($this->CpaTransaccionNumero).'",
			'.(empty($this->CpaTipoCambio)?'CpaTipoCambio = NULL, ':'CpaTipoCambio = '.$this->CpaTipoCambio.',').'
			
			CpaMonto = '.($this->CpaMonto).',
			CpaEstado = '.($this->CpaEstado).',
		 CpaObservacion = "'.($this->CpaObservacion).'",
			 CpaTiempoModificacion = "'.($this->CpaTiempoModificacion).'"
			 WHERE CpaId = "'.($this->CpaId).'";';
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			
				if(!$error){

				if (!empty($this->ClientePagoComprobante)){		
						
					$validar = 0;				
					$InsClientePagoComprobante = new ClsClientePagoComprobante();

					foreach ($this->ClientePagoComprobante as $DatClientePagoPlanchado){

						$InsClientePagoComprobante->CpcId = $DatClientePagoPlanchado->CpcId;
						$InsClientePagoComprobante->CpaId = $this->CpaId;
						
						$InsClientePagoComprobante->FacId = $DatClientePagoPlanchado->FacId;
						$InsClientePagoComprobante->FtaId = $DatClientePagoPlanchado->FtaId;		
						
						$InsClientePagoComprobante->BolId = $DatClientePagoPlanchado->BolId;
						$InsClientePagoComprobante->BtaId = $DatClientePagoPlanchado->BtaId;
						
						$InsClientePagoComprobante->FexId = $DatClientePagoPlanchado->FexId;
						$InsClientePagoComprobante->FetId = $DatClientePagoPlanchado->FetId;						
					
						$InsClientePagoComprobante->CpcEstado = $DatClientePagoPlanchado->CpcEstado;
						$InsClientePagoComprobante->CpcTiempoCreacion = $DatClientePagoPlanchado->CpcTiempoCreacion;
						$InsClientePagoComprobante->CpcTiempoModificacion = $DatClientePagoPlanchado->CpcTiempoModificacion;
						$InsClientePagoComprobante->CpcEliminado = $DatClientePagoPlanchado->CpcEliminado;
						
						if(empty($InsClientePagoComprobante->CpcId)){
							if($InsClientePagoComprobante->CpcEliminado<>2){
								if($InsClientePagoComprobante->MtdRegistrarClientePagoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPA_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsClientePagoComprobante->CpcEliminado==2){
								if($InsClientePagoComprobante->MtdEliminarClientePagoPlanchadoPintado($InsClientePagoComprobante->CpcId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CPA_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsClientePagoComprobante->MtdEditarClientePagoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CPA_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->ClientePagoComprobante) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarClientePago(2,"Se edito el Pago de Cliente",$this);		
				return true;
			}						
				
		}
		
		
	
	
	private function MtdAuditarClientePago($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->CpaId;

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