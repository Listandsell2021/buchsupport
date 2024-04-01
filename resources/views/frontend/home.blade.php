@extends('frontend.layouts.main')

@section('main_content')

    <!-- ========== HOME BANNER ========== -->
    <section class="new-home-banner">

        <div class="banner-main d-flex justify-content-center flex-column container">
            <div class="mb-4">
                <button class="scam-btn" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-exclamation-triangle mr-2"></i> Achtung vor <strong>Betrugmasc...</strong>
                </button>
            </div>

            <h1 class="banner-title">Zentral, sicher <span>&</span> online </h1>
            <p class="banner-txt">Willkommen beim Buch- und Kunstregister, der ersten Anlaufstelle für alle Liebhaber
                von<br> kunsthistorischen Schätzen und Raritäten.

            </p>
            <div class="d-flex flex-row buttonflex">
                <a class="btn banner-left-btn" href="{{ getCustomerLoginUrl() }}">
                    <i class="fa fa-user"></i>JETZT REGISTRIEREN!
                </a>
                <a class="btn banner-right-btn" href="{{ route('frontend.page.contact') }}">
                    <i class="fa fa-user"></i>Kontaktieren Sie uns!
                </a>
            </div>
        </div>
    </section>

    <section class="vido-new-box">
        <div class="container">
            <h4 class="vidoe-tit">
                Schauen Sie sich unser Video an, lernen Sie unsere Dienstleistungen kennen und finden Sie heraus, wie
                wir <span class="forbowncolor">Ihnen helfen können.</h4>

            <div class="new-video-container">
                <div class="container">
                    <div class="embed-responsive embed-responsive-16by9 hello">
                        <video id="videobuch" preload="false"
                               poster="{{ asset('assets/frontend/images/video_bg.webp') }}" loop controls>
                            <source src="{{ asset('assets/frontend/video/BUCH-KUNSTREGISTER UPDATE.mp4') }}"
                                    type="video/mp4">
                        </video>
                    </div>
                </div>

                <div class="play-button-wrapper">
                    <div class="container">
                        <div title="Play video" class="play-gif" id="circle-play-b">
                            <!-- SVG Play Button -->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="512" height="512" x="0" y="0"
                                 viewBox="0 0 500 500" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                 class=""><g>
                                    <circle xmlns="http://www.w3.org/2000/svg" cx="250" cy="250" fill="#e3a40d" r="250"
                                            data-original="#f86252" class=""/>
                                    <path xmlns="http://www.w3.org/2000/svg"
                                          d="m216.759 182.093 86.936 50.193c13.636 7.873 13.636 27.555 0 35.428l-86.936 50.193c-13.636 7.873-30.682-1.968-30.682-17.714v-100.386c0-15.746 17.046-25.587 30.682-17.714z"
                                          fill="#ffffff" data-original="#ffffff" class=""/>
                                </g>
                                <p class="playtxt">Jetzt abspielen</p>
                            </svg>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </section>
    <!-- ========== ABOUT ========== -->
    <section class="about mt100 uber-uns" id="uber-uns">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h4 class="">Das weltweit führende <span
                                    class="forbowncolor"> Buch- & Kunstregister</span></h4>
                        <p class="section-subtitle">Das sind Wir</p>
                    </div>
                    <div class="info-branding">
                        <p>Das Buch & Kunstregister ist ein junger und doch schon bewährter Dienstleister in der
                            Verwaltung von und im Handel mit Buch- und Kunstsammlungen. Der exklusive Zugang zu unserer
                            Plattform soll dem Kunden ermöglichen, seine eigene Sammlung unkompliziert zu verwalten, das
                            Finden interessierter Käufer und attraktiver Angebote zu vereinfachen und einen sicheren und
                            unkomplizierten Handel zu betreiben. Die hohen Qualitätsansprüche unseres Unternehmens
                            bezüglich des Zustands und der Vollständigkeit der aufgenommenen Werke garantieren ein hohes
                            Maß an Sicherheit und Zufriedenheit bei jeder Transaktion.<br><br>Die bewährte
                            Zusammenarbeit mit renommierten Verlagshäusern und Vertriebsdiensten sowie deutschlandweit
                            und auch international agierenden Kunsthändlern gewährleistet ein besonders attraktives
                            Angebot und die größtmögliche Kompetenz. Die Erfassung und der Abgleich Ihrer Daten und die
                            visuelle Einbettung jedes Ihrer Produkte in das Gesamtsortiment gehört zu unseren
                            angebotenen Leistungen. Darüber hinaus stehen wir Ihnen bei Anliegen jeder Art gerne mit
                            unserer Expertise zur Verfügung. Das Angebot selbst ist den heutigen Anforderungen gemäß
                            komplett digitalisiert und stetig einer kritischen Auseinandersetzung unterworfen, um die
                            größtmögliche Qualität unserer Leistungen auch in Zukunft sicherzustellen.</p>
                        <a class="btn about-btn" href="/register">
                            <i class="fa fa-book"></i>REGISTER
                        </a>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="brand-info">
                        <div class="inner">
                            <div class="content">
                                <img src="/assets/frontend/images/home-images/books-logo-about.webp" alt="Image">
                                <div class="stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>

                                <p class="mt20">Wir sind weltweit das erste Unternehmen, das sowohl die Registrierung
                                    und digitale Erfassung exklusiver Bibliotheken anbietet, als auch die Plattform für
                                    den Handel bereitstellt. <br>

                                    Wir vereinen Buchliebhaber und Sammler aus aller Welt und ermöglichen unseren
                                    Kunden, ihre Leidenschaft mit den Vorzügen des digitalen Zeitalters zu vereinen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------BEKAUNT AUS SECTION------------------- -->
    <section class="bekannt-section">
        <div class="container">

            <div class="row bekaant">

                <div class="col-md-12">
                    <div class="flex-box-comp">
                        <div class="section-title"><h4>Bekannt <span class="forbowncolor">aus:</span></h4></div>
                        <div class="desc-logo">
                            <div class="section-description">Zu den Gastbeiträgen von E+K Buch-Kunstregister GmbH für
                                BUNTE.DE
                            </div>
                            <a class="Bekannt-link" href="https://unternehmen.bunte.de/faksimile-verkaufen.html"
                               target="_blank" rel="nofollow"><img class="bunt-img"
                                                                   src="/assets/frontend/images/home-images/bunte-logo.webp"></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- --------------------BEKAUNT AUS  END------------------ -->

    <!-- ========== ROOMS ========== -->
    <section class="rooms gray">
        <div class="container">
            <div class="section-title">
                <h4 class="domain-title">Ihre Vorteile mit dem <span class="forbowncolor">Buch- & Kunstregister</span>:
                </h4>

            </div>
            <div class="row">
                <!-- ITEM -->
                <div class="col-md-4">
                    <div class="room-grid-item">
                        <figure class="gradient-overlay-hover link-icon">
                            <a href="/register">
                                <img src="/assets/frontend/images/home-images/step1.webp" class="img-fluid" alt="Image">
                            </a>

                        </figure>
                        <div class="room-info">
                            <h2 class="room-title">
                                <!-- <a href="/register">Überblick behalten</a> -->
                            </h2>
                            <p>Das Buch- und Kunstregister verschafft ihnen einen Überblick über Ihre seit Jahren
                                gesammelten exklusiven Werke.</p>
                            <a href="/register" class="url-link">
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- ITEM -->
                <div class="col-md-4">
                    <div class="room-grid-item">
                        <figure class="gradient-overlay-hover link-icon">
                            <a href="/register">
                                <img src="/assets/frontend/images/home-images/step2.webp" class="img-fluid" alt="Image">
                            </a>

                        </figure>
                        <div class="room-info">
                            <h2 class="room-title">
                                <!-- <a href="/register">Einfach zu verwenden</a> -->
                            </h2>
                            <p>Ihre persönliche Bibliotheksnummer ermöglicht es ihren Ansprechpartnern, sich einen
                                unkomplizierten und vollständigen Überblick über ihre Sammlung zu verschaffen.</p>
                            <a href="/register" class="url-link">
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- ITEM -->
                <div class="col-md-4">
                    <div class="room-grid-item">
                        <figure class="gradient-overlay-hover link-icon">
                            <a href="/register">
                                <img src="/assets/frontend/images/home-images/step3.webp" class="img-fluid" alt="Image">
                            </a>

                        </figure>
                        <div class="room-info">
                            <h2 class="room-title">
                                <!-- <a href="/register">Generationenübergreifend</a> -->
                            </h2>
                            <p> Die Registrierung und digitale Erfassung Ihrer Sammlung ermöglicht die unkomplizierte
                                Weitergabe von Generation zu Generation und gewährleistet, dass Ihre exklusive
                                Bibliothek dauerhaft vollständig und überschaubar bleibt.</p>
                            <a href="/register" class="url-link">
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ========== SERVICES ========== -->
    <section class="services ">
        <div class="container">
            <div class="section-title">
                <h4 class="steps-title">In 3 einfachen Schritten zur Registrierung Ihrer <span class="forbowncolor">  exklusiven Bibliothek</span>
                </h4>
                <!-- <p class="section-subtitle">Check out our awesome services</p> -->
            </div>
            <div class="row">
                <div class="col-lg-7 col-12">
                    <!-- <div data-slider-id="services" class="services-owl owl-carousel"> -->
                    <div class="services-owl owl-carousel">
                        <figure class="service-owl-img">
                            <img src="/assets/frontend/images/gallery/bookslider1.webp" class="img-fluid" alt="Image">
                        </figure>
                        <figure class="service-owl-img">
                            <img src="/assets/frontend/images/gallery/bookslider2.webp" class="img-fluid" alt="Image">
                        </figure>
                        <figure class="service-owl-img">
                            <img src="/assets/frontend/images/gallery/bookslider3.webp" class="img-fluid" alt="Image">
                        </figure>
                        <figure class="service-owl-img">
                            <img src="/assets/frontend/images/gallery/bookslider4.webp" class="img-fluid" alt="Image">
                        </figure>
                        <figure class="service-owl-img">
                            <img src="/assets/frontend/images/gallery/bookslider5.webp" class="img-fluid" alt="Image">
                        </figure>
                        <figure class="service-owl-img">
                            <img src="/assets/frontend/images/gallery/bookslider6.webp" class="img-fluid" alt="Image">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="owl-thumbs term" data-slider-id="services">
                        <div class="owl-thumb-item">
                  <span class="media-left">
                   <i class="fa fa-phone"></i>
                  </span>
                            <div class="media-body">
                                <a href="/rueckruf">
                                    <h5>Termin vereinbaren</h5>
                                    <p>Kontaktieren Sie uns und vereinbaren Sie heute noch einen Termin mit einem
                                        unserer Vertriebsmitarbeiter. Gerne beraten wir Sie auch telefonisch.</p>
                                </a>
                            </div>
                        </div>
                        <div class="owl-thumb-item werke">
                  <span class="media-left">
                    <i class="fa fa-upload"></i>
                  </span>
                            <div class="media-body">
                                <h5>Werke hochladen und veröffentlichen</h5>
                                <p>Nach dem Registrierungsgespräch werden die nun offiziell erfassten Werke auf unserer
                                    Online-Plattform hochgeladen und veröffentlicht. Sie sind somit weltweit einsehbar
                                    für Liebhaber exklusiver Buchkunst, die auf der Suche nach bestimmten Sammlerstücken
                                    sind.</p>
                            </div>
                        </div>
                        <div class="owl-thumb-item verw">
                  <span class="media-left">
                     <i class="fa fa-book"></i>
                  </span>
                            <div class="media-body">
                                <h5>Verwalten und vernetzen</h5>
                                <p>Durch Ihre persönlichen Zugangsdaten können Sie jederzeit Ihre nunmehr online
                                    dargestellte Sammlung verwalten oder andere exklusive Bibliotheken betrachten.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ========== RESTAURANT ========== -->
    <section class="restaurant image-bg parallax gradient-overlay op5"
             data-src="/assets/frontend/images/home-images/video-book.webp"
             data-parallax="scroll" data-speed="0.3" data-mirror-selector=".wrapper" data-z-index="0">
        <div class="container">

            <div class="row">
                <!-- ITEM -->
                <div class="col-md-7">
                    <div class="section-title library-card-number">
                        <h4>Sie können durch die Eingabe einer Bibliotheksnummer gezielt nach Bibliotheken suchen und so
                            weitere Meisterwerke der <span
                                    class="forbowncolor">Buchkunst kennenlernen</span>.</h4>

                    </div>
                    <div class="home-search">

                        <div class="Vip-search">
                            <form action="#">
                                <input class="vip-search-textfield"
                                       id="vip-search-textfield"
                                       placeholder="16-stellige Bibliotheksnummer"
                                       type="text">
                                <button class="search-txt-btn">Bibliothek suchen</button>
                            </form>
                        </div>
                        <div class="search-error-msg">Es gibt keine registrierte Bibliothek mit dieser Nummer!</div>
                    </div>
                </div>
                <!-- ITEM -->
                <div class="col-md-5">
                    <div class="restaurant-menu-item">
                        <div class="img-fadeInRight book-container">
                            <div class="book">
                                <img alt="The Outstanding Developer by Sebastien Castiel"
                                     src="/assets/frontend/images/home-images/book_cover.webp">
                            </div>
                        </div>
                        <!-- <img class="card-number" src="/assets/frontend/images/home-images/new-library-card.webp"></img> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== NEW-SECTIONS ==========-->
    <section class="news">
        <div class="container">
            <div class="section-title">
                <h4 class="title">Diese Funktionen bietet das Online <span
                            class="forbowncolor"> Buch- &  Kunstregister</span></h4>
                <p class="section-subtitle">Unsere langjährige Expertise und das hohe Maß an Digitalisierung
                    gewährleisten das maximale Kundenerlebnis.</p>
                <!-- <a href="blog.html" class="view-all">View Showroom</a> -->
            </div>
            <div class="row">
                <!-- ITEM -->
                <div class="col-md-4">
                    <div class="news-grid-item">
                        <figure class=" link-icon">

                            <i class="fa fa-gears"> </i>

                        </figure>
                        <div class="news-info">
                            <h4 class="title">
                                Verwaltung
                            </h4>
                            <p>Als registrierter Kunde können Sie die Angaben zu bestehenden Werken ändern oder löschen
                                oder gar neue Werke hinzufügen. Sie können aber auch selbstverständlich uns kontaktieren
                                und uns mitteilen, was geändert werden soll. Wir kommen Ihren Anliegen dann unverzüglich
                                nach.
                            </p>

                        </div>
                    </div>
                </div>
                <!-- ITEM -->
                <div class="col-md-4">
                    <div class="news-grid-item">
                        <figure class=" link-icon">

                            <i class="fa fa-line-chart"> </i>

                        </figure>
                        <div class="news-info">
                            <h4 class="title">
                                Analyse
                            </h4>
                            <p>Wir stellen eine Fülle von Informationen zu den einzelnen Werken zur Verfügung. So finden
                                sich beispielsweise Angaben zum Inhalt, zur Entstehung, die jeweilige Kategorie u.ä. zu
                                jedem einzelnen Stück der Bibliothek. Wir nehmen auch gerne Wünsche und Anregungen auf
                                für Veränderungen oder neue Funktionen. Sie können uns jederzeit Ihre Ideen mitteilen.
                                Diese werden dann bei den regelmäßigen Aktualisierungen der Internetseite
                                berücksichtigt.
                            </p>

                        </div>
                    </div>
                </div>
                <!-- ITEM -->
                <div class="col-md-4">
                    <div class="news-grid-item">
                        <figure class=" link-icon">

                            <i class="fa fa-clock-o"> </i>

                        </figure>
                        <div class="news-info">
                            <h4 class="title">
                                Präsentation
                            </h4>
                            <p>Sie möchten die Sichtbarkeit Ihrer Bibliothek erhöhen? Kein Problem. Sie haben die
                                Möglichkeit, Ihre Sammlung in unserem Showroom auszustellen, um mehr Besucher auf Ihre
                                Bibliothek zu führen. Im Showroom können auch gezielt verschiedene veröffentlichte Werke
                                gesucht werden. In der Detailansicht des Produktes werden die verschiedenen
                                registrierten Bibliotheken aufgezeigt, in denen sich das gesuchte Buch befindet. </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== TESTIMONIALS ========== -->
    <section class="testimonials gray">
        <div class="container">
            <div class="section-title">
                <h4>Meinungen von Kundinnen und <span class="forbowncolor">Kunden</span></h4>
                <!-- <p class="section-subtitle">What our guests are saying about us</p> -->
            </div>
            <div class="owl-carousel testimonials-owl">

                @foreach($reviews as $review)
                    <div class="item">
                        <div class="testimonial-item">

                            <div class="author">
                                <h4 class="name">{{ getSingleLetterFirstName($review->user_name) }}</h4>
                            </div>
                            <div class="rating">
                                <i class="fa fa-star voted" aria-hidden="true"></i>
                                <i class="fa fa-star voted" aria-hidden="true"></i>
                                <i class="fa fa-star voted" aria-hidden="true"></i>
                                <i class="fa fa-star voted" aria-hidden="true"></i>
                                <i class="fa fa-star voted" aria-hidden="true"></i>
                            </div>
                            <p>{{ $review->text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- ---------------APP SECTIONS------------------- -->
    <section class="app-section">
        <div class="container">

            <div class="row appbadgerow">

                <div class="col-md-6">
                    <div class="container">
                        <h3 class="app-title">Sammlung ganz einfach <span>offline verwalten</span></h3>
                        <p class="app-txt">Mit der Buch-Kunstregister App können Sie Ihre Buch- und Kunstsammlungen ganz
                            bequem vom Smartphone aus verwalten.</p>
                        <ul class="applist">
                            <li><span class="listbold">1 Verwaltung:</span> Schaffen Sie Überblick und Ordnung</li>
                            <li><span class="listbold">2 Showroom:</span> Präsentieren Sie Ihre Bibliothek</li>
                            <li><span class="listbold">3 Entdecken:</span> Entdecken Sie neue Meisterwerke</li>
                            <li><span class="listbold">4 Networking:</span> Vernetzen Sie sich mit anderen
                                Kunstliebhabern
                            </li>
                        </ul>

                        <p class="app-txt second">Laden Sie sich jetzt die App im Google Play Store oder App Store
                            runter. So haben Sie auch von unterwegs Ihre Sammlungen im Blick - jederzeit und von
                            überall, auch offline!</p>

                        <div class="download-app-title">Mobile App downloaden</div>
                        <ul class="mobile-app-badges">
                            <li><a target="_blank"
                                   href="https://play.google.com/store/apps/details?id=com.LS.buchkunstregister"><img
                                            src="/assets/frontend/images/home-images/gooogle-play-store-badge.webp"></a>
                            </li>
                            <li class="last-app-list"><a target="_blank"
                                                         href="https://apps.apple.com/in/app/buch-kunstregister/id1614838861">
                                    <img src="/assets/frontend/images/home-images/apple-play-store-badge.webp"></a></li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-6 app-col-img">
                    <img class="old-man" src="/assets/frontend/images/home-images/Mobile-apps-banner.webp">
                </div>
            </div>
    </section>
    <!-- --------------------APP SECTION END------------------ -->









    <!-- ========== EVENTS ========== -->
    <section class="events">
        <div class="container">
            <div class="section-title">
                <h4>Neue <span class="forbowncolor">Werke</span></h4>
                <p class="section-subtitle"></p>
                <a href="{{ route('frontend.get_show_room') }}" class="view-all">Bibliotheken</a>
            </div>
            <div class="events-owl owl-carousel">

                @foreach($latestProducts as $product)
                    <div class="event-item">
                        <div class="top-image-box">
                            <div class="card">
                                <div class="card-top-icon">
                                    <a class="card-link ribbion">
                                        <i class="fa fa-bookmark"></i>
                                        <span class="card-number">{{ $product->quantity }}</span>
                                    </a>
                                </div>
                                <img class="card-img-top"
                                     src="{{ $product->images->count() > 0 ? url('storage/products/'.$product->images->first()->image_path) : asset('assets/frontend/images/300_400.webp') }}"
                                     alt="{{ $product->images->first()?->name }}"
                                />
                                <div class="card-body newwork-content">
                                    <a href="#" class="card-link greenstatus">
                                        <span class="green-top-txt">{{ getProductCondition($product->condition) }}</span>
                                    </a>
                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                    <div class="card-links-list nav-pills nav-fill">
                                        @if(!empty($product->category_name))
                                            <span>{{ $product->category_name }}</span>
                                        @endif
                                        <a href="{{ route('frontend.get_book', ['id' => $product->id]) }}"
                                           data-toggle="tooltip" data-placement="top" title="Mehr erfahren"
                                           class="btn-next"
                                        >
                                            <i class="fa fa-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- ========== FAQ's ========== -->
    <section class="faq">
        <div class="container2">
            <div class="section-title">
                <h4>Häufig gestellte <span class="forbowncolor">Fragen</span></h4>
                <p class="section-subtitle" style="text-align: center;display: block;">Wir haben die häufigsten Fragen
                    und Antworten für Sie zusammengefasst.</p>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <img class="old-man" src="/assets/frontend/images/home-images/faq-left-image.webp">
                </div>
                <div class="col-md-7">
                    <div class="container">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Wie kann man Mitglied werden / Wie kann man ein Konto anlegen?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        Einer unserer Experten betrachtet vor Ort die zur Registrierung ausgewählten
                                        Werke. Dabei werden der Zustand des Produktes bewertet und der Kaufpreis sowie
                                        das Kaufdatum durch eine entsprechende Rechnung ausgewiesen. Abschließend werden
                                        die einzelnen Titel samt der gewonnenen Informationen schriftlich erfasst.
                                        Nach dem Termin erhält der registrierte Kunde eine Willkommens-Box mit
                                        entsprechenden Dokumenten und einer Kundenkarte mit der persönlichen
                                        Registrierungsnummer. Diese ermöglicht Ihnen den Zugriff auf ihr Kundenkonto auf
                                        unserer Online-Plattform.

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapseThree" aria-expanded="true"
                                           aria-controls="collapseThree">
                                            Welche Vorteile genieße ich als Kunde?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse  collapse in show" role="tabpanel"
                                     aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        Der exklusive Zugang zu unserer Plattform ermöglicht unseren Kunden, ihre eigene
                                        Sammlung auf Papier und digital registrieren zu lassen und unkompliziert zu
                                        verwalten. Sollte kein Internetzugang zur Verfügung stehen, ist es auch möglich,
                                        dass die Verwaltung von uns übernommen wird. Das Finden interessierter Käufer
                                        und attraktiver Angebote wird durch die Kooperation mit verschiedenen
                                        renommierten Verlagshäusern und international tätigen Buch- und Kunstsammlern
                                        erheblich erleichtert.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingfour">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapsefour" aria-expanded="false"
                                           aria-controls="collapsefour">
                                            Betreiben Sie Handel auf Ihrer Seite?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsefour" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingfour">
                                    <div class="panel-body">
                                        Nein. Wir selbst kaufen und verkaufen keine Produkte. Wir bieten unseren Kunden
                                        die Möglichkeit, ihre Sammlungen potentiellen Interessenten zu präsentieren. Bei
                                        einem eventuellen Kaufinteresse stellen wir den Kontakt her. Wir sind weder an
                                        den konkreten Verhandlungen beteiligt, noch erhalten wir eine Beteiligung der
                                        Kaufsumme.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== UNSER TEAM ========== -->
    <section class="services unser-team das-team" id="das-team">
        <div class="container">
            <div class="section-title">
                <h4 class="steps-title">Unser <span class="forbowncolor">Team</span></h4>

            </div>
            <p class="team-txt2">
                Unsere Experten betreuen Sie kompetent und umfassend, telefonisch oder vor Ort. Durch unsere langjährige
                Erfahrung im Umgang mit Kunden und dem digitalen Registrierungssystem können wir Sie bestmöglich durch
                unsere Plattform führen. Die umfassende Ausbildung, die professionellen Arbeitsstrukturen und die
                Förderung des Potentials eines jeden Mitarbeiters, haben unsere hochmotivierten Mitarbeiter sowohl im
                Innen- als auch im Außendienst zu hohem Ansehen sowohl in der Branche als auch bei unseren Kunden
                geführt. Unsere Experten stellen höchste Ansprüche an sich selbst und das Unternehmen und haben sich zu
                lebenslangem Lernen verpflichtet. Kundenorientierung und die zeitnahe Erfüllung der Anforderungen
                unserer Kunden stellen einen wesentlichen Aspekt unserer Arbeit dar und werden sehr wichtig genommen.
            </p>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card mb-3 book-cards">
                        <img class="card-img-top"
                             src="/assets/frontend/images/home-images/uber-images.webp"
                             alt="buch-kunstregister">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="mailto:{{ config('buch.company.email') }}">
                                    <i class="fa fa-envelope"></i> {{ config('buch.company.email') }}
                                </a>
                            </h5>
                            <p class="card-text">
                                <a href="tel:{{ config('buch.company.phone_no_link') }}" class="phone-call">
                                    <i class="fa fa-phone"></i>
                                    {{ config('buch.company.phone_no') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 teamcolbox">


                    <div class="box-number2">

                        <div class="media-body">

                            <h5>Engagiert</h5>
                            <p>Jeder Mitarbeiter kann im Buch Kunst Register sein volles Potenzial entfalten. Dies
                                geschieht in der besten Arbeitsumgebung, die die Bedürfnisse der Mitarbeiter
                                berücksichtigt.</p>

                        </div>
                    </div>
                    <div class="box-number2">

                        <div class="media-body">

                            <h5>Professionell</h5>
                            <p>Die Mitarbeiter von Buch Kunst Register stellen höchste Ansprüche an das Unternehmen und
                                sich selbst und alle verpflichten sich zu lebenslangem Lernen.</p>

                        </div>
                    </div>
                    <div class="box-number3">

                        <div class="media-body">

                            <h5>Kundenorientiert</h5>
                            <p>Unser Team erfüllt die sich ständig ändernden Anforderungen unserer Kunden und ist
                                bereit, diese Herausforderungen umfassend zu meistern.</p>

                        </div>
                    </div>
                    <a class="btn about-btn" href="/register">
                        <i class="fa fa-book"></i>Bibliotheken
                    </a>


                </div>
            </div>
        </div>
    </section>


    <!-- professional-section-->
    <section class="team-professional-row" id="unser-team">
        <div class="container">
            <h4 class="teamtitle">Lernen Sie unser <span>Team kennen!</span></h4>
            <ul>
                @foreach($members as $member)
                    <li>
                        <div class="avatar-img">
                            @if($member->gender == 'female')
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="60" height="60" x="0"
                                     y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512"
                                     xml:space="preserve" class=""><g>
                                        <g xmlns="http://www.w3.org/2000/svg" id="Woman">
                                            <path d="m52.128 60h-41.5a2.082 2.082 0 0 1 -2.073-2.2c.517-9.049 2.274-10.833 4.895-12.521 1.077-.694 9.5-3.53 11.459-5.338a1.663 1.663 0 0 0 .091-1.689c-.453-.346-3.268.417-6.234-.409a12.663 12.663 0 0 1 -4.407-2.23 2.084 2.084 0 0 1 -.2-3.1c1.526-1.522 2.884-2.462 3.553-9.267a27.343 27.343 0 0 0 .063-3.576c-.427-15.28 12.625-18.414 18.233-13.576a1.029 1.029 0 0 0 .749.243c5.556-.4 7.87 7.239 8.356 12.655a28.429 28.429 0 0 1 -.127 5.829c-.221 2.2-.683 4.931 2.4 7.779a2.052 2.052 0 0 1 -.375 3.3 16.053 16.053 0 0 1 -4.858 1.835c-2.122.43-4.766-.029-5.174.38a1.589 1.589 0 0 0 .034 1.5c4.3 3.791 10.561 4.8 12.458 6.426 2 1.721 4.452 5.163 4.727 11.788a2.082 2.082 0 0 1 -2.07 2.171zm-27.2-23.829a2.078 2.078 0 0 1 2.072 2.081c0 1.736.156 2.07-.9 3.065-2.8 2.645-10.178 4.742-11.574 5.641-1.789 1.151-3.344 2.153-3.91 9.872a1 1 0 0 0 1 1.082h39.522a1 1 0 0 0 1-1.066c-.354-4.11-1.812-7.307-3.964-9.289-2-1.847-5.714-1.6-12.173-6.346-1.23-.9-1-1.535-1-3.148a2.075 2.075 0 0 1 2.389-2.053 11.258 11.258 0 0 0 4.372-.236 14.105 14.105 0 0 0 3.062-.993 1.01 1.01 0 0 0 .353-1.56c-2.724-3.3-2.464-5.767-2.18-8.6a26.749 26.749 0 0 0 .125-5.451c-.358-3.995-2.189-11.434-6.469-10.809a2.037 2.037 0 0 1 -1.7-.525c-4.18-3.953-15.568-2.182-15.175 11.774a28.8 28.8 0 0 1 -.072 3.828c-.642 6.532-2.105 7.77-3.7 9.9a1.008 1.008 0 0 0 .239 1.446 11.941 11.941 0 0 0 3.055 1.133 10.892 10.892 0 0 0 5.629.254z"
                                                  fill="#d47b39" data-original="#000000" class=""/>
                                        </g>
                                    </g></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="60" height="60" x="0"
                                     y="0" viewBox="0 0 54 60" style="enable-background:new 0 0 512 512"
                                     xml:space="preserve" class=""><g>
                                        <path xmlns="http://www.w3.org/2000/svg" id="Shape"
                                              d="m.54 54.868c4.882 3.055 13.385 4.379 19.148 4.841 9.438.758 25.849.118 33.772-4.841.3069331-.1918474.486237-.5345795.4688135-.8961175s-.2288544-.6854395-.5528135-.8468825c-.89-.443-3.464-1.857-4.692-2.559-6.7-3.906-5.3-.051-12.684-7v-5.814c1.912-1.812 3.017-3.384 3.14-6.159 2.0756608-1.0515764 3.4749757-3.0855737 3.715-5.4.2-1 .605-3.7-.3-5.209 3.134-6.581 1.209-15-5.856-15.861-.986-1.365-4.309-5.123-10.989-5.123-7.836 0-14.71 6.5-14.71 13.9.025531 2.1802479.382271 4.3439532 1.058 6.417-1.663 1.176-1.138 4.706-.909 5.875.239023 2.3136562 1.636758 4.3475471 3.711 5.4.122 2.765 1.215 4.337 3.14 6.161v5.817c-1.4213258 1.390449-2.9637625 2.6514387-4.609 3.768-.82902.4916897-1.7324759.8453041-2.675 1.047-2.9.513-4.5 1.754-9.627 4.5-.428.228-.985.4-1.018 1.084-.01845034.3625849.16106476.7066874.469.899zm47.144-2.568c1.031.589 2.077 1.164 3.129 1.733-3.9684017 1.6673351-8.1559063 2.7554666-12.434 3.231 1.7499009-2.0647192 2.9057607-4.5662015 3.344-7.237 1.73.587 2.527.273 5.961 2.273zm-6.8-26.444c-.0081137.0406244-.0137905.0816978-.017.123-.1431169 1.2861762-.7758733 2.4678945-1.767 3.3-.1159006-1.3177302-.0179702-2.6455319.29-3.932.0222542-.0843444.0353301-.1708464.039-.258 0-.911-.026-1.65-.051-2.2.034-.276.229-.892 1.306-.892.037 0 .115.009.173.011.295.392.368 2.131.027 3.846zm-15.174-23.856c6.789 0 9.465 4.416 9.574 4.6.1786283.30939322.5087435.49999092.866.5h.269c.228.014 5.581.4 5.581 7.7-.0106775 1.7993872-.4162214 3.5744952-1.188 5.2-.0646197-.0034873-.1293803-.0034873-.194 0-.4936322.0002639-.9823395.0981413-1.438.288-.888-7.9-3.823-9.759-4.176-9.954-.4683221-.2590791-1.0576063-.1034939-1.337.353-2.635 4.3-8.962 4.92-8.937 4.922h-5.22c-3.088 0-5 1.512-5.118 4.037-.008.149-.013.318-.014.5-.0986137-.0313414-.19874-.0577079-.3-.079-.6858952-1.9850287-1.0498268-4.0670006-1.078-6.167 0-6.228 6.058-11.9 12.71-11.9zm-12.572 23.982c-.0031394-.0432954-.0088158-.0863694-.017-.129-.365-1.817-.26-3.668.049-3.874.579.085 1.228.039 1.3.658.056.5.033.966.266 3.255.200287 1.1151961.2560795 2.2515475.166 3.381-.9887979-.8297727-1.6204317-2.008178-1.764-3.291zm3.708 4.9c.1536525-1.672659.1180942-3.3573141-.106-5.022-.2241493-2.0331101-.3413109-4.076594-.351-6.122.025-.528.1-2.138 3.121-2.138h5.307c.28-.024 6.45-.615 9.853-4.875 2.284 2.9 2.753 8.517 2.76 12.221-.2314804 1.0094133-.3555042 2.0404865-.37 3.076 0 3.15.793 5.339-2.223 8.07-3.474 3.156-3.401 5.908-6.137 5.908-4.743 0-4.7.418-6.6-2.375-.7170416-1.0934472-1.5374774-2.1154757-2.45-3.052-1.842-1.84-2.759-2.773-2.804-5.693zm1.154 15.395v1.723c0 .5522847.4477153 1 1 1s1-.4477153 1-1v-7.894c1.474 2.094 2.413 3.894 5.3 3.894 5.512 0 5.655.441 8.7-3.894v7.894c0 .5522847.4477153 1 1 1s1-.4477153 1-1v-1.723c1.1735529 1.1045834 2.4611083 2.0813958 3.841 2.914-.367 2.283-1.621 7.176-5.709 8.527-4.7435806.3754983-9.5094194.3754983-14.253 0-4.1-1.347-5.353-6.243-5.72-8.528 1.3796244-.8326139 2.6671448-1.8090646 3.841-2.913zm-11.677 6.017c3.416-1.99 4.233-1.683 5.954-2.269.4380456 2.670858 1.5939282 5.1723899 3.344 7.237-4.2780937-.4755334-8.46559832-1.5636649-12.434-3.231 1.052-.569 2.1-1.145 3.136-1.737z"
                                              fill="#d47b39" data-original="#000000" class=""/>
                                    </g></svg>
                            @endif
                        </div>
                        <div class="avatar-title">{{ ucfirst(substr($member->first_name, 0, 1)) }}
                            . {{ ucfirst($member->last_name) }}</div>
                    </li>
                @endforeach

            </ul>
        </div>

    </section>
    <!-- professional-section-->


    <!-- ========== GALLERY ========== -->
    <section class="gallery galerie" id="galerie">
        <div class="">
            <div class="section-title">
                <h4>Galerie</h4>

            </div>
            <div class="gallery-owl owl-carousel image-gallery">
                <!-- ITEM -->
                @foreach($galleryImages as $galleryImage)
                    <div class="gallery-item">
                        <figure class="gradient-overlay image-icon">
                            <a href="{{ asset($galleryImage->src) }}">
                                <img src="{{ asset($galleryImage->src) }}" alt="Image">
                            </a>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('page_title', 'Buch Kunst Register | Verwaltung mit Buch- & Kunstsammlungen')
@section('page_meta_props')
    @parent
    <meta name="description"
          content="Buch Kunst Register | Verwaltung und Handel mit Buch- und Kunstsammlungen | Jetzt registrieren und interessierte Käufer und attraktive Angebote finden!"/>
@endsection

@section('header_styles')
    @parent

    <style>
        section.footer-form-section {
            padding-top: 0;
        }
    </style>

@endsection

@section('footer_script')
    @parent
    <script src="{{ asset('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/owl.carousel.thumbs.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.cookie.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main-home.js') }}"></script>

    <!-- ProvenExpert ProSeal Widget -->
    <noscript>
        <a href="https://www.provenexpert.com/de-de/ek-...mpaign=...;" target=" _blank" title="Kundenbewertungen &
        Erfahrungen zu E+K Buch-Kunstregister GmbH. " class="pe-pro-seal-more-infos">Mehr Infos</a>
    </noscript>
    <script src="https://s.provenexpert.net/seals/proseal.js" ;></script>
    <script id="proSeal">
        window.addEventListener('load', function (event) {
            window.provenExpert.proSeal({
                widgetId: "83fed057-e051-4c0b-8ee9-483d8b8237b7",
                language: "de-DE",
                bannerColor: "#0DB1CD",
                textColor: "#FFFFFF",
                showReviews: true,
                hideDate: false,
                hideName: false,
                bottom: "208px",
                stickyToSide: "right",
                googleStars: true,
                zIndex: "9999",
            })
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!-- ProvenExpert ProSeal Widget -->

    <script>
        $('#user_id').inputmask({"mask": "9999 9999 9999 9999"});
    </script>
    <script>
        $(document).ready(function () {
            if ($.cookie('pop') == null) {
                $('#myModal').modal('show');
                $.cookie('pop', '1');
            }
        });</script>
    <script>
        $(document).ready(function () {
            $('#vip-search-textfield').inputmask({
                mask: '9999 9999 9999 9999',
                placeholder: ' ',
                showMaskOnHover: false,
                showMaskOnFocus: false,
                onincomplete: function () {
                    $('.search-error-msg').hide();
                }
            });

            $('.search-txt-btn').on('click', function (e) {
                e.preventDefault();
                var user_id = $('.vip-search-textfield').val().replace(/\s/g, '');
                console.log(user_id);
                var count_input = user_id.length;

                if (count_input == 16) {
                    $.ajax({
                        url: '{{ route('frontend.search_customer') }}',
                        type: 'GET',
                        data: {
                            'user_id': user_id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.data.is_available) {
                                window.location.href = '{{ url('/libraries') }}/' + user_id;
                                return;
                            }
                            $('.search-error-msg').show();
                        },
                        error: function (request, error) {
                            alert("Request: " + JSON.stringify(request));
                        }
                    });
                } else {
                    $('.search-error-msg').show();
                }
            });
        });
    </script>
@endsection


