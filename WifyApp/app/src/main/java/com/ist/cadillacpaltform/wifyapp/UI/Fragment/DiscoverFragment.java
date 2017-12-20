package com.ist.cadillacpaltform.wifyapp.UI.Fragment;


import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import com.ist.cadillacpaltform.wifyapp.R;

/**
 * A simple {@link Fragment} subclass.
 */
public class DiscoverFragment extends Fragment {
    private View root;
    private WebView wView;

    public DiscoverFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        root = inflater.inflate(R.layout.fragment_discover, container, false);
        initView();
        return root;
    }

    private void initView(){
        wView = (WebView) root.findViewById(R.id.wv_discover);
        wView.loadUrl("http://i.meituan.com/?utm_source=waputm_baiduwap17&utm_medium=wap");
        wView.setWebViewClient(new WebViewClient() {
            //在webview里打开新链接
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                view.loadUrl(url);
                return true;
            }
        });
    }

}
