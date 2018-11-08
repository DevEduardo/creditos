<table>
    <thead>
    <tr>
        <th colspan="2">FIEDBA S.A.S</th>
        <th></th>
        <th></th>
        <th>*PARCIAL*</th>
    </tr>
    
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2" >Cupon de pago</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">_______________________________________________</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>N°{{ $data->fee_id }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                {{$client->id}}-{{$client->dni}}-{{$client->name}}
                        
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                @if($data->partial == 1)
                    <span class="right">* PARCIAL *</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>{{$client->profile->between_street}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>({{$client->profile->postal_code}})-{{$client->profile->address}} - {{$client->profile->district}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Crédito: {{$data->credit_id}}</td>
            <td></td>
            <td></td>
            <td colspan="2">Cuota: {{$fee->fee_number}}/{{$credit->fees}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Vencim: {{$fee->fee_date_expired->format('d-m-Y')}}</td>
            <td></td>
            <td></td>
            <td colspan="2">F.Pago: {{$fee->fee_date->format('d-m-Y')}}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">_______________________________________________</td>
        </tr>
        <tr>
            <td></td>
            <td>Cuota</td>
            <td>{{$data->amount}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Punitorios</td>
            <td>{{$data->interests}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Total</td>
            <td>{{$data->amount + $data->interests}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">_______________________________________________</td>
        </tr>
        <tr>
            <td>Son $: {{ NumerosEnLetras::convertir($data->amount + $data->interests) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">_______________________________________________</td>
        </tr>
        <tr>
            <td>Proximos vencimientos</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Crédito</td>
            <td></td>
            <td>Cu/Cc</td>
            <td>Venc</td>
            <td>Monto</td>
        </tr>
        <tr>
            @if($data->partial == 0 && $fee->fee_number != $credit->fees || $fee->payment == $fee->fee_amount)
                @if($nextFee)
                    <td>{{$data->credit_id}}</td>
                    <td></td>
                    <td>{{$nextFee->fee_number}}/{{$credit->fees}}</td>
                    <td>{{$nextFee->fee_date_expired->format('d-m-Y')}}</td>
                    <td>{{$nextFee->fee_amount}}</td>
                @endif
            @elseif($data->partial == 1 && $fee->fee_number < $credit->fees)
                <td>{{$data->credit_id}}</td>
                <td></td>
                <td>{{$fee->fee_number}}/{{$credit->fees}}</td>
                <td>{{$fee->fee_date_expired->format('d-m-Y')}}</td>
                <td>{{$fee->fee_amount - $fee->payment }}</td>
            @endif
        </tr>
        <tr>
            <td><b><br>ATENCION:</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Su pago en termino evita la adicion de intereses</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>punitorios y gastos a la/s cuota/s.</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>