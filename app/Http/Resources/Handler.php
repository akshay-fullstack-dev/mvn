<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use App\Http\Resources\Interfaces\IHandler;
use App\Http\Resources\v1\Service\ServiceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class Handler implements IHandler
{
	public function __construct()
	{
	}

	/**
	 * Transforms the classes having transform method
	 *
	 * @param $content
	 * @return array
	 */
	public function transformModel($content)
	{
		if (is_array($content) || $content instanceof Collection) {
			return $this->transformObjects($content);
		} else if ($content instanceof LengthAwarePaginator) {
			// this case runs when we send back a pagination object
			$collection = $content[0];
			if (is_object($collection) && $this->isTransformable($collection, true))
				return $collection->setResources($content);
		} elseif (is_object($content) && $this->isTransformable($content)) {
			return $content->setResource($content);
		}
	}

	private function transformObjects($toTransform)
	{
		$transformed = [];
		foreach ($toTransform as $key => $item) {
			$transformed[$key] = $this->isTransformable($item) ? $item->setResource($item) : $item;
		}
		return $transformed;
	}

	private function isTransformable($item, $is_collection = false)
	{
		if ($is_collection)
			return is_object($item) && method_exists($item, 'setResources');
		else
			return is_object($item) && method_exists($item, 'setResource');
	}
}
