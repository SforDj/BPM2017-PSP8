package com.ist.cadillacpaltform.wifyapp.UI.Fragment;


import android.app.Fragment;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.andexert.expandablelayout.library.ExpandableLayoutListView;
import com.facebook.drawee.view.SimpleDraweeView;
import com.ist.cadillacpaltform.wifyapp.Adapter.MyAdapter;
import com.ist.cadillacpaltform.wifyapp.R;
import com.ist.cadillacpaltform.wifyapp.UI.Activity.MainActivity;
import com.ist.cadillacpaltform.wifyapp.UI.Activity.QuestionActivity;
import com.ist.cadillacpaltform.wifyapp.UI.Activity.WelcomeActivity;
import com.ist.cadillacpaltform.wifyapp.network.Enity.TaskResponse;
import com.ist.cadillacpaltform.wifyapp.network.NetServiceManager;

import rx.Subscriber;

/**
 * A simple {@link Fragment} subclass.
 */
public class TaskListFragment extends Fragment {
    protected View mRoot;
    private ExpandableLayoutListView elvTask;

    public TaskListFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        mRoot = inflater.inflate(R.layout.fragment_task_list, container, false);
        initView();
        return mRoot;
    }

    private void initView() {
        elvTask = (ExpandableLayoutListView) mRoot.findViewById(R.id.elv_task);
        initTaskList();
    }

    private void initTaskList() {
        NetServiceManager.observe(NetServiceManager.getInstance().getTask()).subscribe(new Subscriber<TaskResponse>() {
            @Override
            public void onCompleted() {

            }

            @Override
            public void onError(Throwable e) {
                e.printStackTrace();
            }

            @Override
            public void onNext(TaskResponse taskResponse) {
                BaseAdapter mAdapter = null;
                mAdapter = new MyAdapter<TaskResponse.Task>(taskResponse.taskList, R.layout.unit_task_item) {
                    @Override
                    public void bindView(ViewHolder holder, final TaskResponse.Task obj) {
                        ((TextView) holder.getView(R.id.tv_name)).setText(obj.getName());
                        String rewardType="";
                        switch (obj.getRewardtype()){//0是流量1是话费2是现金3是红包
                            case "0":
                                rewardType="流量:"+obj.getReward()+"M";
                                break;
                            case "1":
                                rewardType="话费:"+obj.getReward()+"元";
                                break;
                            case "2":
                                rewardType="现金:"+obj.getReward()+"元";
                                break;
                            case "3":
                                rewardType="红包:"+obj.getReward()+"元";
                                break;

                        }
                        ((TextView)holder.getView(R.id.tv_reward)).setText(rewardType);
                        String type = "";
                        if (obj.getRewardtype() == "0") {
                            ((SimpleDraweeView)holder.getView(R.id.sdv_task)).setImageURI(new Uri.Builder().scheme("res").path(String.valueOf(R.drawable.wenjuan)).build());
                            type = "问卷";
                        } else {
                            ((SimpleDraweeView)holder.getView(R.id.sdv_task)).setImageURI(new Uri.Builder().scheme("res").path(String.valueOf(R.drawable.biaozhu)).build());
                            type = "数据标注";
                        }
                        ((TextView) holder.getView(R.id.tv_type)).setText(type);
                        ((TextView) holder.getView(R.id.tv_content)).setText(obj.getDescription());
                        //((TextView) holder.getView(R.id.tv_progress)).setText(Double.parseDouble(obj.getProgress())*100+"%");
                        holder.getView(R.id.tv_enter).setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View view) {
                                Intent intent = new Intent(getActivity(), QuestionActivity.class);
                                intent.putExtra("taskId", obj.getId());
                                intent.putExtra("name", obj.getName());
                                startActivity(intent);
                            }
                        });
                    }
                };
                elvTask.setAdapter(mAdapter);
            }
        });
    }

}
