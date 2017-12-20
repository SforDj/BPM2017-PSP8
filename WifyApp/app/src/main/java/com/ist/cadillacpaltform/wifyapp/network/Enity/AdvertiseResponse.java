package com.ist.cadillacpaltform.wifyapp.network.Enity;

import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by czh on 2017/12/13.
 */

public class AdvertiseResponse {
    @SerializedName("Advertise")
    public List<Advertise> advertises;
    public class Advertise {
        private String id;
        private String name;
        private String picurl;

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

        public String getPicurl() {
            return picurl;
        }

        public void setPicurl(String picurl) {
            this.picurl = picurl;
        }
    }
}
