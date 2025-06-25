@extends('layout.master')
@section('APP-CONTENT')
    <div class="radio d-inline-block mr-2">
        <input type="radio" name="bsradio" id="radio1" checked="">
        <label for="radio1">Active</label>
    </div>
    <div class="radio d-inline-block mr-2">
        <input type="radio" name="bsradio" id="radio2">
        <label for="radio2">Inactive</label>
    </div>
    <div class="radio d-inline-block mr-2">
        <input type="radio" name="bsradio1" id="radio3" disabled="" checked="">
        <label for="radio3">Active - Disabled</label>
    </div>
    <div class="radio d-inline-block mr-2">
        <input type="radio" name="bsradio1" id="radio4" disabled="">
        <label for="radio3">Inactive - Disabled</label>
    </div>
@endsection
