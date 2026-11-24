<?php
    
    declare(strict_types=1);

    namespace Models;

    class Libro
    {
        //Constructor con propiedades instanciadas
        public function __construct(
            public readonly string $titulo,
            public readonly string $autor,
            public readonly string $genero,
            public readonly int $year,
            public readonly int $paginas,
            public readonly string $portada
        )
        {}

        //Getters y Setters
        public function getTitulo(): string
        {
            return $this -> titulo;
        }

        public function getAutor(): string
        {
            return $this -> autor;
        }

        public function getGenero(): string
        {
            return $this -> genero;
        }

        public function getYear(): int
        {
            return $this -> year;
        }

        public function getPaginas(): int
        {
            return $this -> paginas;
        }

        public function getPortadas(): string
        {
            return $this -> portada;
        }

        public function setTitulo(string $tituloNuevo): void
        {
            $this -> titulo = $tituloNuevo;
        }

        public function setAutor(string $autorNuevo): void
        {
            $this -> autor = $autorNuevo;
        }

        public function setGenero(string $generoNuevo): void
        {
            $this -> genero = $generoNuevo;
        }

        public function setAnio(int $anioNuevo): void
        {
            $this -> anio = $anioNuevo;
        }

        public function setPaginas(int $paginasNuevo): void
        {
            $this -> paginas = $paginasNuevo;
        }

        public function setPortada(string $portadaNueva): void
        {
            $this -> portada = $portadaNueva;
        }

        //Metodos
        public function existe(string $tituloAc, string $autorAc): bool
        {

            //Existe
            $existe = false;
            $tituloPreparado = trim($tituloAc);
            $autorPreparado = trim($autorAc);

            //Para poder ver contenido de Archivo
            $ruta = BASE_PATH . "/data/biblioteca.txt";

            $contenido = file_get_contents($ruta);

            $librosInfo = json_decode($contenido, true);

            if(file_exists($librosInfo))
            {
                return false;
            }

            foreach($librosInfo as $libro)
            {

                $tituloIgual = ($tituloPreparado === $libro['titulo']);
                $autorIgual = ($autorPreparado === $libro['autor']);

                if($tituloIgual && $autorIgual)
                {
                    $existe = true;
                    return $existe;
                }
            }

            return $existe;
        }

        //Para poder meter texto dentro del fichero que tenemos creado
        public function guardar(string $stringLibro): bool
        {
            //meter texto dentro del archivo
            $correcto = false;

            $ruta = BASE_PATH . "/data/biblioteca.txt";
            $archivo = file_get_contents($ruta);


            if(!file_put_contents($archivo, $stringLibro) === false)
            {
                return $correcto = true;
            }

            return $correcto;
            
        }
    }