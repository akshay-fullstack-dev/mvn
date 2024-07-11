<?php

namespace App\Repositories\Interfaces;

interface IUserDocumentRepository extends IGenericRepository
{
	public function saveUserDocuments($user, $insert_data);
}
