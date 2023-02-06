
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Logueo</title>
</head>
<script language="JavaScript">
function Login(){
var done=0;
var username=document.login.username.value;
username=username.toLowerCase();
var password=document.login.password.value;
password=password.toLowerCase();
if (username=="usuario" && password=="contraseña") { window.location="logueado.php"; done=1; }
if (done==0) { window.location="index.php"; }
}
</script>

<body>
<form name=login>
Usuario: <input type=text name=username>
Contrase&ntilde;a: <input type=password name=password>
<input type=button value="Entrar" onClick="Login()">
</form>
</body>
</html> 
Crear un sistema de nombre de usuario i contraseña con Javascript.php

