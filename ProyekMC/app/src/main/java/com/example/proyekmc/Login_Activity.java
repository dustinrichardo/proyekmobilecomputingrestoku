package com.example.proyekmc;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Login_Activity extends AppCompatActivity {


    Button login;
    TextView pindahRegister;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        login = findViewById(R.id.button_login);
        pindahRegister = findViewById(R.id.textView_disiniLogin);

        pindahRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent mainIntent = new Intent(Login_Activity.this,MainActivity.class);
                startActivity(mainIntent);
                finish();
            }
        });




    }
}