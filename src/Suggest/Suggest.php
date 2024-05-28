<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Suggest;

use Biano\ElasticsearchDSL\NamedBuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

class Suggest implements NamedBuilderInterface
{

    use ParametersTrait;

    private string $name;

    private string $type;

    private string $text;

    private string $field;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $name, string $type, string $text, string $field, array $parameters = [])
    {
        $this->setName($name);
        $this->setType($type);
        $this->setText($text);
        $this->setField($field);
        $this->setParameters($parameters);
    }

    /**
     * Returns suggest name
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns element type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            $this->getName() => [
                'text' => $this->getText(),
                $this->getType() => $this->processArray(['field' => $this->getField()]),
            ],
        ];
    }

}
