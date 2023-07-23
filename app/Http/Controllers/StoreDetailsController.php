<?php

namespace App\Http\Controllers;

use App\Models\StoreDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;

class StoreDetailsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = StoreDetails::select('name', 'description', 'type')->paginate(10);
    return response()->json($data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:50',
      'description' => 'required|string|max:250',
      'file' => 'required|image|max:5000',
      'type' => 'required|in:1,2,3',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 400);
    }

    $imagePath = $request->file('file')->store('private', 'local');

    $data = new StoreDetails();
    $data->name = $request->name;
    $data->description = $request->description;
    $data->type = $request->type;
    $data->file = $imagePath;
    $data->save();

    return response()->json([
      'name' => $data->name,
      'description' => $data->description,
      'type' => $data->type,
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\StoreDetails  $storeDetails
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $data = StoreDetails::select('name', 'description', 'type', 'file')->findOrFail($id);
    $data->image_temp_url = $this->getTemporaryImageUrl($data->file); // Update image_path to file
    unset($data->file); // Update image_path to file

    return new JsonResponse($data, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  }

  public function getTemporaryImageUrl($imagePath)
  {
    $expirationTime = Carbon::now()->addSeconds(10)->timestamp;
    $temporaryUrl = route('download', ['file' => $imagePath, 'expires' => $expirationTime]);
    return ['temporary_url' => $temporaryUrl];
  }

  public function download(Request $request)
  {
    $temporaryUrl = $request->query('file');
    $expirationTime = $request->query('expires');

    if (!is_null($temporaryUrl) && !is_null($expirationTime) && Carbon::now()->timestamp < $expirationTime) {
      return Storage::download($temporaryUrl);
    } else {
      return new JsonResponse(['error' => 'Temporary URL is missing, expired, or invalid'], 400);
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\StoreDetails  $storeDetails
   * @return \Illuminate\Http\Response
   */
  public function edit(StoreDetails $storeDetails)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\StoreDetails  $storeDetails
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, StoreDetails $storeDetails)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\StoreDetails  $storeDetails
   * @return \Illuminate\Http\Response
   */
  public function destroy(StoreDetails $storeDetails)
  {
    //
  }
}
