<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload;

use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusesPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusesPayloadTest
 */
class PullRequestStatusesPayload
{
    /** @var array|PullRequestStatusPayload[] */
    private $elements;

    /**
     * @param PullRequestStatusPayload[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, PullRequestStatusPayload::class);
        $this->elements = $elements;
    }

    public function add(PullRequestStatusPayload $element): void
    {
        $this->elements[] = $element;
    }

    public function has(PullRequestNumber $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getNumber() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(PullRequestNumber $id): ?PullRequestStatusPayload
    {
        foreach ($this->elements as $element) {
            if ($element->getNumber() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return  array|PullRequestStatusPayload[] */
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
            $elements[] = PullRequestStatusPayload::deserialize($item);
        }

        return new self($elements);
    }
}
