<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewBody;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewId;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewState;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewSubmittedAt;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReview;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewAuthor;
use PhpSpec\ObjectBehavior;

class PullRequestReviewSpec extends ObjectBehavior
{
    public function let(
        PullRequestReviewId $id,
        PullRequestReviewBody $body,
        PullRequestReviewAuthor $author,
        PullRequestReviewState $state,
        CommitSha $commitSha,
        PullRequestReviewSubmittedAt $submittedAt
    ) {
        $this->beConstructedWith($id, $body, $author, $state, $commitSha, $submittedAt);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestReview::class);
    }

    public function it_exposes_id(PullRequestReviewId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_body(PullRequestReviewBody $body)
    {
        $this->getBody()->shouldReturn($body);
    }

    public function it_exposes_author(PullRequestReviewAuthor $author)
    {
        $this->getAuthor()->shouldReturn($author);
    }

    public function it_exposes_state(PullRequestReviewState $state)
    {
        $this->getState()->shouldReturn($state);
    }

    public function it_exposes_commit_sha(CommitSha $commitSha)
    {
        $this->getCommitSha()->shouldReturn($commitSha);
    }

    public function it_exposes_submitted_at(PullRequestReviewSubmittedAt $submittedAt)
    {
        $this->getSubmittedAt()->shouldReturn($submittedAt);
    }

    public function it_has_submitted_at()
    {
        $this->hasSubmittedAt()->shouldReturn(true);
    }

    public function it_can_be_serialized(
        PullRequestReviewId $id,
        PullRequestReviewBody $body,
        PullRequestReviewAuthor $author,
        PullRequestReviewState $state,
        CommitSha $commitSha,
        PullRequestReviewSubmittedAt $submittedAt
    ) {
        $id->serialize()->shouldBeCalled()->willReturn(1);
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
        $state->serialize()->shouldBeCalled()->willReturn(PullRequestReviewState::APPROVED);
        $commitSha->serialize()->shouldBeCalled()->willReturn('sha');
        $submittedAt->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $this->serialize()->shouldReturn(
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
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
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
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(PullRequestReview::class);
    }
}
