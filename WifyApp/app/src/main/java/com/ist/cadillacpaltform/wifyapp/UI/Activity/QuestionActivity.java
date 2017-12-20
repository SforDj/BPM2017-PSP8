package com.ist.cadillacpaltform.wifyapp.UI.Activity;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.TextView;

import com.ist.cadillacpaltform.wifyapp.Adapter.MyAdapter;
import com.ist.cadillacpaltform.wifyapp.R;
import com.ist.cadillacpaltform.wifyapp.network.Enity.QuestionResponse;
import com.ist.cadillacpaltform.wifyapp.network.NetServiceManager;

import java.util.List;

import info.hoang8f.widget.FButton;
import rx.Subscriber;

public class QuestionActivity extends Activity {
    private String taskId;
    private ListView listView;
    private FButton btnSubmit;
    private TextView tvTitle;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_question);
        initView();
    }
    private void initView(){
        listView = (ListView)findViewById(R.id.lv_body);
        tvTitle = (TextView)findViewById(R.id.tv_title);
        Intent intent = getIntent();
        taskId = intent.getStringExtra("taskId");
        tvTitle.setText(intent.getStringExtra("name"));
        NetServiceManager.observe(NetServiceManager.getInstance().getQuestionByTaskid(taskId)).subscribe(new Subscriber<QuestionResponse>() {
            @Override
            public void onCompleted() {

            }

            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onNext(QuestionResponse questionResponse) {
                BaseAdapter mAdapter = null;
                mAdapter = new MyAdapter<QuestionResponse.Question>(questionResponse.questionArrayList, R.layout.unit_question_item){
                    @Override
                    public void bindView(ViewHolder holder, final QuestionResponse.Question obj){
                        ((TextView)holder.getView(R.id.tv_question)).setText(holder.getItemPosition()+1+"."+obj.getContent());
                        ((RadioButton)holder.getView(R.id.A)).setText("A."+obj.getA());
                        ((RadioButton)holder.getView(R.id.B)).setText("B."+obj.getB());
                        ((RadioButton)holder.getView(R.id.C)).setText("C."+obj.getC());
                        ((RadioButton)holder.getView(R.id.D)).setText("D."+obj.getD());
                    }
                };
                listView.addFooterView(LayoutInflater.from(QuestionActivity.this).inflate(R.layout.unit_question_submit_button, null));
                listView.setAdapter(mAdapter);
                btnSubmit = (FButton)findViewById(R.id.btn_submit);
                btnSubmit.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        //// TODO: 2017/12/20 提交答案
                    }
                });
            }
        });

    }
}
