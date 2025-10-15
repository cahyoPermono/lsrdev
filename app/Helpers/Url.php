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
     const GetWTIPrice = "MMAPPrice/api/Wti/GetWTICrudeData";


     const GetProductionCompanyDashboardData = "MMAPDashboard/v2/Company/Production";
     const GetSummaryCompanyDashboardData = "MMAPDashboard/v2/Company/Summary";
     const GetSalesCompanyDashboardData = "MMAPDashboard/v2/Company/Sales";
     const GetChartCompanyGasData = "MMAPDashboard/v2/Company/GasChart";
     const GetChartCompanyOilData = "MMAPDashboard/v2/Company/OilChart";
     const GetYtdVsBudgetCompanyData = "/MMAPDashboard/v2/Company/YtdVsBudget";


     const GetProductionAssetDashboardData = "MMAPDashboard/v2/Asset/Production";
     const GetSummaryAssetDashboardData = "MMAPDashboard/v2/Asset/Summary";
     const GetSalesAssetDashboardData = "MMAPDashboard/v2/Asset/Sales";
     const GetChartAssetGasData = "MMAPDashboard/v2/Asset/GasChart";
     const GetChartAssetOilData = "MMAPDashboard/v2/Asset/OilChart";


     const GetProductionBlockDashboardData = "MMAPDashboard/v2/Block/Production";
     const GetSummaryBlockDashboardData = "MMAPDashboard/v2/Block/Summary";
     const GetSalesBlockDashboardData = "MMAPDashboard/v2/Block/Sales";
     const GetChartBlockGasData = "MMAPDashboard/v2/Block/GasChart";
     const GetChartBlockOilData = "MMAPDashboard/v2/Block/OilChart";
     const GetQuarterlyProductionBlockDashboardData = 'MMAPDashboard/v2/Block/ProductionQuarter';


     const GetProductionFieldDashboardData = "MMAPDashboard/v2/Field/Production"; // [✅]
     const GetSummaryFieldDashboardData = "MMAPDashboard/v2/Field/Summary"; // [✅]
     const GetChartFieldGasData = "MMAPDashboard/v2/Field/GasChart"; // [✅]
     const GetChartFieldOilData = "MMAPDashboard/v2/Field/OilChart"; // [✅]


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
     const SafetyCardGetObservationLocation = "MMAPSafetyCard/api/SafetyCard/GetObservationLocation";

     // Phase 2
     const GetListTrainingByEmail = "MMAPSVC2/api/OTC/GetReportOTC";
     const GetRequestApproverList = "MMAPiTrac/v1/Reservation/get_request_approver";
     const GetReservationByApprovePayrol = "MMAPiTrac/v1/Reservation/get_reservation_by_approver_payroll";
     const GetFuturePersonReservation = "MMAPiTrac/v1/Reservation/get_future_person_reservation";
     const GetFuturePoolCarRequest = "MMAPiTrac/v1/Reservation/get_future_pool_car_request";
     const FindUserByPersonIdv2 = "MMAPiTrac/v1/Person/get_person_info";
     const GetReservationInfo = "MMAPiTrac/v1/Reservation/get_reservation_info";
     const GetPosition = "MMAPiTrac/v1/Position/get_position";
     const GetCostCenter = "MMAPiTrac/v1/Cost/get_cost_center";
     const GetLocation = "MMAPiTrac/v1/Location/get_location";
     const GetTransportationType = "MMAPiTrac/v1/Transportation/get_transportation_type";
     const GetPurpostOfVisit = "MMAPiTrac/v1/Purpose/get_purpose_of_visit";
     const PostUpdateOimApprover = "MMAPiTrac/v1/Reservation/update_oim_approver";
     const PostCancelReservationRequest = "MMAPiTrac/v1/Reservation/cancel_person_reservation";
     const PostCreateReservation = "MMAPiTrac/v1/Reservation/post_person_reservation";
     const PostCreatePoolCar = "MMAPiTrac/v1/Reservation/post_pool_car_request";
     const GetReservationByPersonId = "MMAPiTrac/v1/Reservation/get_reservation_by_approver_person_id";
     const PostApprovalReservation = "MMAPiTrac/v1/Reservation/post_oim_approval";
     const GetMinreqValidity = "MMAPiTrac/v1/Reservation/get_minreq_validity";
     const GetCompany = "MMAPiTrac/v1/Company/get_company_list";

     //lsr
     const GetLSRHistoryList = "LSRFieldVerificator/API/GetLSRHistoryList";
     const GetLSRTaskTodo = "LSRFieldVerificator/API/GetLSRTaskTodo";
     const SearchLSR = "LSRFieldVerificator/API/SearchLSR";
     const GetLSRDetail = "LSRFieldVerificator/API/GetLSRDetail";
     const GetCompanyLsr = "LSRFieldVerificator/API/GetCompany";
     const GetBlock = "LSRFieldVerificator/API/GetBlock";
     const GetAreaField = "LSRFieldVerificator/API/GetAreaField";
     const GetLocationLsr = "LSRFieldVerificator/API/GetLocation";
     const GetFunction = "LSRFieldVerificator/API/GetFunction";
     const GetLSRCategory = "LSRFieldVerificator/API/GetLSRCategory";
     const GetLSRSubcategory = "LSRFieldVerificator/API/GetLSRSubcategory";
     const GetPersonnelList = "LSRFieldVerificator/API/GetPersonnelList";
     const GetChecklist = "LSRFieldVerificator/API/GetChecklist";
     const PostLSR = "LSRFieldVerificator/API/PostLSR";
     const PostLSRVerify = "LSRFieldVerificator/API/PostLSRVerify";
     const PostLSRRouteToInitiator = "LSRFieldVerificator/API/PostLSRRouteToInitiator";

}
