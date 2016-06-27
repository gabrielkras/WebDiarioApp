package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ListView;

public class ChamadaActivity extends AppCompatActivity {

    ListView listaMaterias;
    String[] nomeMateria;
    String[] siglaMateria;
    ListaMateriasAdapter adapter;
    Intent retornoJSON;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chamada);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        listaMaterias.setAdapter(adapter);
    }

    private void instanciarObjetos() {
        retornoJSON = getIntent();
        listaMaterias = (ListView) findViewById(R.id.listViewChamada);
        nomeMateria = new String[]{"materia1", "materia2", "materia3"};
        siglaMateria = new String[]{"mat1", "mat2", "mat3"};
        adapter = new ListaMateriasAdapter(this, R.layout.adapter_lista_materias, R.id.textViewNomeMateria, nomeMateria, siglaMateria);
    }
}
