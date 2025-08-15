<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Povcription of ClsPagoProveedor
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPagoProveedor {

    public $PovId;
	public $PrvId;
    public $PovFecha;
    public $MonId;	
	public $PovTipoCambio;
	public $PovObservacion;
	public $PovObservacionImpresa;
	public $PovMonto;
	public $PovFoto;	
	public $PovEstado;	
    public $PovTiempoCreacion;
    public $PovTiempoModificacion;
    public $PovEliminado;

	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $PrvNumeroDocumento;
	public $TdoId;
	
	public $MonNombre;
	
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
		
	public function MtdGenerarPagoProveedorId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PovId,5),unsigned)) AS "MAXIMO"
		FROM tblpovpagoproveedor';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->PovId = "POV-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PovId = "POV-".$fila['MAXIMO'];					
		}

	}


	public function MtdObtenerPagoProveedor($oCompleto=true){

        $sql = 'SELECT 
        pov.PovId,
		pov.PrvId,
pov.CueId,
		DATE_FORMAT(pov.PovFecha, "%d/%m/%Y") AS "NPovFecha",
		pov.MonId,		
		pov.PovTipoCambio,
		pov.PovObservacion,		
		pov.PovMonto,
		pov.PovFoto,
		
		pov.PovNumeroOperacion,
		pov.PovEstado,	
		DATE_FORMAT(pov.PovTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPovTiempoCreacion",
        DATE_FORMAT(pov.PovTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPovTiempoModificacion",
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,
		prv.TdoId,
		
		tdo.TdoNombre 
		
        FROM tblpovpagoproveedor pov
			
		LEFT JOIN tblprvproveedor prv
		ON pov.PrvId = prv.PrvId
			
			LEFT JOIN tbltdotipodocumento tdo
			ON prv.TdoId = tdo.TdoId
			
				LEFT JOIN tblmonmoneda mon
				ON pov.MonId = mon.MonId
					
					
        WHERE PovId = "'.$this->PovId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->PovId = $fila['PovId'];
			$this->PrvId = $fila['PrvId'];		
			$this->CueId = $fila['CueId'];		
			
			$this->PovFecha = $fila['NPovFecha'];
			$this->MonId = $fila['MonId'];
			$this->PovTipoCambio = $fila['PovTipoCambio'];
			$this->PovObservacion = $fila['PovObservacion'];
			
			$this->PovMonto = $fila['PovMonto'];
			$this->PovFoto = $fila['PovFoto'];	
			
			
			$this->PovNumeroOperacion = $fila['PovNumeroOperacion'];		
			$this->PovEstado = $fila['PovEstado'];
			$this->PovTiempoCreacion = $fila['NPovTiempoCreacion'];
			$this->PovTiempoModificacion = $fila['NPovTiempoModificacion'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			$this->TdoNombre = $fila['TdoNombre'];
			
			
				switch($this->PovEstado){
					case 1:
						$this->PovEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->PovEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->PovEstadoDescripcion = "Anulado";
				
					break;
					
				}	
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPagoProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PovId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCuenta=NULL) {
		
		
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
			
				
		if(!empty($oEstado)){
			$estado = ' AND pov.PovEstado = '.$oEstado;
		}	
		
		if(!empty($oMoneda)){
			$moneda = ' AND pov.MonId = "'.$oMoneda.'"';
		}	
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pov.PovFecha)>="'.$oFechaInicio.'" AND DATE(pov.PovFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pov.PovFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pov.PovFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
			
		if(!empty($oCuentaId)){
			$cuenta = ' AND pov.CueId = "'.$oCuentaId.'"';
		}

			  $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pov.PovId,
				pov.PrvId,
pov.CueId,
				
				DATE_FORMAT(pov.PovFecha, "%d/%m/%Y") AS "NPovFecha",
				pov.MonId,
				pov.PovTipoCambio,
				pov.PovObservacion,
				
				pov.PovMonto,
				pov.PovFoto,
				
				pov.PovNumeroOperacion,
				pov.PovEstado,	
				DATE_FORMAT(pov.PovTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPovTiempoCreacion",
                DATE_FORMAT(pov.PovTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPovTiempoModificacion",

				mon.MonNombre,
				mon.MonSimbolo,
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId,
				
				tdo.TdoNombre,
				
				ban.BanNombre,
				cue.CueNumero
				
				FROM tblpovpagoproveedor pov

					LEFT JOIN tblprvproveedor prv
					ON pov.PrvId = prv.PrvId
						
						LEFT JOIN tblcuecuenta cue
						ON pov.CueId = cue.CueId
							
							LEFT JOIN tblbanbanco ban
							ON cue.BanId = ban.BanId
				
						LEFT JOIN tbltdotipodocumento tdo
						ON prv.TdoId = tdo.TdoId
				
							LEFT JOIN tblmonmoneda mon
							ON pov.MonId = mon.MonId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$vdirecta.$cuenta.$ovvehiculo.$cpago.$moneda.$tdestino.$factura.$boleta.$area.$fecha.$cuenta.$area.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPagoProveedor = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PagoProveedor = new $InsPagoProveedor();				
					
                    $PagoProveedor->PovId = $fila['PovId'];					
					$PagoProveedor->PrvId = $fila['PrvId'];	
					$PagoProveedor->CueId = $fila['CueId'];	
									
                    $PagoProveedor->PovFecha = $fila['NPovFecha'];
					$PagoProveedor->MonId = $fila['MonId'];
					$PagoProveedor->PovTipoCambio= $fila['PovTipoCambio'];
					$PagoProveedor->PovObservacion = $fila['PovObservacion'];					
					$PagoProveedor->PovMonto = $fila['PovMonto'];
					$PagoProveedor->PovFoto = $fila['PovFoto'];	
					
					
					$PagoProveedor->PovNumeroOperacion = $fila['PovNumeroOperacion'];				
					$PagoProveedor->PovEstado = $fila['PovEstado'];
                    $PagoProveedor->PovTiempoCreacion = $fila['NPovTiempoCreacion'];
					$PagoProveedor->PovTiempoModificacion = $fila['NPovTiempoModificacion'];

					$PagoProveedor->MonNombre = $fila['MonNombre'];
					$PagoProveedor->MonSimbolo = $fila['MonSimbolo'];
					
					$PagoProveedor->PrvNombre = $fila['PrvNombre'];
					$PagoProveedor->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$PagoProveedor->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$PagoProveedor->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$PagoProveedor->TdoId = $fila['TdoId'];					
					$PagoProveedor->TdoNombre = $fila['TdoNombre'];
					
					$PagoProveedor->BanNombre = $fila['BanNombre'];
					$PagoProveedor->CueNumero = $fila['CueNumero'];
					
					switch($PagoProveedor->PovEstado){
						case 1:
							$PagoProveedor->PovEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$PagoProveedor->PovEstadoDescripcion = "Realizado";
						break;
						
						case 6:
							$PagoProveedor->PovEstadoDescripcion = "Anulado";
					
						break;
						
					}	
				
                    $PagoProveedor->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PagoProveedor;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarPagoProveedor($oElementos) {
		
		
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					//$sql = 'UPDATE tblpovpagoproveedor SET PovEstado = '.$oEstado.' WHERE   PovId = "'.($elemento).'" ';
					$sql = 'DELETE FROM  tblpovpagoproveedor WHERE  PovId = "'.($elemento).'" ';
					
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarPagoProveedor(3,"Se elimino el Abono de Proveedor",$aux);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionPovhacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}	
			
							
	}
	
	

	public function MtdActualizarEstadoPagoProveedor($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					
					$sql = 'UPDATE tblpovpagoproveedor SET PovEstado = '.$oEstado.' WHERE   PovId = "'.($elemento).'" ';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarPagoProveedor(2,"Se actualizo el Estado del Abono de Proveedor",$elemento);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionPovhacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}							
	}



	public function MtdRegistrarPagoProveedor() {
	
	
	$this->InsMysql->MtdTransaccionIniciar();
	
	$error = false;
	
			$this->MtdGenerarPagoProveedorId();
		
			$sql = 'INSERT INTO tblpovpagoproveedor (
			PovId,
			PrvId,
			CueId,
			
			PovFecha,
			MonId,
			
			PovTipoCambio,
			PovObservacion,
			
			PovMonto,		
			PovFoto,
			
			PovNumeroOperacion,
			
			PovEstado,
			PovTiempoCreacion,
			PovTiempoModificacion
			) 
			VALUES (
			"'.($this->PovId).'", 
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CueId)?'NULL, ':'"'.$this->CueId.'",').'

			"'.($this->PovFecha).'",
			"'.($this->MonId).'",
			
			'.(empty($this->PovTipoCambio)?'NULL, ':''.$this->PovTipoCambio.',').'
			"'.($this->PovObservacion).'",
			
			'.($this->PovMonto).',
			"'.($this->PovFoto).'",
			
			"'.($this->PovNumeroOperacion).'",
			
			'.($this->PovEstado).', 
			"'.($this->PovTiempoCreacion).'", 
			"'.($this->PovTiempoModificacion).'");';					


			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
//
			
			
		
		if($error) {	
			$this->InsMysql->MtdTransaccionPovhacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			
			$this->MtdAuditarPagoProveedor(1,"Se registro el Abono de Proveedor",$this);	
			return true;
		}		
				
			
	}
	
	
	
	public function MtdEditarPagoProveedor() {
		
		$sql = 'UPDATE tblpovpagoproveedor SET 
		
		'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
		PovFecha = "'.($this->PovFecha).'",
		MonId = "'.($this->MonId).'",
		'.(empty($this->PovTipoCambio)?'PovTipoCambio = NULL, ':'PovTipoCambio = '.$this->PovTipoCambio.',').'
		
		PovObservacion = "'.($this->PovObservacion).'",
		PovMonto = '.($this->PovMonto).',
		PovNumeroOperacion = "'.($this->PovNumeroOperacion).'",
		
		PovFoto = "'.($this->PovFoto).'",
		
		PovEstado = '.($this->PovEstado).',
		PovTiempoModificacion = "'.($this->PovTiempoModificacion).'"
		WHERE PovId = "'.($this->PovId).'";';
			
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
	
		if(!$resultado) {						
		  $error = true;
		} 	

			if($error) {						
				return false;
			} else {	
			
				$this->MtdAuditarPagoProveedor(2,"Se edito el Abono de Proveedor",$this);					
				return true;
			}						
				
		}	
		
		
		
		public function MtdEditarPagoProveedorDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblpovpagoproveedor SET 
			'.$oCampo.' = "'.($oDato).'",
			PovTiempoModificacion = NOW()
			WHERE PovId = "'.($oId).'";';
			
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
	





//
//		public function MtdNotificarPagoProveedorRegistro($oPagoProveedor,$oPovtinatario){
//			
//			$this->OcoId = $oPagoProveedor;
//			$this->MtdObtenerPagoProveedor();
//			
//			global $EmpresaMonedaId;
//			
//			$mensaje .= "NOTIFICACION DE REGISTRO:";	
//			$mensaje .= "<br>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Datos del Abono de Proveedor.";	
//			$mensaje .= "<br>";	
//
//			$mensaje .= "Codigo Interno: <b>".$this->PovId."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Fecha PagoProveedor: <b>".$this->PovFecha."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "A la Orden de: <b>";	
//			$mensaje .= "".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
//			$mensaje .= "".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."";	
//			$mensaje .= "".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."";	
//			$mensaje .= "</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Numero de Cheque: <b>".$this->PovNumeroCheque."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Cuenta Afecta: <b>".$this->BanNombre."/".$this->CueNumero."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Moneda: <b>".$this->MonNombre."</b>";	
//			$mensaje .= "<br>";	
//			
//			if($this->MonId<>$EmpresaMonedaId ){
//				$this->PovMonto = round($this->PovMonto / $this->PovTipoCambio,2);
//			}		
//
//			$mensaje .= "Monto: <b>".number_format($this->PovMonto,2)."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "<hr>";
//			$mensaje .= "<br>";
//			
//			$mensaje .= "Concepto: <b>".$this->PovConcepto."</b>";	
//			$mensaje .= "<br>";	
//
//					
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			
//					
//			
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
//			
//			//echo $mensaje;
//			$InsCorreo = new ClsCorreo();	
//			//$InsCorreo->MtdEnviarCorreo($oPovtinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO APREMBOLSO: ".$this->PovId." - ".$this->PovNumeroCheque." - ".$this->PovFecha,$mensaje);
//			$InsCorreo->MtdEnviarCorreo($oPovtinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO APREMBOLSO: ".$this->PovNumeroCheque." - ".$this->PovFecha,$mensaje);
//			
//		}
//		
		
		
		private function MtdAuditarPagoProveedor($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->PovId;
			$InsAuditoria->AudCodigoExtra = "";
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