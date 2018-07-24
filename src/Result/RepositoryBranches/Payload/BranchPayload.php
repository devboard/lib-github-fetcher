<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Git\Branch\BranchName;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayloadTest
 */
class BranchPayload
{
    /** @var BranchName */
    private $name;

    /** @var CommitDetails */
    private $commit;

    public function __construct(BranchName $name, CommitDetails $commit)
    {
        $this->name   = $name;
        $this->commit = $commit;
    }

    public function getName(): BranchName
    {
        return $this->name;
    }

    public function getCommit(): CommitDetails
    {
        return $this->commit;
    }

    public function serialize(): array
    {
        return ['name' => $this->name->serialize(), 'commit' => $this->commit->serialize()];
    }

    public static function deserialize(array $data): self
    {
        return new self(BranchName::deserialize($data['name']), CommitDetails::deserialize($data['commit']));
    }
}
