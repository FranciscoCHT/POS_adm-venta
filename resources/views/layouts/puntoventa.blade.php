<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/ventacss.css')}}" type="text/css">
    <title>Venta</title>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Bootstrap select  complemento   -->
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">    
    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <style>

        
    .precio_total2 {
        width: 100%;            
        padding: 4px 15px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid #E7AF68;
        border-radius: 4px;
        color: #303038;
        font-size: large;
    }


    .footer_pos {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
        border-top: 4px solid #E7AF68;
        background-color: e19f4b;
        
        
        
        
    }
    .texto_th{
        color: #fb9b36;
        font-size: large;
        
    }
    .texto_titulo{
        color: #303038;
        height: 20px;
        margin: 8px 0;
        font-size: x-large;
    }
    .boton_paga {
        width: 100%;
        height: 45px;
        padding: 7px 15px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid #E7AF68;
        border-radius: 4px;
        font-size: large;
        background-color: #d89a4c;
        color: #07080B;
    }

    .codigo_producto {
        width: 100%;
        padding: 7px 15px;
        box-sizing: border-box;
        border: 0px solid #303038;
        border-radius: 4px;
        font-size: xx-large;
    }
    .codigo_producto2 {
        width: 100%;
        padding: 7px 15px;
        border-radius: 4px;
        
    }

    div.borde_titulo {
        border: 2px solid #e19f4b;
        border-radius: 8px;
        height: 50px;
        width: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        }
    .dato_empresa {
        width: 100%;
        padding: 7px -30px;
        margin: 16px 0;
        box-sizing: border-box;
        border: 0px solid #FBFBFB;
        color: #15242C;
        border-radius: 4px;
        text-align: left;
        float: center;
        font-weight: bold;
    }
    body {
        background: #f1f8fa;
    }

    .imagen {
        
        margin: 0px 0px 15px 15px;
        height: auto; 
        width: 130px; 
        padding: 20px 0px;
    }


    .table-fixed thead,
    .table-fixed tfoot{
    width: 100%;
    
    }

   


    .my-custom-scrollbar {
    position: relative;
    height: 310px;
    overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    hr {
    border: 1px solid red; 
    height: 2px; width: 70%;
    }

    .table-fixed thead,
    .table-fixed tbody,
    .table-fixed tfoot,
    .table-fixed tr,
    .table-fixed td,
    .table-fixed th {
    display: block;
    
    }

    .table-fixed td,
    .table-fixed thead > tr> th,
    .table-fixed tfoot > tr> td{
    float: left;
    border-bottom-width: 0;
    color: #434141;
    }

    .table-fixed td,
    .table-fixed thead > th{
    float: left;
    border-bottom-width: 0;
    color: #000000;
    font-weight: bold;
    }

    .header {
    overflow: hidden;
    height: 85px;
    padding: 0px 100px;
    border-bottom: 4px solid #E7AF68;
    background-color: e19f4b;
    }

    .header a {
    float: left;
    color: black;
    text-align: center;
    padding: 12px;
    text-decoration: none;
    font-size: 18px; 
    line-height: 25px;
    border-radius: 4px;

    }

    .header a.logo {
    font-size: 25px;
    font-weight: bold;
    }

    .header a:hover {
    background-color: #ddd;
    color: black;

    }

    .header a.active {
    background-color: dodgerblue;
    color: white;
    }

    .header-center {
    float: center;
    }
    .header-right {
    float: right;
    }
    @media screen and (max-width: 500px) {
        .header a {
        float: none;
        display: block;
        text-align: left;
        }

        .header-right {
        float: none;
        }
    }

    .button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 20px 4px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
    }

    .button1 {
    background-color: white; 
    color: black; 
    border: 2px solid #e19f4b;
    }

    .button1:hover {
    background-color: #e19f4b;
    color: white;
    }

    .button2 {
    background-color: white; 
    color: black; 
    border: 2px solid #008CBA;
    }

    .button2:hover {
    background-color: #008CBA;
    color: white;
    }




    
    </style>
</head>
<body >
        @yield('contenido')    
</body>

</html>