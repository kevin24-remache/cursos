<?php
if (!function_exists('formatear_nombre_apellido')) {
    function formatear_nombre_apellido($nombres, $apellidos)
    {
        // Nombres
        $partes_nombre = explode(" ", $nombres);
        if (count($partes_nombre) > 1) {
            $segundo_nombre_formateado = substr($partes_nombre[1], 0, 1) . str_repeat("x", max(0, 7));  // 1 letra + 7 'x'
            $nombre_formateado = $partes_nombre[0] . ' ' . $segundo_nombre_formateado;
        } else {
            $nombre_formateado = $partes_nombre[0] . str_repeat("", max(0, 8 - strlen($partes_nombre[0])));
        }

        // Apellidos
        $partes_apellido = explode(" ", $apellidos);
        if (count($partes_apellido) > 1) {
            $apellido1_formateado = substr($partes_apellido[0], 0, 1) . str_repeat("x", 7);
            $apellido2_formateado = substr($partes_apellido[1], 0, 1) . str_repeat("x", 7);
            $apellidos_formateados = $apellido1_formateado . " " . $apellido2_formateado;
        } else {
            $apellidos_formateados = substr($partes_apellido[0], 0, 1) . str_repeat("x", 7);
        }

        return [
            'nombres' => $nombre_formateado,
            'apellidos' => $apellidos_formateados
        ];
    }
}