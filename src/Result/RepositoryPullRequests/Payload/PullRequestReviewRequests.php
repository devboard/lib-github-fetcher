<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequestsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequestsTest
 */
class PullRequestReviewRequests
{
    /** @var array|PullRequestReviewRequest[] */
    private $elements;

    /**
     * @param PullRequestReviewRequest[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, PullRequestReviewRequest::class);
        $this->elements = $elements;
    }

    public function add(PullRequestReviewRequest $element): void
    {
        $this->elements[] = $element;
    }

    public function has(int $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(int $id): ?PullRequestReviewRequest
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return array|PullRequestReviewRequest[] */
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
            $elements[] = PullRequestReviewRequest::deserialize($item);
        }

        return new self($elements);
    }
}
