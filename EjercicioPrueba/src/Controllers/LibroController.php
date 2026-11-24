<?php
declare(strict_types=1);

namespace Controllers;

use Core\Pages;
use Models\Libro;
use Requests\LibroRequest;

/** Controlador del modelo Libro. */
final class LibroController
{
    /** Muestra el formulario de alta. (YA HECHO) */
    public function create(): void
    {
        new Pages()->render('libro/formulario');
    }

    /** Procesa el alta de un libro. */
    public function store(): void
    {
        // TODO (apartado 4): crear new LibroRequest($_POST, $_FILES).
        //      Si no es válido -> render('libro/formulario') con 'errores' y 'datos', y return.

        if($_SERVER['REQUEST_METHOD'] !== 'POST') 
            {
                $this->create();
                return;
            }


        $request = new LibroRequest($_POST, $_FILES);

        if (!$request->esValido())
        {
            new Pages()->render('libro/formulario', [
                "errores" => $request->errores()
            ]);
            return;
        }

        //
        // TODO (apartado 5):
        //      1. Generar el nombre único de la imagen (todavía no se mueve).
        //      2. Crear el objeto Libro con ese nombre de portada.
        //      3. Si existe() -> render('libro/formulario') con $errores['general'], y return.
        //      4. Mover la imagen a RUTA_IMG.
        //
        // TODO (apartado 6):
        //      guardar() -> render('libro/formulario') con 'mensaje' y 'libro'.
        //      Si falla -> borrar la imagen que ya se había movido y mostrar un error.
    }

    /** Muestra el catálogo. */
    public function index(): void
    {
        $libros = [];

        // TODO (apartado 3): rellenar $libros leyendo RUTA_BIBLIOTECA línea por línea
        //      (un array de objetos Libro).
        $ruta = BASE_PATH . "/data/biblioteca.txt";

        $contenido = file_get_contents($ruta);

        $librosInfo = json_decode($contenido, true);

        foreach($librosInfo as $libro)
        {
            $libroNuevo = new Libro($libro['titulo'], $libro['autor'] , $libro['genero'] ,$libro['anio'], $libro['paginas'] ,$libro['portada']);

            $libros[] = $libroNuevo;
        }

        new Pages()->render('libro/catalogo', ['libros' => $libros]);
    }
}
