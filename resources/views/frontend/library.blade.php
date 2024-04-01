@extends('frontend.layouts.main')

@section('main_content')

    <div class="shop-page-wrapper shop-page-padding lib">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="shop-sidebar library-sidebar">
                        <div class="sidebar-widget mb-50">
                            <div class="shop-found libe">
                                <div class="mb-3">
                                    <div class="library-page-txt text-center">

                                        @if($customer->membership_id > 0)
                                            <div class="text-center mb-3">
                                            <span class="special-vip">VIP
                                            {{  $customer->membership_title }}
                                            </span>
                                            </div>
                                        @endif

                                        <div class="member-id-desc">
                                            <span class="vipid" style="font-size: 20px;">ID</span>:
                                            <span class="vip-value" style="font-size: 20px;">{{ $customer->uid }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sidebar-btn">
                                    <!-- <p class="preview-btn">
                                        <a href="{{ route('frontend.user.download_product_detail', ['id' => $customer->id]) }}">Druckansicht</a>
                                    </p> -->
                                    <p class="pmessage-btn">
                                        <a href="#" data-toggle="modal" data-target="#user-message-modal"
                                           class="message-btn">Nachricht senden</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-widget mb-40 main-collection">
                            <h3 class="sidebar-title">Kollektionen</h3>
                            <div class="Collection-group">
                                <div class="value-work">{{ $products->total() }}</div>
                                <div class="key-work">Werke</div>
                                <div class="value-number">{{ $totalProducts }}</div>
                                <div class="key-work">Anzahl</div>
                            </div>
                        </div>
                        <div class="status-circle">
                            <div class="row d-flex justify-content-center mt-100">
                                <div class="col-md-12">
                                    <div class="statusgreen">
                                        <div class="status-title">Zustand</div>
                                        <div class="progress green">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                            <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                            <div class="progress-value">{{ floor(($productConditionAggregate/5)*100) }}
                                                %
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="left-call-action">
                            <section class="service-categories text-xs-center">
                                <a href="{{ route('frontend.page.contact') }}">
                                    <div class="card service-card card-inverse">
                                        <div class="card-block">
                                            <span class="fa fa-phone fa-3x"></span>
                                            <h4 class="card-title">Wir freuen uns auf Ihren Anruf!</h4>
                                            <div class="btn-card"><span class="request-cal">Jetzt anrufen</span></div>
                                        </div>
                                    </div>
                                </a>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="library-container">

                        @if(Session::has('success'))
                            <div class="mb-3">
                                @include('frontend.common.success_message')
                            </div>
                        @endif

                        <div class="library-header">
                            <div class="library-header-top clearfix">
                                <div class="clearfix">
                                    <h4 class="float-left">Alle <span>Bücher</span></h4>
                                    <div class="lib-filter float-right">
                                        <div class="filter-button-item">
                                            <a href="#" id="library-filter-btn"
                                            >
                                                <svg width="20" height="18" viewBox="0 0 22 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21 1H1L9 10.46V17L13 19V10.46L21 1Z" stroke="#24262D"
                                                          stroke-width="2" stroke-linecap="round"
                                                          stroke-linejoin="round"></path>
                                                </svg>
                                                <span class="fbi-filter fbi-filter-text">Filter</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $hasQueryParams = (request()->has('product_name') || request()->has('product_categories') ||
                                    request()->has('product_condition') || request()->has('sort_by') || request()->has('sort_order')
                                );
                                ?>
                                <form class="lib-filter-content"
                                      method="GET"
                                      style="display: {{ $hasQueryParams ? 'block' : 'none' }}"
                                      action="{{ route('frontend.get_customer_libraries', ['customer_id' => $customerId]) }}"
                                >
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div id="library-search-filter" class="row">
                                                <div class="col-md-4 form-group">
                                                    <input type="text"
                                                           class="form-control"
                                                           name="product_name"
                                                           value="{{ request('product_name') }}"
                                                           placeholder="Suchen"
                                                    />
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <select name="product_condition" id="" class="form-control">
                                                        <option value="">Zustand</option>
                                                        @foreach(config('buch.product_conditions') as $condition)
                                                            <option value="{{ $condition['value'] }}"
                                                                    {{ request('product_condition') == $condition['value'] ? 'selected' : '' }}
                                                            >
                                                                {{ $condition['label'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group categories-select-wrapper">
                                                    <select class="product_categories form-control"
                                                            name="product_categories[]"
                                                            multiple="multiple"
                                                    >
                                                        @foreach($categories as $category)
                                                            <option
                                                                    value="{{ $category->id }}"
                                                                    {{ in_array($category->id, (array) request('product_categories')) ? 'selected' : '' }}
                                                            >{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="library-search-sort" class="row">
                                                <?php
                                                $sortings = [
                                                    ['label' => 'Zustand', 'value' => 'user_products.condition'],
                                                    ['label' => 'Produkt', 'value' => 'products.title'],
                                                    ['label' => 'Kategorie', 'value' => 'product_categories.title']
                                                ];
                                                ?>
                                                <div class="col-md-4">
                                                    <select name="sort_by" class="form-control"
                                                            id="product-sorting">
                                                        <option value="">Sortieren nach</option>
                                                        @foreach($sortings as $sorting)
                                                            <option value="{{ $sorting['value'] }}"
                                                                    {{ request('sort_by') == $sorting['value'] ? 'selected' : '' }}
                                                            >
                                                                {{ $sorting['label'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="sort_order" class="form-control"
                                                            id="product-sorting">
                                                        <option value="">Sortierung</option>
                                                        <option
                                                                value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                                                            Aufsteigend
                                                        </option>
                                                        <option
                                                                value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                                            Absteigend
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn mb-2 btn-primary btn-block" type="submit">Suche</button>
                                            <a href="{{ route('frontend.get_customer_libraries', ['customer_id' => $customerId]) }}"
                                               class="btn btn-danger btn-block">
                                                übersichtlich
                                            </a>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                        @if(count($products) > 0)
                            <div class="library-content">
                                <div class="shop-product-content tab-content">
                                    <div id="grid-sidebar12" class="tab-pane fade active show">
                                        <div id="app">
                                            <product-container
                                                    :initial-products="{{ json_encode($products->items()) }}"
                                                    :customer-id="{{ $customerId }}"
                                                    :config="{{ json_encode([
                                                    'baseUrl' => url('/'),
                                                    'storageUrl' => getProductStorageUrl(),
                                                    'filterCustomersUrl' => route('frontend.filter_customers'),
                                                    'filterProductsUrl' => route('frontend.filter_products'),
                                                    'customerLibraryUrl' => url('/libraries').'/',
                                                    'guestInquiryUrl' => route('guest.inquiry'),
                                                    'dataProtectionUrl' => route('frontend.page.data_protection'),
                                                    'product_conditions' => config('buch.product_conditions'),
                                                    'product_condition_default' => config('buch.product_condition_default'),
                                                    'bookUrl' => url('/books').'/',
                                                    'emptyImageUrl' => getDummyImageUrl(),
                                                ]) }}"
                                            ></product-container>
                                        </div>
                                        <div class="text-center">
                                            {!!
                                                $products->appends([
                                                    'product_name'      => request('product_name'),
                                                    'product_condition' => request('product_condition'),
                                                    'product_categories' => request('product_categories'),
                                                    'sort_by'           => request('sort_by'),
                                                    'sort_order'        => request('sort_order'),
                                                ])->links()
                                            !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user-message-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nachricht für ID: {{ $customerId }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('frontend.guest.message_to_user') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $customerId }}"/>
                        <div class="form-group">
                            <label for="first_name">Vorname *</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"/>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Nachname *</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="text" class="form-control" name="email" id="email"/>
                        </div>
                        <div class="form-group">
                            <label for="phone_no">Telefonnummer *</label>
                            <input type="number" class="form-control" name="phone_no" id="phone_no"/>
                        </div>
                        <div class="form-group">
                            <label for="message">Ihre Nachricht *</label>
                            <textarea class="form-control" name="message" id="message" rows="10"
                            ></textarea>
                        </div>
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary float-right">Senden</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_title', $customerId.' | Jetzt Werke entdecken!')
@section('page_meta_props')
    @parent
    <meta name="description"
          content="{{ $customerId }} | Verwaltung und Handel mit Buch- und Kunstsammlungen | Jetzt seltene und wertvolle Werke entdecken!"/>
@endsection

@section('footer_script')
    @parent

    @vite(['resources/jsBundler/frontend/libraries.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.product_categories').select2({
                placeholder: "Kategorie",
                allowClear: true
            });
            $('#library-filter-btn').on('click', function (e) {
                e.preventDefault();
                $('.lib-filter-content').fadeToggle();
            });
        });
    </script>
@endsection
@section('header_styles')
    @parent

    <style>
        footer {
            background: #ffffff;
        }

        .shop-page-padding.lib {
            background: #f5f3f0;
            position: relative;
        }

        footer:before {
            content: '';
            position: absolute;
            z-index: 9;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 67px;
            background-image: url(../assets/frontend/images/home-images/footer-scratch-paper.webp);
            background-repeat: no-repeat;
        }

        section.footer-form-section {
            padding-top: 0;
        }

        .shop-page-padding.lib:before {
            content: '';
            position: absolute;
            z-index: 999;
            left: 0;
            top: -7px;
            width: 100%;
            height: 67px;
            transform: rotateX(
                    181deg
            );
            background-image: url(../assets/frontend/images/home-images/white-strip-paper.webp);
            background-repeat: no-repeat;
        }

        section.book-detail-page.section-bg {
            background-color: #f5f3f0;
            padding: 9% 0% 9% 0%;
        }

        .statusgreen {
            background: #fff;
        }

        .library-header-top.clearfix {
            background: #ffffff;
        }

        .left-call-action .service-card {
            background: #ffe6d3;
        }

        textarea {
            min-height: auto;
            background: #fff !important;
            /* box-shadow: inset 1px 8px 9px -6px #dcdcdc !important;*/
            border-radius: 11px !important;
            border: 0px solid #4c4b517d !important;


        }

        span.select2-selection.select2-selection--multiple {
            background: #fff !important;
            box-shadow: inset 1px 8px 9px -6px #dcdcdc !important;
            border-radius: 11px !important;
            border: 1px solid #4c4b517d !important;
            min-height: 45px;
        }

        .form-control {
            background: #fff !important;
            box-shadow: inset 1px 8px 9px -6px #dcdcdc !important;
            border-radius: 11px !important;
            border: 1px solid #4c4b517d !important;
            min-height: 45px;
        }

        .form-group label {
            color: #3f3f3f;
        }

        .card-links-list .card-link:nth-child(2) {
            padding: 4px 10px;
        }

        @media (max-width: 1199px) {
            .shop-page-padding.lib:before {
                display: none;
            }

            footer:before {
                display: none;
            }
        }

        .shop-found.libe {
            background: #3f3f3f;
        }

        .library-page-txt span.vip-value {
            color: #fff !important;
        }

        .lib-filter-content {
            background-color: #fff;
        }
    </style>

@endsection
