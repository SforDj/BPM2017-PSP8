package com.ist.cadillacpaltform.wifyapp.network;

import com.ist.cadillacpaltform.wifyapp.network.Enity.AdvertiseResponse;

import retrofit2.Retrofit;
import retrofit2.adapter.rxjava.RxJavaCallAdapterFactory;
import retrofit2.converter.gson.GsonConverterFactory;
import rx.Observable;
import rx.Subscriber;
import rx.android.schedulers.AndroidSchedulers;
import rx.schedulers.Schedulers;

/**
 * Created by czh on 2017/12/13.
 */

public class NetServiceManager {
    private String BASE_URL="http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/";
    //private String BASE_URL="http://10.0.2.2:1234/";
    private Retrofit mRetrofit;
    private NetService netService;
    private static NetServiceManager netServiceManager;

    private NetServiceManager() {
        mRetrofit = new Retrofit.Builder()
                .addConverterFactory(GsonConverterFactory.create())
                .baseUrl(BASE_URL)
                .addCallAdapterFactory(RxJavaCallAdapterFactory.create())
                .build();
        netService = mRetrofit.create(NetService.class);
    }

    public static NetService getInstance(){
        if(netServiceManager==null){
            netServiceManager = new NetServiceManager();
        }
        return netServiceManager.netService;
    }

    static public  <T> Observable<T> observe(Observable<T> observable){
        return observable
                .subscribeOn(Schedulers.io())
                .unsubscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread());
    }

}
