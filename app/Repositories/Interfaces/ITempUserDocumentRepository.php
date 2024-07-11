<?php

namespace App\Repositories\Interfaces;

interface ITempUserDocumentRepository extends IGenericRepository
{
	public function saveUserDocuments($user, $insert_data);
}
