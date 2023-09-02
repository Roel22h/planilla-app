<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class Pagination
{
	public static function paginate(Model $model, array $jqxParams, array $totalColumns = [], bool $paginate = true, array $additionalFilters = []): array
	{
		$paginationHelper = new Pagination();
		$summedColumns = [];

		$query = $model::query();

		if ($jqxParams) {
			$query = $paginationHelper->jqxgrid_filter($query, $jqxParams);
		}

		if ($additionalFilters) {
			$query = $paginationHelper->aditional_filter($query, $additionalFilters);
		} else {
			$query->orderBy('id', 'desc');
		}

		$totalrecords = $query->count();

		if ($totalColumns) {
			$summedColumns = $paginationHelper->totalColumns($query, $totalColumns);
		}

		if ($paginate) {
			$query = $paginationHelper->pagination($query, $jqxParams);
		}

		$rows =  $query->get();

		return [$rows, $totalrecords, $summedColumns];
	}

	private function jqxgrid_filter(Builder $query, array $jqxParams): Builder
	{
		$filterGroups = $jqxParams['filterGroups'] ?? NULL;

		if ($filterGroups) {
			foreach ($filterGroups as $filterGroup) {
				$field = $filterGroup['field'];
				$filters = $filterGroup['filters'];

				$filterType = $filters[0]['type'];
				$condition = $filters[0]['condition'];

				if ($filterType === 'datefilter') {
					foreach ($filters as $filter) {
						$condition = $filter['condition'];
						$value = (Carbon::createFromFormat('D M d Y H:i:s O +', $filter['value']))->format('Y-m-d');

						switch ($condition) {
							case 'GREATER_THAN_OR_EQUAL':
								$query->whereDate($field, ">=", $value);
								break;
							case 'LESS_THAN_OR_EQUAL':
								$query->whereDate($field, "<=", $value);
								break;
							case 'GREATER_THAN':
								$query->whereDate($field, ">", $value);
								break;
							case 'LESS_THAN':
								$query->whereDate($field, "<", $value);
								break;

							default:
								break;
						}
					}
				} else {
					$values = array_column($filters, 'value');

					switch ($condition) {
						case 'EQUAL':
							// if (in_array('', $values)) {
							// 	$query->where(function ($query) use ($field, $values) {
							// 		$query->whereIn($field, $values)
							// 			->orWhereNull($field);
							// 	});
							// } else {
							$query->whereIn($field, $values);
							// }
							break;
						case 'CONTAINS':
							$query->where($field, 'like', "%{$values[0]}%");
							break;
						case 'NULL':
							$query->whereNull($field);
							break;

						default:
							break;
					}
				}
			}
		}

		return $query;
	}

	private function aditional_filter(Builder $query, array $additionalFilters): Builder
	{
		foreach ($additionalFilters as $key => $value) {
			$method = $value[0];
			$filters = $value[1];

			switch ($method) {
				case 'where':
					$query->where($filters);
					break;

				case 'whereIn':
					$query->whereIn($filters);
					break;

				case 'orderBy':
					$column = $filters[0];
					$direction = $filters[1];

					$query->orderBy($column, $direction);
					break;

				default:
					# code...
					break;
			}
		}

		return $query;
	}

	private function totalColumns(Builder $query, array $columns): stdClass
	{
		$result = new stdClass();

		foreach ($columns as $key => $column) {
			$result->$column = $query->sum($column);
		}

		return $result;
	}

	private function pagination(Builder $query, array $jqxParams): Builder
	{
		$pagesize = $jqxParams['pagesize'];
		$pagenum = $jqxParams['pagenum'];

		$start = $pagenum * $pagesize;

		$query->limit($pagesize)->offset($start);

		return $query;
	}
}
