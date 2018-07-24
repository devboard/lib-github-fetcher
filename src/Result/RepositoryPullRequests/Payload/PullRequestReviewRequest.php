<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountId;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequestSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequestTest
 */
class PullRequestReviewRequest
{
    /** @var int */
    private $id;

    /** @var PullRequestRequestedReviewer */
    private $requestedReviewer;

    public function __construct(int $id, PullRequestRequestedReviewer $requestedReviewer)
    {
        $this->id                = $id;
        $this->requestedReviewer = $requestedReviewer;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRequestedReviewerId(): AccountId
    {
        return $this->requestedReviewer->getUserId();
    }

    public function getRequestedReviewer(): PullRequestRequestedReviewer
    {
        return $this->requestedReviewer;
    }

    public function serialize(): array
    {
        return ['id' => $this->id, 'requestedReviewer' => $this->requestedReviewer->serialize()];
    }

    public static function deserialize(array $data): self
    {
        return new self($data['id'], PullRequestRequestedReviewer::deserialize($data['requestedReviewer']));
    }
}
