<?php

declare(strict_types=1);

namespace Requests;

final class LibroRequest
{
    //Tamaño de la foto
    const TAM_MAX = 500 * 1024;
    const GENEROS = ['novela', 'ciencia ficción', 'terror'];

    private array $datos = [];
    private array $errores = [];
    private array $archivo = [];
    private string $extension = '';

    public function __construct(array $entrada, array $archivo)
    {
        $this->archivo = $archivo;

        $this->sanear($entrada);
        $this->validar();
        $this ->validarFoto();
    }

    private function sanear(array $entrada): void
    {

        $titulo = $entrada['titulo'] ?? '';
        $autor = $entrada['autor'] ?? '';
        $genero = $entrada['genero'] ?? '';
        $anio = $entrada['anio'] ?? null;
        $paginas = $entrada['paginas'] ?? null;
        $portada = $entrada['portada'] ?? '';

        $this->datos = [
            'titulo' => is_string($titulo) ? trim($titulo) : '',
            'autor' => is_string($autor) ? $autor : '',
            'genero' => is_string($genero) ? $genero : '',
            'anio' => is_string($anio) ? trim($anio) : null,
            'paginas' => is_string($paginas) ? $paginas : null,
            'portada' => is_string($portada) ? $portada : ''
        ];
    }

    private function validar(): void
    {
        if ($this->datos['titulo'] === '')
        {
            $this->errores['titulo'] = 'El titulo es obligatorio';
        }

        if ($this->datos['autor'] === '')
        {
            $this->errores['autor'] = 'El autor es obligatorio';
        }

        $genero1 = ($this->datos['genero'] === GENEROS[0]);
        $genero2 = ($this->datos['genero'] === GENEROS[1]);
        $genero3 = ($this->datos['genero'] === GENEROS[2]);

        if (!$genero1 || !$genero2 || !$genero3)
        {
            $this->errores['genero'] = 'El genero introducido es erroneo';
        }

        $anioNum = (int)($this->datos['anio']);

        if ($anioNum <= 0)
        {
            $this->errores['anio'] = 'Tiene que ser mayor a 0';
        }

        $numPaginas = (int)($this->datos['paginas']);

        if ($numPaginas <= 0)
        {
            $this->errores['paginas'] = 'El Nº de paginas tiene que ser mayor a 0';
        }
    }

    
    private function validarFoto(): void
    {
        $foto = $this->archivo;

        if (($foto['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK)
        {
            $this->errores['imagen'] = 'Selecciona una imagen válida.';
        }
        elseif ($foto['size'] > self::TAM_MAX)
        {
            $this->errores['imagen'] = 'La imagen supera los 2 MB.';
        }
        elseif (!is_uploaded_file($foto['tmp_name']))
        {
            $this->errores['imagen'] = 'El archivo no procede de una subida HTTP.';
        }
        else
        {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeReal = $finfo->file($foto['tmp_name']);

            $permitidos = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'webp'
            ];

            if (!isset($permitidos[$mimeReal]))
            {
                $this->errores['imagen'] = 'Solo se permiten JPG, PNG y WEBP.';
            }
            else
            {
                $this->extension = $permitidos[$mimeReal];
            }
        }
    }

    public function guardarFoto(string $directorio): string
    {
        $nombre = '';

        if ($this->esValido() && $this->extension !== '')
        {
            if (!is_dir($directorio))
            {
                if (!mkdir($directorio, 0755, true))
                {
                    $this->errores['imagen'] = 'No se pudo crear la carpeta.';
                }
            }

            if ($this->esValido())
            {
                $nombreFinal = date('Ymd_His') . '_'
                    . bin2hex(random_bytes(4))
                    . '.' . $this->extension;

                if (move_uploaded_file(
                    $this->archivo['tmp_name'],
                    $directorio . $nombreFinal
                ))
                {
                    $nombre = $nombreFinal;
                }
                else
                {
                    $this->errores['imagen'] = 'No se pudo guardar la imagen.';
                }
            }
        }

        return $nombre;
    }

    public function esValido(): bool
    {
        return $this->errores === [];
    }

    public function datos(): array
    {
        return $this->datos;
    }

    public function errores(): array
    {
        return $this->errores;
    }
}
