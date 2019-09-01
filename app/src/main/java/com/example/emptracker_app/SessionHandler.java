package com.example.emptracker_app;
import android.content.SharedPreferences;
import android.content.Context;
import android.content.Intent;

import java.util.HashMap;

public class SessionHandler {

    SharedPreferences sharedPreferences;
    public SharedPreferences.Editor editor;
    public Context context;
    int PRIVATE_MODE = 0;

    private static final String PREF_NAME = "USERINFO";
    private static final String LOGIN = "IS_LOGIN";
    public static final String NAME = "NAME";

    public SessionHandler(Context context) {
        this.context = context;
        sharedPreferences = context.getSharedPreferences(PREF_NAME, PRIVATE_MODE);
        editor = sharedPreferences.edit();
    }

    public void createSession(String name){

        editor.putBoolean(LOGIN, true);
        editor.putString(NAME, name);
        editor.apply();
    }

    public boolean isLoggin(){
        return sharedPreferences.getBoolean(LOGIN, false);
    }

    public boolean checkLogin(){

        if (!this.isLoggin()){
            Intent i = new Intent(context, MainActivity.class);
            context.startActivity(i);
            //((HomeActivity) context).finish();
        }
        return true;
    }

    public HashMap<String, String> getUserDetail(){

        HashMap<String, String> user = new HashMap<>();
        user.put(NAME, sharedPreferences.getString(NAME, null));
        return user;
    }

    public void logout(){

        editor.clear();
        editor.commit();
        Intent i = new Intent(context, MainActivity.class);
        context.startActivity(i);
        //((HomeActivity) context).finish();

    }

}