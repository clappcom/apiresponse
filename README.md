API RESPONSE LIBRARY

$response = new ApiResponse(ErrorResponseCode::ERROR_RELATED_VIDEO_UPLOAD_MISSING_SHARED_LINK);
/* LARAVEL JSON RESPONSE */
return Response::json($response->getResponse());

