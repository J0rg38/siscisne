<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Avrcription of ClsAbonoProveedor
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAbonoProveedor {

    public $AvrId;
	
	public $PrvId;
	public $CliId;
	public $PerId;
	
	public $CueId;
    public $AvrFecha;
    public $MonId;
	
	public $AreId;
	
	public $AvrTipoCambio;
	public $AvrObservacion;
	public $AvrObservacionImpresa;
	public $AvrConcepto;
	
	public $AvrNumeroCheque;
	public $AvrReferencia;

	public $AvrMonto;
	public $AvrTipo;
	public $AvrFoto;
	public $AvrTipoAvrtino;

	public $AvrEstado;	
    public $AvrTiempoCreacion;
    public $AvrTiempoModificacion;
    public $AvrEliminado;
	
	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $PrvNumeroDocumento;
	public $TdoIdProveedr;
	
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;
	public $TdoIdCliente;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $PerNumeroDocumento;
	public $TdoIdPersonal;
	
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
		
	public function MtdGenerarAbonoProveedorId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(AvrId,5),unsigned)) AS "MAXIMO"
		FROM tblavrabonoproveedor';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->AvrId = "AVR-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->AvrId = "AVR-".$fila['MAXIMO'];					
		}

	}
		
    public function MtdObtenerAbonoProveedor($oCompleto=true){

        $sql = 'SELECT 
        avr.AvrId,
		avr.PrvId,
		
		DATE_FORMAT(avr.AvrFecha, "%d/%m/%Y") AS "NAvrFecha",
		avr.MonId,		
		avr.AvrTipoCambio,
		
		avr.AvrObservacion,		
		avr.AvrMonto,
		avr.AvrFoto,
		
		avr.AvrEstado,	
		DATE_FORMAT(avr.AvrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAvrTiempoCreacion",
        DATE_FORMAT(avr.AvrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAvrTiempoModificacion",
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,
		prv.TdoId,
		
		tdo.TdoNombre 
		
		
        FROM tblavrabonoproveedor des
			
		LEFT JOIN tblprvproveedor prv
		ON avr.PrvId = prv.PrvId
			
			LEFT JOIN tbltdotipodocumento tdo
			ON prv.TdoId = tdo.TdoId
			
				LEFT JOIN tblmonmoneda mon
				ON avr.MonId = mon.MonId
					
					
        WHERE AvrId = "'.$this->AvrId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->AvrId = $fila['AvrId'];
			$this->PrvId = $fila['PrvId'];		
			$this->AvrFecha = $fila['NAvrFecha'];
			$this->MonId = $fila['MonId'];
			$this->AvrTipoCambio = $fila['AvrTipoCambio'];
			$this->AvrObservacion = $fila['AvrObservacion'];
			
			$this->AvrMonto = $fila['AvrMonto'];
			$this->AvrFoto = $fila['AvrFoto'];			
			$this->AvrEstado = $fila['AvrEstado'];
			$this->AvrTiempoCreacion = $fila['NAvrTiempoCreacion'];
			$this->AvrTiempoModificacion = $fila['NAvrTiempoModificacion'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			$this->TdoNombre = $fila['TdoNombre'];
			
			
				switch($this->AvrEstado){
					case 1:
						$this->AvrEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->AvrEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->AvrEstadoDescripcion = "Anulado";
				
					break;
					
				}	
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerAbonoProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AvrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="AvrFecha",$oMoneda=NULL) {
		
		
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
			$estado = ' AND avr.AvrEstado = '.$oEstado;
		}	
		
		if(!empty($oMoneda)){
			$moneda = ' AND avr.MonId = "'.$oMoneda.'"';
		}	
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(avr.AvrFecha)>="'.$oFechaInicio.'" AND DATE(avr.AvrFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(avr.AvrFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(avr.AvrFecha)<="'.$oFechaFin.'"';		
			}			
		}

			  $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				avr.AvrId,
				avr.PrvId,
				
				DATE_FORMAT(avr.AvrFecha, "%d/%m/%Y") AS "NAvrFecha",
				avr.MonId,
				avr.AvrTipoCambio,
				avr.AvrObservacion,
				
				avr.AvrMonto,
				avr.AvrFoto,
			
				avr.AvrEstado,	
				DATE_FORMAT(avr.AvrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAvrTiempoCreacion",
                DATE_FORMAT(avr.AvrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAvrTiempoModificacion",

				mon.MonNombre,
				mon.MonSimbolo,
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId,
				
				tdo.TdoNombre
				
				FROM tblavrabonoproveedor des

					LEFT JOIN tblprvproveedor prv
					ON avr.PrvId = prv.PrvId
				
						LEFT JOIN tbltdotipodocumento tdo
						ON prv.TdoId = tdo.TdoId
				
							LEFT JOIN tblmonmoneda mon
							ON avr.MonId = mon.MonId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$vdirecta.$ovvehiculo.$cpago.$moneda.$tdestino.$factura.$boleta.$area.$fecha.$cuenta.$area.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAbonoProveedor = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AbonoProveedor = new $InsAbonoProveedor();				
					
                    $AbonoProveedor->AvrId = $fila['AvrId'];					
					$AbonoProveedor->PrvId = $fila['PrvId'];					
                    $AbonoProveedor->AvrFecha = $fila['NAvrFecha'];
					$AbonoProveedor->MonId = $fila['MonId'];
					$AbonoProveedor->AvrTipoCambio= $fila['AvrTipoCambio'];
					$AbonoProveedor->AvrObservacion = $fila['AvrObservacion'];					
					$AbonoProveedor->AvrMonto = $fila['AvrMonto'];
					$AbonoProveedor->AvrFoto = $fila['AvrFoto'];					
					$AbonoProveedor->AvrEstado = $fila['AvrEstado'];
                    $AbonoProveedor->AvrTiempoCreacion = $fila['NAvrTiempoCreacion'];
					$AbonoProveedor->AvrTiempoModificacion = $fila['NAvrTiempoModificacion'];

					$AbonoProveedor->MonNombre = $fila['MonNombre'];
					$AbonoProveedor->MonSimbolo = $fila['MonSimbolo'];
					
					$AbonoProveedor->PrvNombre = $fila['PrvNombre'];
					$AbonoProveedor->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$AbonoProveedor->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$AbonoProveedor->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$AbonoProveedor->TdoId = $fila['TdoId'];					
					$AbonoProveedor->TdoNombre = $fila['TdoNombre'];
					
					switch($AbonoProveedor->AvrEstado){
						case 1:
							$AbonoProveedor->AvrEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$AbonoProveedor->AvrEstadoDescripcion = "Realizado";
						break;
						
						case 6:
							$AbonoProveedor->AvrEstadoDescripcion = "Anulado";
					
						break;
						
					}	
				
                    $AbonoProveedor->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AbonoProveedor;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarAbonoProveedor($oElementos) {
		
		
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					//$sql = 'UPDATE tblavrabonoproveedor SET AvrEstado = '.$oEstado.' WHERE   AvrId = "'.($elemento).'" ';
					$sql = 'DELETE FROM  tblavrabonoproveedor WHERE  AvrId = "'.($elemento).'" ';
					
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarAbonoProveedor(3,"Se elimino el Abono de Proveedor",$aux);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionAvrhacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}	
			
							
	}
	
	

	public function MtdActualizarEstadoAbonoProveedor($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					
					$sql = 'UPDATE tblavrabonoproveedor SET AvrEstado = '.$oEstado.' WHERE   AvrId = "'.($elemento).'" ';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarAbonoProveedor(2,"Se actualizo el Estado del Abono de Proveedor",$elemento);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionAvrhacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}							
	}



	public function MtdRegistrarAbonoProveedor() {
	
	
	$this->InsMysql->MtdTransaccionIniciar();
	
	$error = false;
	
			$this->MtdGenerarAbonoProveedorId();
		
			$sql = 'INSERT INTO tblavrabonoproveedor (
			AvrId,
			PrvId,
			AvrFecha,
			MonId,
			
			AvrTipoCambio,
			AvrObservacion,
			AvrMonto,
		
			AvrFoto,
			
			AvrEstado,
			AvrTiempoCreacion,
			AvrTiempoModificacion
			) 
			VALUES (
			"'.($this->AvrId).'", 

			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			

			"'.($this->AvrNumeroCheque).'",
			"'.($this->AvrReferencia).'",
						
			"'.($this->AvrFecha).'",
			"'.($this->MonId).'",
			
			'.(empty($this->AvrTipoCambio)?'NULL, ':''.$this->AvrTipoCambio.',').'
			"'.($this->AvrObservacion).'",
			
			'.($this->AvrMonto).',
			"'.($this->AvrFoto).'",
		
			'.($this->AvrEstado).', 
			"'.($this->AvrTiempoCreacion).'", 
			"'.($this->AvrTiempoModificacion).'");';					


			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
//
			
			
		
		if($error) {	
			$this->InsMysql->MtdTransaccionAvrhacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			
			$this->MtdAuditarAbonoProveedor(1,"Se registro el Abono de Proveedor",$this);	
			return true;
		}		
				
			
	}
	
	
	
	public function MtdEditarAbonoProveedor() {
		
		$sql = 'UPDATE tblavrabonoproveedor SET 
		
		'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
		AvrFecha = "'.($this->AvrFecha).'",
		MonId = "'.($this->MonId).'",
		'.(empty($this->AvrTipoCambio)?'AvrTipoCambio = NULL, ':'AvrTipoCambio = '.$this->AvrTipoCambio.',').'
		
		AvrObservacion = "'.($this->AvrObservacion).'",
		AvrMonto = '.($this->AvrMonto).',
		AvrFoto = "'.($this->AvrFoto).'",
	
		AvrEstado = '.($this->AvrEstado).',
		AvrTiempoModificacion = "'.($this->AvrTiempoModificacion).'"
		WHERE AvrId = "'.($this->AvrId).'";';
			
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
	
		if(!$resultado) {						
		  $error = true;
		} 	

			if($error) {						
				return false;
			} else {	
			
				$this->MtdAuditarAbonoProveedor(2,"Se edito el Abono de Proveedor",$this);					
				return true;
			}						
				
		}	
		
		
		
		public function MtdEditarAbonoProveedorDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblavrabonoproveedor SET 
			'.$oCampo.' = "'.($oDato).'",
			AvrTiempoModificacion = NOW()
			WHERE AvrId = "'.($oId).'";';
			
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
//		public function MtdNotificarAbonoProveedorRegistro($oAbonoProveedor,$oAvrtinatario){
//			
//			$this->OcoId = $oAbonoProveedor;
//			$this->MtdObtenerAbonoProveedor();
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
//			$mensaje .= "Codigo Interno: <b>".$this->AvrId."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Fecha AbonoProveedor: <b>".$this->AvrFecha."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "A la Orden de: <b>";	
//			$mensaje .= "".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
//			$mensaje .= "".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."";	
//			$mensaje .= "".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."";	
//			$mensaje .= "</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Numero de Cheque: <b>".$this->AvrNumeroCheque."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Cuenta Afecta: <b>".$this->BanNombre."/".$this->CueNumero."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Moneda: <b>".$this->MonNombre."</b>";	
//			$mensaje .= "<br>";	
//			
//			if($this->MonId<>$EmpresaMonedaId ){
//				$this->AvrMonto = round($this->AvrMonto / $this->AvrTipoCambio,2);
//			}		
//
//			$mensaje .= "Monto: <b>".number_format($this->AvrMonto,2)."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "<hr>";
//			$mensaje .= "<br>";
//			
//			$mensaje .= "Concepto: <b>".$this->AvrConcepto."</b>";	
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
//			//$InsCorreo->MtdEnviarCorreo($oAvrtinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO APREMBOLSO: ".$this->AvrId." - ".$this->AvrNumeroCheque." - ".$this->AvrFecha,$mensaje);
//			$InsCorreo->MtdEnviarCorreo($oAvrtinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO APREMBOLSO: ".$this->AvrNumeroCheque." - ".$this->AvrFecha,$mensaje);
//			
//		}
//		
		
		
		private function MtdAuditarAbonoProveedor($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->AvrId;
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