<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class RegisterUserMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        $user = new User([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => bcrypt($args['password']),
        ]);
        $user->save();

        $token = $user->createToken('app')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
