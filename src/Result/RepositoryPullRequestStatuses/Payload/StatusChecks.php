<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload;

use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\StatusChecksSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\StatusChecksTest
 */
class StatusChecks
{
    /** @var array|StatusCheck[] */
    private $elements;

    /**
     * @param StatusCheck[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, StatusCheck::class);
        $this->elements = $elements;
    }

    public function add(StatusCheck $element): void
    {
        $this->elements[] = $element;
    }

    public function has(StatusCheckId $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(StatusCheckId $id): ?StatusCheck
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return  array|StatusCheck[] */
    public function toArray(): array
    {
        return $this->elements;
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function serialize(): array
    {
        $data = [];
        foreach ($this->elements as $element) {
            $data[] = $element->serialize();
        }

        return $data;
    }

    public static function deserialize(array $data): self
    {
        $elements = [];
        foreach ($data as $item) {
            $elements[] = StatusCheck::deserialize($item);
        }

        return new self($elements);
    }
}
