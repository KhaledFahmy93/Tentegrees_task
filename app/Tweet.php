<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tweet extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tweet', 'user_id' 
    ];

    /**
	 * Get the user of this tweet.
	 *
	 * @return BelongsTo
	 */
	public function User()
	{
		return $this->belongsTo(User::class);
	}
}
