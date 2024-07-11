<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserDocuments
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
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereBackImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereDocumentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereFrontImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocuments whereUserId($value)
 * @mixin \Eloquent
 */
class UserDocuments extends Model
{
    protected $fillable = ['document_name', 'document_number', 'front_image', 'back_image', 'document_type', 'document_status'];
}
