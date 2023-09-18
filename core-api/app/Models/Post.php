<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Post extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'detail','user_id'
    ];

    // public function getCreatedAtAttribute( $value ) {
    //     if($value){
    //         return \Carbon\Carbon::parse($value)->format('d M Y H:i A');
    //     }
    //     return null;
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')
        ->where('parent_id', null)
        ->latest();
    }
    public function likes()
    {
        return $this->hasMany(like::class, 'post_id', 'id')
        ->join("users","likes.user_id","users.id")
        ->select(
            "users.first_name",
            "users.last_name",
            "users.id as user_id",
            "likes.id",
            "likes.post_id",
        );
    }
    
    public function User()
    {
        return $this->belongsTo(User::class, 'id','user_id');
    }
    public function author()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id','attachment_id');
    }
}