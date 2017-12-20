package com.ist.cadillacpaltform.wifyapp.UI.Activity;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.andexert.expandablelayout.library.ExpandableLayoutListView;
import com.ist.cadillacpaltform.wifyapp.Adapter.MyAdapter;
import com.ist.cadillacpaltform.wifyapp.R;
import com.ist.cadillacpaltform.wifyapp.network.Enity.TaskResponse;
import com.ist.cadillacpaltform.wifyapp.network.NetServiceManager;

import rx.Subscriber;

public class TaskListActivity extends AppCompatActivity {
    private TextView tvTitle;
    private ImageView ivBack;
    private ExpandableLayoutListView elvTask;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_task_list);
        initView();
    }

    private void initView() {
        tvTitle = (TextView) findViewById(R.id.tv_title);
        tvTitle.setText("任务列表");
        ivBack = (ImageView) findViewById(R.id.iv_back);
        ivBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //// TODO: 2017/12/9
                finish();
            }
        });
        elvTask = (ExpandableLayoutListView) findViewById(R.id.elv_task);
        initTaskList();
    }

    private void initTaskList() {
        NetServiceManager.observe(NetServiceManager.getInstance().getTask()).subscribe(new Subscriber<TaskResponse>() {
            @Override
            public void onCompleted() {

            }

            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onNext(TaskResponse taskResponse) {
                BaseAdapter mAdapter = null;
                mAdapter = new MyAdapter<TaskResponse.Task>(taskResponse.taskList, R.layout.unit_task_item) {
                    @Override
                    public void bindView(ViewHolder holder, TaskResponse.Task obj) {
                        ((TextView) holder.getView(R.id.tv_name)).setText(obj.getName());
//                        String rewardType="";
//                        switch (obj.getRewardtype()){//0是流量1是话费2是现金3是红包
//                            case "0":
//                                rewardType="流量";
//
//                        }
//                        ((TextView)holder.getView(R.id.tv_reword)).setText(obj.getReward());
                        String type = "";
                        if (obj.getRewardtype() == "0") {
                            type = "问卷";
                        } else {
                            type = "数据标注";
                        }
                        ((TextView) holder.getView(R.id.tv_type)).setText(type);

                        ((TextView) holder.getView(R.id.tv_content)).setText(obj.getDescription());
                        //((TextView) holder.getView(R.id.tv_progress)).setText(Double.parseDouble(obj.getProgress())*100+"%");
                    }
                };

                elvTask.setAdapter(mAdapter);
            }
        });
    }
}
