<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class AuthMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
    }


    public function register($_, array $args, GraphQLContext $context)
    {
        $user = new User;
        $user->name = $args['name'];
        $user->email = $args['email'];
        $user->password = Hash::make($args['password']);
        $user->save();

        return [
            'user' => $user,
            'token' => $user->createToken('app')->plainTextToken,
        ];
    }

    public function login($rootValue, array $args, GraphQLContext $context)
    {
        $user = User::where('email', $args['email'])->first();

        if (!$user || !Hash::check($args['password'], $user->password)) {
            return [
                'success' => false,
                'token' => null,
                'user' => null,
            ];
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'success' => true,
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logout($rootValue, array $args, $context)
    {
        $user = Auth::guard('sanctum')->user();

        // Revoke the user's current token
        if ($user) {
            $user->currentAccessToken()->delete();

            return [
                'message' => 'You have been successfully logged out.',
                'success' => true,
            ];
        }

        return [
            'message' => 'Unable to logout, no active user session.',
            'success' => false,
        ];
    }
}
