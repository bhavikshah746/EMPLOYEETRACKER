package com.example.emptracker_app;

import android.content.Context;
import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.RelativeLayout;
import android.util.Log;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.StringReader;
import java.util.HashMap;
import java.util.Map;
import static android.support.constraint.solver.SolverVariable.Type.CONSTANT;


public class MainActivity extends AppCompatActivity {

    RelativeLayout rellayout1, rellayout2;
    private  EditText username, password;
    private Button btnLogin;
    SessionHandler sessionHandler;
    Context context;
    //MCrypt mCrypt;

    Handler handler = new Handler();
    Runnable runnable = new Runnable() {
        @Override
        public void run() {
            rellayout1.setVisibility(View.VISIBLE);
            rellayout2.setVisibility(View.VISIBLE);
        }
    };
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        sessionHandler = new SessionHandler(this);
        if(sessionHandler.checkLogin()){
            Log.i("info","Hi");
            Intent taskListActivity = new Intent(this, taskListActivity.class);
            startActivity(taskListActivity);
        }
        rellayout1 = (RelativeLayout) findViewById(R.id.rellayout1);
        rellayout2 = (RelativeLayout) findViewById(R.id.rellayout2);

        handler.postDelayed(runnable, 3000); //timeout for splash screen


        username = (EditText) findViewById(R.id.Edit_Userame);
        password = (EditText) findViewById(R.id.Edit_PassWord);
        btnLogin = (Button)findViewById(R.id.btnLogin);


    }

    @Override
    protected void onResume() {
        super.onResume();
        if (sessionHandler.checkLogin()) {

            Intent taskListActivity = new Intent(this, taskListActivity.class);
            startActivity(taskListActivity);
        }
    }

    public void fnLogIn(View view) throws Exception {

        final String userNm = username.getText().toString().trim();
        final String passWd = password.getText().toString().trim();

        //mCrypt = new MCrypt();
        /* Encrypt */
        //final String encryptedPassWd = MCrypt.bytesToHex( mCrypt.encrypt(passWd) );

        String logInURL = "http://192.168.56.1/website/AppOperation.php";


        StringRequest stringRequest = new StringRequest(Request.Method.POST, logInURL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {

                    JSONObject jsonObject = new JSONObject(response);

                    if(jsonObject.getBoolean("error")==false){
                        Intent intent = new Intent(getApplicationContext(),taskListActivity.class);
                        startActivity(intent);

                        sessionHandler.createSession(userNm);
                        Toast.makeText(getApplicationContext(), "Log in Successful", Toast.LENGTH_SHORT).show();


                    }else {

                        Toast.makeText(getApplicationContext(), jsonObject.getString("Msg"), Toast.LENGTH_LONG).show();
                    }


                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplicationContext(),error.getMessage(), Toast.LENGTH_LONG).show();
                Log.i("err",error.getMessage());
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("username", userNm);
                params.put("password", passWd);
                params.put("ActionType", "checkLogIn");
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
}
