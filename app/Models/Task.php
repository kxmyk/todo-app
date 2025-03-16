<?php

namespace App\Models;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'priority', 'status', 'due_date', 'user_id'];

    public function generateAccessToken()
    {
        $this->access_token = Str::random(32);
        $this->access_token_expires_at = Carbon::now()->addHours(24); // Token ważny 24h
        $this->save();

        return $this->access_token;
    }

    public function isAccessTokenValid(): bool
    {
        return $this->access_token_expires_at && Carbon::parse($this->access_token_expires_at)->isFuture();
    }


}
