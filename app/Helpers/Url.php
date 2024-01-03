<?php
namespace App\Helpers;

class Url
{
     // USE CASE 1
     const ListCertificate = "MMAPSVC2/api/PTS/GetCertificateList"; // [✅]
     const ListCompetency = "MMAPSVC2/api/CTMS/GetCompetencyList"; // [✅]
     const FindUserByEmail = "MMAPSVC2/api/PTS/GetDataByEmail"; // [✅]
     const FindUserByPersonId = "MMAPSVC2/api/PTS/GetDataByPersonId"; // [✅]
     const GetPermitDetail = "MMAPSVC2/api/PTW/GetPermitDetail"; // [✅]
     const GetWLDetail = "MMAPSVC2/api/PTW/GetWLDetail"; // [✅]
     const GetListTraining = "MMAPSVC2/api/CTMS/GetTrainingList";  // [✅]
     const GetListIsolation = "MMAPSVC2/api/IC/GetDetail";  // [✅]
     const GetVerificatorDetail = "MMAPSVC2/api/IC/GetVerificatorDetail"; // [✅]
     const PutIcDetail = "MMAPSVC2/api/IC/PutICDetail"; // [✅]
     const PutPermitDetail = "MMAPSVC2/api/PTW/PutPermitDetail"; // [✅]

     // USE CASE 2
     const GetMedcoStockPrice = "MMAPPrice/api/Stock/GetStockPrices"; // [✅]
     const GetCrudeBrentStockPrice = "MMAPPrice/api/Brent/GetBrentCrudeData"; // [✅]
     const GetCPIStockPrice = "MMAPPrice/api/ICP/GetICPData"; // [✅]
     const GetProductionCompanyDashboardData = "MMAPDashboard/v1/Company/Production"; // [✅]
     const GetSalesCompanyDashboardData = "MMAPDashboard/v1/Company/Sales"; // [✅]
     const GetProductionAssetDashboardData = "MMAPDashboard/v1/Asset/Production"; // [✅]
     const GetSalesAssetDashboardData = "MMAPDashboard/v1/Asset/Sales"; // [✅]
     const GetProductionBlockDashboardData = "MMAPDashboard/v1/Block/Production"; // [✅]
     const GetSalesBlockDashboardData = "MMAPDashboard/v1/Block/Sales"; // [✅]
}