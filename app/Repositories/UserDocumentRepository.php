<?php

namespace App\Repositories;

use App\Enum\DocumentEnum;
use App\Models\UserDocuments;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IUserDocumentRepository;

class UserDocumentRepository extends GenericRepository implements IUserDocumentRepository
{
	public function model()
	{
		return UserDocuments::class;
	}

	public function saveUserDocuments($user, $insert_data)
	{
		$where = ['document_type' => $insert_data['document_type']];
		return $user->user_documents()->updateOrCreate($where,$this->getDocumentInsertData($insert_data));
	}

	private function getDocumentInsertData($document)
	{
		return [
			'document_name' => $document['document_name'],
			'document_number' => $document['document_number'],
			'front_image' => $document['front_image'],
			'back_image' => $document['back_image'],
			'document_status' => DocumentEnum::UNDER_REVIEW
		];
	}
}
