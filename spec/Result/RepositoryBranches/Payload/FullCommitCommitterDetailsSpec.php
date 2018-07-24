<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\Committer\CommitterName;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitCommitter;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\FullCommitCommitterDetails;
use PhpSpec\ObjectBehavior;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class FullCommitCommitterDetailsSpec extends ObjectBehavior
{
    public function let(
        CommitterName $name,
        EmailAddress $email,
        CommitDate $commitDate,
        UserId $userId,
        UserLogin $login,
        AccountType $type,
        UserAvatarUrl $avatarUrl
    ) {
        $this->beConstructedWith($name, $email, $commitDate, $userId, $login, $type, $avatarUrl, $siteAdmin = false);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FullCommitCommitterDetails::class);
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

    public function it_exposes_user_id(UserId $userId)
    {
        $this->getUserId()->shouldReturn($userId);
    }

    public function it_exposes_login(UserLogin $login)
    {
        $this->getLogin()->shouldReturn($login);
    }

    public function it_exposes_type(AccountType $type)
    {
        $this->getType()->shouldReturn($type);
    }

    public function it_exposes_avatar_url(UserAvatarUrl $avatarUrl)
    {
        $this->getAvatarUrl()->shouldReturn($avatarUrl);
    }

    public function it_exposes_is_site_admin()
    {
        $this->isSiteAdmin()->shouldReturn(false);
    }

    public function it_can_be_serialized(
        CommitterName $name,
        EmailAddress $email,
        CommitDate $commitDate,
        UserId $userId,
        UserLogin $login,
        AccountType $type,
        UserAvatarUrl $avatarUrl
    ) {
        $name->serialize()->shouldBeCalled()->willReturn('Jane Johnson');
        $email->serialize()->shouldBeCalled()->willReturn('jane@example.com');
        $commitDate->serialize()->shouldBeCalled()->willReturn('2018-01-02T20:21:22+00:00');
        $userId->serialize()->shouldBeCalled()->willReturn(6752317);
        $login->serialize()->shouldBeCalled()->willReturn('baxterthehacker');
        $type->serialize()->shouldBeCalled()->willReturn('User');
        $avatarUrl->serialize()->shouldBeCalled()->willReturn('https://avatars.githubusercontent.com/u/6752317?v=3');
        $this->serialize()->shouldReturn(
            [
                '__type'     => 'FullCommitCommitterDetails',
                'name'       => 'Jane Johnson',
                'email'      => 'jane@example.com',
                'commitDate' => '2018-01-02T20:21:22+00:00',
                'userId'     => 6752317,
                'login'      => 'baxterthehacker',
                'type'       => 'User',
                'avatarUrl'  => 'https://avatars.githubusercontent.com/u/6752317?v=3',
                'siteAdmin'  => false,
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            '__type'     => 'FullCommitCommitterDetails',
            'name'       => 'Jane Johnson',
            'email'      => 'jane@example.com',
            'commitDate' => '2018-01-02T20:21:22+00:00',
            'userId'     => 6752317,
            'login'      => 'baxterthehacker',
            'type'       => 'User',
            'avatarUrl'  => 'https://avatars.githubusercontent.com/u/6752317?v=3',
            'siteAdmin'  => false,
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(FullCommitCommitterDetails::class);
    }
}
