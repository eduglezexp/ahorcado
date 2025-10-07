<?php

/**
 * @author eduglezexp
 * @version 1.0
 */

class Storage {
    private string $key;

    /**
     * Constructor que inicializa la clave de sesion
     * @param string $key Clave de sesion
     */
    public function __construct(string $key = 'ahorcado') {
        session_start();
        $this->key = $key;
        if (!isset($_SESSION[$this->key])) {
            $_SESSION[$this->key] = [];
        }
    }

    /**
     * Funcion que obtiene un valor de sesion
     * @param string $name Nombre del valor
     * @param mixed $default Valor por defecto si no existe
     * @return mixed Valor de sesion o por defecto
     */
    public function get(string $name, $default = null) {
        return $_SESSION[$this->key][$name] ?? $default;
    }

    /**
     * Funcion que establece un valor de sesion
     * @param string $name Nombre del valor
     * @param mixed $value Valor a establecer
     * @return void
     */
    public function set(string $name, $value): void {
        $_SESSION[$this->key][$name] = $value;
    }

    /**
     * Funcion que resetea el estado del juego
     * @return void
     */
    public function reset(): void {
        unset($_SESSION[$this->key]);
    }
}