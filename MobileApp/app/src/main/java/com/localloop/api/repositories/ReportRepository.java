package com.localloop.api.repositories;

import com.localloop.data.models.Report;
import com.localloop.utils.DataCallBack;

public interface ReportRepository {

    void insertReport(String entityType, int reportId, DataCallBack<Report> callBack);
}
