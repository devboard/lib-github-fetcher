<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DateTime;
use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;
use DevboardLib\GitHub\Milestone\MilestoneClosedAt;
use DevboardLib\GitHub\Milestone\MilestoneCreatedAt;
use DevboardLib\GitHub\Milestone\MilestoneCreator;
use DevboardLib\GitHub\Milestone\MilestoneDescription;
use DevboardLib\GitHub\Milestone\MilestoneDueOn;
use DevboardLib\GitHub\Milestone\MilestoneId;
use DevboardLib\GitHub\Milestone\MilestoneNumber;
use DevboardLib\GitHub\Milestone\MilestoneState;
use DevboardLib\GitHub\Milestone\MilestoneTitle;
use DevboardLib\GitHub\Milestone\MilestoneUpdatedAt;
use DevboardLib\GitHub\PullRequest\PullRequestBody;
use DevboardLib\GitHub\PullRequest\PullRequestClosedAt;
use DevboardLib\GitHub\PullRequest\PullRequestCreatedAt;
use DevboardLib\GitHub\PullRequest\PullRequestId;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\PullRequest\PullRequestTitle;
use DevboardLib\GitHub\PullRequest\PullRequestUpdatedAt;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewBody;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewId;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewState;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewSubmittedAt;
use DevboardLib\GitHub\Repo\RepoCreatedAt;
use DevboardLib\GitHub\Repo\RepoDescription;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\Repo\RepoHomepage;
use DevboardLib\GitHub\Repo\RepoId;
use DevboardLib\GitHub\Repo\RepoLanguage;
use DevboardLib\GitHub\Repo\RepoMirrorUrl;
use DevboardLib\GitHub\Repo\RepoName;
use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHub\Repo\RepoParent;
use DevboardLib\GitHub\Repo\RepoPushedAt;
use DevboardLib\GitHub\Repo\RepoTimestamps;
use DevboardLib\GitHub\Repo\RepoUpdatedAt;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\HeadRepository;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\MergedPullRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignee;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignees;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAuthor;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabel;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabels;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergedBy;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergeDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMilestone;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestRequestedReviewer;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReview;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewAuthor;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequests;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviews;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\MergedPullRequest
 * @group  unit
 */
class MergedPullRequestTest extends TestCase
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

    /** @var HeadRepository */
    private $headRepository;

    /** @var PullRequestAssignees */
    private $assignees;

    /** @var PullRequestReviewRequests */
    private $reviewRequests;

    /** @var PullRequestReviews */
    private $reviews;

    /** @var PullRequestMilestone */
    private $milestone;

    /** @var PullRequestLabels */
    private $labels;

    /** @var PullRequestMergeDetails */
    private $mergeDetails;

    /** @var PullRequestClosedAt|null */
    private $closedAt;

    /** @var PullRequestCreatedAt */
    private $createdAt;

    /** @var PullRequestUpdatedAt */
    private $updatedAt;

    /** @var MergedPullRequest */
    private $sut;

    public function setUp(): void
    {
        $this->id     = new PullRequestId(1);
        $this->number = new PullRequestNumber(1);
        $this->title  = new PullRequestTitle('value');
        $this->body   = new PullRequestBody('value');
        $this->author = new PullRequestAuthor(
            new AccountId(1),
            new AccountLogin('value'),
            'name',
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->headRepository = new HeadRepository(
            new RepoId(1),
            new RepoFullName(new AccountLogin('value'), new RepoName('name')),
            new RepoOwner(
                new AccountId(1),
                new AccountLogin('value'),
                AccountType::USER(),
                new AccountAvatarUrl('avatarUrl'),
                true
            ),
            true,
            new BranchName('name'),
            true,
            new RepoParent(new RepoId(1), new RepoFullName(new AccountLogin('value'), new RepoName('name'))),
            new RepoDescription('description'),
            new RepoHomepage('homepage'),
            new RepoLanguage('language'),
            new RepoMirrorUrl('mirrorUrl'),
            true,
            new RepoTimestamps(
                new RepoCreatedAt('2018-01-01T00:01:00+00:00'),
                new RepoUpdatedAt('2018-01-01T00:01:00+00:00'),
                new RepoPushedAt('2018-01-01T00:01:00+00:00')
            )
        );
        $this->assignees = new PullRequestAssignees(
            [
                new PullRequestAssignee(
                    new AccountId(1),
                    new AccountLogin('value'),
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                ),
            ]
        );
        $this->reviewRequests = new PullRequestReviewRequests(
            [
                new PullRequestReviewRequest(
                    1,
                    new PullRequestRequestedReviewer(
                        new AccountId(1),
                        new AccountLogin('value'),
                        'name',
                        AccountType::USER(),
                        new AccountAvatarUrl('avatarUrl'),
                        true
                    )
                ),
            ]
        );
        $this->reviews = new PullRequestReviews(
            [
                new PullRequestReview(
                    new PullRequestReviewId(1),
                    new PullRequestReviewBody('value'),
                    new PullRequestReviewAuthor(
                        new AccountId(1),
                        new AccountLogin('value'),
                        'name',
                        AccountType::USER(),
                        new AccountAvatarUrl('avatarUrl'),
                        true
                    ),
                    PullRequestReviewState::APPROVED(),
                    new CommitSha('sha'),
                    new PullRequestReviewSubmittedAt('2018-01-01T00:01:00+00:00')
                ),
            ]
        );
        $this->milestone = new PullRequestMilestone(
            new MilestoneId(1),
            new MilestoneTitle('value'),
            new MilestoneDescription('value'),
            new MilestoneDueOn('2018-01-01T00:01:00+00:00'),
            MilestoneState::OPEN(),
            new MilestoneNumber(1),
            new MilestoneCreator(
                new AccountId(1),
                new AccountLogin('value'),
                AccountType::USER(),
                new AccountAvatarUrl('avatarUrl'),
                true
            ),
            new MilestoneClosedAt('2018-01-01T00:01:00+00:00'),
            new MilestoneCreatedAt('2018-01-01T00:01:00+00:00'),
            new MilestoneUpdatedAt('2018-01-01T00:01:00+00:00')
        );
        $this->labels = new PullRequestLabels(
            [new PullRequestLabel(new LabelId(1), new LabelName('value'), new LabelColor('color'), true)]
        );
        $this->mergeDetails = new PullRequestMergeDetails(
            new PullRequestMergedBy(
                new AccountId(1),
                new AccountLogin('value'),
                'name',
                AccountType::USER(),
                new AccountAvatarUrl('avatarUrl'),
                true
            ),
            new DateTime('2018-01-01T00:01:00+00:00')
        );
        $this->closedAt  = new PullRequestClosedAt('2018-01-01T00:01:00+00:00');
        $this->createdAt = new PullRequestCreatedAt('2018-01-01T00:01:00+00:00');
        $this->updatedAt = new PullRequestUpdatedAt('2018-01-01T00:01:00+00:00');
        $this->sut       = new MergedPullRequest(
            $this->id,
            $this->number,
            $this->title,
            $this->body,
            $this->author,
            $this->headRepository,
            $this->assignees,
            $this->reviewRequests,
            $this->reviews,
            $this->milestone,
            $this->labels,
            $this->mergeDetails,
            $this->closedAt,
            $this->createdAt,
            $this->updatedAt
        );
    }

    public function testGetId(): void
    {
        self::assertSame($this->id, $this->sut->getId());
    }

    public function testGetNumber(): void
    {
        self::assertSame($this->number, $this->sut->getNumber());
    }

    public function testGetTitle(): void
    {
        self::assertSame($this->title, $this->sut->getTitle());
    }

    public function testGetBody(): void
    {
        self::assertSame($this->body, $this->sut->getBody());
    }

    public function testGetAuthor(): void
    {
        self::assertSame($this->author, $this->sut->getAuthor());
    }

    public function testGetHeadRepository(): void
    {
        self::assertSame($this->headRepository, $this->sut->getHeadRepository());
    }

    public function testGetAssignees(): void
    {
        self::assertSame($this->assignees, $this->sut->getAssignees());
    }

    public function testGetReviewRequests(): void
    {
        self::assertSame($this->reviewRequests, $this->sut->getReviewRequests());
    }

    public function testGetReviews(): void
    {
        self::assertSame($this->reviews, $this->sut->getReviews());
    }

    public function testGetMilestone(): void
    {
        self::assertSame($this->milestone, $this->sut->getMilestone());
    }

    public function testGetLabels(): void
    {
        self::assertSame($this->labels, $this->sut->getLabels());
    }

    public function testGetMergeDetails(): void
    {
        self::assertSame($this->mergeDetails, $this->sut->getMergeDetails());
    }

    public function testGetClosedAt(): void
    {
        self::assertSame($this->closedAt, $this->sut->getClosedAt());
    }

    public function testGetCreatedAt(): void
    {
        self::assertSame($this->createdAt, $this->sut->getCreatedAt());
    }

    public function testGetUpdatedAt(): void
    {
        self::assertSame($this->updatedAt, $this->sut->getUpdatedAt());
    }

    public function testHasClosedAt(): void
    {
        self::assertTrue($this->sut->hasClosedAt());
    }

    public function testSerialize(): void
    {
        $expected = [
            '__type' => 'DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\MergedPullRequest',
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
            'labels'       => [['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true]],
            'mergeDetails' => [
                'mergedBy' => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'name'      => 'name',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'mergedAt' => '2018-01-01T00:01:00+00:00',
            ],
            'closedAt'  => '2018-01-01T00:01:00+00:00',
            'createdAt' => '2018-01-01T00:01:00+00:00',
            'updatedAt' => '2018-01-01T00:01:00+00:00',
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, MergedPullRequest::deserialize(json_decode($serialized, true)));
    }
}
