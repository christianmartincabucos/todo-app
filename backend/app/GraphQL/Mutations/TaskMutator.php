<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Task;

final class TaskMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function deleteAll($rootValue, array $args)
    {
        Task::query()->delete();
        return 'All tasks have been deleted.';
    }
}
