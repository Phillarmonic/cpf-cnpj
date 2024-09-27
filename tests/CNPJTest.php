<?php

use Phillarmonic\CpfCnpj\CNPJ;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CNPJ::class)]
class CNPJTest extends TestCase
{
    #[DataProvider('validCnpjProvider')]
    public function testValidCnpj(string $cnpj): void
    {
        $cnpjObj = new CNPJ($cnpj);
        $this->assertTrue($cnpjObj->isValid(), "CNPJ {$cnpj} should be valid.");
        $this->assertEquals($this->formatCnpj($cnpj), $cnpjObj->format(), "Formatted CNPJ should match expected format.");
    }

    #[DataProvider('invalidCnpjProvider')]
    public function testInvalidCnpj(string $cnpj): void
    {
        $cnpjObj = new CNPJ($cnpj);
        $this->assertFalse($cnpjObj->isValid(), "CNPJ {$cnpj} should be invalid.");
        $this->assertFalse($cnpjObj->format(), "Formatting should fail for invalid CNPJ.");
    }

    public static function validCnpjProvider(): array
    {
        return [
            ['11222333000181'],
            ['11444777000161'],
            ['12345678000195'],
        ];
    }

    public static function invalidCnpjProvider(): array
    {
        return [
            ['00000000000000'],
            ['11111111111111'],
            ['12345678901234'],
            ['11222333000180'], // Incorrect check digit
            // Add more invalid CNPJ numbers as needed
        ];
    }

    /**
     * Helper method to format CNPJ.
     *
     * @param string $cnpj
     * @return string
     */
    private function formatCnpj(string $cnpj): string
    {
        return sprintf(
            '%s.%s.%s/%s-%s',
            substr($cnpj, 0, 2),
            substr($cnpj, 2, 3),
            substr($cnpj, 5, 3),
            substr($cnpj, 8, 4),
            substr($cnpj, 12, 2)
        );
    }
}
