<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\Author\AuthorName;
use DevboardLib\Git\Commit\CommitDate;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitAuthorDetailsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitAuthorDetailsTest
 */
class BasicCommitAuthorDetails implements CommitAuthor
{
    /** @var AuthorName */
    private $name;

    /** @var EmailAddress */
    private $email;

    /** @var CommitDate */
    private $commitDate;

    public function __construct(AuthorName $name, EmailAddress $email, CommitDate $commitDate)
    {
        $this->name       = $name;
        $this->email      = $email;
        $this->commitDate = $commitDate;
    }

    public function getName(): AuthorName
    {
        return $this->name;
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    public function getCommitDate(): CommitDate
    {
        return $this->commitDate;
    }

    public function hasFullDetails(): bool
    {
        return false;
    }

    public function serialize(): array
    {
        return [
            '__type'     => 'BasicCommitAuthorDetails',
            'name'       => $this->name->serialize(),
            'email'      => $this->email->serialize(),
            'commitDate' => $this->commitDate->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            AuthorName::deserialize($data['name']),
            EmailAddress::deserialize($data['email']),
            CommitDate::deserialize($data['commitDate'])
        );
    }
}
