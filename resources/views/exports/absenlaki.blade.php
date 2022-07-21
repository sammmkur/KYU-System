<table>
    <thead>
        @php
            $month = $periode[0];
            $year = $periode[1];
            $column = ['C','D','E','F','G','H']
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
        @php
            $i=5;
            $a=0;
            $c_awal=$column[$a].$i;
        @endphp
        @foreach($data as $d=>$value)
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
        @php
            $i++;
        @endphp
        </tr>
        @endforeach
        @php
            $c_end = $column[$a].($i-1);
            $count_i= $i-1;
            $i=5;
        @endphp
        <tr>
        </tr>
        <tr>
            <td colspan="2" style="font-weight:bold">Total Yang Datang</td>
        @foreach ($date as $d)
            <td>=COUNTIF({{$c_awal}}:{{$c_end}},"v")</td>
            @php
                $a++;
                $c_awal=$column[$a].$i;
                $c_end = $column[$a].($count_i);
                
            @endphp
        @endforeach
        </tr>
       
    </tbody>
</table>