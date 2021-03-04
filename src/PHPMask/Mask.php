<?php

declare(strict_types=1);

namespace PHPMask;

use InvalidArgumentException;

class Mask
{

    public const DIRECTION_RIGHT = 'DIRECTION_RIGHT';
    public const DIRECTION_LEFT = 'DIRECTION_LEFT';


    /**
     * Aplica uma máscara de caracteres em uma string de entrada
     * 
     * @param string $inputValue valor ao qual será aplicada a mascara
     * @param string $mask formato da máscara a ser aplicada(caracteres # e * serão substituidos)
     * @param string $fillChaar caractere a ser utilizado se a máscara tiver mais caracteres a serem substituidos que a entrada
     * @param string $direction Direção em que os caracteres da entrada serão colocados na mascara. Aceita os valores das constantes `Mask::DIRECTION_LEFT` e `Mask::DIRECTION_RIGHT`. Padrão `Mask::DIRECTION_LEFT`.
     */
    public static function apply(string $inputValue, string $mask, $fillChar = '0', string $direction = Mask::DIRECTION_LEFT): string
    {
        if ($fillChar === null) $fillChar = '0';

        if (strlen($fillChar) > 1 || strlen($fillChar) === 0) throw new InvalidArgumentException('fillchar must have 1 character');

        $maskared = '';

        $inputCursor = ($direction === Mask::DIRECTION_LEFT) ? 0 : strlen($inputValue) - 1;
        $cursor =   ($direction === Mask::DIRECTION_LEFT) ? 0 : strlen($mask) - 1;
        $increment = ($direction === Mask::DIRECTION_LEFT) ? 1 : -1;

        while (Mask::hasNextCursor($mask, $cursor, $direction)) {
            if ($mask[$cursor] === '#') {

                if (Mask::hasInputValue($inputValue, $inputCursor, $direction)) {
                    $maskared = Mask::concatByDirection($maskared, $inputValue[$inputCursor], $direction);
                    $inputCursor += $increment;
                } else {
                    $maskared = Mask::concatByDirection($maskared, $fillChar, $direction);
                }
                $cursor += $increment;
            } elseif ($mask[$cursor] === '*') {

                if (Mask::hasInputValue($inputValue, $inputCursor, $direction)) {
                    $maskared = Mask::concatByDirection($maskared, $inputValue[$inputCursor], $direction);
                    $inputCursor += $increment;
                } else {
                    $cursor += $increment;
                }
            } else {
                $maskared = Mask::concatByDirection($maskared, $mask[$cursor], $direction);
                $cursor += $increment;
            }
        }

        return $maskared;
    }


    /**
     * Verifica se o cursor da máscara já atingiu o final
     * 
     * @param string valor da máscar que esta sendo percorrido
     * @param int $cursor posição do cursor para ser verficado
     * @param string $direction Direção que o input esta sendo percorrido - Mask::DIRECTION_LEFT ou Mask::DIRECTION_RIGHT
     * @return bool true se o cursor ainda não chegou no final
     */
    private static function hasNextCursor(string $mask, int $cursor, string $direction): bool
    {
        if ($direction === Mask::DIRECTION_LEFT) {
            return $cursor < strlen($mask);
        } else {
            return $cursor >= 0;
        }
    }

    /**
     * Verifica se o cursor da entrada já atingiu o final do input dependendo da direção
     * 
     * @param string valor de entrada que esta sendo percorrido
     * @param int $inputCursor posição do cursor para ser verficado
     * @param string $direction Direção que o input esta sendo percorrido - Mask::DIRECTION_LEFT ou Mask::DIRECTION_RIGHT
     * @return bool
     */
    private static function hasInputValue(string $inputValue, int $inputCursor, string $direction): bool
    {
        if ($direction === Mask::DIRECTION_LEFT) {
            return $inputCursor < strlen($inputValue);
        } else {
            return $inputCursor >= 0;
        }
    }

    /**
     * Concatena máscara com novo charactere na direção passada
     * 
     * @param string $maskared Valor que máscara já foi aplicada
     * @param string $char Caractere que será concatenado
     * @param string $direction Direção da concatenação - Mask::DIRECTION_LEFT ou Mask::DIRECTION_RIGHT
     * @return string Valor concatenado
     */
    private static function concatByDirection(string $maskared, string $char, string $direction): string
    {
        if ($direction === Mask::DIRECTION_LEFT) {
            return $maskared . $char;
        } else {
            return $char . $maskared;
        }
    }
}
