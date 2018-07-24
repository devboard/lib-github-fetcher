<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Milestone\MilestoneState;
use DevboardLib\GitHub\PullRequest\PullRequestBody;
use DevboardLib\GitHub\PullRequest\PullRequestClosedAt;
use DevboardLib\GitHub\PullRequest\PullRequestCreatedAt;
use DevboardLib\GitHub\PullRequest\PullRequestId;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\PullRequest\PullRequestTitle;
use DevboardLib\GitHub\PullRequest\PullRequestUpdatedAt;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewState;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\ClosedPullRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\HeadRepository;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignees;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAuthor;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabels;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMilestone;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequests;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviews;
use PhpSpec\ObjectBehavior;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class ClosedPullRequestSpec extends ObjectBehavior
{
    public function let(
        PullRequestId $id,
        PullRequestNumber $number,
        PullRequestTitle $title,
        PullRequestBody $body,
        PullRequestAuthor $author,
        HeadRepository $headRepository,
        PullRequestAssignees $assignees,
        PullRequestReviewRequests $reviewRequests,
        PullRequestReviews $reviews,
        PullRequestMilestone $milestone,
        PullRequestLabels $labels,
        PullRequestClosedAt $closedAt,
        PullRequestCreatedAt $createdAt,
        PullRequestUpdatedAt $updatedAt
    ) {
        $this->beConstructedWith(
            $id,
            $number,
            $title,
            $body,
            $author,
            $headRepository,
            $assignees,
            $reviewRequests,
            $reviews,
            $milestone,
            $labels,
            $closedAt,
            $createdAt,
            $updatedAt
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClosedPullRequest::class);
        $this->shouldImplement(PullRequest::class);
    }

    public function it_exposes_id(PullRequestId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_number(PullRequestNumber $number)
    {
        $this->getNumber()->shouldReturn($number);
    }

    public function it_exposes_title(PullRequestTitle $title)
    {
        $this->getTitle()->shouldReturn($title);
    }

    public function it_exposes_body(PullRequestBody $body)
    {
        $this->getBody()->shouldReturn($body);
    }

    public function it_exposes_author(PullRequestAuthor $author)
    {
        $this->getAuthor()->shouldReturn($author);
    }

    public function it_exposes_head_repository(HeadRepository $headRepository)
    {
        $this->getHeadRepository()->shouldReturn($headRepository);
    }

    public function it_exposes_assignees(PullRequestAssignees $assignees)
    {
        $this->getAssignees()->shouldReturn($assignees);
    }

    public function it_exposes_review_requests(PullRequestReviewRequests $reviewRequests)
    {
        $this->getReviewRequests()->shouldReturn($reviewRequests);
    }

    public function it_exposes_reviews(PullRequestReviews $reviews)
    {
        $this->getReviews()->shouldReturn($reviews);
    }

    public function it_exposes_milestone(PullRequestMilestone $milestone)
    {
        $this->getMilestone()->shouldReturn($milestone);
    }

    public function it_exposes_labels(PullRequestLabels $labels)
    {
        $this->getLabels()->shouldReturn($labels);
    }

    public function it_exposes_closed_at(PullRequestClosedAt $closedAt)
    {
        $this->getClosedAt()->shouldReturn($closedAt);
    }

    public function it_exposes_created_at(PullRequestCreatedAt $createdAt)
    {
        $this->getCreatedAt()->shouldReturn($createdAt);
    }

    public function it_exposes_updated_at(PullRequestUpdatedAt $updatedAt)
    {
        $this->getUpdatedAt()->shouldReturn($updatedAt);
    }

    public function it_has_closed_at()
    {
        $this->hasClosedAt()->shouldReturn(true);
    }

    public function it_can_be_serialized(
        PullRequestId $id,
        PullRequestNumber $number,
        PullRequestTitle $title,
        PullRequestBody $body,
        PullRequestAuthor $author,
        HeadRepository $headRepository,
        PullRequestAssignees $assignees,
        PullRequestReviewRequests $reviewRequests,
        PullRequestReviews $reviews,
        PullRequestMilestone $milestone,
        PullRequestLabels $labels,
        PullRequestClosedAt $closedAt,
        PullRequestCreatedAt $createdAt,
        PullRequestUpdatedAt $updatedAt
    ) {
        $id->serialize()->shouldBeCalled()->willReturn(1);
        $number->serialize()->shouldBeCalled()->willReturn(1);
        $title->serialize()->shouldBeCalled()->willReturn('value');
        $body->serialize()->shouldBeCalled()->willReturn('value');
        $author->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $headRepository->serialize()->shouldBeCalled()->willReturn(
            [
                'id'       => 1,
                'fullName' => ['owner' => 'value', 'repoName' => 'name'],
                'owner'    => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'private'       => true,
                'defaultBranch' => 'name',
                'fork'          => true,
                'parent'        => ['id' => 1, 'fullName' => ['owner' => 'value', 'repoName' => 'name']],
                'description'   => 'description',
                'homepage'      => 'homepage',
                'language'      => 'language',
                'mirrorUrl'     => 'mirrorUrl',
                'archived'      => true,
                'timestamps'    => [
                    'createdAt' => '2018-01-01T00:01:00+00:00',
                    'updatedAt' => '2018-01-01T00:01:00+00:00',
                    'pushedAt'  => '2018-01-01T00:01:00+00:00',
                ],
            ]
        );
        $assignees->serialize()->shouldBeCalled()->willReturn(
            [
                [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
            ]
        );
        $reviewRequests->serialize()->shouldBeCalled()->willReturn(
            [
                [
                    'id'                => 1,
                    'requestedReviewer' => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'name'      => 'name',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                ],
            ]
        );
        $reviews->serialize()->shouldBeCalled()->willReturn(
            [
                [
                    'id'     => 1,
                    'body'   => 'value',
                    'author' => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'name'      => 'name',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'state'       => PullRequestReviewState::APPROVED,
                    'commitSha'   => 'sha',
                    'submittedAt' => '2018-01-01T00:01:00+00:00',
                ],
            ]
        );
        $milestone->serialize()->shouldBeCalled()->willReturn(
            [
                'id'          => 1,
                'title'       => 'value',
                'description' => 'value',
                'dueOn'       => '2018-01-01T00:01:00+00:00',
                'state'       => MilestoneState::OPEN,
                'number'      => 1,
                'creator'     => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'closedAt'  => '2018-01-01T00:01:00+00:00',
                'createdAt' => '2018-01-01T00:01:00+00:00',
                'updatedAt' => '2018-01-01T00:01:00+00:00',
            ]
        );
        $labels->serialize()->shouldBeCalled()->willReturn(
            [['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true]]
        );
        $closedAt->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $createdAt->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $updatedAt->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $this->serialize()->shouldReturn(
            [
                '__type' => 'DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\ClosedPullRequest',
                'id'     => 1,
                'number' => 1,
                'title'  => 'value',
                'body'   => 'value',
                'author' => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'name'      => 'name',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'headRepository' => [
                    'id'       => 1,
                    'fullName' => ['owner' => 'value', 'repoName' => 'name'],
                    'owner'    => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'private'       => true,
                    'defaultBranch' => 'name',
                    'fork'          => true,
                    'parent'        => ['id' => 1, 'fullName' => ['owner' => 'value', 'repoName' => 'name']],
                    'description'   => 'description',
                    'homepage'      => 'homepage',
                    'language'      => 'language',
                    'mirrorUrl'     => 'mirrorUrl',
                    'archived'      => true,
                    'timestamps'    => [
                        'createdAt' => '2018-01-01T00:01:00+00:00',
                        'updatedAt' => '2018-01-01T00:01:00+00:00',
                        'pushedAt'  => '2018-01-01T00:01:00+00:00',
                    ],
                ],
                'assignees' => [
                    [
                        'userId'    => 1,
                        'login'     => 'value',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                ],
                'reviewRequests' => [
                    [
                        'id'                => 1,
                        'requestedReviewer' => [
                            'userId'    => 1,
                            'login'     => 'value',
                            'name'      => 'name',
                            'type'      => AccountType::USER,
                            'avatarUrl' => 'avatarUrl',
                            'siteAdmin' => true,
                        ],
                    ],
                ],
                'reviews' => [
                    [
                        'id'     => 1,
                        'body'   => 'value',
                        'author' => [
                            'userId'    => 1,
                            'login'     => 'value',
                            'name'      => 'name',
                            'type'      => AccountType::USER,
                            'avatarUrl' => 'avatarUrl',
                            'siteAdmin' => true,
                        ],
                        'state'       => PullRequestReviewState::APPROVED,
                        'commitSha'   => 'sha',
                        'submittedAt' => '2018-01-01T00:01:00+00:00',
                    ],
                ],
                'milestone' => [
                    'id'          => 1,
                    'title'       => 'value',
                    'description' => 'value',
                    'dueOn'       => '2018-01-01T00:01:00+00:00',
                    'state'       => MilestoneState::OPEN,
                    'number'      => 1,
                    'creator'     => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'closedAt'  => '2018-01-01T00:01:00+00:00',
                    'createdAt' => '2018-01-01T00:01:00+00:00',
                    'updatedAt' => '2018-01-01T00:01:00+00:00',
                ],
                'labels'    => [['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true]],
                'closedAt'  => '2018-01-01T00:01:00+00:00',
                'createdAt' => '2018-01-01T00:01:00+00:00',
                'updatedAt' => '2018-01-01T00:01:00+00:00',
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'id'     => 1,
            'number' => 1,
            'title'  => 'value',
            'body'   => 'value',
            'author' => [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'headRepository' => [
                'id'       => 1,
                'fullName' => ['owner' => 'value', 'repoName' => 'name'],
                'owner'    => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'private'       => true,
                'defaultBranch' => 'name',
                'fork'          => true,
                'parent'        => ['id' => 1, 'fullName' => ['owner' => 'value', 'repoName' => 'name']],
                'description'   => 'description',
                'homepage'      => 'homepage',
                'language'      => 'language',
                'mirrorUrl'     => 'mirrorUrl',
                'archived'      => true,
                'timestamps'    => [
                    'createdAt' => '2018-01-01T00:01:00+00:00',
                    'updatedAt' => '2018-01-01T00:01:00+00:00',
                    'pushedAt'  => '2018-01-01T00:01:00+00:00',
                ],
            ],
            'assignees' => [
                [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
            ],
            'reviewRequests' => [
                [
                    'id'                => 1,
                    'requestedReviewer' => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'name'      => 'name',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                ],
            ],
            'reviews' => [
                [
                    'id'     => 1,
                    'body'   => 'value',
                    'author' => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'name'      => 'name',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'state'       => PullRequestReviewState::APPROVED,
                    'commitSha'   => 'sha',
                    'submittedAt' => '2018-01-01T00:01:00+00:00',
                ],
            ],
            'milestone' => [
                'id'          => 1,
                'title'       => 'value',
                'description' => 'value',
                'dueOn'       => '2018-01-01T00:01:00+00:00',
                'state'       => MilestoneState::OPEN,
                'number'      => 1,
                'creator'     => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'closedAt'  => '2018-01-01T00:01:00+00:00',
                'createdAt' => '2018-01-01T00:01:00+00:00',
                'updatedAt' => '2018-01-01T00:01:00+00:00',
            ],
            'labels'    => [['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true]],
            'closedAt'  => '2018-01-01T00:01:00+00:00',
            'createdAt' => '2018-01-01T00:01:00+00:00',
            'updatedAt' => '2018-01-01T00:01:00+00:00',
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(ClosedPullRequest::class);
    }
}
