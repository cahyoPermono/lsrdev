<?php
namespace App\Helpers;

class Url
{
     // USE CASE 1
     const ListCertificate = "MMAPSVC2/api/PTS/GetCertificateList";
     const ListCompetency = "MMAPSVC2/api/CTMS/GetCompetencyList";
     const FindUserByEmail = "MMAPSVC2/api/PTS/GetDataByEmail";
     const FindUserByPersonId = "MMAPSVC2/api/PTS/GetDataByPersonId";
     const GetPermitDetail = "MMAPSVC2/api/PTW/GetPermitDetail";
     const GetWLDetail = "MMAPSVC2/api/PTW/GetWLDetail";
     const GetListTraining = "MMAPSVC2/api/CTMS/GetTrainingList";
     const GetListIsolation = "MMAPSVC2/api/IC/GetDetail";
     const GetVerificatorDetail = "MMAPSVC2/api/IC/GetVerificatorDetail";
     const PutIcDetail = "MMAPSVC2/api/IC/PutICDetail";
     const PutPermitDetail = "MMAPSVC2/api/PTW/PutPermitDetail";

     // USE CASE 2
     const GetMedcoStockPrice = "MMAPPrice/api/Stock/GetStockPrices";
     const GetCrudeBrentStockPrice = "MMAPPrice/api/Brent/GetBrentCrudeData";
     const GetCPIStockPrice = "MMAPPrice/api/ICP/GetICPData";


     const GetProductionCompanyDashboardData = "MMAPDashboard/v1/Company/Production";
     const GetSummaryCompanyDashboardData = "MMAPDashboard/v1/Company/Summary";
     const GetSalesCompanyDashboardData = "MMAPDashboard/v1/Company/Sales";
     const GetChartCompanyGasData = "MMAPDashboard/v1/Company/GasChart";
     const GetChartCompanyOilData = "MMAPDashboard/v1/Company/OilChart";


     const GetProductionAssetDashboardData = "MMAPDashboard/v1/Asset/Production";
     const GetSummaryAssetDashboardData = "MMAPDashboard/v1/Asset/Summary";
     const GetSalesAssetDashboardData = "MMAPDashboard/v1/Asset/Sales";
     const GetChartAssetGasData = "MMAPDashboard/v1/Asset/GasChart";
     const GetChartAssetOilData = "MMAPDashboard/v1/Asset/OilChart";


     const GetProductionBlockDashboardData = "MMAPDashboard/v1/Block/Production";
     const GetSummaryBlockDashboardData = "MMAPDashboard/v1/Block/Summary";
     const GetSalesBlockDashboardData = "MMAPDashboard/v1/Block/Sales";
     const GetChartBlockGasData = "MMAPDashboard/v1/Block/GasChart";
     const GetChartBlockOilData = "MMAPDashboard/v1/Block/OilChart";


     const GetProductionFieldDashboardData = "MMAPDashboard/v1/Field/Production"; // [✅]
     const GetSummaryFieldDashboardData = "MMAPDashboard/v1/Field/Summary"; // [✅]
     const GetChartFieldGasData = "MMAPDashboard/v1/Field/GasChart"; // [✅]
     const GetChartFieldOilData = "MMAPDashboard/v1/Field/OilChart"; // [✅]


     // HSE
     const GetHseCalendarEvent = "MMAPHSECampaign/api/Data/GetCalendars";
     const GetHseDocument = "MMAPHSECampaign/api/Data/GetHSEDocument";
     const GetHseLeassonLearned = "MMAPHSECampaign/api/Data/GetLessonLearneds";
     const GetHseNews = "MMAPHSECampaign/api/Data/GetNews";
     const GetHsePopupCampaign = "MMAPHSECampaign/api/Data/GetPopupNotifications";
     const GetHseBannerCampaign = "MMAPHSECampaign/api/Data/GetPosterCampaigns";
     const GetHsePoster = "MMAPHSECampaign/api/Data/GetPosters";
     const GetHseQuizz = "MMAPHSECampaign/api/Data/GetQuizzes";

     // Safety Card
     const SafetyCardGetStatistic = "MMAPSafetyCard/api/SafetyCard/GetStatistic";
     const SafetyCardGetRiskRank = "MMAPSafetyCard/api/SafetyCard/GetRiskRank";
     const SafetyCardGetCategory = "MMAPSafetyCard/api/SafetyCard/GetCategory";
     const SafetyCardGetBlockFunction = "MMAPSafetyCard/api/SafetyCard/GetBlockFunction";
     const SafetyCardGetLocation = "MMAPSafetyCard/api/SafetyCard/GetLocation";
     const SafetyCardGetDivision = "MMAPSafetyCard/api/SafetyCard/GetDivision";
     const SafetyCardGetDepartment = "MMAPSafetyCard/api/SafetyCard/GetDepartment";
     const SafetyCardGetReportType = "MMAPSafetyCard/api/SafetyCard/GetReportType";
     const SafetyCardGetPossibilityOfEvent = "MMAPSafetyCard/api/SafetyCard/GetPossibilityOfEvent";
     const SafetyCardGetUnsafeBehaviour = "MMAPSafetyCard/api/SafetyCard/GetUnsafeBehaviour";
     const SafetyCardGetUnsafeCondition = "MMAPSafetyCard/api/SafetyCard/GetUnsafeCondition";
     const SafetyCardGetUnsafeReason = "MMAPSafetyCard/api/SafetyCard/GetUnsafeReason";
     const SafetyCardGetLifeSavingRules = "MMAPSafetyCard/api/SafetyCard/GetLifeSavingRules";
     const SafetyCardGetRecommendationCategory = "MMAPSafetyCard/api/SafetyCard/GetRecommendationCategory";
     const SafetyCardGetRecommendationPriority = "MMAPSafetyCard/api/SafetyCard/GetRecommendationPriority";
     const SafetyCardGetPosition = "MMAPSafetyCard/api/SafetyCard/GetPosition";
     const SafetyCardGetResponsiblePerson = "MMAPSafetyCard/api/SafetyCard/GetResponsiblePerson";
     const SafetyCardPostSafetyCard = "MMAPSafetyCard/api/SafetyCard/PostSafetyCard";
     const SafetyCardGetSafetyCardList = "MMAPSafetyCard/api/SafetyCard/GetSafetyCardList";
     const SafetyCardGetSafetyCardDetail = "MMAPSafetyCard/api/SafetyCard/GetSafetyCardDetail";
}