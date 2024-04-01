<!doctype html>
<html class="no-js" lang='{{ config('app.locale') }}'>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section('page_title', 'Bücher-Register')
        @yield('page_title')
    </title>
    @section('page_meta_props')
    @show
    <meta name="robots" content="nosnippet">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon-96x96.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/frontend/fonts/font-awesome.min.css') }}">
    @section('header_styles')
        @if(isInProduction())
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/combined-app.css') }}"/>
        @else
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-roboto.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/bundle.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/jquery.mmenu.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom_style.css') }}"/>
            <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom-new-home.css') }}"/>
        @endif
    @endsection
    @yield('header_styles')


</head>

<body>


<!-- ========== MOBILE MENU ========== -->
<nav id="mobile-menu"></nav>
<!-- ========== WRAPPER ========== -->
<div class="wrapper">

    <div class="topbar">
        <div class="container">
            <div class="welcome-mssg">
                Willkommen zu buch-kunstregister.
            </div>
            <div class="top-right-menu">
                <ul class="top-menu">
                    <li class="d-none d-md-inline">
                        <a target="_blank" title="Google Play"
                           href="https://play.google.com/store/apps/details?id=com.LS.buchkunstregister">
                            <img width="26px" src="{{ asset('assets/frontend/images/home-images/google-play.svg') }}">
                        </a>
                    </li>
                    <li class="d-none d-md-inline">
                        <a target="_blank" title="Apple store"
                           href="https://apps.apple.com/in/app/buch-kunstregister/id1614838861">
                            <img width="26px"
                                 src="{{ asset('assets/frontend/images/home-images/apple-black-logo.svg') }}">
                        </a>
                    </li>
                    <li class="d-none d-md-inline">
                        <a href="tel:{{ config('buch.company.phone_no_link') }}">
                            <i class="fa fa-phone"></i> {{ config('buch.company.phone_no') }}
                        </a>
                    </li>
                    <li class="d-none d-md-inline">
                        <a href="mailto:{{ config('buch.company.email') }}">
                            <i class="fa fa-envelope-o "></i>{{ config('buch.company.email') }}</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- ========== HEADER ========== -->
    <header class="horizontal-header sticky-header" data-menutoggle="1199">
        <div class="container">
            <!-- BRAND -->
            <div class="brand">
                <div class="logo">
                    <a href="{{ route('frontend.home') }}">

                        <img src="{{ asset('assets/frontend/images/buch-new-logo.png') }}" alt="Logo">

                    </a>
                </div>
            </div>
            <!-- MOBILE MENU BUTTON -->
            <div id="toggle-menu-button" class="toggle-menu-button">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
            <!-- MAIN MENU -->
            <nav id="main-menu" class="main-menu">
                <ul class="menu">
                    <li class="menu-item "><a href="{{ route('frontend.home') }}">Start</a></li>
                    <li class="menu-item "><a href="{{ route('frontend.home') }}#uber-uns">Über uns</a></li>
                    <li class="menu-item "><a href="{{ route('frontend.home') }}#das-team">Das Team</a></li>
                    <li class="menu-item "><a href="{{ route('frontend.home') }}#galerie">Galerie</a></li>
                    <li class="menu-item "><a href="{{ route('frontend.home') }}#kontaktform">Kontakt</a></li>


                    <li class="menu-item menu-btn sam">
                        <a href="{{ route('frontend.get_show_room') }}" class="btn">
                            <i class="fa fa-book"></i>
                            Sammlung
                        </a>
                    </li>
                    <li class="menu-item menu-btn user">
                        <a href="{{ getCustomerLoginUrl() }}" class="btn">
                            <i class="fa fa-user"></i>
                            Login
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="myModal" class="modal home-popup fade">


            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">


                    <div class="modal-body">
                        <h5 class="modal-title-new">Vorsicht vor <span>Betrügern!</span></h5>
                        <button type="button" class="close close-cross" data-dismiss="modal">&times;</button>
                        <p class="emailbold">Wichtige Mitteilung an unsere geschätzten Kunden: Keine Angebote per Mail
                            oder Telefon !</p>
                        <p class="head-txt">Sehr geehrte Kunden,<br>Wir möchten Sie darüber informieren, dass unser
                            Unternehmen keine Angebote oder Werbemitteilungen per E-Mail oder telefonisch versendet.
                            Sollten Sie eine solche Nachricht erhalten, bitten wir Sie, nicht darauf zu reagieren und
                            uns umgehend darüber zu informieren.</p>
                        <p class="head-txt">In der heutigen Zeit sind Betrugsversuche und Phishing-Angriffe leider
                            allgegenwärtig. Aus diesem Grund haben wir strenge Sicherheitsmaßnahmen implementiert, um
                            die Privatsphäre und die Interessen unserer Kunden zu schützen. Unsere offiziellen
                            Mitteilungen erfolgen ausschließlich über unsere offizielle Website oder postalische
                            Sendungen.</p>

                        <p class="head-txt">Zurzeit sind mehrere Personen unterwegs, die in unserem Namen auftreten,
                            aber nicht zu unseren Handelsvertretern gehören. Um sicherzugehen, dass es sich um seriöse
                            Vertreter handelt, bitten wir Sie darum, diese Personen dazu aufzufordern, sich auszuweisen.
                            Unsere Handelsvertreter tragen einen entsprechenden Ausweis mit ihrem Namen und einem Foto
                            bei sich.
                        <p>
                        <p class="head-txt">Wenn der Herr / die Dame auf Aufforderung diesen Ausweis nicht nachzeigt und
                            kein gültiges Ausweisdokument zur Bestätigung mit sich führt, sollten Sie alarmiert sein.
                            Sie können dann unter der folgenden Nr. anrufen, um sich die Identität des Handelsvertreters
                            / der Handelsvertreterin bestätigen zu lassen: <a href="tel:004930520045118">030-520 045
                                118</a>.</p>
                        <p class="head-txt"><strong>Des Weiteren weisen wir darauf hin, dass wir keine Bücher verkaufen
                                und
                                keine Barzahlungen annehmen.</strong> Wenn jemand Ihnen also eines dieser Anliegen in
                            unserem Namen
                            anbringt, handelt es sich definitiv nicht um jemanden, der für uns oder in unserem Auftrag
                            arbeitet.</p>
                        <p class="head-txt">In solch einem Fall empfehlen wir, die Polizei zu benachrichtigen, da es
                            sich dann offensichtlich um einen versuchten Betrugsfall handelt.</p>
                        <button type="button" class="btn btn-secondary btnclose" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!--- ===== SNOW EFFECT ======= ---->

    </header>


    <div class="main-content-wrapper">
        @yield('main_content')
    </div>


    <!-- ========== FOOTER ========== -->
    <footer id="main-footer">

        @if(!request()->is('rueckruf'))
            <section class="footer-form-section">
                <div class="container">
                    <div class="newsletter-sec" id="kontaktform">

                        @include('frontend.common.query_message')
                        @include('frontend.common.error_message')
                        @include('flash::message')

                        <form class="footerform" method="post"
                              action="{{ route('frontend.contact_form') }}">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-lg-8">

                                    <div class="kontakt-cta-mobile">
                                        Nehmen Sie Kontakt mit uns auf!
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group-sm">
                                                <input type="text"
                                                       id="first_name"
                                                       name="first_name"
                                                       class="form-control"
                                                       placeholder="Vorname (Optional)"
                                                       value="{{ old('first_name') }}"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group-sm">
                                                <input type="text"
                                                       id="last_name"
                                                       name="last_name"
                                                       class="form-control"
                                                       placeholder="NachName (Optional)"
                                                       value="{{ old('last_name') }}"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                   class="form-control"
                                                   name="user_id"
                                                   id="user_id"
                                                   placeholder="ID (Optional)"
                                                   value="{{ old('user_id') }}"
                                            />
                                            <small id="callback_id" class="form-text text-muted">
                                                Falls Sie bereits einen Account haben, geben Sie bitte Ihre ID an.
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                   id="callback_number"
                                                   class="form-control"
                                                   name="callback_number"
                                                   required
                                                   placeholder="Rückruf-Nummer *"
                                                   value="{{ old('callback_number') }}"
                                            />
                                        </div>
                                        <div class="col-md-12">
                                        <textarea rows="3"
                                                  id="callback_note"
                                                  placeholder="Notiz (Optional) &#10; Zusätzliche Informationen für den Rückruf"
                                                  class="form-control"
                                                  name="callback_note"
                                        >{{ old('callback_note') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-checkboxes">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   id="callback_permission"
                                                   class="form-check-input"
                                                   name="callback_agree"
                                                   value="1"
                                                   required
                                                    {{ old('callback_agree') ? 'checked' : '' }}
                                            />
                                            <label for="callback_permission" class="form-check-label">
                                                Ich bestätigte hiermit, dass die E+K Buch-Kunst Register GmbH mich unter
                                                der
                                                angegebenen Rückruf-Nummer kontaktieren darf.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   id="privacy_policy"
                                                   class="form-check-input"
                                                   name="privacy_policy"
                                                   value="1"
                                                   required
                                                    {{ old('privacy_policy') ? 'checked' : '' }}
                                            />
                                            <label for="privacy_policy" class="form-check-label">
                                                Beim Absenden des Formulars werden wir Ihre Daten für den Zweck der
                                                Kontaktaufnahme
                                                verarbeiten.
                                                <a class="footer-form-privcacy" target="_blank"
                                                   href="{{ route('frontend.page.data_protection') }}">
                                                    Mehr dazu in der Datenschutzerklärung
                                                </a>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4">

                                    <div class="newsz-ltr-text">
                                        <div class="kontakt-cta">
                                            Nehmen Sie Kontakt mit<br> uns auf!
                                        </div>

                                        <button type="submit" class="btn btn-outline-dark px-2 mt-2 w-100">Rückruf
                                            anfordern
                                        </button>

                                        <div class="mt-3">
                                            <a href="#" class="forgot-password-link" data-toggle="modal"
                                               data-target="#forgot-password-modal">
                                                Passwort vergessen?
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </section>
        @endif

        <section class="col-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img class="footer-logo" src="{{ asset('assets/frontend/images/white-logo2.webp') }}">


                        <p class="logo-txt">Eine ausgewählte Büchersammlung ist und bleibt der Brautschatz des Geistes
                            und des
                            Gemütes.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-widget-title">
                            <p>Kontakt</p>
                        </div>
                        <div class="kontakt-list">
                            <ul class="list-group">
                                <li class="list-group-item">
                            <span class="footer-kontakt-icon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                                    <span class="footer-icon-txt">Friedrichstraße 171<br> 10117 Berlin </span>
                                </li>
                                <li class="list-group-item">
                            <span class="footer-kontakt-icon">
                                <i class="fa fa-phone"></i>
                            </span>
                                    <span class="footer-icon-txt">
                                <a href="{{ config('buch.company.phone_no_link') }}">{{ config('buch.company.phone_no') }}</a>
                            </span>
                                </li>
                                <li class="list-group-item">
                            <span class="footer-kontakt-icon">
                                <i class="fa fa-envelope"></i>
                            </span>
                                    <span class="footer-icon-txt">
                                 <a href="mailto:{{ config('buch.company.email') }}"> {{ config('buch.company.email') }}</a>
                            </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-widget-title">
                            <p>Rechtliches</p>
                        </div>
                        <div class="rech-list">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="fa fa-angle-right"></i>
                                    <a href="{{ route('frontend.page.data_protection') }}">Datenschutz</a>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-angle-right"></i>
                                    <a href="{{ route('frontend.page.imprint') }}">Impressum</a>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-angle-right"></i>
                                    <a href="{{ getCustomerLoginUrl() }}">Login</a>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-widget-title">
                            <p>APP DOWNLOADEN</p>
                            <ul class="store-footer-icons">
                                <li>
                                    <a title="Google Play" target="_blank"
                                       href="https://play.google.com/store/apps/details?id=com.LS.buchkunstregister">
                                        <img src="{{ asset('assets/frontend/images/home-images/google-play.svg') }}"
                                             alt="play-store-icon">
                                    </a>
                                </li>
                                <li class="white-apple-icon">
                                    <a title="Apple store" target="_blank"
                                       href="https://apps.apple.com/in/app/buch-kunstregister/id1614838861">
                                        <img src="{{ asset('assets/frontend/images/home-images/white-apple-logo.svg') }}"
                                             alt="white-apple-logo">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </section>


        <!-- SUBFOOTER -->
        <div class="subfooter">
            <div class="row copyfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="copyright-txt">© Copyright <span id="currentYear">2021</span> buch-kunstregister
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p class="copy-txt-comp">Webdesign mit ♥ von <a href="https://listandsell.de/"
                                                                            target="_blank"
                                                                            rel="nofollow">Listandsell.de</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- ========== CONTACT NOTIFICATION ========== -->
<div id="contact-notification" class="notification fixed"></div>

@if(!request()->is('rueckruf'))
    <div id="forgot-password-modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Haben Sie Ihr Passwort vergessen?</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('frontend.user.forgot_password_query') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="account_no">Bibliotheknummer *</label>
                            <input id="account_no"
                                   placeholder="16-stellige Bibliotheksnummer"
                                   class="form-control"
                                   name="user_id"
                                   value="{{ old('user_id') }}"
                                   required
                            />
                        </div>
                        <div class="form-group">
                            <label for="username">Name *</label>
                            <input id="username"
                                   type="text"
                                   placeholder="Geben Sie Ihren Namen ein"
                                   class="form-control"
                                   name="username"
                                   value="{{ old('username') }}"
                                   required
                            />
                        </div>
                        <div class="form-group">
                            <label for="phone_no">Telefonnummer *</label>
                            <input id="phone_no"
                                   type="text"
                                   placeholder="+49XXXXXXXXXX"
                                   class="form-control"
                                   name="phone_no"
                                   value="{{ old('phone_no') }}"
                                   required
                            />
                        </div>
                        <div class="form-group mt-4">
                            <button class="btn btn-block btn-site btn-login">
                                Rückruf anfordern
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endif

<!-- ========== BACK TO TOP ========== -->
<div class="back-to-top">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</div>

@if(false)
    @include('cookieConsent::index')
@endif

@section('footer_script')
    <script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.mmenu.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/parallax.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/frontend/js/plugins.js') }}"></script> -->
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
@endsection
@yield('footer_script')

<script type="text/javascript">
    var year = new Date().getFullYear();
    document.getElementById('currentYear').innerHTML = year;
</script>

</body>
</html>
