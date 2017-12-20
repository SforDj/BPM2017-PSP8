package com.ist.cadillacpaltform.wifyapp.network.Enity;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by czh on 2017/12/15.
 */

public class TaskResponse {
    @SerializedName("Task")
    public ArrayList<Task> taskList;
    public class Task {
        private String id;
        private String name;
        private String description;
        private String progress;//进度，1封顶
        private String type;//0问卷，1数据标注
        private String rewardtype;//0是流量1是话费2是现金3是红包
        private String reward;

        public String getId() {
            return id;
        }

        public void setId(String id) {
            this.id = id;
        }

        public String getName() {
            return name;
        }

        public void setName(String name) {
            this.name = name;
        }

        public String getDescription() {
            return description;
        }

        public void setDescription(String description) {
            this.description = description;
        }

        public String getProgress() {
            return progress;
        }

        public void setProgress(String progress) {
            this.progress = progress;
        }

        public String getType() {
            return type;
        }

        public void setType(String type) {
            this.type = type;
        }

        public String getRewardtype() {
            return rewardtype;
        }

        public void setRewardtype(String rewardtype) {
            this.rewardtype = rewardtype;
        }

        public String getReward() {
            return reward;
        }

        public void setReward(String reward) {
            this.reward = reward;
        }
    }
}
