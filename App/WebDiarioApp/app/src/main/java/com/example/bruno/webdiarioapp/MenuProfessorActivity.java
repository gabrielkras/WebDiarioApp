package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class MenuProfessorActivity extends AppCompatActivity {

    Intent intent;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_professor);
    }

    public void exibirMaterias(View view) {
        intent = new Intent(this, ListaMateriasActivity.class);
        startActivity(intent);
    }

    public void fazerChamada(View view) {
        intent = new Intent(this, ChamadaActivity.class);
        startActivity(intent);
    }

    public void exibirAlunos(View view) {
        intent = new Intent(this, ListaAlunosActivity.class);
        startActivity(intent);
    }

    public void sairMenu(View view) {
        finish();
    }
}
