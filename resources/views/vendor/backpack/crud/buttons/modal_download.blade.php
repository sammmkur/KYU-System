<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDownload">
    Download
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Please Select..</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formExcel" class="" action="" method="POST" enctype="multipart/form-data">
            {{-- <form class="" action="{{url('export-claim/gift/download')}}" method="POST" enctype="multipart/form-data"> --}}

            {!! csrf_field() !!}
            <div class="row">

                <div class="col-md-6 form-group">
					@php
					$data_period = [];
					$now = \Carbon\Carbon::now();

					$data_period[null] = 'Select Year';

					// set the CRUD model to something (anything)
					// but ideally it'd be the model of the entity that has the form
					function getWednesdays($y, $m)
					{
						return new DatePeriod(
							new DateTime("first wednesday of $y-$m"),
							DateInterval::createFromDateString('next wednesday'),
							new DateTime("last day of $y-$m")
						);
					}
					$i = 0;
					// foreach (getWednesdays(2010, 11) as $wednesday) {
					// 	// echo $wednesday->format("l, Y-m-d\n");
					// 	$data_period[$i] = $wednesday->format("l, Y-m-d\n");
					// 	$i++;
					// }

					// 	$crud = app()->make('crud');
					//   $crud->setModel(\App\Models\Product::class);

					
					  for ($i=$now->year-10; $i <= $now->year+10; $i++) { 
						$data_period[$i] = $i;
					  }
					  $now = date('Y');
					@endphp
    
                    @include('crud::fields.select2_from_array', [
                        'crud' => $crud,
                        'field' => [
                          'name'        => 'period',
                          'label'       => "Period",
                          'type'        => 'select2_from_array',
                          'options'     => $data_period,
                          'allows_null' => false,
                          'wrapper' => [
                            'class' => 'form-group col-md-12 px-0',
                          ],
                        ]
                    ])
                  </div>
                  
                   
                  <div class="col-md-6 form-group">
                    
                   
                    {{-- <select class="select2" name="month" id="month" class="form-control">
                      <option value>Select Month</option>
                      @for($j=1; $j <= 12; $j++)
                      <option value="{{ $j }}">{{ \Carbon\Carbon::createFromFormat('m', $j)->format('F')}}</option>
                      @endfor
                  </select> --}}
                  @php
                  $data_month = [];
                  $now = \Carbon\Carbon::now();
        
                  $data_month[null] = 'Select Month';
        
                  for($j=1; $j <= 12; $j++){
                    $data_month[$j] = Carbon\Carbon::createFromFormat('m', $j)->format('F');
                    }
                    $now = date('Y');
                  @endphp
            
                            @include('crud::fields.select2_from_array', [
                                'crud' => $crud,
                                'field' => [
                                  'name'        => 'month',
                                  'label'       => "Month",
                                  'type'        => 'select2_from_array',
                                  'options'     => $data_month,
                                  'allows_null' => false,
                                  'wrapper' => [
                                    'class' => 'form-group col-md-12 px-0',
                                  ],
                                ]
                            ])
                  </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="control-point-download btn btn-success">Download</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('after_scripts')
  <script>
  $('#modalDownload').appendTo('body')

  $(".control-point-download").on("click", function(e){
    e.preventDefault();
      var backpack_url = "{{ backpack_url() }}";
      var url = backpack_url +'/export';
      $('#formExcel').attr('action',url).submit();
  });


  </script>
  @endpush