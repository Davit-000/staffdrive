<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function createClient()
  {
    /** @var \App\User $user **/
    $user = auth()->user();

    $client = $user->clients()->create($this->all());

    return response()->json([
      'client' => $client,
      'message' => 'Client successfully created'
    ]);
  }
}
