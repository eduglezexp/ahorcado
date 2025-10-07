<?php

/**
 * @author eduglezexp
 * @version 1.0
 */

class Renderer {

    /**
     * Retorna una imagen (GIF o PNG) del ahorcado según los intentos restantes.
     * @param int $attemptsLeft Número de intentos restantes.
     * @return string HTML con la imagen.
     */
    public function image(int $attemptsLeft): string {
        $path = "resources/gif/";
        $filename = "{$path}{$attemptsLeft}.gif";
        return "<div class='hangman'><img src='{$filename}' alt='Ahorcado' /></div>";
    }
}