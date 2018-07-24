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
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequests;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequests
 * @group  unit
 */
class PullRequestsTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var PullRequests */
    private $sut;

    /** @SuppressWarnings(PHPMD.ExcessiveMethodLength) */
    public function setUp(): void
    {
        $this->elements = [
            new MergedPullRequest(
                new PullRequestId(1),
                new PullRequestNumber(1),
                new PullRequestTitle('value'),
                new PullRequestBody('value'),
                new PullRequestAuthor(
                    new AccountId(1),
                    new AccountLogin('value'),
                    'name',
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                ),
                new HeadRepository(
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
                ),
                new PullRequestAssignees(
                    [
                        new PullRequestAssignee(
                            new AccountId(1),
                            new AccountLogin('value'),
                            AccountType::USER(),
                            new AccountAvatarUrl('avatarUrl'),
                            true
                        ),
                    ]
                ),
                new PullRequestReviewRequests(
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
                ),
                new PullRequestReviews(
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
                ),
                new PullRequestMilestone(
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
                ),
                new PullRequestLabels(
                    [new PullRequestLabel(new LabelId(1), new LabelName('value'), new LabelColor('color'), true)]
                ),
                new PullRequestMergeDetails(
                    new PullRequestMergedBy(
                        new AccountId(1),
                        new AccountLogin('value'),
                        'name',
                        AccountType::USER(),
                        new AccountAvatarUrl('avatarUrl'),
                        true
                    ),
                    new DateTime('2018-01-01T00:01:00+00:00')
                ),
                new PullRequestClosedAt('2018-01-01T00:01:00+00:00'),
                new PullRequestCreatedAt('2018-01-01T00:01:00+00:00'),
                new PullRequestUpdatedAt('2018-01-01T00:01:00+00:00')
            ),
        ];
        $this->sut = new PullRequests($this->elements);
    }

    public function testGetElements(): void
    {
        self::assertSame($this->elements, $this->sut->toArray());
    }

    public function testSerializeAndDeserialize(): void
    {
        $serialized     = $this->sut->serialize();
        $serializedJson = json_encode($serialized);
        self::assertEquals($this->sut, $this->sut::deserialize(json_decode($serializedJson, true)));
    }
}
