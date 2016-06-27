package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.os.SystemClock;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;

import java.util.concurrent.TimeUnit;

public class SplashActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    protected void onResume() {
        super.onResume();
        Intent intent = new Intent(this, LoginActivity.class);
        SystemClock.sleep(TimeUnit.SECONDS.toMillis(1));
        startActivity(intent);
        finish();
    }
}
