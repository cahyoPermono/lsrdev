# LSR (Life Saving Rules) Module Documentation

## Overview

The LSR (Life Saving Rules) module is a comprehensive system for managing work submissions, safety categories, and permit-to-work processes. This module provides APIs for managing companies, blocks, areas, locations, functions, categories, work verifiers, and submissions.

## Architecture

### Directory Structure
```
app/Http/Controllers/Api/Lsr/
├── ApiLsrController.php

app/Services/Lsr/
├── LsrService.php

storage/dummy-data/lsr/
├── companies.json
├── blocks.json
├── areas.json
├── locations.json
├── functions.json
├── categories.json
├── work-verifiers.json
└── submissions.json
```

## API Endpoints

### Authentication
All LSR endpoints require authentication and use the `authorization:lsr` middleware.

### 1. GET /lsr/companies
Get list of all companies.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "Medco E&P Indonesia",
      "code": "MEPI",
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 2. GET /lsr/blocks
Get list of all blocks.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "Block A",
      "company_id": 1,
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 3. GET /lsr/areas
Get list of all areas/fields.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "Area 1",
      "block_id": 1,
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 4. GET /lsr/locations
Get list of all locations.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "Jakarta Office",
      "area_id": 1,
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 5. GET /lsr/functions
Get list of all work functions.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "Electrical Work",
      "code": "ELC",
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 6. GET /lsr/categories
Get list of all risk categories.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "High Risk",
      "description": "High risk activities requiring special permits",
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 7. GET /lsr/work-verifiers
Get list of all work verifiers.

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "employee_id": "EMP001",
      "department": "HSE",
      "email": "john.doe@medcoenergi.com",
      "phone": "+62-811-0000-0001",
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### 8. GET /lsr/submissions
Get list of submissions with optional filtering.

**Query Parameters:**
- `status` (optional): Filter by submission status (draft, submitted, approved, rejected)
- `work_verifier_id` (optional): Filter by work verifier ID

**Example Request:**
```
GET /lsr/submissions?status=draft&work_verifier_id=1
```

**Response:**
```json
{
  "status": 200,
  "message": "success",
  "data": [
    {
      "id": 1,
      "company_id": 1,
      "block_id": 1,
      "area_id": 1,
      "location_id": 1,
      "function_id": 1,
      "ptw_number": "PTW-2024-001",
      "activity_description": "Electrical maintenance work",
      "categories": [1, 2],
      "start_work_verifier_id": 1,
      "questionnaires": [
        {
          "question_number": "Q001",
          "compliance_st1": true,
          "deviation_st1": "No deviation",
          "compliance_st2": true,
          "deviation_st2": "No deviation"
        }
      ],
      "status": "draft",
      "created_at": "2024-01-01T08:00:00Z",
      "updated_at": "2024-01-01T08:00:00Z"
    }
  ]
}
```

### 9. POST /lsr/submissions
Create a new submission.

**Request Body:**
```json
{
  "company": 1,
  "block": 1,
  "area_field": 1,
  "location": 1,
  "function": 1,
  "ptw_number": "PTW-2024-005",
  "activity_description": "New electrical work",
  "categorys": [1, 2],
  "start_work_verifier_id": 1,
  "questionnaires": [
    {
      "question_number": "Q001",
      "compliance_st1": true,
      "deviation_st1": "No deviation",
      "compliance_st2": false,
      "deviation_st2": "Safety protocol not followed"
    }
  ]
}
```

**Validation Rules:**
- `company`: required, integer
- `block`: required, integer
- `area_field`: required, integer
- `location`: required, integer
- `function`: required, integer
- `ptw_number`: required, string
- `activity_description`: required, string
- `categorys`: required, array
- `start_work_verifier_id`: required, integer
- `questionnaires`: optional, array
- `questionnaires.*.question_number`: required if questionnaires provided, string
- `questionnaires.*.compliance_st1`: required if questionnaires provided, boolean
- `questionnaires.*.deviation_st1`: required if questionnaires provided, string
- `questionnaires.*.compliance_st2`: required if questionnaires provided, boolean
- `questionnaires.*.deviation_st2`: required if questionnaires provided, string

**Response:**
```json
{
  "status": 200,
  "message": "Submission created successfully",
  "data": {
    "id": 5,
    "company_id": 1,
    "block_id": 1,
    "area_id": 1,
    "location_id": 1,
    "function_id": 1,
    "ptw_number": "PTW-2024-005",
    "activity_description": "New electrical work",
    "categories": [1, 2],
    "start_work_verifier_id": 1,
    "questionnaires": [
      {
        "question_number": "Q001",
        "compliance_st1": true,
        "deviation_st1": "No deviation",
        "compliance_st2": false,
        "deviation_st2": "Safety protocol not followed"
      }
    ],
    "status": "draft",
    "created_at": "2024-01-05T08:00:00Z",
    "updated_at": "2024-01-05T08:00:00Z"
  }
}
```

## Data Structures

### Submission Status Values
- `draft`: Initial status when submission is created
- `submitted`: When submission is submitted for review
- `approved`: When submission is approved
- `rejected`: When submission is rejected

### Category Types
- `High Risk`: Activities requiring special permits
- `Medium Risk`: Standard procedures required
- `Low Risk`: Basic safety measures required
- `Critical`: Multiple approvals required

### Questionnaires Data Structure
The `questionnaires` field contains an array of compliance questionnaire objects used for safety verification:

**Questionnaire Object Fields:**
- `question_number`: string - Unique identifier for the question (e.g., "Q001", "Q002")
- `compliance_st1`: boolean - Compliance status for station/supervisor 1 (true = compliant, false = non-compliant)
- `deviation_st1`: string - Description of deviation if compliance_st1 is false
- `compliance_st2`: boolean - Compliance status for station/supervisor 2 (true = compliant, false = non-compliant)
- `deviation_st2`: string - Description of deviation if compliance_st2 is false

**Example Questionnaire Data:**
```json
[
  {
    "question_number": "Q001",
    "compliance_st1": true,
    "deviation_st1": "No deviation",
    "compliance_st2": true,
    "deviation_st2": "No deviation"
  },
  {
    "question_number": "Q002",
    "compliance_st1": false,
    "deviation_st1": "PPE not worn during work",
    "compliance_st2": true,
    "deviation_st2": "No deviation"
  }
]
```

## Production Migration Guide

### Step 1: Update Configuration

Create or update your API configuration file (`config/api.php` or similar):

```php
<?php

return [
    'lsr' => [
        'companies_url' => 'https://external-api.com/api/companies',
        'blocks_url' => 'https://external-api.com/api/blocks',
        'areas_url' => 'https://external-api.com/api/areas',
        'locations_url' => 'https://external-api.com/api/locations',
        'functions_url' => 'https://external-api.com/api/functions',
        'categories_url' => 'https://external-api.com/api/categories',
        'work_verifiers_url' => 'https://external-api.com/api/work-verifiers',
        'submissions_url' => 'https://external-api.com/api/submissions',
    ]
];
```

### Step 2: Update Service Methods

In `app/Services/Lsr/LsrService.php`, replace dummy data methods with API calls:

#### Replace `getCompanies()` method:
```php
public function getCompanies()
{
    try {
        $response = Http::timeout(30)->get(config('api.lsr.companies_url'));

        if ($response->successful()) {
            return $response->json();
        }

        // Fallback to dummy data if API fails
        return $this->getCompaniesFromDummy();
    } catch (\Exception $e) {
        Log::error('Failed to fetch companies from API: ' . $e->getMessage());
        return $this->getCompaniesFromDummy();
    }
}

private function getCompaniesFromDummy()
{
    $jsonContent = Storage::get('dummy-data/lsr/companies.json');
    return json_decode($jsonContent, true);
}
```

#### Replace `createSubmission()` method:
```php
public function createSubmission($data)
{
    try {
        $response = Http::timeout(30)->post(config('api.lsr.submissions_url'), [
            'company_id' => $data['company_id'],
            'block_id' => $data['block_id'],
            'area_id' => $data['area_field'],
            'location_id' => $data['location'],
            'function_id' => $data['function'],
            'ptw_number' => $data['ptw_number'],
            'activity_description' => $data['activity_description'],
            'categories' => $data['categorys'],
            'start_work_verifier_id' => $data['start_work_verifier_id']
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to create submission via API');
    } catch (\Exception $e) {
        Log::error('Failed to create submission via API: ' . $e->getMessage());

        // Fallback to dummy data storage
        return $this->createSubmissionInDummy($data);
    }
}
```

### Step 3: Update All Service Methods

Apply similar patterns to all methods in `LsrService.php`:
- `getBlocks()`
- `getAreas()`
- `getLocations()`
- `getFunctions()`
- `getCategories()`
- `getWorkVerifiers()`
- `getSubmissions()`

### Step 4: Add HTTP Client Configuration

Ensure your Laravel application has proper HTTP client configuration. Add to `config/http.php` or create Guzzle configuration:

```php
'client' => [
    'timeout' => 30,
    'verify' => false, // Set to true in production with proper certificates
],
```

### Step 5: Environment Variables

Add API endpoints to your `.env` file:

```env
LSR_API_BASE_URL=https://external-api.com/api
LSR_API_TIMEOUT=30
LSR_API_KEY=your_api_key_here
```

### Step 6: Testing Migration

1. **Test API Endpoints**: Verify all external API endpoints are accessible
2. **Test Error Handling**: Ensure graceful fallback to dummy data when APIs fail
3. **Monitor Performance**: Check response times and implement caching if needed
4. **Update Documentation**: Document the external API contracts and data formats

### Step 7: Deployment Checklist

- [ ] Update API configuration with production URLs
- [ ] Test all endpoints with production APIs
- [ ] Verify error handling and fallbacks
- [ ] Update API documentation with production details
- [ ] Monitor API usage and performance
- [ ] Set up proper logging for API interactions

## Error Handling

The module includes comprehensive error handling:

- **API Failures**: Automatic fallback to dummy data
- **Validation Errors**: Detailed validation messages
- **Network Issues**: Timeout handling with retry logic
- **Logging**: All API interactions are logged for debugging

## Security Considerations

1. **API Authentication**: Ensure external APIs use proper authentication
2. **Data Validation**: Validate all data from external sources
3. **Rate Limiting**: Implement rate limiting for API calls
4. **SSL/TLS**: Use HTTPS for all external API communications
5. **Input Sanitization**: Sanitize all data before processing

## Monitoring and Maintenance

### Logging
All API interactions are logged in Laravel's log files:
- Successful API calls
- API failures and fallbacks
- Performance metrics
- Error details

### Health Checks
Add health check endpoints to monitor API availability:
```php
// In ApiLsrController.php
public function healthCheck()
{
    try {
        $response = Http::get(config('api.lsr.companies_url'));
        return $this->sendSuccess(['status' => 'healthy']);
    } catch (\Exception $e) {
        return $this->sendError('API unavailable', 503);
    }
}
```

## Support

For issues or questions regarding the LSR module:
1. Check the API documentation above
2. Review the production migration guide
3. Check Laravel logs for error details
4. Verify external API availability and authentication

---

*This documentation was generated for the LSR module implementation. Last updated: January 2025*
