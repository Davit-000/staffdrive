<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProjectRequest;

class ProjectsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Client $client
   * @param CreateProjectRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(CreateProjectRequest $request, Client $client)
  {
    return $request->createProject($client);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateProjectRequest $request
   * @param Client $client
   * @param Project $project
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateProjectRequest $request, Client $client, Project $project)
  {
    return $request->updateProject($client, $project);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Client $client
   * @param Project $project
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy(Client $client, Project $project)
  {
    $project->delete();

    return response()->json([
      'message' => 'successfully deleted'
    ], 200);
  }
}
