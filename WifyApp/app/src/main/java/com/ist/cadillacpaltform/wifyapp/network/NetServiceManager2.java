package com.ist.cadillacpaltform.wifyapp.network;

import retrofit2.Retrofit;
import retrofit2.adapter.rxjava.RxJavaCallAdapterFactory;
import retrofit2.converter.gson.GsonConverterFactory;
import rx.Observable;
import rx.android.schedulers.AndroidSchedulers;
import rx.schedulers.Schedulers;

/**
 * Created by czh on 2017/12/13.
 */

public class NetServiceManager2 {
    private String BASE_URL="http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/";
    //private String BASE_URL="http://10.0.2.2:1234/";
    private Retrofit mRetrofit;
    private NetService netService;
    private static NetServiceManager2 netServiceManager;

    private NetServiceManager2() {
        mRetrofit = new Retrofit.Builder()
                .addConverterFactory(GsonConverterFactory.create())
                .baseUrl(BASE_URL)
                .addCallAdapterFactory(RxJavaCallAdapterFactory.create())
                .build();
        netService = mRetrofit.create(NetService.class);
    }

    public static NetService getInstance(){
        if(netServiceManager==null){
            netServiceManager = new NetServiceManager2();
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
