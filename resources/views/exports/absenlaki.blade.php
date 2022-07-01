<table>
    <thead>
        @php
            $month = $periode[0];
            $year = $periode[1];
           
        @endphp
        <tr>
            <th colspan="9" style="text-align: center;font-weight:bold">ABSENSI ANGGOTA KYU {{$month}} {{$year}}</th>    
        </tr>
        <tr>
            <th colspan="9" style="text-align: center;font-weight:bold">LAKI-LAKI<th>
        </tr>
        <tr>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <th>Panggilan</th>
            @foreach ($date as $d)
                <th>{{$d}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d=>$value)
        {{-- @dd($data) --}}
        <tr>
                <td>{{$value['complete_name']}}</td>
                <td>{{$value['short_name']}}</td>
                @foreach ($date as $d)
                    @if($d == $value['absent_date'])
                    
                        <td>v</td>
                    @else
                    
                        <td></td>
                    @endif
                @endforeach

        </tr>
        @endforeach
       
    </tbody>
</table>