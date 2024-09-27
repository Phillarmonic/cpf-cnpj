<?php

namespace Phillarmonic\CpfCnpj\Tests;

use Phillarmonic\CpfCnpj\CPF;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CPF::class)]
class CPFTest extends TestCase
{
    #[DataProvider('validCpfProvider')]
    public function testValidCpf(string $cpf): void
    {
        $cpfObj = new CPF($cpf);
        $this->assertTrue($cpfObj->isValid(), "CPF {$cpf} should be valid.");
        $this->assertEquals($this->formatCpf($cpf), $cpfObj->format(), "Formatted CPF should match expected format.");
    }

    #[DataProvider('invalidCpfProvider')]
    public function testInvalidCpf(string $cpf): void
    {
        $cpfObj = new CPF($cpf);
        $this->assertFalse($cpfObj->isValid(), "CPF {$cpf} should be invalid.");
        $this->assertFalse($cpfObj->format(), "Formatting should fail for invalid CPF.");
    }

    public static function validCpfProvider(): array
    {
        return [
            ['52998224725'],
            ['16899535009'],
            ['11144477735'],
        ];
    }

    public static function invalidCpfProvider(): array
    {
        return [
            ['12345678900'],
            ['11111111111'],
            ['00000000000'],
            ['52998224724'], // Incorrect check digit
        ];
    }

    /**
     * Helper method to format CPF.
     *
     * @param string $cpf
     * @return string
     */
    private function formatCpf(string $cpf): string
    {
        return sprintf(
            '%s.%s.%s-%s',
            substr($cpf, 0, 3),
            substr($cpf, 3, 3),
            substr($cpf, 6, 3),
            substr($cpf, 9, 2)
        );
    }
}
