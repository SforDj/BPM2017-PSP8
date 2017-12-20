package com.ist.cadillacpaltform.wifyapp.network.Enity;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by czh on 2017/12/19.
 */

public class QuestionResponse {
    @SerializedName("Question")
    public ArrayList<Question> questionArrayList;
    public class Question{
        private String id;
        private String taskid;
        private String questionid;
        private String content;
        private String a;
        private String b;
        private String c;
        private String d;
        private String acount;
        private String bcount;
        private String ccount;
        private String dcount;

        public String getId() {
            return id;
        }

        public void setId(String id) {
            this.id = id;
        }

        public String getTaskid() {
            return taskid;
        }

        public void setTaskid(String taskid) {
            this.taskid = taskid;
        }

        public String getQuestionid() {
            return questionid;
        }

        public void setQuestionid(String questionid) {
            this.questionid = questionid;
        }

        public String getContent() {
            return content;
        }

        public void setContent(String content) {
            this.content = content;
        }

        public String getA() {
            return a;
        }

        public void setA(String a) {
            this.a = a;
        }

        public String getB() {
            return b;
        }

        public void setB(String b) {
            this.b = b;
        }

        public String getC() {
            return c;
        }

        public void setC(String c) {
            this.c = c;
        }

        public String getD() {
            return d;
        }

        public void setD(String d) {
            this.d = d;
        }

        public String getAcount() {
            return acount;
        }

        public void setAcount(String acount) {
            this.acount = acount;
        }

        public String getBcount() {
            return bcount;
        }

        public void setBcount(String bcount) {
            this.bcount = bcount;
        }

        public String getCcount() {
            return ccount;
        }

        public void setCcount(String ccount) {
            this.ccount = ccount;
        }

        public String getDcount() {
            return dcount;
        }

        public void setDcount(String dcount) {
            this.dcount = dcount;
        }
    }
}

