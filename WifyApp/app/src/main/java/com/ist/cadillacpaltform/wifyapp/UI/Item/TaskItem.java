package com.ist.cadillacpaltform.wifyapp.UI.Item;

/**
 * Created by czh on 2017/12/12.
 */

public class TaskItem {
    private String name;
    private String reword;
    private String progress;

    public TaskItem() {
    }

    public TaskItem(String name, String reword, String progress) {
        this.name = name;
        this.reword = reword;
        this.progress = progress;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getReword() {
        return reword;
    }

    public void setReword(String reword) {
        this.reword = reword;
    }

    public String getProgress() {
        return progress;
    }

    public void setProgress(String progress) {
        this.progress = progress;
    }


}
