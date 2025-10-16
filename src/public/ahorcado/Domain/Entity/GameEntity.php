<?php

/**
 * @author eduglezexp
 * @version 1.0
 */

namespace Domain\Entity;

use Domain\Repository\IGameRepository;

class GameEntity implements IGameRepository {
    private string $word;
    private int $maxAttempts;
    private int $attemptsLeft;
    private array $usedLetters;

    /**
     * Constructor para inicializar el juego
     * @param string $word Palabra a adivinar
     * @param int $maxAttempts Numero maximo de intentos
     * @param array|null $state Estado previo del juego (opcional)
     * @return void
     */
    public function __construct(string $word, int $maxAttempts = 6, ?array $state = null) {
        $this->word = strtoupper($word);
        $this->maxAttempts = $maxAttempts;

        if ($state) {
            $this->attemptsLeft = $state['attemptsLeft'];
            $this->usedLetters = $state['usedLetters'];
        } else {
            $this->attemptsLeft = $maxAttempts;
            $this->usedLetters = [];
        }
    }

    /**
     * Funcion que procesa una letra o palabra, resta intentos si falla
     * @param string $letter Letra a adivinar
     * @return void
     */
    public function guessLetter(string $letter): void {
        $letter = strtoupper($letter);

        if ($this->isWon() || $this->isLost()) {
            return;
        }

        if (strlen($letter) > 1) {
            if ($letter === $this->word) {
                $this->usedLetters = str_split($this->word);
            } else {
                $this->attemptsLeft--;
            }
        } else {
            if (in_array($letter, $this->usedLetters)) {
                return;
            }
            $this->usedLetters[] = $letter;
            if (strpos($this->word, $letter) === false) {
                $this->attemptsLeft--;
            }
        }
    }

    /**
     * Funcion que devuelve palabra con guiones bajos y letras descubiertas
     * @return string Palabra con letras descubiertas y guiones bajos
     */
    public function getMaskedWord(): string {
        $masked = '';
        foreach (str_split($this->word) as $ch) {
            $masked .= in_array($ch, $this->usedLetters) ? $ch : '_';
        }
        return $masked;
    }

    /**
     * Funcion que retorna los intentos restantes
     * @return int Intentos restantes
     */
    public function getAttemptsLeft(): int {
        return $this->attemptsLeft;
    }

    /**
     * Funcion que retorna las letras usadas
     * @return array Letras usadas
     */
    public function getUsedLetters(): array {
        return $this->usedLetters;
    }

    /**
     * Funcion que verifica si se ha ganadoel juego
     * @return bool Verdadero si se ha ganado, falso en caso contrario
     */
    public function isWon(): bool {
        foreach (str_split($this->word) as $ch) {
            if (!in_array($ch, $this->usedLetters)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Funcion que verifica si se ha perdido el juego
     * @return bool Verdadero si se ha perdido, falso en caso contrario
     */
    public function isLost(): bool {
        return $this->attemptsLeft <= 0 && !$this->isWon();
    }

    /**
     * Funcion que retorna la palabra a adivinar
     * @return string Palabra a adivinar
     */
    public function getWord(): string {
        return $this->word;
    }

    /**
     * Funcion que serializa el estado del juego para guardarlo en sesion
     * @return array Estado del juego
     */
    public function toState(): array {
        return [
            'attemptsLeft' => $this->attemptsLeft,
            'usedLetters' => $this->usedLetters,
        ];
    }
}