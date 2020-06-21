<?php

namespace App\Http\Requests;

use App\Client;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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

  public function updateClient(Client $client)
  {
    $client->update($this->all());

    return response()->json([
      'client' => $client->fresh('projects'),
      'message' => 'Client updated.'
    ], 200);
  }
}
