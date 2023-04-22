<?php
namespace App\Repository;

use App\Entity\TaskEntity;

class TaskRepository extends BaseRepository
{
  public function create(TaskEntity $task): TaskEntity
  {
    $query = '
      INSERT INTO `tasks`
        (`uid`, `title`, `status`, `createdAt`, `updatedAt`)
      VALUES
        (:uid, :title, :status, :createdAt, :updatedAt)
    ';

    $statement = $this->getDb()->prepare($query);
    $statement->bindParam('uid', $task->uid);
    $statement->bindParam('title', $task->title);
    $statement->bindParam('status', $task->status);
    $statement->bindParam('createdAt', $task->createdAt);
    $statement->bindParam('updatedAt', $task->updatedAt);
    $statement->execute();

    $taskId = (int) $this->database->lastInsertId();

    return $this->checkAndGetTask($taskId, $task->uid);
  }

  public function checkAndGetTask(int $taskId, string $userId): TaskEntity
  {
    $query = 'SELECT * FROM `tasks` WHERE `id` = :id AND `uid` = :uid';
    $statement = $this->getDb()->prepare($query);
    $statement->bindParam('id', $taskId);
    $statement->bindParam('uid', $userId);
    $statement->execute();

    $task = $statement->fetchObject(TaskEntity::class);
    if (! $task) {
        throw new \App\Exception\Auth('Task not found.', 404);
    }

    return $task;
  }

}