<?php

/**
 * @author eduglezexp
 * @version 1.0
 */

namespace Application\Domain\Entity;

class WordProviderEntity {
    private string $filePath;

    /**
     * Constructor que inicializa la ruta del archivo de palabras
     */
    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    /**
     * Funcion que retorna una palabra aleatoria del archivo
     * @return string Palabra aleatoria
     */
    public function randomWord(): string {
        $words = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $word = $words[array_rand($words)];
        $word = strtoupper($this->sanitize($word));
        return $word;
    }

    /**
     * Funcion que sanitiza una palabra, eliminando caracteres no alfabeticos
     * @param string $text Texto a sanitizar
     * @return string Texto sanitizado
     */
    private function sanitize(string $text): string {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        return preg_replace('/[^A-Z]/', '', strtoupper($text));
    }
}