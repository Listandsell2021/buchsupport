@extends('frontend.layouts.main')

@section('main_content')

    <div class="page-main-content">
        <div class="container">
            <div class="legal__wrapper row flex-column text-center">
                <h1>Impressum</h1>
                <p>
                    E+K Buch-Kunstregister GmbH <br />Gf Erkan Kirikci und Kadir Elevit
                    <br />
                    Friedrichstraße 171<br />10117 Berlin<br />Deutschland
                </p>
                <p>
                    Tel.: <a class="link" href="tel:{{ config('buch.company.phone_no_link') }}">{{ config('buch.company.phone_no') }}</a
                    ><br />E-Mail:
                    <a class="link" href="mailto:{{ config('buch.company.email') }}"
                    >{{ config('buch.company.email') }}</a
                    >
                </p>
                <p>
                    Handelsregister Berlin-Charlottenburg<br />Registernummer: HRB 221154 B
                </p>
                <p>
                    Plattform der EU-Kommission zur Online-Streitbeilegung:
                    <a class="link" href="https://ec.europa.eu/odr"
                    >https://ec.europa.eu/odr</a
                    >
                </p>
                <p>
                    Wir sind zur Teilnahme an einem Streitbeilegungsverfahren vor einer
                    Verbraucherschlichtungsstelle weder verpflichtet noch bereit.
                </p>
            </div>
        </div>
    </div>

@endsection

@section('page_title', 'Impressum')
@section('header_styles')
    @parent

   <style>

footer{
    margin-top: 0;
}
section.footer-form-section{
        padding-top: 0;
}
@media (max-width: 1199px){
footer:before{
    display: none;
}
  </style>


@endsection
