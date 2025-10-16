<?php

use Domain\Entity\GameEntity as Game;
use Domain\Entity\WordProviderEntity as WordProvider;
use Infrastructure\Autoload\Storage as Storage;
use Presentation\Views\Renderer as Renderer;

$storage = new Storage();
$renderer = new Renderer();
$provider = new WordProvider(__DIR__ . '/resources/palabras.txt');

$state = $storage->get('state');
$word = $storage->get('word');

if (!$word || !$state) {
    $word = $provider->randomWord();
    $game = new Game($word);
} else {
    $game = new Game($word, 6, $state);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['letter'])) {
        $game->guessLetter($_POST['letter']);
    } elseif (isset($_POST['reset'])) {
        $storage->reset();
        header('Location: index.php');
        exit;
    }
}

$storage->set('state', $game->toState());
$storage->set('word', $game->getWord());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ahorcado</title>
    <link rel="stylesheet" href="resources/styles.css">
</head>
<body>
    <div class="info-juego">
        <?php if ($game->isWon()): ?>
            <h2>¡Ganaste! La palabra era <?= $game->getWord(); ?>.</h2>
        <?php elseif ($game->isLost()): ?>
            <h2>¡Perdiste! La palabra era <?= $game->getWord(); ?>.</h2>
        <?php else: ?>
            <form method="POST">
                <input type="text" name="letter">
                <button type="submit">Probar</button>
            </form>
        <?php endif; ?>

        <form method="POST">
            <button type="submit" name="reset">Reiniciar juego</button>
        </form>
        <p>Intentos restantes: <?= $game->getAttemptsLeft(); ?></p>
        <p>Letras usadas: <?= implode(', ', $game->getUsedLetters()); ?></p>
    </div>
    <?= $renderer->image($game->getAttemptsLeft()); ?>

    <p class="word"><?= implode(' ', str_split($game->getMaskedWord())); ?></p>
</body>
</html>

