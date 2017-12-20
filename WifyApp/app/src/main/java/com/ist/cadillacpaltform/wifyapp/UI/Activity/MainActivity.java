package com.ist.cadillacpaltform.wifyapp.UI.Activity;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.FragmentActivity;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;

import com.ist.cadillacpaltform.wifyapp.R;
import com.ist.cadillacpaltform.wifyapp.UI.Fragment.DiscoverFragment;
import com.ist.cadillacpaltform.wifyapp.UI.Fragment.LoginFragment;
import com.ist.cadillacpaltform.wifyapp.UI.Fragment.PersonFragment;
import com.ist.cadillacpaltform.wifyapp.UI.Fragment.TaskListFragment;

public class MainActivity extends FragmentActivity {

    private Context mContext;
    private BottomNavigationView bottomNavigationView;
    private TaskListFragment taskListFragment;
    private LoginFragment loginFragment;
    private PersonFragment personFragment;
    private DiscoverFragment discoverFragment;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        bottomNavigationView = (BottomNavigationView) findViewById(R.id.bottom_navigation);
        taskListFragment = new TaskListFragment();
        loginFragment = new LoginFragment();
        discoverFragment = new DiscoverFragment();
        personFragment = new PersonFragment();
        getFragmentManager().beginTransaction().add(R.id.frament_content, loginFragment).commit();
        bottomNavigationView.setOnNavigationItemSelectedListener(
                new BottomNavigationView.OnNavigationItemSelectedListener() {
                    @Override
                    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                        switch (item.getItemId()) {
                            case R.id.item_wifi:
                                //// TODO: 2017/12/18 replace add hide and show
                                getFragmentManager().beginTransaction().replace(R.id.frament_content, loginFragment).commit();
                                break;
                            case R.id.item_task:
                                getFragmentManager().beginTransaction().replace(R.id.frament_content, taskListFragment).commit();
                                break;
                            case R.id.item_discover:
                                getFragmentManager().beginTransaction().replace(R.id.frament_content, discoverFragment).commit();
                                break;
                            case R.id.item_me:
                                getFragmentManager().beginTransaction().replace(R.id.frament_content, personFragment).commit();
                                break;
                        }
                        item.setChecked(true);
                        return false;
                    }
                });

    }

}
