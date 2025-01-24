package com.localloop.api.repositories;

import com.localloop.data.models.Report;
import com.localloop.utils.DataCallBack;

public interface ReportRepository {

    void insertReport(int reportId, DataCallBack<Report> callBack);

}
