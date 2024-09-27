<?php

namespace Phillarmonic\CpfCnpj;

class CPF extends Document
{
    /**
     * Invalid CPF numbers (blacklist).
     *
     * @var array
     */
    protected array $blacklist = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
    ];

    /**
     * Check if the CPF number is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        // Check the length
        if (strlen($this->value) !== 11) {
            return false;
        }

        // Check if it's blacklisted
        if (in_array($this->value, $this->blacklist, true)) {
            return false;
        }

        // Validate first check digit
        if (!$this->validateCheckDigit(9, 10)) {
            return false;
        }

        // Validate second check digit
        if (!$this->validateCheckDigit(10, 11)) {
            return false;
        }

        return true;
    }

    /**
     * Validate a specific check digit.
     *
     * @param int $position The position of the digit to validate.
     * @param int $weightStart The starting weight for calculation.
     * @return bool
     */
    private function validateCheckDigit(int $position, int $weightStart): bool
    {
        $sum = 0;
        for ($i = 0, $weight = $weightStart; $i < $position; $i++, $weight--) {
            $sum += (int)$this->value[$i] * $weight;
        }

        $result = $sum % 11;
        $expected = $result < 2 ? 0 : 11 - $result;

        return (int)$this->value[$position] === $expected;
    }

    /**
     * Format the CPF number.
     *
     * @return string|false
     */
    public function format(): string|false
    {
        if (!$this->isValid()) {
            return false;
        }

        return sprintf(
            '%s.%s.%s-%s',
            substr($this->value, 0, 3),
            substr($this->value, 3, 3),
            substr($this->value, 6, 3),
            substr($this->value, 9, 2)
        );
    }
}
