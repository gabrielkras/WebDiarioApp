package com.example.bruno.webdiarioapp;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

public class ListaMateriasActivity extends AppCompatActivity {

    ListView listaMaterias;
    String[] nomeMateria;
    String[] siglaMateria;
    ListaMateriasAdapter adapter;
    Intent retornoJSON;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lista_materias);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        listaMaterias.setAdapter(adapter);
        listaMaterias.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent detalheMateria = new Intent(ListaMateriasActivity.this, MateriaDetalheActivity.class);
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
        listaMaterias = (ListView) findViewById(R.id.listViewMaterias);
        nomeMateria = new String[]{"materia1", "materia2", "materia3"};
        siglaMateria = new String[]{"mat1", "mat2", "mat3"};
        adapter = new ListaMateriasAdapter(this, R.layout.adapter_lista_materias, R.id.textViewNomeMateria, nomeMateria, siglaMateria);
    }
}

class ListaMateriasAdapter extends ArrayAdapter<String> {

    Context context;
    TextView textViewNomeMateria;
    TextView textViewSiglaMateria;
    String[] nomeMateria;
    String[] siglaMateria;

    public ListaMateriasAdapter(Context context, int resource, int textView, String[] nomeMateria, String[] siglaMateria) {
        super(context, resource, textView, nomeMateria);
        this.context = context;
        this.nomeMateria = nomeMateria;
        this.siglaMateria = siglaMateria;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View itemDaLista = inflater.inflate(R.layout.adapter_lista_materias, parent, false);
        textViewNomeMateria = (TextView) itemDaLista.findViewById(R.id.textViewNomeMateria);
        textViewSiglaMateria = (TextView) itemDaLista.findViewById(R.id.textViewSiglaMateria);

        textViewNomeMateria.setText(nomeMateria[position]);
        textViewSiglaMateria.setText(siglaMateria[position]);
        return itemDaLista;
    }
}
