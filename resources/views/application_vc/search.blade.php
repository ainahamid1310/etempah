@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Bilik Mesyuarat > Semak Kekosongan</span>

    </div>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header header-elements-inline bg-light">
                <h5 class="card-title">Carian Tempahan</h5>
            </div>
            <form action="/application/search/result">
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Nama Mesyuarat: </label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="nama_mesyuarat">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Bilik: </label>
                                <div class="col-md-8">
                                    <select class="form-control select-search" data-placeholder="Pilih Bilik" data-fouc>
                                        <option></option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh & Masa Mula: </label>
                                <div class="col-md-3">
                                    <input class="form-control" type="datetime-local" name="datetime-local">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh & Masa Tamat: </label>
                                <div class="col-md-3">
                                    <input class="form-control" type="datetime-local" name="datetime-local">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-success">Semak </button>
                        <a href="/application/create"><button type="button" class="btn bg-info" disabled>Mohon Tempahan
                            </button></a>
                    </div>

                </div>
            </form>


            {{-- @include('applications.index') --}}
        </div>
    </div>
@endsection
