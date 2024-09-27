# phillarmonic/cpf-cnpj

A PHP library for validating and formatting CPF and CNPJ numbers from Brazil.

## Installation

You can install this library using Composer. Run the following command in your project directory:

```bash
composer require phillarmonic/cpf-cnpj
```

## Usage

### Validating CPF Numbers

To validate a CPF number:

```php
use Phillarmonic\CpfCnpj\CPF;

$cpf = new CPF('123.456.789-09');
if ($cpf->isValid()) {
    echo "The CPF is valid.";
} else {
    echo "The CPF is not valid.";
}
```

### Formatting CPF Numbers

To format a valid CPF number:

```php
use Phillarmonic\CpfCnpj\CPF;

$cpf = new CPF('12345678909');
$formattedCpf = $cpf->format();

if ($formattedCpf !== false) {
    echo "Formatted CPF: " . $formattedCpf; // Outputs: 123.456.789-09
} else {
    echo "Invalid CPF, unable to format.";
}
```

### Validating CNPJ Numbers

To validate a CNPJ number:

```php
use Phillarmonic\CpfCnpj\CNPJ;

$cnpj = new CNPJ('12.345.678/0001-95');
if ($cnpj->isValid()) {
    echo "The CNPJ is valid.";
} else {
    echo "The CNPJ is not valid.";
}
```

### Formatting CNPJ Numbers

To format a valid CNPJ number:

```php
use Phillarmonic\CpfCnpj\CNPJ;

$cnpj = new CNPJ('12345678000195');
$formattedCnpj = $cnpj->format();

if ($formattedCnpj !== false) {
    echo "Formatted CNPJ: " . $formattedCnpj; // Outputs: 12.345.678/0001-95
} else {
    echo "Invalid CNPJ, unable to format.";
}
```

## Important Notes

1. The library automatically removes any non-digit characters from the input, so you can pass formatted or unformatted numbers.
2. The `isValid()` method checks for:
    - Correct length (11 digits for CPF, 14 digits for CNPJ)
    - Not in the blacklist of known invalid numbers
    - Validity of check digits
3. The `format()` method returns `false` if the number is invalid.

## Error Handling

The library doesn't throw exceptions. Instead, it returns `false` or fails silently in case of invalid input. Always check the return value of `isValid()` before using the number, and check if `format()` returns `false` before using the formatted result.

## Contributing

If you'd like to contribute to this project, please submit a pull request on the GitHub repository.

## License

This library is open-sourced software licensed under the MIT license.