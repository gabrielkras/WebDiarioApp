package com.example.bruno.webdiarioapp;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

public class ListaAlunosActivity extends AppCompatActivity {

    ListView listaAlunos;
    String[] nomeAluno;
    String[] prontuario;
    ListaAlunoAdapter adapter;
    Intent retornoJSON;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lista_alunos);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        listaAlunos.setAdapter(adapter);
    }

    private void instanciarObjetos() {
        retornoJSON = getIntent();
        listaAlunos = (ListView) findViewById(R.id.listViewAlunos);
        nomeAluno = new String[]{"aluno1", "aluno1", "aluno1"};
        prontuario = new String[]{"alu1", "alu2", "alu3"};
        adapter = new ListaAlunoAdapter(this, R.layout.adapter_lista_alunos, R.id.textViewNomeAluno, nomeAluno, prontuario);
    }
}

class ListaAlunoAdapter extends ArrayAdapter<String> {

    Context context;
    TextView textViewNomeAluno;
    TextView textViewProntuario;
    String[] nomeAluno;
    String[] prontuario;

    public ListaAlunoAdapter(Context context, int resource, int textView, String[] nomeAluno, String[] prontuario) {
        super(context, resource, textView, nomeAluno);
        this.context = context;
        this.nomeAluno = nomeAluno;
        this.prontuario = prontuario;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View itemDaLista = inflater.inflate(R.layout.adapter_lista_alunos, parent, false);
        textViewNomeAluno = (TextView) itemDaLista.findViewById(R.id.textViewNomeAluno);
        textViewProntuario = (TextView) itemDaLista.findViewById(R.id.textViewProntuario);

        textViewNomeAluno.setText(nomeAluno[position]);
        textViewProntuario.setText(prontuario[position]);
        return itemDaLista;
    }
}
