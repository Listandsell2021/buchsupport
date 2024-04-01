<template>

    <div>
        <!-- ========== MOBILE MENU ========== -->
        <nav id="mobile-menu"></nav>
        <!-- ========== WRAPPER ========== -->
        <div class="wrapper">
            <!-- ========== TOP MENU ========== -->
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
                                    <img width="26px" src="/frontend/images/google-play.svg" alt="google play"/>
                                </a>
                            </li>
                            <li class="d-none d-md-inline">
                                <a target="_blank" title="Apple store"
                                   href="https://apps.apple.com/in/app/buch-kunstregister/id1614838861">
                                    <img width="26px" src="/frontend/images/apple-black.svg"  alt="apple"/>
                                </a>
                            </li>
                            <li class="d-none d-md-inline">
                                <a :href="'tel:'+HelperUtils.trimSpace(BuchSetting.company.phone_no)">
                                    <i class="fa icon-phone"></i> {{ BuchSetting.company.phone_no }}
                                </a>
                            </li>
                            <li class="d-none d-md-inline">
                                <a :href="'mailto:'+BuchSetting.company.email">
                                    <i class="fa icon-envelope-open-o"></i>{{ BuchSetting.company.email }}</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <!-- ========== HEADER ========== -->
            <header class="horizontal-header sticky-header" data-menutoggle="1199">
                <div class="container">
                    <div class="brand">
                        <div class="logo">
                            <a :href="PageUrl.frontend.home">
                                <img src="/frontend/images/logo.png" alt="Logo">
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
                            <li class="menu-item "><a :href="PageUrl.frontend.home">Start</a></li>
                            <li class="menu-item "><a :href="PageUrl.frontend.home+'#uber-uns'">Über uns</a></li>
                            <li class="menu-item "><a :href="PageUrl.frontend.home+'#das-team'">Das Team</a></li>
                            <li class="menu-item "><a :href="PageUrl.frontend.home+'#galerie'">Galerie</a></li>
                            <li class="menu-item "><a :href="PageUrl.frontend.home+'#kontaktform'">Kontakt</a></li>
                            <li class="menu-item menu-btn sam">
                                <a :href="PageUrl.frontend.showroom" class="btn">
                                    <i class="fa icon-book"></i>
                                    Sammlung
                                </a>
                            </li>
                            <li class="menu-item menu-btn user">
                                <a href="/login" class="btn">
                                    <i class="fa icon-user"></i>
                                    Login
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </header>

            <div class="main-content-wrapper">
                <slot></slot>
            </div>

            <!-- ========== FOOTER ========== -->
            <footer id="main-footer">

                <section class="footer-form-section">
                    <div class="container">
                        <div class="newsletter-sec" id="kontaktform">

                            <form class="footerform" method="post"
                                  action="/frontend/contact_form">
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
                                                           value=""
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
                                                           value=""
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text"
                                                       class="form-control"
                                                       name="user_id"
                                                       id="user_id"
                                                       placeholder="ID (Optional)"
                                                       value=""
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
                                                       value=""
                                                />
                                            </div>
                                            <div class="col-md-12">
                                        <textarea rows="3"
                                                  id="callback_note"
                                                  placeholder="Notiz (Optional) &#10; Zusätzliche Informationen für den Rückruf"
                                                  class="form-control"
                                                  name="callback_note"
                                        ></textarea>
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
                                                />
                                                <label for="callback_permission" class="form-check-label">
                                                    Ich bestätigte hiermit, dass die E+K Buch-Kunst Register GmbH mich unter
                                                    der angegebenen Rückruf-Nummer kontaktieren darf.
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox"
                                                       id="privacy_policy"
                                                       class="form-check-input"
                                                       name="privacy_policy"
                                                       value="1"
                                                       required
                                                />
                                                <label for="privacy_policy" class="form-check-label">
                                                    Beim Absenden des Formulars werden wir Ihre Daten für den Zweck der
                                                    Kontaktaufnahme
                                                    verarbeiten.
                                                    <a class="footer-form-privcacy" target="_blank"
                                                       href="/frontend/page/data_protection">
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

                <section class="col-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="footer-logo" src="/frontend/images/white-logo2.png" alt="footer logo"/>
                                <p class="logo-txt">
                                    Eine ausgewählte Büchersammlung ist und bleibt der Brautschatz des
                                    Geistes und des Gemütes.
                                </p>
                            </div>
                            <div class="col-md-4">
                                <div class="footer-widget-title">
                                    <p>Kontakt</p>
                                </div>
                                <div class="kontakt-list">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span class="footer-kontakt-icon">
                                                <i class="fa icon-ma"></i>
                                            </span>
                                            <span class="footer-icon-txt">
                                                {{ BuchSetting.company.street }}<br>
                                                {{ BuchSetting.company.postal_code }}
                                                {{ BuchSetting.company.city }}
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="footer-kontakt-icon">
                                                <i class="fa icon-phone"></i>
                                            </span>
                                            <span class="footer-icon-txt">
                                                <a :href="'tel:'+HelperUtils.trimSpace(BuchSetting.company.phone_no)">{{ BuchSetting.company.phone_no }}</a>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="footer-kontakt-icon">
                                                <i class="fa icon-mail"></i>
                                            </span>
                                            <span class="footer-icon-txt">
                                                 <a :href="'mailto:'+BuchSetting.company.email">{{ BuchSetting.company.email }}</a>
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
                                            <i class="fa icon-angle-right"></i>
                                            <a :href="PageUrl.frontend.data_protection">Datenschutz</a>
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fa icon-angle-right"></i>
                                            <a :href="PageUrl.frontend.imprint">Impressum</a>
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fa icon-angle-right"></i>
                                            <a :href="PageUrl.frontend.login">Login</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer-widget-title">
                                    <p>APP DOWNLOADEN</p>
                                    <ul class="store-footer-icons">
                                        <li>
                                            <a title="Google Play"
                                               target="_blank"
                                               :href="BuchSetting.company.playstore_link"
                                            >
                                                <img src="/frontend/images/google-play.svg" alt="play store icon">
                                            </a>
                                        </li>
                                        <li class="white-apple-icon">
                                            <a title="Apple store"
                                               target="_blank"
                                               :href="BuchSetting.company.applestore_link"
                                            >
                                                <img src="/frontend/images/white-apple-logo.svg" alt="apple store icon">
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
                                    <p class="copyright-txt">
                                        © Copyright
                                        <span id="currentYear">{{ year }}</span>
                                        {{ BuchSetting.company.name }}
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <p class="copy-txt-comp">Webdesign mit ♥ von
                                        <a href="https://listandsell.de/"
                                            target="_blank"
                                            rel="nofollow">
                                            Listandsell.de
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

        <!-- ========== CONTACT NOTIFICATION ========== -->
        <div id="contact-notification" class="notification fixed"></div>

        <!-- ========== BACK TO TOP ========== -->
        <div class="back-to-top">
            <i class="fa icon-angle-up" aria-hidden="true"></i>
        </div>

    </div>

</template>
<script setup>
import '../assets/scss/custom/frontend.scss';
import "../assets/frontend/css/font-roboto.css";
import "../assets/frontend/css/fontello.css";
import "../assets/frontend/css/bundle.css";
import "../assets/frontend/css/responsive.css";
import "../assets/frontend/css/jquery.mmenu.css";
import "../assets/frontend/css/owl.carousel.min.css";
import "../assets/frontend/css/magnific-popup.css";
import "../assets/frontend/css/custom_style.css";
import "../assets/frontend/css/frontend.css";
import BuchSetting from "@/storage/data/buch";
import PageUrl from "@/storage/data/pageurl";
import HelperUtils from "../libraries/utils/helpers/HelperUtils";

const year = new Date().getFullYear();



</script>