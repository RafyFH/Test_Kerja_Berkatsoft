@extends('partials.master')
@section('content')

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-send-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1449">{{$produk}}</span>
                </div>
                <div class="desc"> Produk </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-user"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="12,5">{{$customer}} </div>
                <div class="desc"> Customer </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="549">{{$sales_order}}</span>
                </div>
                <div class="desc"> Sales Order </div>
            </div>
        </a>
    </div>
</div>
<div class="clearfix"></div>
@endsection