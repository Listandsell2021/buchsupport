@extends('frontend.layouts.main')

@section('main_content')

    <section class="contact-container">

        <div class="container">

            <h3 class="text-center m-b-30">Registrierung</h3>

            @include('frontend.common.success_message')

            @include('frontend.common.error_message')


            <form class="registration-form" method="post"
                  action="{{ route('frontend.page.registration') }}"
                  style="margin-bottom: 120px;"
            >
                @csrf

                <div class="form-group">
                    <label>Anrede *</label>
                    <div>
                        <input type="radio"
                               name="gender"
                               id="female"
                               value="female"
                               {{ old('gender') == 'female' ? 'checked' : '' }}
                               class="m-r-5"
                        />
                        <label for="female" class="m-r-15">Frau</label>

                        <input type="radio"
                               name="gender"
                               id="male"
                               value="male"
                               {{ old('gender') == 'male' ? 'checked' : '' }}
                               class="m-r-5"
                        />
                        <label for="male">Herr</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="first_name">Vorname *</label>
                            <input type="text"
                                   class="form-control"
                                   name="first_name"
                                   id="first_name"
                                   placeholder="Vorname eingeben"
                                   value="{{ old('first_name') }}"
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="last_name">Nachname *</label>
                            <input type="text"
                                   class="form-control"
                                   name="last_name"
                                   id="last_name"
                                   placeholder="Nachname eingeben"
                                   value="{{ old('last_name') }}"
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Adresse *</label>
                            <input type="text"
                                   class="form-control"
                                   name="address"
                                   id="address"
                                   placeholder="Adresse eingeben"
                                   value="{{ old('address') }}"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zip">Postleitzahl *</label>
                            <input type="text"
                                   class="form-control"
                                   name="zip"
                                   id="zip"
                                   placeholder="Postleitzahl eingeben"
                                   value="{{ old('zip') }}"
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">Stadt *</label>
                            <input type="text"
                                   class="form-control"
                                   name="city"
                                   id="city"
                                   placeholder="Stadt eingeben"
                                   value="{{ old('city') }}"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Land *</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">Wählen Sie ein Land</option>
                                @foreach(getCountries() as $country)
                                    <option {{ $country == old('country') ? 'selected' : '' }} value="{{ $country }}">
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Passwort *</label>
                            <input type="password"
                                   class="form-control"
                                   name="password"
                                   id="password"
                                   placeholder="Eingeben Passwort"
                                   value="{{ old('password') }}"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Passwort bestätigen *</label>
                            <input type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Eingeben Passwort bestätigen"
                                   value="{{ old('password_confirmation') }}"
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Geburtstag *</label>
                            <input type="text"
                                   class="form-control"
                                   name="dob"
                                   id="dob"
                                   placeholder=""
                                   value="{{ old('dob') }}"
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_first_name">Sekundär Vorname</label>
                            <input type="text"
                                   class="form-control"
                                   name="secondary_first_name"
                                   id="secondary_first_name"
                                   placeholder="Eingeben Sekundär Vorname"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_last_name">Sekundär Nachname</label>
                            <input type="text"
                                   class="form-control"
                                   name="secondary_last_name"
                                   id="secondary_last_name"
                                   placeholder="Eingeben Sekundär Nachname"
                            />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-dark px-2 mt-2 w-100">Neues Profil anlegen</button>
                </div>

            </form>
        </div>
    </section>

@endsection

@section('header_styles')
    @parent
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('footer_script')
    @parent
    <script src="{{ asset('frontend/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('#dob').datepicker({
            autoclose:true,
            language:"de-DE",
            format:"dd.mm.yyyy"
        });
    </script>
@endsection

@section('page_title', 'Buch Kunst Register | Registrieren Sie sich jetzt auf unserer Plattform!')

@section('page_meta_props')
    @parent
    <meta name="description" content="Buch Kunst Register | Verwalten Sie Ihre Buch- und Kunstsammlungen online | Finden Sie interessierte Käufer und attraktive Angebote | Jetzt registrieren!" />
@endsection


