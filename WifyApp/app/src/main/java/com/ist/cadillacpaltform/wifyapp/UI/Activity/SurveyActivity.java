package com.ist.cadillacpaltform.wifyapp.UI.Activity;

import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;
import android.widget.TextView;

import com.ist.cadillacpaltform.wifyapp.R;

public class SurveyActivity extends Activity {
    private TextView tvTitle;
    private ImageView ivBack;
    private WebView wvSurvey;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_survey);
        initView();
    }

    private void initView() {
        tvTitle = (TextView) findViewById(R.id.tv_title);
        tvTitle.setText("调查问卷");
        ivBack = (ImageView) findViewById(R.id.iv_back);
        ivBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //// TODO: 2017/12/9
                finish();
            }
        });
        wvSurvey = (WebView) findViewById(R.id.wv_body);
        wvSurvey.loadUrl("https://www.wjx.cn/jq/17141631.aspx");          //调用loadUrl方法为WebView加入链接
        wvSurvey.setWebViewClient(new WebViewClient() {
            //设置在webView点击打开的新网页在当前界面显示,而不跳转到新的浏览器中
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                view.loadUrl(url);
                return true;
            }
        });
        WebSettings settings = wvSurvey.getSettings();
        settings.setUseWideViewPort(true);//设定支持viewport
        settings.setLoadWithOverviewMode(true);   //自适应屏幕
        settings.setBuiltInZoomControls(true);
        settings.setDisplayZoomControls(false);
        settings.setSupportZoom(true);//设定支持缩放
        settings.setJavaScriptEnabled(true);
        settings.setDisplayZoomControls(false);
    }

    @Override
    public void onBackPressed() {
        if (wvSurvey.canGoBack()) {
            wvSurvey.goBack();
        } else {
            super.onBackPressed();
        }
    }


}
