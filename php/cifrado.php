<?php

// Define la clave de cifrado y el método de cifrado
define('KEY_CIFRADO', 'FERRE.2023-mon--2598301*');
define('METODO_CIFRADO', 'aes-128-cbc');

// Esta función cifra un conjunto de datos utilizando la clave y el método de cifrado definidos.
function cifrar($data)
{
    // Obtiene la longitud del vector de inicialización (IV) para el método de cifrado
    $iv_length = openssl_cipher_iv_length(METODO_CIFRADO);

    // Genera un IV aleatorio
    $iv = openssl_random_pseudo_bytes($iv_length);

    // Cifra los datos utilizando la clave, el método de cifrado, el IV y los datos de entrada
    $cipher = openssl_encrypt($data, METODO_CIFRADO, KEY_CIFRADO, OPENSSL_RAW_DATA, $iv);

    // Devuelve una cadena que incluye el IV y los datos cifrados, separados por ':'
    return base64_encode($iv) . ':' . base64_encode($cipher);
}

// Esta función descifra una cadena cifrada utilizando la clave y el método de cifrado definidos.
function descifrar($input)
{
    // Divide la cadena cifrada en dos partes: IV y datos cifrados
    $parts = explode(':', $input);
    $iv = base64_decode($parts[0]);
    $cipher = base64_decode($parts[1]);

    // Descifra los datos utilizando la clave, el método de cifrado, el IV y los datos cifrados
    return openssl_decrypt($cipher, METODO_CIFRADO, KEY_CIFRADO, OPENSSL_RAW_DATA, $iv);
}
