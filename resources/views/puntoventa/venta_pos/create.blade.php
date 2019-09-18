@extends('layouts.puntoventa')

@section('contenido')

<script type="text/javascript" src="{{asset("js/rsvp-3.1.0.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/sha-256.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/qz-tray.js")}}"></script>

<div class="header">
    <div class="header-right">
    <!--<button  class="button button2 ">Gestionar</button>-->
    @if(Auth::user()->rol == 'Administrador')
        <a href="{{url('inicio')}}" class="button btn-default button2">Gestionar</a>
    @endif

    <!--<button class="button button1 ">Cerrar Sesión</button>-->
    <a href="{{url('logout')}}" class="button btn-default button2">Salir</a>
    </div>
    <div class="col-lg-6 col-sm-2 col-md-2 col-xs-12 dato_empresa">
        <div class="borde_titulo">
            <b>Local:</b> {{ $datos_empresa->nombre}} / Dirección: {{$datos_empresa->direccion}}
        </div>
    </div>
    <div class="header-center">
        <img src="{{asset('logos/vendeya_pos_final_2.png')}}" class="imagen">
    </div>
</div>


<div class="row encabezado_pos">
    <div class="container">
        <!-- MI MODAL -->
        <div id="mi-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- CONTENIDO DEL MODAL-->
                <div class="modal-content">
                    <form>
                    <div class="modal-body">
                        <h4>Ingrese Precio</h4>
                        <div class="form-group">
                            <label >VALOR PRODUCTO: </label>
                            <input type="text"  class="form-control"  name="precio_2" id="precio_2">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="agregar-2"data-dismiss="modal">Agregar</button>
                    </div>
                    </form>
                </div>
                <!-- TERMINA CONTENIDO DEL MODAL-->
            </div>
        </div>
        <!-- TERMINA EL MODAL --->
        <form id="formulario_venta" method="POST">
            @csrf
            <br>
            <div class="row">
            <div class="col-lg-6 col-sm-5 col-md-6 col-xs-12">
                    <div class="">
                        <label class="texto_titulo" >CÓDIGO DE BARRA: </label>
                        <select name="producto_id"  class="form-control selectpicker input_lector "  data-size='7' autofocus title="Buscar Producto.." id="producto_id" data-live-search="true">
                            @foreach($productos as $producto)
                            <option value="{{$producto->id}}_{{$producto->stock}}_{{$producto->precio}}_{{$producto->nombre}}">{{$producto->producto}}</option>
                            @endforeach
					    </select>
                    </div>
                </div>
            </div><br>
            <div class="panel panel-default">
                <div class="col-lg-12  col-xs-12 table-wrapper-scroll-y my-custom-scrollbar panel-body" >
                    <table id="detalle_venta" class="table  table-hover " cellspacing="0"  >
                        <thead>
                            <tr>
                                <th class="col-xs-2 texto_th">Opciones</th>
                                <th class="col-xs-2 texto_th">Producto</th>
                                <th class="col-xs-2 texto_th">Cantidad</th>
                                <th class="col-xs-2 texto_th">Precio Unitario</th>
                                <th class="col-xs-2 texto_th">Descuento</th>
                                <th class="col-xs-2 texto_th">SubTotal</th>
                            </tr>
                        </thead>
                        <tfoot>
                        <input type="hidden" class="form-control" id="precio_total" name="precio_total"></td>
                        </tfoot>
                        </table>
                    </div>
            </div>
            <div class="row">
                <div class=" col-xs-12 footer_pos">
                    <div class="container">
                            <div class="col-lg-2 col-sm-5 col-md-5 ">
                                <label  style="color:#303038 ">TOTAL:</label>
                                <input type="text" disabled class="precio_total2 col-xs-8" id="precio_total2" name="precio_total2">
                            </div>
                            <div class="col-lg-3 col-sm-5 col-md-5 " >
                                <label  style="color:#303038 ">PAGA CON $:</label>
                                <input type="text"  class="precio_total2 col-xs-8" id="pago" name="pago">
                            </div>
                            <div class="col-lg-4 col-sm-5 col-md-5">
                            <label style="color:#303038 "></label>
                            <button type="submit" id="pagar" class="btn boton_paga btn-default">Pagar</button>
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script >
    $(document).ready(function(){
        $('#formulario_venta').submit(function(e){
            e.preventDefault();
            $.ajax({
                url:window.location.origin + '/venta/ok',
                type:'post',
                data:$('#formulario_venta').serialize(),
            }).done((data) => {
                 console.log(data);

                /// Authentication setup ///
                qz.security.setCertificatePromise(function(resolve, reject) {
                    //Preferred method - from server
                    $.ajax("../assets/signing/certificado-digital.txt").then(resolve, reject);

                    //Alternate method 1 - anonymous
                    //        resolve();

                    //Alternate method 2 - direct
                    //resolve("-----BEGIN CERTIFICATE-----\n" +
                    //        "MIIDqTCCApGgAwIBAgIUeZiIaSLm8hWemZP5GaY1ga34KtswDQYJKoZIhvcNAQEL\n" +
                    //        "BQAwYzELMAkGA1UEBhMCQ0wxDjAMBgNVBAgMBUNoaWxlMQ4wDAYDVQQHDAVBcmlj\n" +
                    //        "YTEPMA0GA1UECgwGV2FsaWV4MQswCQYDVQQLDAJJVDEWMBQGA1UEAwwNd3d3Lndh\n" +
                    //        "bGlleC5jbDAgFw0xOTA5MTcwNTEyMTlaGA8yMDUxMDMxMjA1MTIxOVowYzELMAkG\n" +
                    //        "A1UEBhMCQ0wxDjAMBgNVBAgMBUNoaWxlMQ4wDAYDVQQHDAVBcmljYTEPMA0GA1UE\n" +
                    //        "CgwGV2FsaWV4MQswCQYDVQQLDAJJVDEWMBQGA1UEAwwNd3d3LndhbGlleC5jbDCC\n" +
                    //        "ASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMAHryhRuzPAttuEN6gop079\n" +
                    //        "x3/dImUyHnwFufhi6g0hxrb2g7lvW4bN3Ff/DG0bHUmBUkDORW8rZ60hJ+iWoVig\n" +
                    //        "SQyHxEhdw3wrhhsNxbOFgojAnRgA2Cyvvnf6OvzEkztJzgE/80TSzOtBz6Cv48vU\n" +
                    //        "zV7BRwhgK6g1gtXvJxtOf70fLq/dthuvsyh98NJlN1GWrtLydp8R894C7Z/76roo\n" +
                    //        "SiMvxbXfT5VBPFEjJoGNoFxd75hTfloAOiRKJWlPOdUG4KBeoR4RrWob6bhob/N9\n" +
                    //        "mJGNk03X53OjX+krbsChbonJwgBxbVIk79ZwuNbKzxy4EjZ+NmvmF+lANSGxbbcC\n" +
                    //        "AwEAAaNTMFEwHQYDVR0OBBYEFEa6AzCaZypgfHta/glL7aO4zdh3MB8GA1UdIwQY\n" +
                    //        "MBaAFEa6AzCaZypgfHta/glL7aO4zdh3MA8GA1UdEwEB/wQFMAMBAf8wDQYJKoZI\n" +
                    //        "hvcNAQELBQADggEBAFO3SfPBTD7sCImd8dBliVzxrb1WtK47r5x7ZKeOTgjqpgYJ\n" +
                    //        "U55Lyy6wyEWeGNNjOJokrivrlKj/RS+5gv8rjbRACnMT3CRrfS5E9Bd9LDfEt86u\n" +
                    //        "aFwN0Hb09NaIoqtx78v/YtPz8zKr9yNlppeo59HXWoL5qJcIQtqvu5e45rMkHbFx\n" +
                    //        "n/5x2IwXX+g/FhRl3SvKD5YWIOHnpfCqXRtonfkzzZQ81yjspjJCoLvcmFhwpayq\n" +
                    //        "wJ9ZqbKfoPQ3VbyRMzJ53dCDEt4t55GP2zcLU46WxDeEdBLm2FZXTNIA2oDV++eK\n" +
                    //        "EpHPFzdc93XXkc+zGrbTSsm4warZNd3EQY1ND4E=\n" +
                    //        "-----END CERTIFICATE-----\n");
                });

                qz.websocket.connect().then(function() {
                    return qz.printers.find("POS");              // Pass the printer name into the next Promise
                }).then(function(printer) {
                    var config = qz.configs.create(printer);       // Create a default config for the found printer
                    var datos = [data];   // Raw
                    return qz.print(config, datos);
                }).catch(function(e) { console.error(e); });
                
                setTimeout(function() {window.location.reload(true);}, 10); //Se hace un timeout, debido a que al llamar a certificado en servidor, ocurre una demora que hace que no alcance a imprimir si se hace inmediatamente el reload().
            }).fail((data) => {
                console.log('Error AJAX');
            });
        });

        $("#pagar").hide();
        //No hacer "enter" en formulario, solamente en el botón!
		$("#formulario_venta").keypress(function(e) {
			if (e.which == 13) {
				return false;
			}
		});
        //Cuando se oculta el modal
        $("#mi-modal").on("hidden.bs.modal", function () {
        // Aquí va el código a disparar en el evento
            //limpiar();
        });
        //Cuando se muestra el modal
        $('#mi-modal').on('shown.bs.modal', function() {
            $('#precio_2').focus();
        })
        //Cuando se detecta cambios en el select de elección de productos
        $("#producto_id").change(function(){
            agregar();
        });
        //Muestra el vuelto en una alerta
        $('#pagar').click(function(){
            cancelado = $('#pago').val();
            cancelado = cancelado.replace(/[($)\s\._\-]+/g, '');
            vuelto = cancelado - total;
            $('#pago').val(cancelado);
            alert('El Vuelto es $'+vuelto);
        });
        //Formatear el dinero ingresado en el modal
        $('#precio_2').on('keyup',function(){
            var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}
			// When the arrow keys are pressed, abort.
			if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
				return;
			}
			var $this = $(this);
			// Get the value.
			var input = $this.val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;
			$this.val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString('es-CL');
			} );
        });
        // Formatear el numero de pago que ingresa
        $('#pago').on('keyup',function(){
            var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}
			// When the arrow keys are pressed, abort.
			if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
				return;
			}
			var $this = $(this);
			// Get the value.
			var input = $this.val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;
			$this.val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString('es-CL');
			} );
            evaluar();
        });
        //Deteca los cambios en los inputs de la tabla
        $("#detalle_venta").on('change','tr input',function(){
            ide=(this.id).split('_');
            nombre_input = ide[0];
            id = ide[1];
            if(nombre_input == 'cantidad'){
                total = total - $('#precio_linea_'+id).val();
                suma = $('#'+(this.id)).val()*($('#precio_unitario_'+id).val() - $('#descuento_'+id).val());
                $('#precio_linea_'+id).val(suma);
                $('#precio_lin_'+id).html(new Intl.NumberFormat('es-CL').format(suma));
                total = total + suma;
                //$("#total").html("$ "+total);
                $("#precio_total").val(total);
                $("#precio_total2").val(new Intl.NumberFormat('es-CL').format(total));
                evaluar2();
                $("#producto_id").focus();
            }
            else if(nombre_input == 'descuento'){
                //Para el descuento
                total = total - $('#precio_linea_'+id).val();
                //suma =  $('#cantidad_'+id).val()*($('#precio_unitario_'+id).val() - $('#'+(this.id)).val());
                suma =  ($('#cantidad_'+id).val()*$('#precio_unitario_'+id).val()) - $('#'+(this.id)).val();
                $('#precio_linea_'+id).val(suma);
                $('#precio_lin_'+id).html(new Intl.NumberFormat('es-CL').format(suma));
                total = total + suma;
                //$("#total").html("$ "+total);
                $("#precio_total").val(total);
                $("#precio_total2").val(new Intl.NumberFormat('es-CL').format(total));
                evaluar2();
                $("#producto_id").focus();
            }
        });
        //Cuando se agrega un producto a granel o stock 99999
        $('#agregar-2').click(function(){

            datosProducto=document.getElementById('producto_id').value.split('_');
            producto_id=datosProducto[0];
            producto=$("#producto_id option:selected").text();
            cantidad=1;
            precio_unitario = $('#precio_2').val();
            precio_unitario = precio_unitario.replace(/[($)\s\._\-]+/g, '');
            precio_linea = precio_unitario;
            descuento = 0;

            if( producto_id!="" && precio_unitario!="" && precio_linea!="")
            {
                total=total+(cantidad*precio_unitario);
                var fila=
                '<tr class="selected " id="fila'+cont+'"><td class="col-xs-2"><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td class="col-xs-2"><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td><td class="col-xs-2"><input class="col-xs-9" type="hidden" id="cantidad_'+cont+'" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td class="col-xs-2"><input class="col-xs-4" type="hidden" id="precio_unitario_'+cont+'" name="precio_unitario[]" value="'+precio_unitario+'">'+new Intl.NumberFormat('es-CL').format(precio_unitario)+'</td><td class="col-xs-2"><input class="col-xs-9" type="number" id="descuento_'+cont+'" name="descuento[]" value="'+descuento+'" ></td><td class="col-xs-2"><input class="col-xs-2" type="hidden" id="precio_linea_'+cont+'" name="precio_linea[]" value="'+precio_linea+'"><h4 class="col-xs-2" id="precio_lin_'+cont+'"><b>'+new Intl.NumberFormat('es-CL').format(precio_linea)+'</b></h4></td></tr>';
                cont++;
                limpiar();
                //$("#total").html("$ "+total);
                $("#precio_total").val(total);
                $("#precio_total2").val(new Intl.NumberFormat('es-CL').format(total));
                evaluar2();
                $("#detalle_venta").append(fila);
            }
        });
    });

    var cont=0;
	total=0;
    // Agregar productos a la tabla los normales por cantidad
	function agregar(){

        datosProducto=document.getElementById('producto_id').value.split('_');
        stock_actual = datosProducto[1];
        if(stock_actual == '99999')
        {
            $('#mi-modal').modal();
        }else{
            producto_id=datosProducto[0];
            producto=$("#producto_id option:selected").text();
            cantidad=1;
            precio_unitario=datosProducto[2];
            precio_linea=cantidad*precio_unitario;
            descuento = 0;
            if( producto_id!="" && cantidad!="" && cantidad>0 && precio_unitario!="" && precio_linea!="")
            {
                total=total+(cantidad*precio_unitario);
                var fila=
                '<tr class="selected  " id="fila'+cont+'"><td class="col-xs-2"><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td class="col-xs-2"><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td><td class="col-xs-2"><input class="col-xs-9" type="number" id="cantidad_'+cont+'" name="cantidad[]" value="'+cantidad+'"></td><td class="col-xs-2"><input class="col-xs-4" type="hidden" id="precio_unitario_'+cont+'" name="precio_unitario[]" value="'+precio_unitario+'">'+new Intl.NumberFormat('es-CL').format(precio_unitario)+'</td><td class="col-xs-2"><input class="col-xs-9"  type="number" id="descuento_'+cont+'" name="descuento[]" value="'+descuento+'"></td><td class="col-xs-2"><input class="col-xs-2" type="hidden" id="precio_linea_'+cont+'" name="precio_linea[]" value="'+precio_linea+'"><h4 class="col-xs-2" id="precio_lin_'+cont+'"><b>'+new Intl.NumberFormat('es-CL').format(precio_linea)+'</b></h4></td></tr>';
                cont++;
                limpiar();
                //$("#total").html("$ "+total);
                $("#precio_total").val(total);
                $("#precio_total2").val(new Intl.NumberFormat('es-CL').format(total));
                evaluar2();
                $("#detalle_venta").append(fila);
            }
            else
            {
                alert('Error al ingresar el detalle de la compra, revise los datos del producto');
            }
        }
	}
    //funcion para limpiar los campos
	function limpiar(){
        //especial para el modal
        $('#precio_2').val('');
		$("#producto_id").selectpicker('val','');
        $("#producto_id option").prop('selected',false);
        $("#producto_id").focus();
	}
    //funcion para detectar si hay productos agregados
    //se puede utilizar total, en vez de precio_total2 input
	function evaluar(){
        pago = $('#pago').val();
        pago = pago.replace(/[($)\s\._\-]+/g, '');
        precio_total2 = $('#precio_total2').val();
        precio_total2 = precio_total2.replace(/[($)\s\._\-]+/g, '');
		if((total > 0) && ((pago - precio_total2 ) >= 0 ) )
		{
			$("#pagar").show();
            $('#pagar').focus();
		}
		else
		{
			$("#pagar").hide();
            //alert('Se debe pagar con un valor mayor o igual al total de venta');
            if( !precio_total2 || precio_total2 == 0){
                $('#pago').val('');
            }else{
            }   //alert('Se debe pagar con un valor mayor o igual al total de venta');
            }
		}
    //Esta funcion verifica si se muestra el boton pagar, verifica lo demas
    function evaluar2(){
        if($("#pagar").show() ){
            pago = $('#pago').val();
            pago = pago.replace(/[($)\s\._\-]+/g, '');
            precio_total2 = $('#precio_total2').val();
            precio_total2 = precio_total2.replace(/[($)\s\._\-]+/g, '');
            if( !( (total > 0) && ((pago - precio_total2 ) >= 0 ) ) )
            {
                $("#pagar").hide();
            }
            if( total == 0){
                $('#pago').val('');
            }
        }
    }
    //eliminar productos
	function eliminar(index){
        total = total - $('#precio_linea_'+index).val();
		$("#precio_total").val(total);
        $("#precio_total2").val(new Intl.NumberFormat('es-CL').format(total));
		$("#fila"+index).remove();
        $("#producto_id").focus();
        evaluar2();
	}
</script>
@endpush
@endsection