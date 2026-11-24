
// TODO (apartado 2): vista de la ficha de un libro.
// Recibe la variable $libro (objeto Libro). Solo HTML y PHP para pintar.
<h1>Catálogo</h1>

<article class="ficha">
    <? $libros ?>
    <?php if (!empty($libros)): ?>
        <?php foreach ($libros as $libro): ?>
        
        <img src="'<?= e($libro['portada'] ?? "") ?>'" alt="no hay portada aun">
        <h3><?= e($libro['titulo'] ?? "") ?></h3>
        <p class="autor">Por: <?= e($libro['autor'] ?? "") ?> </p>
        <span class="genero"> <?= e($libro['genero'] ?? "") ?> </span>

    <?php endforeach; ?>
</article>
