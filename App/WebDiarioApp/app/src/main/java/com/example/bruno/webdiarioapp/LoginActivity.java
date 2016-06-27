package com.example.bruno.webdiarioapp;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
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
    String JSONConsultaBanco;
    String retornoJSON;
    EditText editTextSenha;
    EditText editTextProntuario;
    JSONArray jsonArray;
    ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        instanciarObjetos();
    }

    @Override
    protected void onResume() {
        super.onResume();
        jsonTask = new JSONTask();
        progressDialog = new ProgressDialog(this);
        progressDialog.setTitle("Carregando");
        progressDialog.setMessage("Processando JSON");
        progressDialog.setProgressStyle(progressDialog.STYLE_SPINNER);
        progressDialog.setIndeterminate(true);
    }

    private void instanciarObjetos() {
        editTextProntuario = (EditText) findViewById(R.id.editProntuarioUsuario);
        editTextSenha = (EditText) findViewById(R.id.editSenhaUsuario);
        spinnerEscolhaTipo = (Spinner) findViewById(R.id.spinnerEscolhaTipo);
        adicionarNoSpinner();
    }

    public void carregarMenu(View view) {
        progressDialog.show();
        construindoJSON(editTextProntuario.getText().toString(), editTextSenha.getText().toString(), spinnerEscolhaTipo.toString());
        jsonTask.setContext(LoginActivity.this);
        jsonTask.setDialog(progressDialog);
        fazerConexao();
        testandoJSON();
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
            // jsonTask.execute("http://192.168.0.102/app.php/api/login").get();
            retornoJSON = jsonTask.execute("http://jsonplaceholder.typicode.com/posts").get();
            jsonArray = new JSONArray(retornoJSON);
        } catch (InterruptedException e) {
            Log.d("erro", e.toString());
        } catch (ExecutionException e) {
            Log.d("erro", e.toString());
        } catch (JSONException e) {
            Log.d("erro", e.toString());
        }
    }

    private void testandoJSON() {
        for (int i = 0; i < jsonArray.length(); i++) {
            try {
                JSONObject jsonObject = jsonArray.getJSONObject(i);
                Log.d("teste", jsonObject.getString("userId"));
            } catch (JSONException e) {
                Log.d("erro", e.toString());
            }
        }
    }

    private void construindoJSON(String prontuario, String senha, String tipoLogin) {
        JSONConsultaBanco = "" +
                "{" +
                "\"registry\":\"" + prontuario + "\"" +
                "\"password\":\"" + senha + "\"" +
                "\"login_type\":\"" + tipoLogin + "\"" +
                "}";
        jsonTask.setJson(JSONConsultaBanco);
    }
}

class JSONTask extends AsyncTask<String, String, String> {

    HttpURLConnection conexao;
    String JSONConsultaBanco;
    String retornoJson;
    Context context;
    ProgressDialog progressDialog;

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected String doInBackground(String... urls) {
        try {
            URL url = new URL(urls[0]);
            conexao = (HttpURLConnection) url.openConnection();
            conexao.setRequestProperty("Content-Type", "application/json");
            conexao.setRequestProperty("Accept", "application/json");
            conexao.setDoOutput(false);
            conexao.setRequestMethod("GET");
            conexao.connect();

            /*OutputStream outputStream = conexao.getOutputStream();
            BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
            writer.write(json);
            writer.flush();
            writer.close();
            outputStream.close();*/

            InputStream inputStream = conexao.getInputStream();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
            StringBuffer stringBuffer = new StringBuffer();
            String cadaLinha = "";


            while ((cadaLinha = bufferedReader.readLine()) != null) {
                stringBuffer.append(cadaLinha);
            }

            retornoJson = stringBuffer.toString();
            conexao.disconnect();
            return retornoJson;
        } catch (MalformedURLException e) {
            Log.d("teste", e.toString());
        } catch (IOException e) {
            Log.d("teste", e.toString());
        }
        conexao.disconnect();
        return null;
    }

    @Override
    protected void onPostExecute(String s) {
        super.onPostExecute(s);
        progressDialog.dismiss();
    }

    public void setJson(String JSONConsultaBanco) {
        this.JSONConsultaBanco = JSONConsultaBanco;
    }

    public void setContext(Context context) {
        this.context = context;
    }

    public void setDialog(ProgressDialog progressDialog) {
        this.progressDialog = progressDialog;
    }
}
