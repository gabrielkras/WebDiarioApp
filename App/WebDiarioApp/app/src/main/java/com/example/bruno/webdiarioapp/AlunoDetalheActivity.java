package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;

public class AlunoDetalheActivity extends AppCompatActivity {

    Intent intent;
    TextView textViewNomeAluno;
    TextView textViewProntuario;
    TextView textViewDescricao1;
    TextView textViewDescricao2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_aluno_detalhe);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        setarValores();
    }

    private void instanciarObjetos() {
        intent = getIntent();
        textViewNomeAluno = (TextView) findViewById(R.id.textViewNomeAluno);
        textViewProntuario = (TextView) findViewById(R.id.textViewProntuario);
        textViewDescricao1 = (TextView) findViewById(R.id.textViewDescricao1);
        textViewDescricao2 = (TextView) findViewById(R.id.textViewDescricao2);
    }

    private void setarValores() {
        textViewNomeAluno.setText(intent.getStringExtra("nomeAluno"));
        textViewProntuario.setText(intent.getStringExtra("prontuario"));
        textViewDescricao1.setText(intent.getStringExtra("descricao1"));
        textViewDescricao2.setText(intent.getStringExtra("descricao2"));
    }
}
