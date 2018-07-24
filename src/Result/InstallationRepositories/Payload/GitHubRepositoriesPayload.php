<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload;

use DevboardLib\GitHub\Repo\RepoId;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoriesPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoriesPayloadTest
 */
class GitHubRepositoriesPayload
{
    /** @var array|GitHubRepositoryPayload[] */
    private $elements;

    /**
     * @param GitHubRepositoryPayload[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, GitHubRepositoryPayload::class);
        $this->elements = $elements;
    }

    public function add(GitHubRepositoryPayload $element): void
    {
        $this->elements[] = $element;
    }

    public function has(RepoId $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(RepoId $id): ?GitHubRepositoryPayload
    {
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return array|GitHubRepositoryPayload[] */
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
            $elements[] = GitHubRepositoryPayload::deserialize($item);
        }

        return new self($elements);
    }
}
