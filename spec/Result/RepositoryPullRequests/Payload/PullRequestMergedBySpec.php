<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergedBy;
use PhpSpec\ObjectBehavior;

class PullRequestMergedBySpec extends ObjectBehavior
{
    public function let(AccountId $userId, AccountLogin $login, AccountType $type, AccountAvatarUrl $avatarUrl)
    {
        $this->beConstructedWith($userId, $login, $name = 'Octo cat', $type, $avatarUrl, $siteAdmin = false);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestMergedBy::class);
    }

    public function it_exposes_user_id(AccountId $userId)
    {
        $this->getUserId()->shouldReturn($userId);
    }

    public function it_exposes_login(AccountLogin $login)
    {
        $this->getLogin()->shouldReturn($login);
    }

    public function it_exposes_name()
    {
        $this->getName()->shouldReturn('Octo cat');
    }

    public function it_exposes_type(AccountType $type)
    {
        $this->getType()->shouldReturn($type);
    }

    public function it_exposes_avatar_url(AccountAvatarUrl $avatarUrl)
    {
        $this->getAvatarUrl()->shouldReturn($avatarUrl);
    }

    public function it_exposes_is_site_admin()
    {
        $this->isSiteAdmin()->shouldReturn(false);
    }

    public function it_can_be_serialized(
        AccountId $userId, AccountLogin $login, AccountType $type, AccountAvatarUrl $avatarUrl
    ) {
        $userId->serialize()->shouldBeCalled()->willReturn(583231);
        $login->serialize()->shouldBeCalled()->willReturn('octocat');
        $type->serialize()->shouldBeCalled()->willReturn('User');
        $avatarUrl->serialize()->shouldBeCalled()->willReturn('https://avatars3.githubusercontent.com/u/583231?v=4');
        $this->serialize()->shouldReturn(
            [
                'userId'    => 583231,
                'login'     => 'octocat',
                'name'      => 'Octo cat',
                'type'      => 'User',
                'avatarUrl' => 'https://avatars3.githubusercontent.com/u/583231?v=4',
                'siteAdmin' => false,
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'userId'    => 583231,
            'login'     => 'octocat',
            'name'      => 'Octo cat',
            'type'      => 'User',
            'avatarUrl' => 'https://avatars3.githubusercontent.com/u/583231?v=4',
            'siteAdmin' => false,
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(PullRequestMergedBy::class);
    }
}
