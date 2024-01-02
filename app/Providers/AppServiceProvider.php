<?php

namespace App\Providers;

use App\Helpers\HArr;
use App\Http\Controllers\ExportTable;
use App\Http\Controllers\HospitalitySectorController;
use App\Models\Company;
use App\Models\FFE;
use App\Models\FFEItem;
use App\Models\HospitalitySector;
use App\Models\IncomeStatementItem;
use App\Models\Language;
use App\Models\PropertyAcquisition;
use App\Models\Section;
use App\ReadyFunctions\CalculateFixedLoanAtEndService;
use App\ReadyFunctions\CalculateLoanService;
use App\ReadyFunctions\CalculateLoanWithdrawal;
use App\ReadyFunctions\CalculateProfitsEquations;
use App\ReadyFunctions\Date;
use App\ReadyFunctions\InstallmentMethod ;
use App\ReadyFunctions\ProjectsUnderProgress;
use App\ReadyFunctions\SCurveService;
use App\ReadyFunctions\StartUpCostService;
use App\ReadyFunctions\SteadyDeclineMethod;
use App\ReadyFunctions\SteadyGrowthMethod as xyz;
use App\ReadyFunctions\SteadyGrowthMethod;
use App\ReadyFunctions\StraightMethod;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	
	public function test(string $startDate , int $duration)
	{
		
	}
	public function boot(Request $request)
	{
		//$startUpCostService = new StartUpCostService();
		//$hospitalitySector = HospitalitySector::find(278);
		
		
		$yearIndexWithYear = [];
		$dateIndexWithDate = [];
		$dateWithDateIndex = [];
		$studyStartDate = null;
		$studyEndDate = null;
		
		$hospitalitySectorId = $request->segment(4);
		if(is_numeric($hospitalitySectorId)){
			$hospitalitySector = HospitalitySector::find($hospitalitySectorId);
			if($hospitalitySector){
				$studyDates = $hospitalitySector->getStudyDates() ;
				$studyStartDate = Arr::first($studyDates);
				$studyEndDate = Arr::last($studyDates);
				$studyStartDate = $studyStartDate ? Carbon::make($studyStartDate)->format('m/d/Y'):null;
				$studyEndDate = $studyEndDate ? Carbon::make($studyEndDate)->format('m/d/Y'):null;
				$datesAndIndexesHelpers = $hospitalitySector->datesAndIndexesHelpers($studyDates);
				$datesIndexWithYearIndex=$datesAndIndexesHelpers['datesIndexWithYearIndex']; 
				$yearIndexWithYear=$datesAndIndexesHelpers['yearIndexWithYear']; 
				$dateIndexWithDate=$datesAndIndexesHelpers['dateIndexWithDate']; 
				$dateIndexWithMonthNumber=$datesAndIndexesHelpers['dateIndexWithMonthNumber']; 
				$dateWithMonthNumber=$datesAndIndexesHelpers['dateWithMonthNumber']; 
				$dateWithDateIndex=$datesAndIndexesHelpers['dateWithDateIndex']; 
				app()->singleton('datesIndexWithYearIndex',function() use ($datesIndexWithYearIndex){
					return $datesIndexWithYearIndex;
				});
				app()->singleton('yearIndexWithYear',function() use ($yearIndexWithYear){
					return $yearIndexWithYear;
				});
				
				app()->singleton('dateIndexWithDate',function() use ($dateIndexWithDate){
					return $dateIndexWithDate;
				});
				app()->singleton('dateWithMonthNumber',function() use ($dateWithMonthNumber){
					return $dateWithMonthNumber;
				});
				app()->singleton('dateIndexWithMonthNumber',function() use ($dateIndexWithMonthNumber){
					return $dateIndexWithMonthNumber;
				});
				app()->singleton('dateWithDateIndex',function() use ($dateWithDateIndex){
					return $dateWithDateIndex;
				});
			}
			
		}
		
		
		View::share('langs', Language::all());
		View::share('lang', app()->getLocale());
		View::share('yearIndexWithYear', $yearIndexWithYear);
		View::share('dateIndexWithDate', $dateIndexWithDate);
		View::share('dateWithDateIndex', $dateWithDateIndex);
		View::share('studyStartDate', $studyStartDate);
		View::share('studyEndDate', $studyEndDate);
		$currentCompany = Company::find(Request()->segment(2));
		if ($currentCompany) {
			View::share('exportables', (new ExportTable)->customizedTableField($currentCompany, 'SalesGathering', 'selected_fields'));
			View::share('exportablesForUploadExcel', (new ExportTable)->customizedTableField($currentCompany, 'UploadExcel', 'selected_fields'));
		}
		View::composer('*', function ($view) {

			$requestData = Request()->all();
			if (isset($requestData['start_date']) && isset($requestData['end_date'])) {
				$view->with([
					'start_date' => $requestData['start_date'],
					'end_date' => $requestData['end_date'],
				]);
			} elseif (isset($requestData['date'])) {
				$view->with([
					'date' => $requestData['date']
				]);
			}
		});

		View::composer('*', function ($view) {
			if (Auth::check()) {


				if (request()->route()->named('home') || (!isset(request()->company))) {
					$sections = [Section::with('subSections')->find(2)];
					$view->with('client_sections', $sections);
				} else {
					$view->with('client_sections', Section::mainClientSideSections()->with('subSections')->get());
				}
				if (Auth::user()->hasrole('super-admin')) {
					$view->with('super_admin_sections', Section::mainSuperAdminSections()->get());
				}
			}
		});
	}

}
