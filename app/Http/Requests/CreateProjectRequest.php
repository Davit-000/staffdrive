<?php

namespace App\Http\Requests;

use App\Client;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
      'name' => 'required|string|min:3|max:255'
    ];
  }

  public function createProject(Client $client)
  {
    $project = $client->projects()->create($this->all());

    return response()->json([
      'project' => $project,
      'message' => 'Project created successfully.'
    ], 200);
  }
}
