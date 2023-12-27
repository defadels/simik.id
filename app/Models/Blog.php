<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  use HasFactory;

  protected $table = 'blog';

  protected $guarded = [];

  public function kategori()
  {
    return $this->belongsTo('App\Models\KategoriBlog', 'kategori_id')->withDefault();
  }
}
