<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DevboardLib\Git\Branch\BranchName;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusesPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusesPayloadTest
 */
class BranchStatusesPayload
{
    /** @var array|BranchStatusPayload[] */
    private $elements;

    /**
     * @param BranchStatusPayload[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, BranchStatusPayload::class);
        $this->elements = $elements;
    }

    public function add(BranchStatusPayload $element): void
    {
        $this->elements[] = $element;
    }

    public function has(BranchName $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getName() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(BranchName $id): ?BranchStatusPayload
    {
        foreach ($this->elements as $element) {
            if ($element->getName() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return  array|BranchStatusPayload[] */
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
            $elements[] = BranchStatusPayload::deserialize($item);
        }

        return new self($elements);
    }
}
