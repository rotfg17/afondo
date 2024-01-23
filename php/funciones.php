<?php

// Función que verifica si alguno de los elementos en un array es nulo o vacío
function esNulo(array $parametros)
{
    foreach ($parametros as $parametro) {
        if (strlen(trim($parametro)) < 1) {
            return true;
        }
    }
    return false;
}

// Función que verifica si una cadena es una dirección de correo electrónico válida
function esEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

// Función que verifica si dos contraseñas son iguales
function validaPassword($password, $repassword)
{
    if (strcmp($password, $repassword) !== 0) {
        return true;
    }
    return false;
}

// Función que genera un token aleatorio
function generarToken()
{
    return md5(uniqid(mt_rand(), false));
}

// Función que registra un cliente en la base de datos
function registrar(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO autor (nombres, email, activo) VALUES(?, ?, 1)");
    if ($sql->execute($datos)) {
        return $con->lastInsertId();
    }
    return 0;
}

// Función que registra un usuario en la base de datos
function registraUsuario(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO usuarios (usuario, password,  token,  id_autor)VALUES (?, ?, ?, ?)");
    if($sql->execute($datos)){
        return true;
    }
    return false;
}


// Función que verifica si un usuario ya existe en la base de datos
function usuarioExiste($usuario, $con)
{
    $sql = $con->prepare("SELECT id  FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

// Función que verifica si un correo electrónico ya existe en la base de datos
function emailExiste($email, $con)
{
    $sql = $con->prepare("SELECT id  FROM autor WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

// Función que muestra mensajes de error
function mostrarMensajes(array $errors)
{
    if (count($errors) > 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}



// Función que valida un token para activar un usuario
function validaToken($id, $token, $con)
{
    $msg = "";
    $sql = $con->prepare("SELECT id  FROM usuarios WHERE id  = ? AND token LIKE ? LIMIT 1");
    $sql->execute([$id, $token]);
    if ($sql->fetchColumn() > 0) {
        if (activarUsuario($id, $con)) {
            header("location: index.php");
            exit;
    } else {
        $msg = "Error al activar cuenta."; 
    }

    } else {
        $msg = "No existe registro del autor.";
    }
    return $msg;

}


// Función que activa un usuario en la base de datos
function activarUsuario($id, $con)
{
    $sql = $con->prepare("UPDATE usuarios SET activacion = 1, token = '' WHERE id = ? ");
    return $sql->execute([$id]);
}


function slugify($text)
{
    // Reemplaza los caracteres especiales y espacios con guiones
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // Convierte a minúsculas
    $text = mb_strtolower($text, 'UTF-8');

    // Elimina cualquier caracter no alfanumérico o guiones adicionales
    $text = preg_replace('~[^-\w]+~', '', $text);

    // Elimina guiones al principio y al final del texto
    $text = trim($text, '-');

    return $text;
}




// Función que realiza el proceso de inicio de sesión
function login($usuario, $password, $con)
{
    $sql = $con->prepare("SELECT id,  password FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (esActivo($usuario, $con)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION["user_id"] = $row['id'];
                $_SESSION["user_name"] = $row['usuario'];
                header("location: inicio.php");
                exit;
            }
        } else {
            return "El autor no ha sido activado.";
        }
    }
    return "El autor y/o contraseña son incorrectos.";
}

// Función que verifica si un usuario está activo
function esActivo($usuario, $con)
{
    $sql = $con->prepare("SELECT activacion FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row['activacion'] == 1) {
        return true;
    }
    return false;
}


// Función que genera un token para solicitar restablecimiento de contraseña
function solicitaPassword($user_id, $con)
{
    $token = generarToken();
    
    $sql = $con->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");
    if ($sql->execute([$token, $user_id])) {
        return $token;
    }
    return null;
}

// Función que verifica si un token de solicitud de restablecimiento de contraseña es válido
function verificaTokenRequest($user_id, $token, $con)
{
    $sql = $con->prepare("SELECT id FROM usuarios WHERE id=? AND token_password LIKE ? AND password_request=1 LIMIT 1");
    $sql->execute([$user_id, $token]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

// Función que activa la contraseña después de restablecerla
function activaPassword($user_id, $password, $con)
{
    $sql = $con->prepare("UPDATE usuarios SET password=?, token_password = '', password_request = 0 WHERE id=?");
    if ($sql->execute([$password, $user_id])) {
        return true;
    }
    return false;
}