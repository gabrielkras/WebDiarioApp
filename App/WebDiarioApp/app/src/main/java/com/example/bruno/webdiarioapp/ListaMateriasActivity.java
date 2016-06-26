package com.example.bruno.webdiarioapp;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.List;

public class ListaMateriasActivity extends AppCompatActivity {

    ListView listaMaterias;
    List<String> materias;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lista_materias);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        ArrayAdapter<String> adapterListaMateria = new ArrayAdapter<>(this, R.layout.adapter_lista_materias, materias);
        ArrayAdapter<String> adapterListaMateria2 = new ArrayAdapter<>(this, android.R.layout.simple_list_item_2, materias);
    }

    private void instanciarObjetos() {
        listaMaterias = (ListView) findViewById(R.id.listViewMaterias);
        materias = new ArrayList<>();
        materias.add("materia1");
        materias.add("materia2");
        materias.add("materia3");
    }
}
