<?php
if (!function_exists('json')) {
    /**
     * sending a custom json
     *
     * @param array $body
     * @param null $errors
     * @param int $code
     * @param string $statusText
     * @return \Illuminate\Http\JsonResponse
     */
    function json($body = [], $errors = null, $code = 200, $statusText = "OK"){
        $status = [
            "200" => "OK",
            "201" => "Created",
            "204" => "No Content",
            "400" => "Bad Request",
            "401" => "Unauthorized",
            "404" => "Not Found",
            "409" => "Conflict",
            "422" => "Unprocessable Entity",
            "500" => "Internal Server Error"
        ];

        $contents = [
            "status"        => empty($status[$code]) ? $statusText : $status[$code],
            "code"          => $code,
            "response_time" => microtime(true) - LARAVEL_START,
            "body"          => $body,
            "errors"        => $errors == null ? null : $errors,
            "message"       => $code == 200 || $code == 201 || $code == 202 || $code == 203 || $code == 204 ? "success" : "failed"
        ];

        $headers = [
            "Content-Type" => "application/json"
        ];

        return \Illuminate\Support\Facades\Response::json($contents, $code, $headers);
    }
}

if (!function_exists('error')) {
    /**
     * pass a custom error trough a json function above
     *
     * @param mixed $details
     * @param mixed $messages
     * @param int $code
     * @param string $statusText
     * @return \Illuminate\Http\JsonResponse
     */
    function error($details = null, $messages = null, $code = 500, $statusText = "Internal Server Error"){
        $errors = [
            "messages" => $messages
        ];

        if ($details != null) {
            $errors["details"] = $details;
        }

        return json(null, $errors, $code, $statusText);
    }
}
