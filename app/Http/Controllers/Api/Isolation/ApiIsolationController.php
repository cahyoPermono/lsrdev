<?php

namespace App\Http\Controllers\Api\Isolation;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\IsolationService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Isolation
 */
class ApiIsolationController extends ApiController
{
    public function __construct(
        private IsolationService $isolationService
    ) {
    }
    /**
     * Detail Isolation
     */
    public function index(Request $request, $pid)
    {
        $result = $this->isolationService->findByPid($pid);
        return $this->sendSuccess($result);
    }
}