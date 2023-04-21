<?php
namespace App\Repository;

use App\Entity\UserEntity;

class UserRepository extends BaseRepository
{
  public function loginUser(string $email, string $password): UserEntity
  {
    $query = 'SELECT * FROM `users` WHERE `email` = :email ORDER BY `id`';
    $statement = $this->database->prepare($query);
    $statement->bindParam('email', $email);
    $statement->execute();

    $user = $statement->fetchObject(UserEntity::class);
    if (! $user) {
        throw new \App\Exception\Auth(
            'Login failed: Email or password incorrect.', 400
        );
    }

    return $user;
  }

  public function createUser(UserEntity $user): UserEntity
  {
    $query     = 'INSERT INTO `users` (`email`, `password`) VALUES (:email, :password)';
    $statement = $this->database->prepare($query);
    $email     = $user->getEmail();
    $password  = $user->getPassword();

    $statement->bindParam('email', $email);
    $statement->bindParam('password', $password);
    $statement->execute();

    return $this->getUser((int) $this->database->lastInsertId());
  }

  public function getUser(int $userId): UserEntity
  {
    $query     = 'SELECT `id`, `email` FROM `users` WHERE `id` = :id';
    $statement = $this->database->prepare($query);
    $statement->bindParam('id', $userId);
    $statement->execute();
    $user = $statement->fetchObject(UserEntity::class);
    if (! $user) {
        throw new \App\Exception\Auth('User not found.', 404);
    }

    return $user;
  }

  public function checkUserByEmail(string $email): void
  {
      $query     = 'SELECT * FROM `users` WHERE `email` = :email';
      $statement = $this->database->prepare($query);
      $statement->bindParam('email', $email);
      $statement->execute();
      $user = $statement->fetchObject();
      if ($user) {
          throw new \App\Exception\Auth('Email already exists.', 400);
      }
  }
}