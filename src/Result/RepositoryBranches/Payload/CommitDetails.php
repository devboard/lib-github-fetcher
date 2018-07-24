<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\CommitMessage;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Commit\CommitParentCollection;
use DevboardLib\GitHub\Commit\CommitTree;
use DomainException;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetailsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetailsTest
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CommitDetails
{
    /** @var CommitSha */
    private $sha;

    /** @var CommitMessage */
    private $message;

    /** @var CommitDate */
    private $commitDate;

    /** @var CommitAuthor */
    private $author;

    /** @var CommitCommitter */
    private $committer;

    /** @var CommitTree */
    private $tree;

    /** @var CommitParentCollection */
    private $parents;

    /** @var CommitVerification|null */
    private $verification;

    public function __construct(
        CommitSha $sha,
        CommitMessage $message,
        CommitDate $commitDate,
        CommitAuthor $author,
        CommitCommitter $committer,
        CommitTree $tree,
        CommitParentCollection $parents,
        ?CommitVerification $verification = null
    ) {
        $this->sha          = $sha;
        $this->message      = $message;
        $this->commitDate   = $commitDate;
        $this->author       = $author;
        $this->committer    = $committer;
        $this->tree         = $tree;
        $this->parents      = $parents;
        $this->verification = $verification;
    }

    public function getSha(): CommitSha
    {
        return $this->sha;
    }

    public function getMessage(): CommitMessage
    {
        return $this->message;
    }

    public function getCommitDate(): CommitDate
    {
        return $this->commitDate;
    }

    public function getAuthor(): CommitAuthor
    {
        return $this->author;
    }

    public function getCommitter(): CommitCommitter
    {
        return $this->committer;
    }

    public function getTree(): CommitTree
    {
        return $this->tree;
    }

    public function getParents(): CommitParentCollection
    {
        return $this->parents;
    }

    public function getVerification(): ?CommitVerification
    {
        return $this->verification;
    }

    public function hasVerification(): bool
    {
        if (null === $this->verification) {
            return false;
        }

        return true;
    }

    public function serialize(): array
    {
        if (null === $this->verification) {
            $verification = null;
        } else {
            $verification = $this->verification->serialize();
        }

        return [
            'sha'          => $this->sha->serialize(),
            'message'      => $this->message->serialize(),
            'commitDate'   => $this->commitDate->serialize(),
            'author'       => $this->author->serialize(),
            'committer'    => $this->committer->serialize(),
            'tree'         => $this->tree->serialize(),
            'parents'      => $this->parents->serialize(),
            'verification' => $verification,
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['verification']) {
            $verification = null;
        } else {
            $verification = CommitVerification::deserialize($data['verification']);
        }

        if ('BasicCommitAuthorDetails' === $data['author']['__type']) {
            $author = BasicCommitAuthorDetails::deserialize($data['author']);
        } elseif ('FullCommitAuthorDetails' === $data['author']['__type']) {
            $author = FullCommitAuthorDetails::deserialize($data['author']);
        } else {
            throw new DomainException('Unsupported type of commit author details');
        }
        if ('BasicCommitCommitterDetails' === $data['committer']['__type']) {
            $committer = BasicCommitCommitterDetails::deserialize($data['committer']);
        } elseif ('FullCommitCommitterDetails' === $data['committer']['__type']) {
            $committer = FullCommitCommitterDetails::deserialize($data['committer']);
        } else {
            throw new DomainException('Unsupported type of commit committer details');
        }

        return new self(
            CommitSha::deserialize($data['sha']),
            CommitMessage::deserialize($data['message']),
            CommitDate::deserialize($data['commitDate']),
            $author,
            $committer,
            CommitTree::deserialize($data['tree']),
            CommitParentCollection::deserialize($data['parents']),
            $verification
        );
    }
}
