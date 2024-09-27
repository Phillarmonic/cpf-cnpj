<?php

namespace Phillarmonic\CpfCnpj;

abstract class Document
{
    /**
     * The document value.
     *
     * @var string
     */
    protected string $value;

    /**
     * Constructor to initialize the document value.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        // Remove any non-digit characters
        $this->value = preg_replace('/\D/', '', $value);
    }

    /**
     * Check if the document is valid.
     *
     * @return bool
     */
    abstract public function isValid(): bool;

    /**
     * Format the document.
     *
     * @return string|false
     */
    abstract public function format(): string|false;
}
