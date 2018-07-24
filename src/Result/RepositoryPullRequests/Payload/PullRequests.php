<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\PullRequest\PullRequestId;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestsTest
 */
class PullRequests
{
    /** @var array|PullRequest[] */
    private $elements;

    /**
     * @param PullRequest[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, PullRequest::class);
        $this->elements = $elements;
    }

    public function add(PullRequest $element): void
    {
        $this->elements[] = $element;
    }

    public function has(PullRequestId $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(PullRequestId $id): ?PullRequest
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return  array|PullRequest[] */
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
            $class = $item['__type'];

            $elements[] = $class::deserialize($item);
        }

        return new self($elements);
    }
}
