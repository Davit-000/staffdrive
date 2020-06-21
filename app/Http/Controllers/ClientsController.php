<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientsController extends Controller
{
  /**
   * ClientsController constructor.
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    /** @var \App\User $user **/
    $user = auth()->user();

    return view('clients', [
      'clients' => $user->clients->load('projects')
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(CreateClientRequest $request)
  {
    return $request->createClient();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateClientRequest $request
   * @param Client $client
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateClientRequest $request, Client $client)
  {
    return $request->updateClient($client);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Client $client
   * @return void
   */
  public function destroy(Client $client)
  {
    //
  }
}
