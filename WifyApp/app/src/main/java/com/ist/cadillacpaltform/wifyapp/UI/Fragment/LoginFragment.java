package com.ist.cadillacpaltform.wifyapp.UI.Fragment;


import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.dd.CircularProgressButton;
import com.gongwen.marqueen.SimpleMF;
import com.gongwen.marqueen.SimpleMarqueeView;
import com.ist.cadillacpaltform.wifyapp.R;

import java.util.Arrays;
import java.util.List;
import java.util.Properties;

/**
 * A simple {@link Fragment} subclass.
 */
public class LoginFragment extends Fragment {
    private View root;
    private CircularProgressButton circularProgressButton;
    private SimpleMarqueeView marqueeView;

    public LoginFragment() {
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        root = inflater.inflate(R.layout.fragment_login, container, false);
        initView();
        return root;
    }
    private void initView(){
        circularProgressButton = (CircularProgressButton)root.findViewById(R.id.cpb_wifi);
        circularProgressButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                circularProgressButton.setIndeterminateProgressMode(true); // turn on indeterminate progress
                circularProgressButton.setProgress(50);
                //// TODO: 2017/12/18 连接wifi ，之后setProgress(100)还要disable
//                Properties prop=System.getProperties();
//                String proxyHost="X.X.X.X";
//                String proxyPort="X";
//                prop.put("proxySet","true");
//                prop.put("proxyHost",proxyHost);
//                prop.put("proxyPort",proxyPort);
            }
        });

        marqueeView = (SimpleMarqueeView) root.findViewById(R.id.simpleMarqueeView);
        List<String> datas = Arrays.asList("当前站点：上海虹桥", "下个站点：西伯利亚");
        SimpleMF<String> marqueeFactory = new SimpleMF(this.getActivity());
        marqueeFactory.setData(datas);
        marqueeView.setMarqueeFactory(marqueeFactory);
        marqueeView.startFlipping();
    }

}
