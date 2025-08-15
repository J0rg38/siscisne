<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsConfiguracion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsConfiguracion {

    public $EmpresaNombre;
	public $EmpresaNombreComercial;
    public $EmpresaCodigo;
	public $EmpresaEmail;
	public $EmpresaWeb;	
	public $EmpresaTelefono;	
	public $EmpresaCelular;	
	public $EmpresaFax;	
	public $EmpresaPais;	
	public $EmpresaCiudad;	
	public $EmpresaDireccion;	
	public $EmpresaDepartamento;	
	public $EmpresaDistrito;	
	public $EmpresaProvincia;		
	public $EmpresaLogo;
    public $EmpresaMonedaId;	
	public $EmpresaMoneda;	
	public $EmpresaMonedaNombre;	
	
	public $EmpresaImpuestoVenta;
	public $EmpresaImpuestoRenta;
	
	public $ConexionBdHost;
	public $ConexionBdPuerto;
	public $ConexionBdUsuario;
	public $ConexionBdContrasena;
	public $ConexionBdNombre;
	
	public $SistemaVersion;	
	public $SistemaNombre;
	public $SistemaAutor;
	public $SistemaContacto;
	public $SistemaTipo;
	public $SistemaTiempoCreacion;	
	public $SistemaTiempoModificacion;	
	
	public $TiempoCreacion;
    public $TiempoModificacion;
	
    public $Eliminado;
	
	private $ConexionXml;	
	private $EmpresaXml;
	private $ImpuestoXml;
	private $SistemaXml;
	
	private $ConexionPhp;	
	private $EmpresaPhp;
	private $ImpuestoPhp;
	private $SistemaPhp;
	
	public $ConRuta;
	
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
	
	public function MtdObtenerConfiguracionEmpresa(){
		
		if (file_exists($this->ConRuta.'/'.$this->EmpresaXml)) {
			 
			 $XmlConfiguracion = simplexml_load_file($this->ConRuta.'/'.$this->EmpresaXml);


			 if($XmlConfiguracion){

				foreach ($XmlConfiguracion->CnfEmpresa as $DatCnfEmpresa) { 
	
					$this->EmpresaNombre = $DatCnfEmpresa->EmpresaNombre;
					$this->EmpresaNombreComercial = $DatCnfEmpresa->EmpresaNombreComercial;
					$this->EmpresaCodigo = $DatCnfEmpresa->EmpresaCodigo;
					$this->EmpresaEmail = $DatCnfEmpresa->EmpresaEmail;
					$this->EmpresaWeb = $DatCnfEmpresa->EmpresaWeb;
					$this->EmpresaTelefono = $DatCnfEmpresa->EmpresaTelefono;
					$this->EmpresaFax = $DatCnfEmpresa->EmpresaFax;
					$this->EmpresaPais = $DatCnfEmpresa->EmpresaPais;
					$this->EmpresaCiudad = $DatCnfEmpresa->EmpresaCiudad;
					$this->EmpresaDireccion = $DatCnfEmpresa->EmpresaDireccion;
					$this->EmpresaDepartamento = $DatCnfEmpresa->EmpresaDepartamento;
					$this->EmpresaDistrito = $DatCnfEmpresa->EmpresaDistrito;
					$this->EmpresaProvincia = $DatCnfEmpresa->EmpresaProvincia;
					$this->EmpresaLogo = $DatCnfEmpresa->EmpresaLogo;
					$this->EmpresaMonedaId = $DatCnfEmpresa->EmpresaMonedaId;
					$this->EmpresaMoneda = $DatCnfEmpresa->EmpresaMoneda;
					$this->EmpresaMonedaNombre = $DatCnfEmpresa->EmpresaMonedaNombre;
					$this->EmpresaImpuestoVenta = $DatCnfEmpresa->EmpresaImpuestoVenta;
					$this->EmpresaImpuestoRenta = $DatCnfEmpresa->EmpresaImpuestoRenta;				

				}
				
				$Respuesta =  $this;
				
				
				
			 }else{
				 $Respuesta =   NULL;
			 }
			 
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;
    }
	

	 public function MtdObtenerConfiguracionConexion(){
		
		
		if (file_exists($this->ConRuta.'/'.$this->ConexionXml)) {
			 
			 $XmlConfiguracion = simplexml_load_file($this->ConRuta.'/'.$this->ConexionXml);
			 
			 if($XmlConfiguracion){
			 
				foreach ($XmlConfiguracion->CnfConexion as $DatCnfConexion) { 
	
					$this->ConexionBdHost = $DatCnfConexion->ConexionBdHost;
					$this->ConexionBdPuerto = $DatCnfConexion->ConexionBdPuerto;
					$this->ConexionBdUsuario = $DatCnfConexion->ConexionBdUsuario;
					$this->ConexionBdContrasena = $DatCnfConexion->ConexionBdContrasena;
					$this->ConexionBdNombre = $DatCnfConexion->ConexionBdNombre;															
					
				}
				
				$Respuesta =  $this;
				
			 }else{
				 $Respuesta =   NULL;
			 }
			 
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;
    }	
	
	
	public function MtdObtenerConfiguracionSistema(){
		
		
		if (file_exists($this->ConRuta.'/'.$this->SistemaXml)) {
			 
			 $XmlConfiguracion = simplexml_load_file($this->ConRuta.'/'.$this->SistemaXml);
			 
			 if($XmlConfiguracion){
			 
				foreach ($XmlConfiguracion->CnfSistema as $DatCnfSistema) { 
	
					$this->SistemaVersion = $DatCnfSistema->SistemaVersion;
					$this->SistemaNombre = $DatCnfSistema->SistemaNombre;
					$this->SistemaAutor = $DatCnfSistema->SistemaAutor;
					$this->SistemaContacto = $DatCnfSistema->SistemaContacto;
					$this->SistemaTipo = $DatCnfSistema->SistemaTipo;															
					$this->SistemaTiempoCreacion = $DatCnfSistema->SistemaTiempoCreacion;															
					$this->SistemaTiempoModificacion = $DatCnfSistema->SistemaTiempoModificacion;															
					
				}
				
				$Respuesta =  $this;
				
			 }else{
				 $Respuesta =   NULL;
			 }
			 
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;
    }	
	
	public function MtdEditarConfiguracionEmpresa() {
		
	$cadena = '<?xml version="1.0" encoding="utf-8"?>'.	chr(13).
			'<bloque>'.	chr(13).
			'<CnfEmpresa>'.	chr(13).
			'<EmpresaNombre>'.($this->EmpresaNombre).'</EmpresaNombre>'.chr(13).
			'<EmpresaNombreComercial>'.($this->EmpresaNombreComercial).'</EmpresaNombreComercial>'.chr(13).
			'<EmpresaCodigo>'.($this->EmpresaCodigo).'</EmpresaCodigo>'.chr(13).
			'<EmpresaEmail>'.($this->EmpresaEmail).'</EmpresaEmail>'.chr(13).
			'<EmpresaWeb>'.($this->EmpresaWeb).'</EmpresaWeb>'.chr(13).
			'<EmpresaTelefono>'.($this->EmpresaTelefono).'</EmpresaTelefono>'.chr(13).
			'<EmpresaCelular>'.($this->EmpresaCelular).'</EmpresaCelular>'.chr(13).
			'<EmpresaFax>'.($this->EmpresaFax).'</EmpresaFax>'.chr(13).
			'<EmpresaPais>'.($this->EmpresaPais).'</EmpresaPais>'.	chr(13).
			'<EmpresaCiudad>'.($this->EmpresaCiudad).'</EmpresaCiudad>'.chr(13).
			'<EmpresaDireccion>'.($this->EmpresaDireccion).'</EmpresaDireccion>'.chr(13).
			'<EmpresaDepartamento>'.($this->EmpresaDepartamento).'</EmpresaDepartamento>'.chr(13).
			'<EmpresaDistrito>'.($this->EmpresaDistrito).'</EmpresaDistrito>'.chr(13).
			'<EmpresaProvincia>'.($this->EmpresaProvincia).'</EmpresaProvincia>'.chr(13).
			'<EmpresaLogo>'.($this->EmpresaLogo).'</EmpresaLogo>'.	chr(13).
			'<EmpresaMonedaId>'.($this->EmpresaMonedaId).'</EmpresaMonedaId>'.chr(13).
			'<EmpresaMoneda>'.($this->EmpresaMoneda).'</EmpresaMoneda>'.chr(13).
			'<EmpresaMonedaNombre>'.($this->EmpresaMonedaNombre).'</EmpresaMonedaNombre>'.chr(13).			

			'<EmpresaImpuestoVenta>'.($this->EmpresaImpuestoVenta).'</EmpresaImpuestoVenta>'.chr(13).
			'<EmpresaImpuestoRenta>'.($this->EmpresaImpuestoRenta).'</EmpresaImpuestoRenta>'.chr(13).
			'<TiempoCreacion>'.($this->TiempoCreacion).'</TiempoCreacion>'.chr(13).
			'<TiempoModificacion>'.($this->TiempoModificacion).'</TiempoModificacion>'.chr(13).
			'</CnfEmpresa>'.chr(13).
			'</bloque> ';
			
			
	
			$Archivo = fopen($this->ConRuta.'/'.$this->EmpresaXml,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);
			}else{
				$error = true;
			}
			

			/*$cadena = '<?php'.	chr(13).
			'$EmpresaNombre = "'.$this->EmpresaNombre.'";'.	chr(13).
			'$EmpresaNombreComercial = "'.$this->EmpresaNombreComercial.'";'.	chr(13).
			'$EmpresaCodigo = "'.$this->EmpresaCodigo.'";'.	chr(13).			
			'$EmpresaEmail = "'.$this->EmpresaEmail.'";'.	chr(13).
			'$EmpresaWeb = "'.$this->EmpresaWeb.'";'.	chr(13).
			'$EmpresaTelefono = "'.$this->EmpresaTelefono.'";'.	chr(13).
			'$EmpresaFax = "'.$this->EmpresaFax.'";'.	chr(13).
			'$EmpresaPais = "'.$this->EmpresaCiudad.'";'.	chr(13).			
			'$EmpresaDireccion = "'.$this->EmpresaDireccion.'";'.	chr(13).			
			'$EmpresaDepartamento = "'.$this->EmpresaDepartamento.'";'.	chr(13).			
			'$EmpresaDistrito = "'.$this->EmpresaDistrito.'";'.	chr(13).
			'$EmpresaProvincia = "'.$this->EmpresaProvincia.'";'.	chr(13).				
			'$EmpresaLogo = "'.$this->EmpresaLogo.'";'.	chr(13).	
			'$EmpresaMonedaId = "'.$this->EmpresaMonedaId.'";'.	chr(13).			
			'$EmpresaMoneda = "'.$this->EmpresaMoneda.'";'.	chr(13).		
			'$EmpresaMonedaNombre = "'.$this->EmpresaMonedaNombre.'";'.	chr(13).						
			'$EmpresaImpuestoVenta = "'.$this->EmpresaImpuestoVenta.'";'.	chr(13).
			'$EmpresaImpuestoRenta = "'.$this->EmpresaImpuestoRenta.'";'.	chr(13).					
			'?>'.chr(13);
				
			$Archivo = fopen($this->ConRuta.$this->EmpresaPhp,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);
			}else{
				$error = true;
			}*/
				
		
			if($error) {						
				return false;
			} else {				
				return true;
			}	
						
				
	}	
		
		

	
	
	public function MtdEditarConfiguracionConexion() {
		
			$cadena = '<?xml version="1.0" encoding="utf-8"?>'.chr(13).
			'<bloque>'.chr(13).
			'<CnfConexion>'.chr(13).
			'<ConexionBdHost>'.($this->ConexionBdHost).'</ConexionBdHost>'.chr(13).
			'<ConexionBdPuerto>'.($this->ConexionBdPuerto).'</ConexionBdPuerto>'.chr(13).
			'<ConexionBdUsuario>'.($this->ConexionBdUsuario).'</ConexionBdUsuario>'.chr(13).
			'<ConexionBdContrasena>'.($this->ConexionBdContrasena).'</ConexionBdContrasena>'.chr(13).
			'<ConexionBdNombre>'.($this->ConexionBdNombre).'</ConexionBdNombre>'.chr(13).
			'</CnfConexion>'.chr(13).
			'</bloque> ';
		
			$Archivo = fopen($this->ConRuta.'/'.$this->ConexionXml,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);						
			}else{
				$error = true;
			}
		
		
			/*$cadena = '<?php'.	chr(13).
			'$ConexionBdHost = "'.$this->ConexionBdHost.'";'.	chr(13).
			'$ConexionBdPuerto = "'.$this->ConexionBdPuerto.'";'.	chr(13).
			'$ConexionBdUsuario = "'.$this->ConexionBdUsuario.'";'.	chr(13).			
			'$ConexionBdContrasena = "'.$this->ConexionBdContrasena.'";'.	chr(13).
			'$ConexionBdNombre = "'.$this->ConexionBdNombre.'";'.	chr(13).
			'?>'.chr(13);
				
			$Archivo = fopen($this->ConRuta.$this->ConexionPhp,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);
			}else{
				$error = true;
			}*/
			
			
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	
	
	public function MtdEditarConfiguracionSistema() {
		
			$cadena = '<?xml version="1.0" encoding="utf-8"?>'.chr(13).
			'<bloque>'.chr(13).
			'<CnfSistema>'.chr(13).
			'<SistemaVersion>'.($this->SistemaVersion).'</SistemaVersion>'.chr(13).
			'<SistemaNombre>'.($this->SistemaNombre).'</SistemaNombre>'.chr(13).
			'<SistemaAutor>'.($this->SistemaAutor).'</SistemaAutor>'.	chr(13).
			'<SistemaTipo>'.($this->SistemaTipo).'</SistemaTipo>'.chr(13).
			'<SistemaTiempoCreacion>'.($this->SistemaTiempoCreacion).'</SistemaTiempoCreacion>'.chr(13).
			'<SistemaTiempoModificacion>'.($this->SistemaTiempoModificacion).'</SistemaTiempoModificacion>'.chr(13).
			'</CnfSistema>'.chr(13).
			'</bloque> ';
		
			$Archivo = fopen($this->ConRuta.'/'.$this->SistemaXml,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);						
			}else{
				$error = true;
			}
			
			/*$cadena = '<?php'.	chr(13).
			'$SistemaVersion = "'.$this->SistemaVersion.'";'.	chr(13).
			'$SistemaNombre = "'.$this->SistemaNombre.'";'.	chr(13).
			'$SistemaAutor = "'.$this->SistemaAutor.'";'.	chr(13).			
			'$SistemaTiempoCreacion = "'.$this->SistemaTiempoCreacion.'";'.	chr(13).
			'$SistemaTiempoModificacion = "'.$this->SistemaTiempoModificacion.'";'.	chr(13).
			'?>'.chr(13);
				
			$Archivo = fopen($this->ConRuta.$this->SistemaPhp,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);
			}else{
				$error = true;
			}*/
			
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
}
?>