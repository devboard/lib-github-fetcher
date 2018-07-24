<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Git\Branch\BranchName;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchesPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchesPayloadTest
 */
class BranchesPayload
{
    /** @var array|BranchPayload[] */
    private $elements;

    /**
     * @param BranchPayload[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, BranchPayload::class);
        $this->elements = $elements;
    }

    public function add(BranchPayload $element): void
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

    public function get(BranchName $id): ?BranchPayload
    {
        foreach ($this->elements as $element) {
            if ($element->getName() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return array|BranchPayload[] */
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
            $elements[] = BranchPayload::deserialize($item);
        }

        return new self($elements);
    }
}
