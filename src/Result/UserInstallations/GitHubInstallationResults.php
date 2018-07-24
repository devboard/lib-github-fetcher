<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\UserInstallations;

use DevboardLib\GitHub\Installation\InstallationId;
use Webmozart\Assert\Assert;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResultsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResultsTest
 */
class GitHubInstallationResults
{
    /** @var array|GitHubInstallationResult[] */
    private $elements;

    /**
     * @param GitHubInstallationResult[] $elements
     */
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, GitHubInstallationResult::class);
        $this->elements = $elements;
    }

    public function add(GitHubInstallationResult $element): void
    {
        $this->elements[] = $element;
    }

    public function has(InstallationId $id): bool
    {
        foreach ($this->elements as $element) {
            if ($element->getInstallationId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(InstallationId $id): ?GitHubInstallationResult
    {
        foreach ($this->elements as $element) {
            if ($element->getInstallationId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /** @return  array|GitHubInstallationResult[] */
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
            $elements[] = GitHubInstallationResult::deserialize($item);
        }

        return new self($elements);
    }
}
