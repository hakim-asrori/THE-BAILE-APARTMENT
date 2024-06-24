<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     *    @OA\Post(
     *       path="/test",
     *       tags={"Test"},
     *       operationId="test",
     *       summary="Test",
     *       description="TestAPI",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="key",
     *                     type="string"
     *                 ),
     *                 example={"key": "value"}
     *             )
     *         )
     *     ),
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *      ),
     *  )
     */
    public function index()
    {
        return response()->json([
            "code" => 200,
            "status" => "SUCCESS",
            "data" => request()->only('key'),
            "ini body yang dikirim" => request()->all()
        ]);
    }
}
