<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public const STATUS_SELLING = 0; // 販売中（初期値）
    public const STATUS_SOLD    = 1; // 売却済み

    // データベースの値（数値）と表示名（文字列）を対応させるマップ
    public const STATUS_MAP = [
        self::STATUS_SELLING => '販売中',
        self::STATUS_SOLD    => '売却済み',
    ];

    /**いらないかも
     * 現在のステータス名を日本語で取得するアクセサ
     * * アクセサ: status_name属性を取得する
     * データベースの値 (0, 1) を日本語名に変換して返します
     * * Bladeテンプレートなどで $item->status_name として呼び出せます
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        return self::STATUS_MAP[$this->status] ?? '不明';
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'category_id',
        'condition_id',
        'brand',
        'image',
        'user_id',
        'buyer_id',
        'sold_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }


}
