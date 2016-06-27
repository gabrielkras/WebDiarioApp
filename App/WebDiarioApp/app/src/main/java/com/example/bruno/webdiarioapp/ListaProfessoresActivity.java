package com.example.bruno.webdiarioapp;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

public class ListaProfessoresActivity extends AppCompatActivity {

    ListView listaProfessores;
    String[] nomeProfessor;
    String[] prontuario;
    ListaProfessorAdapter adapter;
    Intent retornoJSON;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lista_professores);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        listaProfessores.setAdapter(adapter);
        listaProfessores.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent detalheProfessor = new Intent(ListaProfessoresActivity.this, ProfessorDetalheActivity.class);
                TextView textViewNomeProfessor = (TextView) view.findViewById(R.id.textViewNomeProfessor);
                TextView textViewProntuario = (TextView) view.findViewById(R.id.textViewProntuario);
                Bundle bundle = new Bundle();
                bundle.putString("nomeProfessor", textViewNomeProfessor.getText().toString());
                bundle.putString("prontuario", textViewProntuario.getText().toString());
                bundle.putString("descricao1", "Descrição 1");
                bundle.putString("descricao2", "Descrição 2");
                detalheProfessor.putExtras(bundle);
                startActivity(detalheProfessor);
                Log.d("teste", "clicou");
            }
        });
    }

    private void instanciarObjetos() {
        retornoJSON = getIntent();
        listaProfessores = (ListView) findViewById(R.id.listViewProfessores);
        nomeProfessor = new String[]{"professor1", "professor2", "professor3"};
        prontuario = new String[]{"prof1", "prof2", "prof3"};
        adapter = new ListaProfessorAdapter(this, R.layout.adapter_lista_professores, R.id.textViewNomeProfessor, nomeProfessor, prontuario);
    }
}

class ListaProfessorAdapter extends ArrayAdapter<String> {

    Context context;
    TextView textViewNomeProfessor;
    TextView textViewProntuario;
    String[] nomeProfessor;
    String[] prontuario;

    public ListaProfessorAdapter(Context context, int resource, int textView, String[] nomeProfessor, String[] prontuario) {
        super(context, resource, textView, nomeProfessor);
        this.context = context;
        this.nomeProfessor = nomeProfessor;
        this.prontuario = prontuario;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View itemDaLista = inflater.inflate(R.layout.adapter_lista_professores, parent, false);
        textViewNomeProfessor = (TextView) itemDaLista.findViewById(R.id.textViewNomeProfessor);
        textViewProntuario = (TextView) itemDaLista.findViewById(R.id.textViewProntuario);

        textViewNomeProfessor.setText(nomeProfessor[position]);
        textViewProntuario.setText(prontuario[position]);
        return itemDaLista;
    }
}
