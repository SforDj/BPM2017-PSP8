package com.ist.cadillacpaltform.wifyapp.network;

import com.ist.cadillacpaltform.wifyapp.network.Enity.AdvertiseResponse;
import com.ist.cadillacpaltform.wifyapp.network.Enity.QuestionResponse;
import com.ist.cadillacpaltform.wifyapp.network.Enity.TaskResponse;

import retrofit2.http.GET;
import retrofit2.http.Query;
import rx.Observable;

/**
 * Created by czh on 2017/12/13.
 */

public interface NetService2 {
    @GET("Advertise")//rmp
    Observable<AdvertiseResponse> getAdvertise();

    @GET("Task")
    Observable<TaskResponse> getTask();

    @GET("Question")
    Observable<QuestionResponse> getQuestionByTaskid(@Query("Question.taskid") String taskid);
}
