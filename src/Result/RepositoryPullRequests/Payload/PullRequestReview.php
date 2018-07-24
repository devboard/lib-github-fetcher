<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewBody;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewId;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewState;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewSubmittedAt;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewTest
 */
class PullRequestReview
{
    /** @var PullRequestReviewId */
    private $id;

    /** @var PullRequestReviewBody */
    private $body;

    /** @var PullRequestReviewAuthor */
    private $author;

    /** @var PullRequestReviewState */
    private $state;

    /** @var CommitSha */
    private $commitSha;

    /** @var PullRequestReviewSubmittedAt|null */
    private $submittedAt;

    public function __construct(
        PullRequestReviewId $id,
        PullRequestReviewBody $body,
        PullRequestReviewAuthor $author,
        PullRequestReviewState $state,
        CommitSha $commitSha,
        ?PullRequestReviewSubmittedAt $submittedAt
    ) {
        $this->id          = $id;
        $this->body        = $body;
        $this->author      = $author;
        $this->state       = $state;
        $this->commitSha   = $commitSha;
        $this->submittedAt = $submittedAt;
    }

    public function getId(): PullRequestReviewId
    {
        return $this->id;
    }

    public function getBody(): PullRequestReviewBody
    {
        return $this->body;
    }

    public function getAuthor(): PullRequestReviewAuthor
    {
        return $this->author;
    }

    public function getState(): PullRequestReviewState
    {
        return $this->state;
    }

    public function getCommitSha(): CommitSha
    {
        return $this->commitSha;
    }

    public function getSubmittedAt(): ?PullRequestReviewSubmittedAt
    {
        return $this->submittedAt;
    }

    public function hasSubmittedAt(): bool
    {
        if (null === $this->submittedAt) {
            return false;
        }

        return true;
    }

    public function serialize(): array
    {
        if (null === $this->submittedAt) {
            $submittedAt = null;
        } else {
            $submittedAt = $this->submittedAt->serialize();
        }

        return [
            'id'          => $this->id->serialize(),
            'body'        => $this->body->serialize(),
            'author'      => $this->author->serialize(),
            'state'       => $this->state->serialize(),
            'commitSha'   => $this->commitSha->serialize(),
            'submittedAt' => $submittedAt,
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['submittedAt']) {
            $submittedAt = null;
        } else {
            $submittedAt = PullRequestReviewSubmittedAt::deserialize($data['submittedAt']);
        }

        return new self(
            PullRequestReviewId::deserialize($data['id']),
            PullRequestReviewBody::deserialize($data['body']),
            PullRequestReviewAuthor::deserialize($data['author']),
            PullRequestReviewState::deserialize($data['state']),
            CommitSha::deserialize($data['commitSha']),
            $submittedAt
        );
    }
}
