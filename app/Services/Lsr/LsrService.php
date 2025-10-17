<?php

namespace App\Services\Lsr;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use Illuminate\Support\Facades\Storage;

class LsrService
{

    /**
     * Get LSR History List
     * GET LSRFieldVerificator/API/GetLSRHistoryList
     */
    public function getLSRHistoryList($initiatorEmail = null)
    {
        $query = array_filter([
            'initiatorEmail' => $initiatorEmail,
        ]);

        $response = MedcoRestful::fetchData(
            url: Url::GetLSRHistoryList,
            query: $query
        );

        return $response ?: [];
    }

    /**
     * Get LSR Task Todo
     * GET LSRFieldVerificator/API/GetLSRTaskTodo
     */
    public function getLSRTaskTodo($responsibleUserEmail = null)
    {
        $query = array_filter([
            'responsibleUserEmail' => $responsibleUserEmail,
        ]);

        $response = MedcoRestful::fetchData(
            url: Url::GetLSRTaskTodo,
            query: $query
        );

        return $response ?: [];
    }

    /**
     * Search LSR
     * GET LSRFieldVerificator/API/SearchLSR
     */
    public function searchLSR($initiatorEmail = null,$workerVerifierEmail = null, $ptwNumber = null, $processID = null, $category = null)
    {
        $query = array_filter([
            'initiatorEmail' => $initiatorEmail,
            'workerVerifierEmail' => $workerVerifierEmail,
            'ptwNumber' => $ptwNumber,
            'processID' => $processID,
            'category' => $category,
        ]);

        $response = MedcoRestful::fetchData(
            url: Url::SearchLSR,
            query: $query
        );

        return $response ?: [];
    }

    /**
     * Get LSR Detail
     * GET LSRFieldVerificator/API/GetLSRDetail
     */
    public function getLSRDetail($id)
    {
        if (!$id) {
            return null;
        }

        $response = MedcoRestful::fetchData(
            url: Url::GetLSRDetail,
            query: ['id' => $id]
        );

        return $response;
    }

    /**
     * Get Company List
     * GET LSRFieldVerificator/API/GetCompany
     */
    public function getCompany($searchParam = null)
    {
        $query = array_filter([
            'searchParam' => $searchParam,
        ]);

        $response = MedcoRestful::fetchData(
            url: Url::GetCompanyLsr,
            query: $query
        );

        return $response ?: [];
    }

    /**
     * Get Block List
     * GET LSRFieldVerificator/API/GetBlock
     */
    public function getBlock()
    {
        $response = MedcoRestful::fetchData(
            url: Url::GetBlock,
            query: []
        );

        return $response ?: [];
    }

    /**
     * Get Area Field List
     * GET LSRFieldVerificator/API/GetAreaField
     */
    public function getAreaField($block)
    {
        if (!$block) {
            return [];
        }

        $response = MedcoRestful::fetchData(
            url: Url::GetAreaField,
            query: ['Block' => $block]
        );

        return $response ?: [];
    }

    /**
     * Get Location List
     * GET LSRFieldVerificator/API/GetLocation
     */
    public function getLocation()
    {
        $response = MedcoRestful::fetchData(
            url: Url::GetLocationLsr,
            query: []
        );

        return $response ?: [];
    }

    /**
     * Get Function List
     * GET LSRFieldVerificator/API/GetFunction
     */
    public function getFunction()
    {
        $response = MedcoRestful::fetchData(
            url: Url::GetFunction,
            query: []
        );

        return $response ?: [];
    }

    /**
     * Get LSR Category List
     * GET LSRFieldVerificator/API/GetLSRCategory
     */
    public function getLSRCategory()
    {
        $response = MedcoRestful::fetchData(
            url: Url::GetLSRCategory,
            query: []
        );

        return $response ?: [];
    }

    /**
     * Get LSR Subcategory List
     * GET LSRFieldVerificator/API/GetLSRSubcategory
     */
    public function getLSRSubcategory($lsrCatId)
    {
        if (!$lsrCatId) {
            return [];
        }

        $response = MedcoRestful::fetchData(
            url: Url::GetLSRSubcategory,
            query: ['LSRCatId' => $lsrCatId]
        );

        return $response ?: [];
    }

    /**
     * Get Personnel List
     * GET LSRFieldVerificator/API/GetPersonnelList
     */
    public function getPersonnelList($name = null)
    {
        $query = array_filter([
            'name' => $name,
        ]);

        $response = MedcoRestful::fetchData(
            url: Url::GetPersonnelList,
            query: $query
        );

        return $response ?: [];
    }

    /**
     * Get Checklist
     * GET LSRFieldVerificator/API/GetChecklist
     */
    public function getChecklist($lsrCatId)
    {
        if (!$lsrCatId) {
            return [];
        }

        $response = MedcoRestful::fetchData(
            url: Url::GetChecklist,
            query: ['LSRCatId' => $lsrCatId]
        );

        return $response ?: [];
    }

    /**
     * Post LSR
     * POST LSRFieldVerificator/API/PostLSR
     */
    public function postLSR($model)
    {
        if (!$model) {
            return null;
        }

        $response = MedcoRestful::postAction(
            url: Url::PostLSR,
            body: $model
        );

        return $response;
    }

    /**
     * Post LSR Verify
     * POST LSRFieldVerificator/API/PostLSRVerify
     */
    public function postLSRVerify($model)
    {
        if (!$model) {
            return null;
        }

        $response = MedcoRestful::postAction(
            url: Url::PostLSRVerify,
            query: [],
            body: $model
        );

        return $response;
    }

    /**
     * Post LSR Route To Initiator
     * POST LSRFieldVerificator/API/PostLSRRouteToInitiator
     */
    public function postLSRRouteToInitiator($model)
    {
        if (!$model) {
            return null;
        }

        $response = MedcoRestful::postAction(
            url: Url::PostLSRRouteToInitiator,
            query: [],
            body: $model
        );

        return $response;
    }
}
