<?php

namespace Phillarmonic\CpfCnpj;

class CNPJ extends Document
{
    /**
     * Invalid CNPJ numbers (blacklist).
     *
     * @var array
     */
    protected array $blacklist = [
        '00000000000000',
        '11111111111111',
        '22222222222222',
        '33333333333333',
        '44444444444444',
        '55555555555555',
        '66666666666666',
        '77777777777777',
        '88888888888888',
        '99999999999999'
    ];

    /**
     * Check if the CNPJ number is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        // Check the length
        if (strlen($this->value) !== 14) {
            return false;
        }

        // Check if it's blacklisted
        if (in_array($this->value, $this->blacklist, true)) {
            return false;
        }

        // Validate first check digit
        if (!$this->validateCheckDigit(12, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2])) {
            return false;
        }

        // Validate second check digit
        if (!$this->validateCheckDigit(13, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2])) {
            return false;
        }

        return true;
    }

    /**
     * Validate a specific check digit with custom weights.
     *
     * @param int $position The position of the digit to validate.
     * @param array $weights The array of weights to use for calculation.
     * @return bool
     */
    private function validateCheckDigit(int $position, array $weights): bool
    {
        $sum = 0;
        for ($i = 0; $i < count($weights); $i++) {
            $sum += (int)$this->value[$i] * $weights[$i];
        }

        $result = $sum % 11;
        $expected = $result < 2 ? 0 : 11 - $result;

        return (int)$this->value[$position] === $expected;
    }

    /**
     * Format the CNPJ number.
     *
     * @return string|false
     */
    public function format(): string|false
    {
        if (!$this->isValid()) {
            return false;
        }

        return sprintf(
            '%s.%s.%s/%s-%s',
            substr($this->value, 0, 2),
            substr($this->value, 2, 3),
            substr($this->value, 5, 3),
            substr($this->value, 8, 4),
            substr($this->value, 12, 2)
        );
    }
}
