<?php
namespace App\Helpers;

class Url
{
     const ListCertificate = "MMAPSVC2/api/PTS/GetCertificateList";
     const ListCompetency = "MMAPSVC2/api/CTMS/GetCompetencyList";
     const FindUserByEmail = "MMAPSVC2/api/PTS/GetDataByEmail";
     const FindUserByPersonId = "MMAPSVC2/api/PTS/GetDataByPersonId";
     const GetPermitDetail = "MMAPSVC2/api/PTW/GetPermitDetail";
     const GetWLDetail = "MMAPSVC2/api/PTW/GetWLDetail";
     const GetListTraining = "MMAPSVC2/api/CTMS/GetTrainingList";
     const GetListIsolation = "MMAPSVC2/api/IC/GetDetail";
     const GetVerificatorDetail = "MMAPSVC2/api/IC/GetVerificatorDetail";
     const PutPermitDetail = "MMAPSVC2/api/PTW/PutPermitDetail";
     const GetMedcoStockPrice = "MMAPPrice/api/Stock/GetStockPrices";
     const GetCrudeBrentStockPrice = "MMAPPrice/api/Brent/GetBrentCrudeData";
     const GetCPIStockPrice = "MMAPPrice/api/ICP/GetICPData";
}