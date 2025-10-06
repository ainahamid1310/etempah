<!-- @if (count($errors) > 0)
    <div class="alert alert-danger alert-styled-right alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                class="sr-only">Tutup</span></button>
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

{{-- Bootstrap Alert --}}
@if (Session::has('successMessage'))
    <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                class="sr-only">Tutup</span></button>
        <strong>Berjaya, </strong> {{ session('successMessage') }}
    </div>
@endif

@if (Session::has('errorMessage'))
    <div class="alert alert-warning alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                class="sr-only">Tutup</span></button>
        <strong>Ralat! </strong> {{ session('errorMessage') }}
    </div>
@endif

@if (session('email_error'))
    <div class="alert alert-warning alert-styled-left alert-dismissible">
        <strong>Gagal! </strong> {{ session('email_error') }}
    </div>
@endif


