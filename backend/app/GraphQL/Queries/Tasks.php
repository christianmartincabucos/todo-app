<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Task;

final class Tasks
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return Task::all();
    }
}
