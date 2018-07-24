<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload;

use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusPayloadSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusPayloadTest
 */
class PullRequestStatusPayload
{
    /** @var PullRequestNumber */
    private $number;

    /** @var CommitSha */
    private $sha;

    /** @var StatusCheckState */
    private $status;

    /** @var StatusChecks */
    private $statusChecks;

    public function __construct(
        PullRequestNumber $number, CommitSha $sha, StatusCheckState $status, StatusChecks $statusChecks
    ) {
        $this->number       = $number;
        $this->sha          = $sha;
        $this->status       = $status;
        $this->statusChecks = $statusChecks;
    }

    public function getNumber(): PullRequestNumber
    {
        return $this->number;
    }

    public function getSha(): CommitSha
    {
        return $this->sha;
    }

    public function getStatus(): StatusCheckState
    {
        return $this->status;
    }

    public function getStatusChecks(): StatusChecks
    {
        return $this->statusChecks;
    }

    public function serialize(): array
    {
        return [
            'number'       => $this->number->serialize(),
            'sha'          => $this->sha->serialize(),
            'status'       => $this->status->serialize(),
            'statusChecks' => $this->statusChecks->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            PullRequestNumber::deserialize($data['number']),
            CommitSha::deserialize($data['sha']),
            StatusCheckState::deserialize($data['status']),
            StatusChecks::deserialize($data['statusChecks'])
        );
    }
}
