package com.localloop.utils;

import com.google.gson.Gson;

import okhttp3.ResponseBody;

public class ErrorRequest {
    private String name;
    private String message;
    private int code;
    private int status;
    private String type;

    public static String getErrorResponse(ResponseBody errorResponse, String defaultErrorMessage) {
        try (ResponseBody errorBody = errorResponse) {
            if (errorBody != null) {
                ErrorRequest errorRequest = new Gson().fromJson(errorBody.charStream(), ErrorRequest.class);
                return errorRequest.getMessage();
            }
        } catch (Exception e) {
            return defaultErrorMessage;
        }
        
        return defaultErrorMessage;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public int getCode() {
        return code;
    }

    public void setCode(int code) {
        this.code = code;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }
}
