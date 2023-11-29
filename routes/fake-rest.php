<?php

use App\Helpers\Url;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get(Url::ListCertificate, function () {
     $file = File::get(storage_path('fake-rest/PTS_GetListCertificate.json'));
     return response()->json(json_decode($file));
});

Route::get(Url::ListCompetency, function () {
     $file = File::get(storage_path('fake-rest/CTMS_GetListCompetency.json'));
     return response()->json(json_decode($file));
});

Route::get(Url::FindUserByEmail, function () {
     $file = File::get(storage_path('fake-rest/PTS_GetDataByEmail.json'));
     return response()->json(json_decode($file));
});

Route::get(Url::FindUserByPersonId, function () {
     $file = File::get(storage_path('fake-rest/PTS_GetDataByPersonId.json'));
     return response()->json(json_decode($file));
});


Route::get(Url::GetPermitDetail, function () {
     $file = File::get(storage_path('fake-rest/BPM_PTW_GetPermitDetail.json'));
     return response()->json(json_decode($file));
});


Route::get(Url::GetWLDetail, function () {
     $file = File::get(storage_path('fake-rest/BPM_PTW_GetWLDetail.json'));
     return response()->json(json_decode($file));
});

Route::get(Url::GetListTraining, function () {
     $file = File::get(storage_path('fake-rest/CTMS_GetListTraining.json'));
     return response()->json(json_decode($file));
});
Route::get(Url::GetListIsolation, function () {
     $file = File::get(storage_path('fake-rest/BPM_IC_GetDetail.json'));
     return response()->json(json_decode($file));
});