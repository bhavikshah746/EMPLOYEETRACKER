<?php

return[
    //users
    'users_saving'=>[
        'first_name'=>'required',
        'email'=>'required|email|unique:users',
        'username'=>'required|unique:users',
        'role'=>'required',
        'password'=>'required|confirmed',
        'phone'=>'numeric',
        'permissions'=>'array',
        //'employ_id'=>'required',
    ],
    'users_edit'=>[
        'first_name'=>'required',
        'role'=>'required',
        'phone'=>'numeric',
        'permissions'=>'array',
        'password'=>'confirmed',
        //'employ_id'=>'required',
    ],
    'salesperson_create'=>[
        'first_name'=>'required',
        'email'=>'required|email|unique:users',
        'username'=>'required|unique:users',
        'role'=>'required',
        'password'=>'required|confirmed',
        'phone'=>'numeric',
        'area_id'=>'array',
        'salesperson_id'=>'array',
        'permissions'=>'array',
        'type'=>'numeric',
        //'employ_id'=>'required',
    ],
    'salesperson_edit'=>[
        'first_name'=>'required',
        'role'=>'required',
        'area_id'=>'array',
        'salesperson_id'=>'array',
        'phone'=>'numeric',
        'type'=>'numeric',
        'permissions'=>'array',
        'password'=>'confirmed',
        //'employ_id'=>'required',
    ],

    'profile'=>[
        
    ],

    'change-password'=>[
        'token'=>'required',
        'password'=>'required'
    ],

    //areas
    'areas'=>[
        'name'=>'required',
        'state'=>'required',
        'city'=>'required',
        'country'=>'required'
    ],

    'categories'=>[
        'name'=>'required'
    ],

    //companies
    'companies'=>[
        'name'=>'required',
        'area_id'=>'required',
        'consunt_name'=>'required',
        'client_name'=>'required',
        'mobile'=>'required',
        'landline'=>'required',
        'address'=>'max:500',
        'file'=>'image',
        'client_type'=>'required|numeric'
    ],


    //tasks
    'tasks'=>[
        'title'=>'required',
        'company_id'=>'required|numeric',
        'date_time'=>'required',
        'disc'=>'required'
    ],
    'tasks_responce_api'=>[
        'token'=>'required',
        'responce_status'=>'required|boolean',
        'next_visit'=>'required'
    ],


    //attendences
    'attendence'=>[
        'token'=>'required',
        'type'=>'required|numeric'
    ],
    'attendence_end_day'=>[
        //'note'=>'required'
    ],
    'attendence_edit'=>[
        'token'=>'required',
        'end_time'=>'required',
        //'note'=>'required'
    ],

    //products
    'products'=>[
        /*'name'=>'required',
        'pricePerUnit'=>'required|numeric',
        'code'=>'required',
        'image'=>'array',
        'image_path'=>'array',
        'paper_id'=>'numeric',
        'design_id'=>'numeric'*/
    ],
    'papers'=>[
        'name'=>'required|unique:papers'
    ],
    'designs'=>[
        'name'=>'required|unique:designs'
    ],

    //expances
    'expance_api'=>[
        'subject'=>'required',
        'token'=>'required',
        'price'=>'required'
    ],

    'orders'=>[
        'token'=>'required',
        'client_id'=>'required',
        //'date'=>'required',
        //'product_category'=>'required|array',
        //'paper_id'=>'required|array',
        //'design_id'=>'required|array',
        //'quantity'=>'required|array',
    ],
    'current_location'=>[
        'token'=>'required',
        'longitude'=>'required',
        'latitude'=>'required'
    ]

];