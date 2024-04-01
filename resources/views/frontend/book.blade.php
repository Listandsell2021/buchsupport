@extends('frontend.layouts.main')

@section('main_content')

    <section class="book-detail-page section-bg">
        <div class="container">

            @include('frontend.common.error_message')
            @include('frontend.common.success_message')

            <div class="row row-sm">
                <div class="col-md-6 _boxzoom">

                    @if($registerId)
                        <ul class="book-breadcrumb">
                            <li class="book-breadcrumb-item">
                                <a class="book-breadcrumb-link"
                                   href="{{ route('frontend.get_customer_libraries', ['customer_id' => $registerId]) }}">
                                    {{ $registerId }}
                                </a>
                            </li>
                            <li class="book-breadcrumb-item">
                                <a class="book-breadcrumb-link"
                                   href="{{ route('frontend.get_book', ['id' => $book->id, 'register' => $registerId]) }}">
                                    {{ $book->product_name }}
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if(count($book->images) > 0)
                        <div class="image-book-layer">
                            <div class="zoom-thumb">
                                <ul class="piclist">
                                    @foreach($book->images as $image)
                                        <li><img src="{{ getProductStorageUrl($image->image_path) }}"
                                                 alt="{{ $image->image_path }}"></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="_product-images">
                                <div class="picZoomer">
                                    @foreach($book->images as $image)
                                        <img class="my_img" src="{{ getProductStorageUrl($image->image_path) }}"
                                             alt="{{ $image->image_path }}">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="image-book-layer">
                            <div class="zoom-thumb">
                                <ul class="piclist">
                                    <li>
                                        <img src="{{ asset('asset/frontend/images/300_400.webp') }}"
                                             alt="no preview"
                                             style="background-color: #fff;"
                                        />
                                    </li>
                                </ul>
                            </div>
                            <div class="_product-images">
                                <div class="picZoomer">
                                    <img class="my_img" src="{{ asset('asset/frontend/images/300_400.webp') }}"
                                         alt="no preview"
                                         style="background-color: #fff; height: auto;"
                                    />
                                </div>
                            </div>
                        </div>

                    @endif

                    @if(!empty($book->yt_link))
                        <div class="youtube-detail-section">
                            <p class="remarks-title">Video</p>
                            <div class="youtube-frame">
                                <iframe width="520" height="315"
                                        src="https://www.youtube.com/embed/{{ $book->yt_link }}"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif


                </div>
                <div class="col-md-6">
                    <div class="_product-detail-content">
                        <p class="_p-name">{{ $book->product_name }}</p>
                        <div class="clearfix mt-1 mb-2">
                            @if(!empty($book->category))
                                <div class="pull-left m-b-20"><small>{{ $book->category->title }}</small></div>
                            @endif
                            <a href="#" data-toggle="modal" data-target="#user-message-modal"
                               class="pull-right btn btn-interest">
                                <i class="fa fa fa-book mr-1"></i> Kaufinteresse
                            </a>
                        </div>
                        <div class="description-content">
                            @if($book->note != '' || !is_null($book->note))
                                <p class="description-title">Beschreibung</p>
                                <p class="description-text">{!! $book->note !!}</p>
                            @else
                                <p class="description-text">
                                    Demnächst erwartet Sie hier eine vollumfängliche Beschreibung zu diesem wertvollen
                                    Exponat.
                                </p>
                            @endif
                        </div>
                    </div>

                    @if(count($customers) > 0)
                        <div class="book-detail-search" id="book-detail-search">
                            <p class="book-search-title">Bibliotheken, in denen Sie dieses Werk finden</p>
                            <div class="detail-search">

                                <div class="Vip-search">
                                    <form action="{{ route('frontend.get_book', ['id' => $book->id]) }}" method="GET">
                                        <input type="hidden" name="page" value="{{ request()->get('page') }}"/>
                                        <input type="hidden" name="register" value="{{ $registerId }}"/>
                                        <input name="user-id"
                                               type="text"
                                               class="vip-search-textfield"
                                               id="vip-search-textfield"
                                               placeholder="Ich suche nach ..."
                                               value="{{ request()->get('user-id') }}"
                                        >
                                        <button><i class="ti-search fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-search">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Bibliotheken VIP</th>
                                        <th scope="col">Zustand</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($customers as $customer)
                                        <tr>
                                            <td>
                                                <a class="vipkey"
                                                   href="{{ route('frontend.get_customer_libraries', ['customer_id' => $customer->user_id]) }}">
                                                    {{ $customer->uid }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="status-table">
                                                    <span class="green-tablestatus">
                                                        {{ getProductCondition($customer->condition) }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="bc-custom-pagination">
                                    {{ $customers
                                            ->onEachSide(1)
                                            ->appends([
                                                'register' => request()->get('register'),
                                                'user-id' => request()->get('user-id'),
                                            ])
                                            ->links()
                                    }}
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="search-error-msg">Es gibt keine registrierte Bibliothek mit dieser Nummer!</div>
                    @endif

                </div>
            </div>
        </div>
    </section>


    <div class="modal fade book-p-modal" id="user-message-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ANFRAGEFORMULAR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body inquery-form-custom inquiry-form">
                    <form action="{{ route('frontend.guest.message_from_book') }}" method="post">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                        <input type="hidden" name="user_id" value="{{ $registerId }}"/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label for="first_name">Vorname *</label></div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="first_name" id="first_name" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label for="last_name">Nachname *</label></div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="last_name" id="last_name" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label for="email">E-Mail Adresse *</label></div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="email" id="email" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label for="telephone">Telefonnummer *</label></div>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="phone_no" id="telephone" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label for="telephone">Budget *</label></div>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="price" id="price" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label for="terms">Nutzungsbedingungen*</label></div>
                                <div class="col-md-8">
                                    <input type="checkbox" name="terms" id="terms" value="1" required>
                                    <div class="term-text">
                                        Ich habe die Nutzungsbedinungen und
                                        <a href="{{ route('frontend.page.data_protection') }}"
                                           target="_blank">Datenschutzerklärung</a>
                                        gelesen und bin damit einverstanden.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary">Weiter →</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page_title', $book->product_name)
@section('page_meta_props')
    @parent
    <meta name="description" content="{{ $book->product_name }} | Verwaltung und Handel mit Buch- und Kunstsammlungen | Jetzt seltene und wertvolle Werke entdecken!" />
@endsection

@section('header_styles')
    @parent

    <style>
        footer {
            background: #ffffff;
        }

        footer:before {
            content: '';
            position: absolute;
            z-index: 9;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 67px;
            background-image: url(/images/home-images/footer-scratch-paper.png);
            background-repeat: no-repeat;
        }

        section.footer-form-section {
            padding-top: 0;
        }

        section.book-detail-page.section-bg:before {
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
            background-image: url(/images/home-images/white-strip-paper.png);
            background-repeat: no-repeat;
        }

        section.book-detail-page.section-bg {
            background-color: #f5f3f0;
            padding: 9% 0% 9% 0%;
        }

        @media (max-width: 1199px) {
            section.book-detail-page.section-bg:before {
                display: none;
            }

            footer:before {
                display: none;
            }
        }
    </style>


@endsection

@section('footer_script')
    @parent


    <script src="{{ asset('assets/frontend/js/piczoomer.js') }}"></script>

@endsection




