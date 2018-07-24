<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\Committer\CommitterName;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitCommitterDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitCommitter;
use PhpSpec\ObjectBehavior;

class BasicCommitCommitterDetailsSpec extends ObjectBehavior
{
    public function let(CommitterName $name, EmailAddress $email, CommitDate $commitDate)
    {
        $this->beConstructedWith($name, $email, $commitDate);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BasicCommitCommitterDetails::class);
        $this->shouldImplement(CommitCommitter::class);
    }

    public function it_exposes_name(CommitterName $name)
    {
        $this->getName()->shouldReturn($name);
    }

    public function it_exposes_email(EmailAddress $email)
    {
        $this->getEmail()->shouldReturn($email);
    }

    public function it_exposes_commit_date(CommitDate $commitDate)
    {
        $this->getCommitDate()->shouldReturn($commitDate);
    }

    public function it_can_be_serialized(CommitterName $name, EmailAddress $email, CommitDate $commitDate)
    {
        $name->serialize()->shouldBeCalled()->willReturn('Jane Johnson');
        $email->serialize()->shouldBeCalled()->willReturn('jane@example.com');
        $commitDate->serialize()->shouldBeCalled()->willReturn('2018-01-02T20:21:22+00:00');
        $this->serialize()->shouldReturn(
            [
                '__type'     => 'BasicCommitCommitterDetails',
                'name'       => 'Jane Johnson',
                'email'      => 'jane@example.com',
                'commitDate' => '2018-01-02T20:21:22+00:00',
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            '__type'     => 'BasicCommitCommitterDetails',
            'name'       => 'Jane Johnson',
            'email'      => 'jane@example.com',
            'commitDate' => '2018-01-02T20:21:22+00:00',
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(BasicCommitCommitterDetails::class);
    }
}
