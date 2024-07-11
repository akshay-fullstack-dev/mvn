<?php

namespace App\Repositories;

use App\Enum\DocumentEnum;
use App\Models\TempUserDocuments;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\ITempUserDocumentRepository;

class TempUserDocumentRepository extends GenericRepository implements ITempUserDocumentRepository
{
	public function model()
	{
		return TempUserDocuments::class;
	}

	public function saveUserDocuments($user, $insert_data)
	{
		$where = ['document_type' => $insert_data['document_type']];
		return $user->user_temp_documents()->updateOrCreate($where, $this->getDocumentInsertData($insert_data));
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
	public function get_user_docs($user)
	{
		$document = $user->user_temp_documents()->get();
		if ($document->count() > 0)
			return $document;
		return false;
	}
}
