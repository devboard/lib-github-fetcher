<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusPayloadTest
 */
class BranchStatusPayload
{
    /** @var BranchName */
    private $name;

    /** @var CommitSha */
    private $sha;

    /** @var StatusCheckState|null */
    private $status;

    /** @var StatusChecks */
    private $statusChecks;

    public function __construct(
        BranchName $name, CommitSha $sha, ?StatusCheckState $status, StatusChecks $statusChecks
    ) {
        $this->name         = $name;
        $this->sha          = $sha;
        $this->status       = $status;
        $this->statusChecks = $statusChecks;
    }

    public function getName(): BranchName
    {
        return $this->name;
    }

    public function getSha(): CommitSha
    {
        return $this->sha;
    }

    public function getStatus(): ?StatusCheckState
    {
        return $this->status;
    }

    public function getStatusChecks(): StatusChecks
    {
        return $this->statusChecks;
    }

    public function serialize(): array
    {
        if (null === $this->status) {
            $status = null;
        } else {
            $status = $this->status->serialize();
        }

        return [
            'name'         => $this->name->serialize(),
            'sha'          => $this->sha->serialize(),
            'status'       => $status,
            'statusChecks' => $this->statusChecks->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['status']) {
            $status = null;
        } else {
            $status = StatusCheckState::deserialize($data['status']);
        }

        return new self(
            BranchName::deserialize($data['name']),
            CommitSha::deserialize($data['sha']),
            $status,
            StatusChecks::deserialize($data['statusChecks'])
        );
    }
}
