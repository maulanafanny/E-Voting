@extends('voting.master')
@section('judul','E-voting')
@section('konten')
    <div class="mycontainer" style="overflow-x:hidden">
    <div class="row">
 
        <div class="col-md-12">
          <div class="card mx-auto mb-5 cardku">
             
                 <div class="card-body text-center">
                  <h5 class="card-title"></h5>
                  <div class="row">
                      <div class="col">
                      <h3>Terimakasih Atas Partisipasinya</h3>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col"><a href="{{ route('votinglogin') }}" class="btn btn-primary mb-1" style="width:100%">Halaman Utama</a></div>
                  </div>
         </div>
         </div>
        </div>
      </div>
    </div>

@endsection