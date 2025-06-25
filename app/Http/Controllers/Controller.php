<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // PRIVATE HELPERS

    protected function createUserFromRequest(array $data): User
    {
        return User::create([
            'first_name'     => $data['first_name'],
            'middle_name'    => $data['middle_name'] ?? null,
            'last_name'      => $data['last_name'],
            'extension_name' => $data['extension_name'] ?? null,
            'email'          => $data['email'],
            'contact_number' => $data['contact_number'],
            'user_type'      => $data['user_type'],
            'password'       => Hash::make($data['member_id']),
        ]);
    }

    protected function respond(callable $callback, $notFoundMessage = 'Server error.'): JsonResponse
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error($notFoundMessage . ' ' . $e->getMessage());
            return $this->fail($notFoundMessage);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return $this->fail('An error occurred.');
        }
    }

    protected function success(mixed $data, string $message, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

    protected function fail(string $message, int $code = Response::HTTP_FORBIDDEN): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], $code);
    }
}
