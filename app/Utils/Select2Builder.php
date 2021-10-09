<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Collection;

abstract class Select2Builder
{

    const SOURCE_MAPPING_VALUE = 'value';
    const SOURCE_MAPPING_LABEL = 'label';

    public string $id;
    public string $name;
    public Collection $source;
    public array $sourceMapping;

    public function __construct()
    {
        $this->build();
    }

    abstract public function build();

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Select2Builder
     */
    public function setId(string $id): Select2Builder
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Select2Builder
     */
    public function setName(string $name): Select2Builder
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return Collection
     */
    public function getSource(): Collection
    {
        return $this->source;
    }

    /**
     * @param Collection $source
     * @return Select2Builder
     */
    public function setSource(Collection $source): Select2Builder
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return array
     */
    public function getSourceMapping(): array
    {
        return $this->sourceMapping;
    }

    /**
     * @param array $sourceMapping
     * @return Select2Builder
     */
    public function setSourceMapping(array $sourceMapping): Select2Builder
    {
        $this->sourceMapping = $sourceMapping;
        return $this;
    }


}
