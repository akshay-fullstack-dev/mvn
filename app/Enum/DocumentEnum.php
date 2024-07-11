<?php

namespace App\Enum;

class DocumentEnum
{
	// document type
	const DRIVING_LICENCE = 1;
	const HIGH_SCHOOL_DIPLOMA = 2;
	const OTHER_DOCUMENT_TYPE = 3;

	// document approved status
	const NOT_APPROVED = 0;
	const APPROVED = 1;
	const UNDER_REVIEW = 2;
}
