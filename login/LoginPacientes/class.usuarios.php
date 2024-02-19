<?php
class usuario{
	private $IdUsuario;
	private $usuario;
	private $Nombre;
	private $Rol;
	private $NombreRol;

	private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}

		public function bienvenida_usuario(){

			$usuario = $_SESSION['usuario'];
			$Rol = $_SESSION['Rol'];

			$sql = "SELECT u.IdUsuario, u.Nombre, u.Rol, r.Nombre as NombreRol
			FROM usuarios u, roles r
			WHERE u.Rol=r.IdRol and IdUsuario = '$usuario';";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de enviar la consulta";
                echo $this->_message_error($mensaje);
            }else{   
			
				$this->IdUsuario = $row['IdUsuario'];
				$this->Nombre = $row['Nombre'];
				$this->NombreRol = $row['NombreRol'];
				$Rol = $row['Rol'];

			}
			
			if ($Rol == 1) {
				echo "Bienvenido $this->NombreRol";
				//$html = "<script>alert('Bienvenido " . $this->UsuarioPersona . "');
                //window.location.href = '../admin/index.html';
                //</script>";
			} elseif ($Rol == 2) {
				echo "Bienvenido $this->NombreRol";
				//$html = "<script>alert('Bienvenido " . $this->UsuarioPersona . "');
                //window.location.href = '../profesor/index.php';
                //</script>";
			} elseif ($Rol == 3) {
				echo "Bienvenido $this->NombreRol";
				header("Location: ../../Paciente/index.html");
				exit;
				//$html = "<script>alert('Bienvenido " . $this->UsuarioPersona . "');
                //window.location.href = '../estudiante/index.php';
                //</script>";				
			} 

		
		//echo $html;
		}

	private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto){
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla where Rol=3;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}
	

	public function get_login(){
		
		
		$sql = "SELECT IdUsuario
		FROM usuarios;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de enviar la consulta";
                echo $this->_message_error($mensaje);
            }else{   
			
				$this->IdUsuario = $row['IdUsuario'];

			}
		

			$html = '
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6">
						<div class="card mt-5">
							<div class="card-body">
								<h2 class="card-title text-center">Formulario de login</h2>
								<form name="login" method="POST" action="validar.php" enctype="multipart/form-data">
									<div class="form-group">
										<label for="usuario">Usuario</label>
										' . $this->_get_combo_db("usuarios", "IdUsuario", "Nombre", "usuario", $this->IdUsuario) . '
									</div>
									
									<div class="form-group">
										<label for="clave">Contraseña</label>
										<input type="password" class="form-control" id="clave" placeholder="&#128272; Contraseña" name="clave" value="123">
									</div>
									
									<button class="btn btn-primary btn-block" type="submit" name="LOGIN">Iniciar sesión</button>
									<a href="../index.html" class="btn btn-danger btn-block">Cancelar</a>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		';

		return $html;

	}
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//****************************************************************************	
	
} // FIN SCRPIT
?>

