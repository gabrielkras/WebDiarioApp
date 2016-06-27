package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;

public class ProfessorDetalheActivity extends AppCompatActivity {

    Intent intent;
    TextView textViewNomeProfessor;
    TextView textViewProntuario;
    TextView textViewDescricao1;
    TextView textViewDescricao2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_professor_detalhe);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        setarValores();
    }

    private void instanciarObjetos() {
        intent = getIntent();
        textViewNomeProfessor = (TextView) findViewById(R.id.textViewNomeProfessor);
        textViewProntuario = (TextView) findViewById(R.id.textViewProntuario);
        textViewDescricao1 = (TextView) findViewById(R.id.textViewDescricao1);
        textViewDescricao2 = (TextView) findViewById(R.id.textViewDescricao2);
    }

    private void setarValores() {
        textViewNomeProfessor.setText(intent.getStringExtra("nomeProfessor"));
        textViewProntuario.setText(intent.getStringExtra("prontuario"));
        textViewDescricao1.setText(intent.getStringExtra("descricao1"));
        textViewDescricao2.setText(intent.getStringExtra("descricao2"));
    }
}
