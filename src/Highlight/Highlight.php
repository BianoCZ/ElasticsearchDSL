<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Highlight;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;
use stdClass;
use function count;

/**
 * Data holder for highlight api.
 */
class Highlight implements BuilderInterface
{

    use ParametersTrait;

    /**
     * Holds fields for highlight
     *
     * @var array<string,array<mixed>>
     */
    private array $fields = [];

    /** @var array<string,array<mixed>>|null */
    private ?array $tags = null;

    /**
     * @param array<mixed> $params
     */
    public function addField(string $name, array $params = []): self
    {
        $this->fields[$name] = $params;

        return $this;
    }

    /**
     * Sets html tag and its class used in highlighting.
     *
     * @param array<mixed> $preTags
     * @param array<mixed> $postTags
     */
    public function setTags(array $preTags, array $postTags): self
    {
        $this->tags['pre_tags'] = $preTags;
        $this->tags['post_tags'] = $postTags;

        return $this;
    }

    public function getType(): string
    {
        return 'highlight';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->tags !== null) {
            $data = $this->tags;
        }

        $data = $this->processArray($data);

        foreach ($this->fields as $field => $params) {
            $data['fields'][$field] = count($params) ? $params : new stdClass();
        }

        return $data;
    }

}
