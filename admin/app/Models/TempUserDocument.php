<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TempUserDocument
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
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereBackImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereDocumentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereFrontImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocument whereUserId($value)
 * @mixin \Eloquent
 */
class TempUserDocument extends Model
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
