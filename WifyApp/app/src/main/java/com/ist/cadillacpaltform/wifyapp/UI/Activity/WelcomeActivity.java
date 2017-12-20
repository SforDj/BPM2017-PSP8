package com.ist.cadillacpaltform.wifyapp.UI.Activity;

import android.content.Intent;
import android.net.Uri;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import com.facebook.drawee.view.SimpleDraweeView;
import com.ist.cadillacpaltform.wifyapp.R;
import com.ist.cadillacpaltform.wifyapp.network.Enity.AdvertiseResponse;
import com.ist.cadillacpaltform.wifyapp.network.NetServiceManager;

import rx.Subscriber;

public class WelcomeActivity extends AppCompatActivity {
    SimpleDraweeView sdvAd;
    private final long SPLASH_LENGTH = 2000;
    private Handler handler = new Handler();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_welcome);
        sdvAd = (SimpleDraweeView) findViewById(R.id.sdv_ad);
        sdvAd.setImageURI(new Uri.Builder().scheme("res").path(String.valueOf(R.drawable.ad_placeholder)).build());
        //setAdPic();
        handler.postDelayed(new Runnable() {  //使用handler的postDelayed实现延时跳转
            public void run() {
                Intent intent = new Intent(WelcomeActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        }, SPLASH_LENGTH);//2秒后跳转至应用主界面MainActivity
    }

    private void setAdPic() {
        NetServiceManager.observe(NetServiceManager.getInstance().getAdvertise()).subscribe(new Subscriber<AdvertiseResponse>() {
            @Override
            public void onCompleted() {
            }

            @Override
            public void onError(Throwable e) {
                e.printStackTrace();
            }

            @Override
            public void onNext(AdvertiseResponse advertiseResponse) {
                for (AdvertiseResponse.Advertise temp : advertiseResponse.advertises) {
                    if (temp.getName() != null && temp.getName().equals("startpage")) {
                        sdvAd.setImageURI(temp.getPicurl());
                        return;
                    }
                }
            }
        });


    }

}
