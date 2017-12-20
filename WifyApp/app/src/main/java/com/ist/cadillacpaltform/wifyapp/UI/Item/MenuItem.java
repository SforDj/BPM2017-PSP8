package com.ist.cadillacpaltform.wifyapp.UI.Item;

/**
 * Created by czh on 2017/12/10.
 */

public class MenuItem {
    private int id;
    private String name;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }


    public MenuItem() {
    }

    public MenuItem(int iId, String iName) {
        this.id = iId;
        this.name = iName;
    }


}
