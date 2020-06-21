<?php

namespace App\Http\Requests;

use App\Client;
use App\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|string|min:3,max:255'
    ];
  }

  public function updateProject(Client $client, Project $project)
  {
    $project->update($this->all());

    return response()->json([
      'project' => $project->fresh(),
      'message' => 'Project updated.'
    ], 200);
  }
}
