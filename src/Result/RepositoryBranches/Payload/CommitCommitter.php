<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\Committer\CommitterName;

interface CommitCommitter
{
    public function hasFullDetails(): bool;

    public function getName(): CommitterName;

    public function getEmail(): EmailAddress;

    public function getCommitDate(): CommitDate;

    public function serialize(): array;

    public static function deserialize(array $data);
}
