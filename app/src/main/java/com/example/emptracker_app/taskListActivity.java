package com.example.emptracker_app;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

public class taskListActivity extends AppCompatActivity {

    SessionHandler sessionHandler;
    private Button taskBtn;
    Button[] buttons;
    String status;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_task_list);


        String logInURL = "http://192.168.56.1/website/AppOperation.php";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, logInURL, new Response.Listener<String>() {

            @Override
            public void onResponse(String response) {
                try {

                    JSONObject jsonObject = new JSONObject(response);

                    buttons = new Button[10];

                    if(jsonObject.getBoolean("error")==false){

                        JSONArray jsonArray = jsonObject.getJSONArray("TaskData");

                        for(int i=0; i<jsonArray.length();i++){

                            String buttonID = "assignedTask" + (i+1);
                            int resID = getResources().getIdentifier(buttonID, "id", getPackageName());
                            buttons[i] = ((Button) findViewById(resID));

                            JSONObject jsonObject1 = jsonArray.getJSONObject(i);
                            Iterator it = jsonObject1.keys();
                            String key = (String) it.next();
                            String value = jsonObject1.getString(key);
                            buttons[i].setText(value);
                        }
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
                params.put("username", "bhavikshah746");
                params.put("ActionType", "getTask");
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);



    }

    @Override
    public void onBackPressed() {

        sessionHandler = new SessionHandler(taskListActivity.this);

        if(sessionHandler.checkLogin()) {

            Intent intent = new Intent(Intent.ACTION_MAIN);
            intent.addCategory(Intent.CATEGORY_HOME);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
    }

    public void taskOne(View view){
        Intent startNewActivity = new Intent(this, taskDetails.class);
        startActivity(startNewActivity);
    }
}
