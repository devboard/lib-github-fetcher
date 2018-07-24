<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountId;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssigneesSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssigneesTest
 */
class PullRequestAssignees
{
    /** @var array|PullRequestAssignee[] */
    private $elements;

    /**
     * @param PullRequestAssignee[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, PullRequestAssignee::class);
        $this->elements = $elements;
    }

    public function add(PullRequestAssignee $element): void
    {
        $this->elements[] = $element;
    }

    public function has(AccountId $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getUserId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(AccountId $id): ?PullRequestAssignee
    {
        foreach ($this->elements as $element) {
            if ($element->getUserId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return array|PullRequestAssignee[] */
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
            $elements[] = PullRequestAssignee::deserialize($item);
        }

        return new self($elements);
    }
}
