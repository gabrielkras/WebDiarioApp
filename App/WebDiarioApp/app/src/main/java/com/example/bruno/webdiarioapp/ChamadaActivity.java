package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;

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
        listaMaterias.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent detalheMateria = new Intent(ChamadaActivity.this, MateriaDetalheActivity.class);
                TextView textViewNomeMateria = (TextView) view.findViewById(R.id.textViewNomeMateria);
                TextView textViewSiglaMateria = (TextView) view.findViewById(R.id.textViewSiglaMateria);
                Bundle bundle = new Bundle();
                bundle.putString("nomeMateria", textViewNomeMateria.getText().toString());
                bundle.putString("siglaMateria", textViewSiglaMateria.getText().toString());
                bundle.putString("descricao1", "Descrição 1");
                bundle.putString("descricao2", "Descrição 2");
                detalheMateria.putExtras(bundle);
                startActivity(detalheMateria);
            }
        });
    }

    private void instanciarObjetos() {
        retornoJSON = getIntent();
        listaMaterias = (ListView) findViewById(R.id.listViewChamada);
        nomeMateria = new String[]{"Materia1", "Materia2", "Materia3", "Materia4", "Materia5", "Materia6", "Materia7"};
        siglaMateria = new String[]{"mat1", "mat2", "mat3", "mat4", "mat5", "mat6", "mat7"};
        adapter = new ListaMateriasAdapter(this, R.layout.adapter_lista_materias, R.id.textViewNomeMateria, nomeMateria, siglaMateria);
    }
}
