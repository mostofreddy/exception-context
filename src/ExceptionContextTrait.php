<?php

declare(strict_types=1);

namespace Smarttly\ExceptionUtils;

trait ExceptionContextTrait
{
    /** @var array $context */
    protected array $context = [];

    /**
     * @param array $context
     * @return self
     */
    public function setContext(array $context): self
    {
        $this->context = $context + $this->context;
        return $this;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
