<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static Client create(array $attrs)
 */
class Client extends Model
{
  /**
   * @var string[]
   */
  protected $fillable = ['name'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function projects()
  {
    return $this->hasMany(Project::class, 'client_id', 'id');
  }
}
