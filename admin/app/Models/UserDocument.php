<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserDocument
 *
 * @property int $id
 * @property int $user_id
 * @property string $document_name
 * @property string|null $document_number
 * @property string $front_image
 * @property string|null $back_image
 * @property int $document_type 1:- FOR DRIVING LICENCE2:- HIGH SCHOOL DIPLOMA 3:- OTHER DOCUMENT TYPE
 * @property int $document_status 0:- NOT APPROVED1:- APPROVED 2:- UNDER REVIEW
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $resource_url
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereBackImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereDocumentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereFrontImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereUserId($value)
 * @mixin \Eloquent
 */
class UserDocument extends Model
{
    protected $fillable = [
        'user_id',
        'document_name',
        'document_number',
        'front_image',
        'back_image',
        'document_type',
        'document_status',
        'message',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/user-documents/'.$this->getKey());
    }
}
