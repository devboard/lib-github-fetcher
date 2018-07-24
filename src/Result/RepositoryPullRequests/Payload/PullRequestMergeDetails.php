<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DateTime;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergeDetailsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergeDetailsTest
 */
class PullRequestMergeDetails
{
    /** @var PullRequestMergedBy */
    private $mergedBy;

    /** @var DateTime */
    private $mergedAt;

    public function __construct(PullRequestMergedBy $mergedBy, DateTime $mergedAt)
    {
        $this->mergedBy = $mergedBy;
        $this->mergedAt = $mergedAt;
    }

    public function getMergedBy(): PullRequestMergedBy
    {
        return $this->mergedBy;
    }

    public function getMergedAt(): DateTime
    {
        return $this->mergedAt;
    }

    public function serialize(): array
    {
        return ['mergedBy' => $this->mergedBy->serialize(), 'mergedAt' => $this->mergedAt->format('c')];
    }

    public static function deserialize(array $data): self
    {
        return new self(PullRequestMergedBy::deserialize($data['mergedBy']), new DateTime($data['mergedAt']));
    }
}
