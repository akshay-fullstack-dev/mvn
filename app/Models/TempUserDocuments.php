<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TempUserDocuments
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
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments query()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereBackImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereDocumentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereFrontImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUserDocuments whereUserId($value)
 * @mixin \Eloquent
 */
class TempUserDocuments extends Model
{
    protected $fillable = ['document_name', 'document_number', 'front_image', 'back_image', 'document_type', 'document_status'];
}
