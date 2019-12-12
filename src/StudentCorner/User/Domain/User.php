<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    /** @var UserId */
    private $id;
    /** @var UserEmail */
    private $email;
    /** @var UserEncryptedPassword */
    private $password;

    public function __construct(UserId $id, UserEmail $email, UserEncryptedPassword $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(UserId $id, UserEmail $email, UserEncryptedPassword $encryptedPassword)
    {
        $user = new User($id, $email, $encryptedPassword);

        $user->record(UserSignedUpDomainEvent::create($user));

        return $user;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserEncryptedPassword
    {
        return $this->password;
    }
}
