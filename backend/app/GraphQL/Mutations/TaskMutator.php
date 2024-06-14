<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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

    public function createTask($rootValue, array $args, GraphQLContext $context)
    {
        if (!Auth::check()) {
            throw new \Exception('Not authenticated');
        }

        $user = Auth::user();

        $validationRules = [
            'description' => ['required', new \App\Rules\UniqueTaskDescriptionForUser($user->id)],
            'status' => 'required',
        ];

        validator($args, $validationRules)->validate();
        
        $task = new Task();
        $task->description = $args['description'];
        $task->status = $args['status'];
        $task->user_id = $user->id;
        $task->save();

        return $task;
    }

    public function deleteAll($rootValue, array $args)
    {
        Task::query()->delete();
        return 'All tasks have been deleted.';
    }
}
