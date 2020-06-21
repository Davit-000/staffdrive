<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  /**
   * @var string[]
   */
  protected $fillable = ['name'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function client()
  {
    return $this->belongsTo(Client::class, 'client_id', 'id');
  }
}
