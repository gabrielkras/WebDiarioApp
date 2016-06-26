package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class MenuAlunoActivity extends AppCompatActivity {

    Intent intent;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_aluno);
    }

    public void exibirMateriasAluno(View view) {
        intent = new Intent(this, ListaMateriasActivity.class);
        startActivity(intent);
    }

    public void exibirProfessores(View view) {
        intent = new Intent(this, ListaProfessoresActivity.class);
        startActivity(intent);
    }

    public void verPresencas(View view) {
        intent = new Intent(this, ListaMateriasActivity.class);
        startActivity(intent);
    }

    public void sairMenu(View view) {
        finish();
    }
}
