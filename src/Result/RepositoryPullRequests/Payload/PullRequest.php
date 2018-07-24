<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\PullRequest\PullRequestBody;
use DevboardLib\GitHub\PullRequest\PullRequestCreatedAt;
use DevboardLib\GitHub\PullRequest\PullRequestId;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\PullRequest\PullRequestTitle;
use DevboardLib\GitHub\PullRequest\PullRequestUpdatedAt;

interface PullRequest
{
    public function getId(): PullRequestId;

    public function getNumber(): PullRequestNumber;

    public function getTitle(): PullRequestTitle;

    public function getBody(): PullRequestBody;

    public function getAuthor(): PullRequestAuthor;

    public function getHeadRepository(): ?HeadRepository;

    public function getAssignees(): PullRequestAssignees;

    /** @return array|AccountId[] */
    public function getAssigneeIds(): array;

    public function getReviewRequests(): PullRequestReviewRequests;

    /** @return array|AccountId[] */
    public function getRequestedReviewerIds(): array;

    /** @return array|PullRequestRequestedReviewer[] */
    public function getRequestedReviewers(): array;

    public function getReviews(): PullRequestReviews;

    public function getMilestone(): ?PullRequestMilestone;

    public function getLabels(): PullRequestLabels;

    /** @return array|LabelId[] */
    public function getLabelIds(): array;

    public function getCreatedAt(): PullRequestCreatedAt;

    public function getUpdatedAt(): PullRequestUpdatedAt;

    public function serialize(): array;

    public static function deserialize(array $data);
}
