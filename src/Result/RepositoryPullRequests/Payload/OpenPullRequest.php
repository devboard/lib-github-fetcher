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

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 *
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\OpenPullRequestSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\OpenPullRequestTest
 */
class OpenPullRequest implements PullRequest
{
    /** @var PullRequestId */
    private $id;

    /** @var PullRequestNumber */
    private $number;

    /** @var PullRequestTitle */
    private $title;

    /** @var PullRequestBody */
    private $body;

    /** @var PullRequestAuthor */
    private $author;

    /** @var HeadRepository|null */
    private $headRepository;

    /** @var PullRequestAssignees */
    private $assignees;

    /** @var PullRequestReviewRequests */
    private $reviewRequests;

    /** @var PullRequestReviews */
    private $reviews;

    /** @var PullRequestMilestone|null */
    private $milestone;

    /** @var PullRequestLabels */
    private $labels;

    /** @var PullRequestCreatedAt */
    private $createdAt;

    /** @var PullRequestUpdatedAt */
    private $updatedAt;

    public function __construct(
        PullRequestId $id,
        PullRequestNumber $number,
        PullRequestTitle $title,
        PullRequestBody $body,
        PullRequestAuthor $author,
        ?HeadRepository $headRepository,
        PullRequestAssignees $assignees,
        PullRequestReviewRequests $reviewRequests,
        PullRequestReviews $reviews,
        ?PullRequestMilestone $milestone,
        PullRequestLabels $labels,
        PullRequestCreatedAt $createdAt,
        PullRequestUpdatedAt $updatedAt
    ) {
        $this->id             = $id;
        $this->number         = $number;
        $this->title          = $title;
        $this->body           = $body;
        $this->author         = $author;
        $this->headRepository = $headRepository;
        $this->assignees      = $assignees;
        $this->reviewRequests = $reviewRequests;
        $this->reviews        = $reviews;
        $this->milestone      = $milestone;
        $this->labels         = $labels;
        $this->createdAt      = $createdAt;
        $this->updatedAt      = $updatedAt;
    }

    public function getId(): PullRequestId
    {
        return $this->id;
    }

    public function getNumber(): PullRequestNumber
    {
        return $this->number;
    }

    public function getTitle(): PullRequestTitle
    {
        return $this->title;
    }

    public function getBody(): PullRequestBody
    {
        return $this->body;
    }

    public function getAuthor(): PullRequestAuthor
    {
        return $this->author;
    }

    public function getHeadRepository(): ?HeadRepository
    {
        return $this->headRepository;
    }

    public function getAssignees(): PullRequestAssignees
    {
        return $this->assignees;
    }

    /** @return array|AccountId[] */
    public function getAssigneeIds(): array
    {
        $assigneeIds = [];

        foreach ($this->getAssignees()->toArray() as $assignee) {
            $assigneeIds[] = $assignee->getUserId();
        }

        return $assigneeIds;
    }

    public function getReviewRequests(): PullRequestReviewRequests
    {
        return $this->reviewRequests;
    }

    /** @return array|AccountId[] */
    public function getRequestedReviewerIds(): array
    {
        $requestedReviewerIds = [];

        foreach ($this->getReviewRequests()->toArray() as $reviewRequest) {
            $requestedReviewerIds[] = $reviewRequest->getRequestedReviewer()->getUserId();
        }

        return $requestedReviewerIds;
    }

    /** @return array|PullRequestRequestedReviewer[] */
    public function getRequestedReviewers(): array
    {
        $requestedReviewers = [];

        foreach ($this->getReviewRequests()->toArray() as $reviewRequest) {
            $requestedReviewers[] = $reviewRequest->getRequestedReviewer();
        }

        return $requestedReviewers;
    }

    public function getReviews(): PullRequestReviews
    {
        return $this->reviews;
    }

    public function getMilestone(): ?PullRequestMilestone
    {
        return $this->milestone;
    }

    public function getLabels(): PullRequestLabels
    {
        return $this->labels;
    }

    /** @return array|LabelId[] */
    public function getLabelIds(): array
    {
        $labelIds = [];
        foreach ($this->labels->toArray() as $label) {
            $labelIds[] = $label->getId();
        }

        return $labelIds;
    }

    public function getCreatedAt(): PullRequestCreatedAt
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): PullRequestUpdatedAt
    {
        return $this->updatedAt;
    }

    public function serialize(): array
    {
        if (null === $this->headRepository) {
            $headRepository = null;
        } else {
            $headRepository = $this->headRepository->serialize();
        }

        if (null === $this->milestone) {
            $milestone = null;
        } else {
            $milestone = $this->milestone->serialize();
        }

        return [
            '__type'         => get_class($this),
            'id'             => $this->id->serialize(),
            'number'         => $this->number->serialize(),
            'title'          => $this->title->serialize(),
            'body'           => $this->body->serialize(),
            'author'         => $this->author->serialize(),
            'headRepository' => $headRepository,
            'assignees'      => $this->assignees->serialize(),
            'reviewRequests' => $this->reviewRequests->serialize(),
            'reviews'        => $this->reviews->serialize(),
            'milestone'      => $milestone,
            'labels'         => $this->labels->serialize(),
            'createdAt'      => $this->createdAt->serialize(),
            'updatedAt'      => $this->updatedAt->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['headRepository']) {
            $headRepository = null;
        } else {
            $headRepository = HeadRepository::deserialize($data['headRepository']);
        }

        if (null === $data['milestone']) {
            $milestone = null;
        } else {
            $milestone = PullRequestMilestone::deserialize($data['milestone']);
        }

        return new self(
            PullRequestId::deserialize($data['id']),
            PullRequestNumber::deserialize($data['number']),
            PullRequestTitle::deserialize($data['title']),
            PullRequestBody::deserialize($data['body']),
            PullRequestAuthor::deserialize($data['author']),
            $headRepository,
            PullRequestAssignees::deserialize($data['assignees']),
            PullRequestReviewRequests::deserialize($data['reviewRequests']),
            PullRequestReviews::deserialize($data['reviews']),
            $milestone,
            PullRequestLabels::deserialize($data['labels']),
            PullRequestCreatedAt::deserialize($data['createdAt']),
            PullRequestUpdatedAt::deserialize($data['updatedAt'])
        );
    }
}
