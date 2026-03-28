<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewSurveyController;
use App\Http\Controllers\PersonalDetailController;
use App\Http\Controllers\HouseDetailController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParivarController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\CalculateTaxController;
use App\Http\Controllers\AndroidAppController;
use App\Http\Controllers\ImportoldHousedetailsController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SurveyorController;
use App\Http\Controllers\Payment\HomeController;

Route::get('/clearCache', function () {
    echo \Artisan::call('config:cache');
});

// Dashboard Routes
Route::get('/GetHouseDetailsForFamily/{house_number}/{city}', [WebServiceController::class, 'GetHouseDetailsForFamily']);
Route::get('/DailyLog', [DashboardController::class, 'DailyLog']);
Route::get('/dashboard', [DashboardController::class, 'dashobaord_total_verifird_house']);
Route::post('/dash-board', [DashboardController::class, 'dashobaord_total_verifird_house'])->name('dash.board');

// Master Controller Routes
Route::controller(MasterController::class)->group(function () {
    Route::post('/SaveCity', 'SaveCity')->name('save.city');
    Route::get('/manageCity', 'CityList');
    Route::get('/add_ward_mohlla', 'WardDetailsAdd');
    Route::post('/Ward-Details-Save', 'WardDetailsSave')->name('save.ward-details');
    Route::get('/UpadtemanageCity', 'UpadtemanageCityView');
    Route::post('/EditmanageCity', 'SaveUpdatemanageCity')->name('update.manageCity');
    Route::get('/Ward-Details-List', 'WardDetailsList');
    Route::get('/UpadteWardDetail', 'UpadteWardDetailView');
    Route::post('/EditWardDetails', 'SaveUpdateWardDetails')->name('update.WardDetail');
    Route::get('/ConstructionDetails', 'GetAgeList');
    Route::post('/Save-Age-Details', 'SaveAgeDetails')->name('Save.AgeDetails');
    Route::get('/UpadteConstruction', 'UpadteConstructionView');
    Route::post('/EditConstruction', 'SaveUpdateConstruction')->name('update.Construction');
    Route::get('/discount', 'DiscountDataList');
    Route::post('/save_discount', 'saveDisount')->name('admin.saveDisount');
    Route::get('/Delete-Discount/{id}', 'DeleteDiscount');
    Route::get('/UpadteDiscountDetail', 'UpadteDiscountDetailView');
    Route::post('/EditDiscountDetail', 'SaveUpdateDiscountDetail')->name('update.DiscountDetail');
    Route::get('/Road-Width-List', 'RoadWidthList');
    Route::get('/UpadteRoadWidthDetail', 'UpadteRoadWidthDetailView');
    Route::post('/EditRoadWidthDetail', 'SaveUpdateRoadWidthDetail')->name('update.RoadWidthDetail');
    Route::post('/save_road_width', 'saveRoadWidth')->name('Save.RoadWidth');
    Route::get('/Delete-Road-Width/{id}', 'DeleteRoadWidth');
    Route::get('/View-Tax-Rate', 'ViewTaxRate');
    Route::post('/Save-Tax-Rate', 'SaveTaxRate')->name('save.TaxRate');
    Route::post('/Delete-TaxRate', 'DeleteTaxRate');
    Route::get('/UpadteTaxRateDetail/{id}', 'UpadteTaxRateDetailView');
    Route::post('/EditTaxRateDetail', 'SaveUpdateTaxRateDetail')->name('update.TaxRateDetail');
});

// User Controller Routes
Route::controller(UserController::class)->group(function () {
    Route::get('/', 'viewLogin');
    Route::get('/Mobile-Login/{imei}', 'viewAndroidLogin');
    Route::get('/login', 'viewLogin');
    Route::post('/androidloginaction', 'androidloginaction')->name('android.login');
    Route::post('/loginaction', 'loginaction')->name('admin.login');
    Route::post('/saveUser', 'saveUser')->name('admin.saveUser');
    Route::get('logout', 'logout');
    Route::get('createUser', 'craeteuser');
    Route::get('updateUser/{id}', 'editUser');
    Route::post('updateUser/{id}', 'updateUser');
    Route::get('manageUser', 'manageUser');
    Route::get('/search', 'SearchManageUser')->name('search');
    Route::get('/searchAccess', 'SearchAccess')->name('searchAccess');
    Route::get('/searchWardMohalla', 'searchWardMohalla')->name('searchWardMohalla');
    Route::post('update_ward_data', 'updateWard')->name('update.ward');
    Route::get('/updateUserStatus', 'updateStatus');
    Route::get('/User-Control', 'userControlView');
    Route::get('/assignWard', 'AssignWard');
});

Route::get('/Survey-Details-NonVerified-List', [NewSurveyController::class, 'GetSurveyDetailsNonVerifiedList']);
Route::get('/Add-New-House', [NewSurveyController::class, 'AddNewHouse']);
Route::post('/Add-New-House', [NewSurveyController::class, 'SaveNewHouse']);
Route::get('/Survey-Details-Verified-List', [NewSurveyController::class, 'GetSurveyDetailsVerifiedList']);
Route::get('/Survey-Details-Rejected-List', [NewSurveyController::class, 'GetSurveyDetailsRejectedList']);
Route::get('/RejectedSurveyData', [NewSurveyController::class, 'ActionSurveyDataRejected']);
Route::get('/verify', [NewSurveyController::class, 'ActionSurveyDataVerified']);
Route::get('/RotateClockwise/{id}', [NewSurveyController::class, 'RotateClockwise']);
Route::get('/RotateAntiClockwise/{id}', [NewSurveyController::class, 'RotateAntiClockwise']);
Route::get('/RotateDocumentClockwise/{id}', [NewSurveyController::class, 'RotateDocumentClockwise']);
Route::get('/RotateDocumentAntiClockwise/{id}', [NewSurveyController::class, 'RotateDocumentAntiClockwise']);
Route::get('/View-Update-Newhouse', [NewSurveyController::class, 'ViewUpdateNewhouse']);
Route::get('/Update-Image/{id}', [NewSurveyController::class, 'ChangeImage']);
Route::post('/Update-Image', [NewSurveyController::class, 'ChangeImageSave']);
Route::post('/update_new_details', [NewSurveyController::class, 'updateNewhouse'])->name('update.Newhouse');
Route::post('/Search-Survey-Details-List', [NewSurveyController::class, 'SearchSurveyDetails']);
Route::post('/Delete-House', [NewSurveyController::class, 'DeleteHouse']);

////////////////////////Personal Details///////////////////////
Route::get('/Personal-Details-NonVerified-List', [PersonalDetailController::class, 'GetPersonalDetailsNonVerifiedList']);
Route::get('/Personal-Details-Verified-List', [PersonalDetailController::class, 'GetPersonalDetailsVerifiedList']);
Route::get('/Personal-Details-Rejected-List', [PersonalDetailController::class, 'GetPersonalDetailsRejectedList']);
Route::get('/Personal-Details-Pending-List', [PersonalDetailController::class, 'GetPersonalDetailsPendingList']);
Route::get('/verifyData', [PersonalDetailController::class, 'ActionPersonalDetailsVerified']);
Route::get('/RejectPersonalDetails', [PersonalDetailController::class, 'ActionPersonalDetailsRejected']);
Route::get('/UnverifyPersonalDetails', [PersonalDetailController::class, 'ActionPersonalDetailsUnVerified']);
Route::post('/update_personal_details', [PersonalDetailController::class, 'UpdatePersonalDetailsSave'])->name('update.PersonalDetails');
Route::get('/UpdateDetails', [PersonalDetailController::class, 'UpdatePersonalDetailsView']);
Route::post('/SearchPersonalDetailsList', [PersonalDetailController::class, 'SearchPersonalDetailsList']);
Route::get('/ActionRejecteDocument/{id}', [PersonalDetailController::class, 'ActionRejecteDocument']);

////////////////////////Other House Details/////////////////////////
Route::get('/Other-House-Details-NonVerified-List', [HouseDetailController::class, 'OtherHouseDetailsNonVerifiedList']);
Route::get('/Other-House-Details-Verified-List', [HouseDetailController::class, 'OtherHouseDetailsVerifiedList']);
Route::get('/Other-House-Details-Rejected-List', [HouseDetailController::class, 'OtherHouseDetailsRejectedList']);
Route::get('/Other-House-Details-Pending-List', [HouseDetailController::class, 'OtherHouseDetailsPendingList']);
Route::get('/rejectHousedata', [HouseDetailController::class, 'ActionOtherHouseDetailsRejected']);
Route::get('/varifyHousedata', [HouseDetailController::class, 'ActionOtherHouseDetailsVerified']);

////////////////////////Surveyor section/////////////////////////
Route::get('/Register-New-House', [SurveyorController::class, 'RegisterNewHouse']);
Route::post('/Register-New-House', [SurveyorController::class, 'genHouseNumber']);
Route::get('/EditNewHouse/{id}', [SurveyorController::class, 'EditNewHouse']);
Route::post('/Edit-New-House', [SurveyorController::class, 'SaveEditNewHouse']);
Route::get('/Rejected-New-House', [SurveyorController::class, 'RejectedNewHouse'])->name('rejected.house.list');
Route::get('/Update-Personal-Details', [SurveyorController::class, 'UpdatePersonalDetailsSurvey'])->name('pending.house.list');
Route::get('/UpdatePersonalDetails/{id}', [SurveyorController::class, 'UpdatePersonalDetails']);
Route::post('/SaveUpdatePersonalDetails', [SurveyorController::class, 'SaveUpdatePersonalDetails'])->name('update.PersonalDetailsSurvey');
Route::get('/Rejected-Personal-Details', [SurveyorController::class, 'RejectedPersonalDetails']);
Route::get('/Update-House-Details', [SurveyorController::class, 'UpdateHouseDetails']);
Route::get('/Register-New-Assets', [SurveyorController::class, 'RegisterNewAssets']);
Route::get('/Upload-Document', [SurveyorController::class, 'UploadDocument']);

////////////////////////Map Details/////////////////////////
Route::controller(MapController::class)->group(function () {
    Route::get('/HouseOnMap', 'HouseOnMap');
    Route::get('/Assets-On-Map', 'AssetsOnMap');
});

////////////////////////Assets Details/////////////////////////////
Route::controller(AssetsController::class)->group(function () {
    Route::get('/Assets', 'AssetsList');
    Route::post('/Delete-Assets', 'DeleteAssets');
    Route::get('/UpadteAssetsDetail', 'UpadteAssetsDetailView');
    Route::post('/EditAssetsDetail', 'SaveUpdateAssetsDetail')->name('update.AssetsDetail');
    Route::post('/Save-Assets', 'SaveAssets')->name('Save.Assets');
    Route::get('/Assets-Details-Verified-List', 'AssetsDetailsVerifiedList');
    Route::get('/Assets-Details-NonVerified-List', 'AssetsDetailsNonVerifiedList');
    Route::get('/Upadte-Assets-Details-NonVerified-List', 'UpadteAssetsDetailsNonVerifiedListView');
    Route::post('/EditAssetsDetailsNonVerifiedListview', 'SaveUpdateAssetsDetailsNonVerified')->name('update.AssetsDetailsNonVerified');
    Route::get('/Assets-Details-Rejected-List', 'AssetsDetailsRejectedList');
    Route::get('/RejectAssetsdata', 'ActionAssetsDetailsRejected');
    Route::get('/varifiedAssetsdata', 'ActionAssetsDetailsVerified');
    Route::get('/Assests-Rotate-Clockwise/{id}', 'RotateClockwise');
    Route::get('/Assests-Rotate-AntiClockwise/{id}', 'RotateAntiClockwise');
    Route::get('/Update-Assets/{id}', 'editAssets');
    Route::post('/Update-Assets/{id}', 'updateAssets');
});

////////////////////////Report Details/////////////////////////////
Route::controller(ReportController::class)->group(function () {
    Route::get('/SurveyReportByStatus', 'get_survey_report');
    Route::get('/SurveyReport', 'ReportSurveyDataView');
    Route::get('/House-Mapping-Report', 'ReportSurveyDataHouseView');
    Route::get('/House-Mapping-Report-List', 'getSurveyHouseReportList');
    Route::get('/Parivar-Register', 'SurveyParivarRegister');
    Route::get('/Search-Parivar-Register', 'SearchSurveyParivarRegister');
    Route::get('/LatLng', 'ListLatLng');
    Route::post('/LatLng', 'ShowListLatLng');
    Route::get('/Old-And-New-Mapping-Report', 'ReportSurveyDataOldAndNewMappingView');
    Route::post('/Old-And-New-Mapping-Report', 'ReportSurveyDataOldAndNewMappingList');
    Route::get('/Document-Mapping', 'ReportDocumentMapping');
    Route::post('/Document-Mapping', 'ReportDocumentMappingList');
    Route::get('/Surveyer-Log', 'SurveyerLog');
    Route::post('/Surveyer-Log', 'ShowListSurveyerLog');
    Route::get('/Data-Verification', 'DataVerification');
    Route::post('/Data-Verification', 'ShowListDataVerification');
    Route::get('/test', 'test');
});

////////////////////////ParivarController Details/////////////////////////////
Route::controller(ParivarController::class)->group(function () {
    Route::get('/Add-Family-Member', 'AddParivar');
    Route::post('/Add-Family-Member', 'SaveParivar')->name('save.new-parivar');
    Route::post('/SaveMukhiya', 'SaveMukhiya');
    Route::get('/verifyHouse', 'verifyHouse');
    Route::get('/getmukhiya', 'getmukhiyaname');
    Route::get('/Parivar-Report', 'GetReport');
    Route::get('/Approve-Parivar-Report', 'GetApproveReport');
    Route::get('/GetAllFamilyMember/{id}', 'GetAllFamilyMember');
    Route::get('/PrintParivarRegister/{id}', 'PrintParivarRegister');
    Route::post('/Search-Parivar', 'SearchParivar');
    Route::post('/ActionParivarRejected', 'ActionParivarRejected');
    Route::post('/ActionParivarApproved', 'ActionParivarApproved');
    Route::post('/Delete-Family-Member', 'DeleteFamilyMemberSingle');
    Route::get('/Update-Family-Member/{id}', 'EditFamilyMember');
    Route::post('/Update-Family-Member/{id}', 'UpdateFamilyMember');
});

/////////////////////////Excel Controller////////////////////////
Route::controller(ExportExcelController::class)->group(function () {
    Route::post('/ExportExcel', 'excel')->name('export.personaldetailSurvey');
    Route::post('/export-Tax-Report', 'exportTaxReport')->name('export.exportTaxReport');
});

// Web Service 
Route::get('/get_RoadWidth/{city}', [WebServiceController::class, 'get_RoadWidth']);
Route::get('/getcity/{state}', [WebServiceController::class, 'get_city_by_state']);
Route::get('/getnagarpalika', [WebServiceController::class, 'get_city'])->name('get.city');
Route::get('/getwardnum/{nagarpalika}', [WebServiceController::class, 'get_ward_number']);
Route::get('/getmohalla/{ward}/{nagarpalika}', [WebServiceController::class, 'getmohalla']);
Route::get('/getSurveyorlist/{nagarpalika}', [WebServiceController::class, 'get_surveyor_list']);
Route::get('/UserControlList/{user_id}', [WebServiceController::class, 'UserControlList']);
Route::get('/getWardDetailsByWardNumber/{ward_number}/{city}', [WebServiceController::class, 'getWardDetailsByWardNumber']);
Route::get('/changeUserControl', [WebServiceController::class, 'changeUserControl']);
Route::get('/getConstructionAge/{nagarpalika}', [WebServiceController::class, 'get_construction_age']);
Route::get('/get-Road-width/{nagarpalika}', [WebServiceController::class, 'getRoadwidth']);
Route::get('/map-data/{city}/{ward_number}', [WebServiceController::class, 'MapData']);
Route::get('/Assets-Data-Map/{city}/{ward_number}/{assets}', [WebServiceController::class, 'AssetsDataMap']);
Route::get('/more-House-data/{house_id}', [WebServiceController::class, 'moreHousedata']);
Route::get('/more-Assets-Data/{assets_id}', [WebServiceController::class, 'moreAssetsData']);
Route::get('/get-Assets', [WebServiceController::class, 'getAssets']);
Route::get('/search-varified-house-details', [WebServiceController::class, 'searchvarifiedhousedetails']);
Route::get('/search-notvarified-house-details', [WebServiceController::class, 'searchnotvarifiedhousedetails']);
Route::get('/checkHouseNumber', [WebServiceController::class, 'checkHoseNumber']);
Route::get('/insert_house', [WebServiceController::class, 'insert_house']);
Route::get('/getmohllaward/{city}', [WebServiceController::class, 'get_mohlla_ward']);

// Calculate Tax Routes
Route::get('/Generate-Tax', [CalculateTaxController::class, 'GenerateTax']);
Route::get('/Generate-Tax-Submit', [CalculateTaxController::class, 'GenerateTaxSubmit']);
Route::get('/View-Report-Calculate-Tax', [CalculateTaxController::class, 'ViewReportCalculateTax']);
Route::get('/get-Tax-Report', [CalculateTaxController::class, 'getTaxReport']);
Route::get('/Tax-Payment-List', [CalculateTaxController::class, 'TaxPaymentList']);
Route::get('/GetHouseNoWardWise/{ward_number}', [CalculateTaxController::class, 'gethousenowardwise']);
Route::get('/Getwardcitywise/{city}', [CalculateTaxController::class, 'getwardcitywise']);
Route::post('/Tax-Payment-List', [CalculateTaxController::class, 'TaxPaymentSearch']);
Route::get('/Tax-Pay/{id}', [CalculateTaxController::class, 'TaxPay']);
Route::post('/Tax-Pay', [CalculateTaxController::class, 'SavePaymentDetails']);
Route::get('/PrintInvoice/{id}', [CalculateTaxController::class, 'PrintInvoice']);
Route::get('/Tax-Payment-Receipt', [CalculateTaxController::class, 'TaxPaymentReceipt']);
Route::get('/Tax-Payment-Notice', [CalculateTaxController::class, 'TaxPaymentNotice']);
Route::post('/Tax-Payment-Bulk-List', [CalculateTaxController::class, 'TaxPaymentBulkList']);

// Android App Routes
Route::get('Parivar/Check-Update', [AndroidAppController::class, 'CheckUpdate']);
Route::get('Parivar/Login', [AndroidAppController::class, 'Login']);
Route::get('Parivar/Search-House-Details', [AndroidAppController::class, 'SearchHouseDetails']);
Route::get('Parivar/selectHouseDetailsHindi', [AndroidAppController::class, 'selectHouseDetailsHindi']);
Route::get('Parivar/Save-Parivar-Details', [AndroidAppController::class, 'SaveParivarDetails']);
Route::get('Parivar/ShowFamilyData/{id}', [AndroidAppController::class, 'ShowFamilyData']);
Route::get('Parivar/Search-House-Details-List', [AndroidAppController::class, 'SearchHouseDetailsList']);

// Import Old House Details Routes
Route::get('Import-old-House-Details', [ImportoldHousedetailsController::class, 'index']);
Route::post('Import-old-House-Details', [ImportoldHousedetailsController::class, 'indexSearch']);
Route::get('Add-Import-old-House-Details', [ImportoldHousedetailsController::class, 'create']);
Route::post('Save-Import-old-House-Details', [ImportoldHousedetailsController::class, 'ImportoldHouseDetails']);
Route::post('/Delete-ImportHouseDetails', [ImportoldHousedetailsController::class, 'DeleteImportHouseDetails']);
Route::post('/Delete-Tax-Payment', [CalculateTaxController::class, 'DeleteTaxAmount']);

Route::get('documents/{folder}/{filename}', function ($folder, $filename) {
    $path = base_path("document/{$folder}/{$filename}");
    
    if (!File::exists($path)) {
        abort(404);
    }
    
    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});

Route::get('file-import-export', [UserController::class, 'fileImportExport']);
Route::post('file-import', [UserController::class, 'fileImport'])->name('file-import');
Route::get('file-export', [UserController::class, 'fileExport'])->name('file-export');

// Payment Controller Group
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/Pay-Tax', [HomeController::class, 'payTax']);
    Route::post('/Pay-Tax', [HomeController::class, 'payTaxList']);
    Route::get('/Pay-Now/{house_id}', [HomeController::class, 'payNow']);
    Route::get('/Ledger', [HomeController::class, 'ledger']);
    Route::post('/Ledger', [HomeController::class, 'viewLedger']);
    Route::get('/View-Receipt', [HomeController::class, 'viewReceipt']);
    Route::post('/View-Receipt', [HomeController::class, 'receiptList']);
    Route::get('/Print-Receipt/{receipt_id}', [HomeController::class, 'printReceipt']);
    Route::get('/Pay', [HomeController::class, 'pay']);
    Route::get('/Payment-Success/{txn_id}', [HomeController::class, 'paymentSuccess']);
    Route::get('/Payment-Failed/{txn_id}', [HomeController::class, 'paymentFailed']);
    Route::get('/Terms-Condition', [HomeController::class, 'termsCondition']);
    Route::get('/Privacy-Policy', [HomeController::class, 'privacyPolicy']);
    Route::get('/Return-Policy', [HomeController::class, 'returnPolicy']);
});

// Property Controller Routes
Route::controller(PropertyController::class)->group(function () {
    Route::get('/Property-Type', 'PropertTypeList');
    Route::get('/Delete-Property-Type/{id}', 'DeletePropertType');
    Route::get('/UpadteProperty-Type', 'UpadtePropertTypeView');
    Route::post('/EditProperty-Type', 'SaveUpdatePropertType')->name('update.PropertType');
    Route::post('/Save-Property-Type', 'PropertType')->name('Save.PropertType');
});