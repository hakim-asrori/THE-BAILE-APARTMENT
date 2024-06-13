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
            "data" => []
        ]);
    }
}
