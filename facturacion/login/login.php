<?phpheader("Content-Type: application/json");$response= array();include("../conexi.php");$link=Conectarse();$myusername=$_POST['rfc_emisores'];$mypassword=$_POST['password']; // To protect mysqli injection (more detail about mysqli injection)$myusername = stripslashes($myusername);$mypassword = stripslashes($mypassword); /* $myusername = mysqli_real_escape_string($myusername);$mypassword = mysqli_real_escape_string($mypassword); */$sql="SELECT * FROM  emisores	WHERE rfc_emisores='$myusername' 	AND password='$mypassword'";$result=mysqli_query($link, $sql);	if (!$result){		die('Error: ' . mysqli_error($link));	}$count=mysqli_num_rows($result);// Si la consulta devuelve 1 fila inicia la sesionif($count==1){	session_start();	session_regenerate_id(true);	$id_sesion = session_id();	$row = mysqli_fetch_assoc($result);	$id_usuario = $row["id_emisores"];	$nombre_usuario= $row["rfc_emisores"];	$_SESSION["id_usuarios"] = $id_usuario or die("Error al asignar id usuario");	//$_SESSION["usuario"] = $myusername or die("Error al iniciar variables de sesión");	$_SESSION["username"] = $nombre_usuario or die("Error al iniciar username");	$_SESSION["rfc_emisores"] = $row["rfc_emisores"] or die("Error al iniciar rfc");	$_SESSION["razon_social_emisores"] = $row["razon_social_emisores"] or die("Error al iniciar razon_social_emisores");	$_SESSION["lugar_expedicion"] = $row["lugar_expedicion_emisores"] or die("Error al iniciar lugar");	$_SESSION["regimen_emisores"] = $row["regimen_emisores"] or die("Error al iniciar lugar");	$_SESSION["password"] = $mypassword or die("Error al iniciar lugar");	$response["login"] = "valid";	$response["session"] = $_SESSION;}else{	$response["login"] = "invalid";		$response["mensaje"] = "Usuario y/o Contraseña Inválidos";}//$response["query"] = $sql;echo json_encode($response);?>