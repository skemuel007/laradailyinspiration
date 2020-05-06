<?php

namespace App\Http\Controllers;

use App\Inspiration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class InspirationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        // gets all inspiration
        $inspirations = Inspiration::all();

        return response()->json([
            'success' => true,
            'data' => $inspirations
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        // check if validation fails
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // check if title has been store before
        $title = ucwords($request->input('title')); // make first letter of each word uppercase

        $inspirationExists = Inspiration::where('title', $title)->first();

        if ( $inspirationExists != null ) {
            // if exist return conflict response
            return response()->json([
                'success' => true,
                'data' => null
            ], JsonResponse::HTTP_CONFLICT);
        }

        // create inspiration
        $inspiration = Inspiration::create([
            'title' => $title,
            'description' => $request->input('description')
        ]);

        // return success message
        return response()->json([
            'success' => true,
            'data' => null
        ], JsonResponse::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        // find inspiration by id
        $inspiration = Inspiration::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $inspiration
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate request input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        // check if validation fails
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // check if title has been store before
        $title = ucwords($request->input('title')); // make first letter of each word uppercase

        // find inspiration record, if not exist, throw error
        $inspiration = Inspiration::findOrFail($id);

        $inspiration->title = $request->input('title');
        $inspiration->description = $request->input('description');
        // update the
        $inspiration->save();

        // return success message
        return response()->json([
            'success' => true,
            'data' => null
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inspiration = Inspiration::findOrFail($id);

        $inspiration->delete();

        return response()->json([
            'success' => true,
            'data' => null
        ], 200);
    }
}
