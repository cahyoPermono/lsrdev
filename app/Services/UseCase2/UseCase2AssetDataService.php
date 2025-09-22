<?php

namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2AssetChartData;
use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2AssetData;
use App\Models\UseCase2\UseCase2AssetSummary;
use Illuminate\Support\Facades\DB;

class UseCase2AssetDataService
{
	public function __construct(
		public $model = UseCase2AssetData::class,
		public $chartModel = UseCase2AssetChartData::class,
		public $summaryModel = UseCase2AssetSummary::class
	) {}


	public function findAllByDateAndType($date, $companyCode, $type, $try = false)
	{
		$dataItems = $this->model::query()
			->where('date', $date)
			->where('type', $type)
			->where('company_code', $companyCode)
			->orderBy('date', 'asc')
			->get();

		if (!count($dataItems) && !$try) {
			Artisan::call('use-case-2:insert-asset-dashboard-data');
			return $this->findAllByDateAndType($date, $companyCode, $type, true);
		}

		return $dataItems;
	}

	public function findSummary($companyCode, $try = false)
	{
		$data = $this->summaryModel::query()
			->where('company_code', $companyCode)
			->first();

		if (!$data && !$try) {
			Artisan::call('use-case-2:insert-asset-summary-data');
			return $this->findSummary($companyCode, true);
		}

		return $data;
	}

	public function findAllChartByDateRangeAndType($start, $end, $assetKind, $type)
	{
		return $this->chartModel::query()
			->where('type', $type)
			->where('asset_kind', $assetKind)
			->whereBetween('date', [$start, $end])
			->select([
				'date as date_label',
				"actual_net",
				"actual_gross",
				"budget_net",
				"budget_gross",
				"outlook_net",
				"outlook_gross",
				"wpnb_net",
				"wpnb_gross",
				"apbn_net",
				"apbn_gross",
			])
			->orderBy('date', 'asc')
			->get();
	}

	public function findAllChartsForActualData($start, $end, $assetKinds, $type)
	{
		if (!is_array($assetKinds)) {
			$assetKinds = [$assetKinds];
		}

		$data = $this->chartModel::select('date', 'asset_kind', 'actual_net', 'actual_gross')
			->whereBetween('date', [$start, $end])
			->whereIn('asset_kind', $assetKinds)
			->where('type', $type)
			->orderBy('date', 'asc')
			->get();

		return $data;
	}

	public function getBudgetChart($start, $end, $assetKinds, $type)
	{
		if (!is_array($assetKinds)) {
			$assetKinds = [$assetKinds];
		}

		$data = $this->chartModel::select('date', 'asset_kind', 'budget_net', 'budget_gross')
			->whereBetween('date', [$start, $end])
			->whereIn('asset_kind', $assetKinds)
			->where('type', $type)
			->orderBy('date', 'asc')
			->get();

		return $data;
	}

	public function findActualVsBudgetDelta()
	{
		return collect(DB::select("
			SELECT 
				type,
				asset_kind,
				actual_net_avg,
				actual_gross_avg,

				budget_net_avg,
				budget_gross_avg,

				wpnb_net_avg,
				wpnb_gross_avg,

				apbn_net_avg,
				apbn_gross_avg,

				-- Delta Net
				ROUND(actual_net_avg - budget_net_avg, 2) AS delta_budget_net,
				ROUND(actual_net_avg - wpnb_net_avg, 2)   AS delta_wpnb_net,
				ROUND(actual_net_avg - apbn_net_avg, 2)   AS delta_apbn_net,

				-- Delta Gross
				ROUND(actual_gross_avg - budget_gross_avg, 2) AS delta_budget_gross,
				ROUND(actual_gross_avg - wpnb_gross_avg, 2)   AS delta_wpnb_gross,
				ROUND(actual_gross_avg - apbn_gross_avg, 2)   AS delta_apbn_gross

			FROM (
				SELECT 
					type,
					asset_kind,

					-- Averages
					ROUND(AVG(actual_net::numeric) FILTER (WHERE date < CURRENT_DATE), 2) AS actual_net_avg,
					ROUND(AVG(actual_gross::numeric) FILTER (WHERE date < CURRENT_DATE), 2) AS actual_gross_avg,

					ROUND(AVG(budget_net::numeric), 2) AS budget_net_avg,
					ROUND(AVG(budget_gross::numeric), 2) AS budget_gross_avg,

					ROUND(AVG(wpnb_net::numeric), 2) AS wpnb_net_avg,
					ROUND(AVG(wpnb_gross::numeric), 2) AS wpnb_gross_avg,

					ROUND(AVG(apbn_net::numeric), 2) AS apbn_net_avg,
					ROUND(AVG(apbn_gross::numeric), 2) AS apbn_gross_avg

				FROM " . $this->chartModel::query()->getModel()->getTable() . "
        		GROUP BY type, asset_kind
			) AS averages
		"));
	}
}
