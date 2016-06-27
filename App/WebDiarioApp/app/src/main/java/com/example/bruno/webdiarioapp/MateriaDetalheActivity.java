package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;

public class MateriaDetalheActivity extends AppCompatActivity {

    Intent intent;
    TextView textViewNomeMateria;
    TextView textViewSiglaMateria;
    TextView textViewDescricao1;
    TextView textViewDescricao2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_materia_detalhe);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        setarValores();
    }

    private void instanciarObjetos() {
        intent = getIntent();
        textViewNomeMateria = (TextView) findViewById(R.id.textViewNomeMateria);
        textViewSiglaMateria = (TextView) findViewById(R.id.textViewSiglaMateria);
        textViewDescricao1 = (TextView) findViewById(R.id.textViewDescricao1);
        textViewDescricao2 = (TextView) findViewById(R.id.textViewDescricao2);
    }

    private void setarValores() {
        textViewNomeMateria.setText(intent.getStringExtra("nomeMateria"));
        textViewSiglaMateria.setText(intent.getStringExtra("siglaMateria"));
        textViewDescricao1.setText(intent.getStringExtra("descricao1"));
        textViewDescricao2.setText(intent.getStringExtra("descricao2"));
    }
}
