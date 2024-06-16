<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     *    @OA\Post(
     *       path="/auth/login",
     *       tags={"Login"},
     *       operationId="login",
     *       summary="Login",
     *       description="API Login",
     *       @OA\Response(
     *           response="200",
     *           description="login successfully!",
     *      ),
     *       @OA\Response(
     *           response="400",
     *           description="email or password wrong!",
     *      ),
     *       @OA\Response(
     *           response="422",
     *           description="body validation!",
     *      ),
     *       @OA\Response(
     *           response="500",
     *           description="internal server error!",
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 schema="Login",
     *                 title="login",
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "admin@mailinator.com", "password": "password"}
     *             )
     *         )
     *      ),
     *    )
     */
    public function login(LoginRequest $request)
    {
        DB::beginTransaction();

        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return MessageFixer::warning(messages: "email or password wrong!");
        }

        if (!Hash::check($request->password, $user->password)) {
            return MessageFixer::warning(messages: "email or password wrong!");
        }

        try {
            $token = $user->createToken('api', ['authenticated'])->plainTextToken;
            $user->baile = $token;

            DB::commit();
            return MessageFixer::success(messages: "login successfully!", data: $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error(messages: $th->getMessage());
        }
    }

    public function check(Request $request)
    {
        return MessageFixer::success(messages: "user Authenticated", data: $request->user());
    }
}
