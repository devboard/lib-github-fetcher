<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Label\LabelId;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabelsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabelsTest
 */
class PullRequestLabels
{
    /** @var array|PullRequestLabel[] */
    private $elements;

    /**
     * @param PullRequestLabel[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, PullRequestLabel::class);
        $this->elements = $elements;
    }

    public function add(PullRequestLabel $element): void
    {
        $this->elements[] = $element;
    }

    public function has(LabelId $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(LabelId $id): ?PullRequestLabel
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return array|PullRequestLabel[] */
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
            $elements[] = PullRequestLabel::deserialize($item);
        }

        return new self($elements);
    }
}
