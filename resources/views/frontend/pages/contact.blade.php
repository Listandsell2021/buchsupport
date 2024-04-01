@extends('frontend.layouts.main')

@section('main_content')

    <section class="contact-container">

        <div class="container">

            @include('frontend.common.query_message')

            @include('frontend.common.error_message')

            @include('flash::message')

            <form class="footerform" method="post"
                  action="{{ route('frontend.contact_form') }}"
                  style="margin-bottom: 120px;"
            >
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
                                           class="form-control"
                                           id="first_name"
                                           name="first_name"
                                           placeholder="Vorname (Optional)"
                                           value="{{ old('first_name') }}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    <input type="text"
                                           class="form-control"
                                           id="last_name"
                                           name="last_name"
                                           placeholder="NachName (Optional)"
                                           value="{{ old('last_name') }}"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text"
                                       class="form-control"
                                       name="user_id"
                                       id="user_id"
                                       placeholder="ID (Optional)"
                                       value="{{ old('user_id') }}"
                                />
                                <small id="callback_id" class="form-text text-muted">
                                    Falls sie bereits einen Account haben, geben Sie bitte Ihre ID an.
                                </small>
                            </div>
                            <div class="col-md-6">
                                <input type="text"
                                       id="callback_number"
                                       class="form-control"
                                       name="callback_number"
                                       value="{{ old('callback_number') }}"
                                       required
                                       placeholder="Rückruf-Nummer *"
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
                                       {{ old('callback_agree') == 1 ? 'checked' : '' }}
                                       required
                                />
                                <label for="callback_permission" class="form-check-label">
                                    Ich besätige hiermit, dass die E+K Buch-Kunst Register GmbH mich unter der
                                    angegebenen Rückruf-Nummer kontaktieren darf.
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox"
                                       id="privacy_policy"
                                       class="form-check-input"
                                       name="privacy_policy"
                                       {{ old('privacy_policy') == 1 ? 'checked' : '' }}
                                       value="1"
                                       required
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
                        </div>

                        <div class="mt-3">
                            <a href="#" class="forgot-password-link" data-toggle="modal" data-target="#forgot-password-modal">
                                Passwort vergessen?
                            </a>
                        </div>

                    </div>
            </form>

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
        </div>
    </section>

@endsection

@section('page_title', 'Buch Kunst Register | Jetzt Rückruf anfordern!')
@section('page_meta_props')
    @parent
    <meta name="description" content="Sie haben Fragen? Buch Kunst Register | Verwaltung und Handel mit Buch- und Kunstsammlungen | Fordern Sie jetzt Ihren persönlichen Rückruf an!" />
@endsection

@section('footer_script')
    @parent

    <script src="{{ asset('frontend/js/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#account_no').inputmask({
                mask: '9999 9999 9999 9999',
                placeholder: ' ',
                showMaskOnHover: false,
                showMaskOnFocus: false,
            });
        });
    </script>
@endsection

