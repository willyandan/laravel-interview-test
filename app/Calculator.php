<?php


namespace App;


class Calculator
{

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function add(int $a, int $b)
    {
        return $a + $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function subtract(int $a, int $b)
    {
        return $a - $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function multiply(int $a, int $b)
    {
        return $a * $b;
    }

    /**
     * @throws \InvalidArgumentException
     * @param int $a
     * @param int $b
     * @return float
     */
    public function divide(int $a, int $b)
    {
        return $a / $b;
    }

    /**
     * @throws \InvalidArgumentException
     * @param int $a
     * @param int $b
     * @return int
     */
    public function modulo(int $a, int $b)
    {
        return $a % $b;
    }
}
