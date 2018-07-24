<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\Author\AuthorName;
use DevboardLib\Git\Commit\CommitDate;

interface CommitAuthor
{
    public function hasFullDetails(): bool;

    public function getName(): AuthorName;

    public function getEmail(): EmailAddress;

    public function getCommitDate(): CommitDate;

    public function serialize(): array;

    public static function deserialize(array $data);
}
