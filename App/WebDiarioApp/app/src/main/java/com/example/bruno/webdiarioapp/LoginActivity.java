package com.example.bruno.webdiarioapp;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutionException;

public class LoginActivity extends AppCompatActivity {

    Intent carregarMenu;
    Spinner spinnerEscolhaTipo;
    String escolhaDoSpinner;
    JSONTask jsonTask;
    String json;
    EditText editTextSenha;
    EditText editTextProntuario;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        adicionarNoSpinner();
        construindoJSON(editTextProntuario.getText().toString(), editTextSenha.getText().toString(), spinnerEscolhaTipo.toString());
    }

    private void instanciarObjetos() {
        editTextProntuario = (EditText) findViewById(R.id.editProntuarioUsuario);
        editTextSenha = (EditText) findViewById(R.id.editSenhaUsuario);
        spinnerEscolhaTipo = (Spinner) findViewById(R.id.spinnerEscolhaTipo);
        jsonTask = new JSONTask();
    }

    public void carregarMenu(View view) {
        // fazerConexao();
        if (escolhaDoSpinner.equals("Professor")) {
            carregarMenu = new Intent(this, MenuProfessorActivity.class);
        } else {
            carregarMenu = new Intent(this, MenuAlunoActivity.class);
        }

        startActivity(carregarMenu);
    }

    public void sair(View view) {
        this.finish();
        Intent sair = new Intent(Intent.ACTION_MAIN);
        sair.addCategory(Intent.CATEGORY_HOME);
        sair.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(sair);
    }

    private void adicionarNoSpinner() {
        List<String> itens = new ArrayList<>();
        itens.add("Professor");
        itens.add("Aluno");
        final ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_dropdown_item_1line, itens);
        spinnerEscolhaTipo.setAdapter(adapter);
        spinnerEscolhaTipo.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                escolhaDoSpinner = adapterView.getSelectedItem().toString();
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });
    }

    private void fazerConexao() {
        try {
            jsonTask.execute("http://192.168.0.102/app_dev.php/api/login").get();
        } catch (InterruptedException e) {
            Log.d("teste", e.toString());
        } catch (ExecutionException e) {
            Log.d("teste", e.toString());
        }
    }

    private void construindoJSON(String prontuario, String senha, String tipoLogin) {
        json = "" +
                "{" +
                "\"registry\":\"" + prontuario + "\"" +
                "\"password\":\"" + senha + "\"" +
                "\"login_type\":\"" + tipoLogin + "\"" +
                "}";
        jsonTask.setJson(json);
    }
}

class JSONTask extends AsyncTask<String, String, String> {

    HttpURLConnection conexao;
    String json;

    @Override
    protected String doInBackground(String... urls) {
        try {
            URL url = new URL(urls[0]);
            conexao = (HttpURLConnection) url.openConnection();
            conexao.setRequestProperty("Content-Type", "application/json");
            conexao.setDoOutput(true);
            // conexao.setRequestProperty("Authorization", "TOTEN!");
            conexao.setRequestMethod("POST");
            conexao.connect();

            OutputStream outputStream = conexao.getOutputStream();
            BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
            writer.write(json);
            writer.close();
            outputStream.close();

            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(conexao.getInputStream(), "UTF-8"));
            String retorno = null;
            StringBuilder stringBuilder = new StringBuilder();
            String resultado = null;

            while ((retorno = bufferedReader.readLine()) != null) {
                stringBuilder.append(retorno);
            }
            bufferedReader.close();
            resultado = stringBuilder.toString();
            Log.d("teste", "passou");
        } catch (MalformedURLException e) {
            Log.d("teste", e.toString());
        } catch (IOException e) {
            Log.d("teste", e.toString());
        }
        return null;
    }

    @Override
    protected void onPostExecute(String s) {
        super.onPostExecute(s);
    }

    public void setJson(String json) {
        this.json = json;
    }
}
