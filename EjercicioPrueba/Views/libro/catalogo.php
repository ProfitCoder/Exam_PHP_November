<h1>Catálogo</h1>

<? $libros ?>
<?php if (!empty($libros)): ?>
    <?php foreach ($libros as $libro): ?>
        <div class="game">
            <h2><?= $libro['titulo'] ?? "" ?></h2>

            <p>Autor: <?= $libro['autor'] ?? "" ?></p>

            <p>Genero: <?= $libro['genero'] ?? "" ?></p>

            <p>Anio: <?= $libro['anio'] ?? null ?></p>

            <p>paginas: <?= $libro['paginas'] ?? null ?></p>

            <p>portada: <?= $libro['paginas'] ?? "" ?></p>

        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Todavia no hay libros en la biblioteca</p>
<?php endif; ?>

<a href="./login">Exit</a>

</form>
