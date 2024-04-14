<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="{{ public_path('admin/css/bootstrap.min.css') }}">
    <style>

        .main-container {
            margin-top: 90px;
            margin-left: auto;
            width: 505px;
            margin-right: auto;
            color: #000;
        }
        .main-container .main-title {
            text-align: center;
            font-size: 20px;
            letter-spacing: 3.7px;
            margin-bottom: 100px;
            line-height: 1.2;
            font-weight: 400;
        }
        .main-container .input-box {
            /*background-color: #F1F4FF;*/
            font-size: 14px;
            text-align: center;
            display: block;
            width: 100%;
            height: 30px;
            padding-top: 6px;
            color: #333;
            font-weight: bold;
        }
        .main-container .description-content {
            font-size: 15px;
            line-height: 1.4;
            text-align: center;
            text-align-last: center;
        }


        .page_break {
            page-break-before: always;
        }

        .main-container-2 {
            margin-top: 125px;
            margin-left: auto;
            width: 560px;
            margin-right: auto;
            color: #000;
        }
        .main-container-2 .main-title {
            text-align: center;
            font-size: 20px;
            letter-spacing: 3.7px;
            margin-bottom: 115px;
            line-height: 1.2;
            font-weight: 400;
        }
        .main-container-2 .user-form-content {
            margin-bottom: 70px;
            margin-left: -15px;
            margin-right: -15px;
        }
        .main-container-2 .table td, .table th {
            padding: 15px;
            border-width: 0;
            width: 50%;
        }
        .main-container-2 .input-box {
            border-bottom: 1px solid #222;
            font-size: 14px;
            text-align: center;
            display: block;
            width: 100%;
            height: 30px;
            padding-top: 6px;
            color: #333;
            font-weight: bold;
        }
        .main-container-2 .form-group {
            margin-bottom: 5px;
        }
        .main-container-2 .form-label {
            font-size: 11px;
            font-weight: normal;
            display: block;
            text-align: center;
            margin-top: 2px;
        }
        .main-container-2 .description-content {
            text-align: center;
            font-size: 15px;
            line-height: 1.4;
        }
        .main-container-2 .c-page-link {
            text-decoration: none;
            font-weight: bold;
            color: #000;
        }


        .user-wrapper {
            padding: 50px 30px;
        }

        .user-wrapper .export-table {
            margin-top: 10px;
        }

        .user-wrapper .bigger-table {
            margin-top: 50px !important
        }

        .user-wrapper .w-100 {
            width: 100% !important
        }

        .user-wrapper .export-facts {
            margin-bottom: 20px;
        }

        .user-wrapper .thead-primary {
            color: black
        }

        .user-wrapper .user-card {
            margin-top: 10px;
        }

        .user-wrapper .site-padding {
            padding: 0 15px;
        }

        .user-wrapper .page_break {
            page-break-before: always;
        }

        .user-wrapper .page-bottom {
            position: fixed;
            width: 100%;
            height: 50px;
            text-align: center;
            bottom: 10;
            left: 0;
        }

        .user-wrapper .page-number:before {
            content: counter(page);
        }

        div.blueTable {
            background-color: #FFFFFF;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            padding: 0 15px;
        }

        .user-wrapper .divTable.blueTable .divTableCell {
            padding: 8px 0;
        }

        .user-wrapper .divTable.blueTable .divTableHead {
            padding: 12px 0;
        }

        .user-wrapper .divTable.blueTable .divTableBody .divTableCell {
            font-size: 13px;
        }

        .user-wrapper .divTable.blueTable .divTableRow:nth-child(even) {
            background: #D0E4F5;
        }

        .user-wrapper .divTable.blueTable .divTableHeading .divTableHead {
            font-size: 15px;
            font-weight: normal;
            color: #000000;
            border-left: 0px solid #D0E4F5;
        }

        .user-wrapper .divTable.blueTable .divTableHeading .divTableHead:first-child {
            border-left: none;
        }

        /* DivTable.com */
        .user-wrapper .divTable {
            display: table;
            border-collapse: collapse;
        }

        .user-wrapper .divTableRow {
            display: table-row;
        }

        .user-wrapper .divTableCell, .divTableHead {
            display: table-cell;
            border-bottom: 1px solid rgb(221, 220, 220);
        }

        .user-wrapper .divTableHeading {
            display: table-header-group;
        }

        .user-wrapper .divTableBody {
            display: table-row-group;
        }
    </style>
</head>
<body>
<div class="main-container">
    <h3 class="main-title">HERZLICH WILLKOMMEN</h3>
    <div class="form-group">
        <div class="input-box">Sehr geehrter
            @if($user->gender == 'male')
                Herr
            @elseif($user->gender == 'female')
                Frau
            @endif
            {{ $user->last_name }}</div>
    </div>
    <div class="description-content">
        auf diesem Wege möchten wir uns herzlich bei Ihnen für Ihr Vertrauen in
        uns und unsere Produkte bedanken. Wir heißen Sie hiermit herzlich bei uns
        willkommen.<br/><br/>
        Mit dem Auftrag der Registrierung Ihrer Bibliothek wird Ihnen die Möglichkeit
        geboten, Ihre Werke für Sie und jeden anderen Buchliebhaber auf unserer
        Homepage www.buch-kunstregister.de kenntlich zu machen. Ihnen wird
        in diesem Zuge eine personalisierte Registrierungsnummer vergeben, so
        dass Sie künftig in den exklusiven Kundenkreis etabliert werden. Wir führen
        Bibliophile Liebhaber und Buchsammler auf unserer Plattform zusammen,
        die aufgrund der kontinuierlich hohen Nachfrage, nun Ihre Werke entdecken
        und gegebenenfalls nachfragen können.<br/><br/>
        Sollten Sie einen Wunsch oder eine Anregung haben, sprechen Sie uns bitte
        jederzeit darauf an. Wir stehen neuen Ideen und Anregungen stets offen
        gegenüber und werden versuchen, jedem Wunsch nachzukommen. Unser
        Ziel ist es, dass Sie nicht nur zufrieden, sondern begeistert von uns und
        unserer Dienstleistung sind. Sollten wir dies erreicht haben, würden wir uns
        freuen, wenn Sie Ihre Begeisterung mit uns und natürlich auch mit anderen
        teilen.<br/><br/>
        Wann immer Sie ein Anliegen an uns haben, zögern Sie nicht, uns zu kon-
        taktieren. Unser zuverlässiges Expertenteam steht Ihnen allzeit engagiert
        zur Beratung und Betreuung ihrer exklusiven Sammlung zur Verfügung.<br/><br/>
        In diesem Sinne freuen wir uns auf eine erfolgreiche Zusammenarbeit.<br/>
        <br/>
        Mit freundlichen Grüßen<br/><br/><br/>
        Lead Kompass
    </div>
</div>

<div class="page_break"></div>
<br/>

<div class="main-container-2">
    <h3 class="main-title">REGISTRIERUNGSBESTÄTIGUNG</h3>
    <div class="user-form-content">
        <table class="table table-borderless">
            <tr>
                <td>
                    <div class="form-group">
                        <div class="input-box">{{ $user->first_name." ".$user->last_name }}</div>
                        <label class="form-label">Name</label>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="input-box">{{ chunk_split($user->id, 4, ' ') }}</div>
                        <label class="form-label">Ihre Bibliotheks-ID-Nummer</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <div class="input-box">{{ getDateInGermany($user->created_at) }}</div>
                        <label class="form-label">Registrierungsdatum</label>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="input-box">{{ $user->password_text }}</div>
                        <label class="form-label">Passwort</label>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="description-content">
        Ihre Bibliothek wurde von uns unter oben angegebener ID-Nummer <br/>
        registriert und kann ab sofort unter <a href="www.buch-kunstregister.de" class="c-page-link">www.buch-kunstregister.de</a><br/>
        abgerufen werden.<br/><br/>
        Die Anmeldung erfolgt anhand ihrer ID-Nummer und des <br/>
        oben genannten Passworts.<br/><br/>
        Ihr Passwort können Sie in Ihrem persönlichen Zugangsbereich<br/>
        jederzeit ändern. Bei Fragen wenden Sie sich bitte unter<br/>
        der Telefonnummer <a href="tel:030-520045118" class="c-page-link">030-520 04 51 18</a> an unser
        Expertenteam.<br/><br/>
        Vielen Dank für Ihre Registrierung!
    </div>
</div>

<div class="page_break"></div>
<br/>


<div class="user-wrapper">
    <?php $pageno = 1; ?>
    <div class="user-card site-padding">
        <h3 class="card-title">ID: {{ $user->id }}</h3>
        <h5 class="card-subtitle mb-2">{{ $user->first_name }} {{ $user->last_name }}</h5>
        @if($user->secondary_first_name && $user->secondary_last_name)
            <h5 class="card-subtitle mb-2">{{ $user->secondary_first_name }} {{ $user->secondary_last_name }}</h5>
        @endif
        <h5 class="card-subtitle mb-2">{{ $user->street }}, {{ $user->postal_code }} {{ $user->city }}
            , {{ $user->country }}</h5>
        <h5 class="card-subtitle mb-2">Geburtsdatum: {{ getDateInGermany($user->birth) }}</h5>
    </div>

    <div class="export-facts site-padding">
        <h6>
            Produkte: {{ $productCount }} <br>
            Preis insgesamt: {{ $sumProducts }} @if($user->country !== 'Schweiz') € @else Franken @endif <br>
            Preis-Durchschnitt: {{ $avgPrice }} @if($user->country !== 'Schweiz') € @else Franken @endif <br>
            Mitgliedschaft: {{ $user->membership_title }}<br>
            Durchschnittlicher Zustand: {{$avgCondition}} von 5 Punkten<br>
            Registriert seit: {{ getDateInGermany($user->created_at) }}
        </h6>
    </div>
    <h3 class="site-padding">Produkt-Übersicht</h3>
    @if($productCount !== 0)
        <div class="smaller-table">
            <div class="divTable blueTable">
                <div class="divTableHeading">
                    <div class="divTableRow">
                        <div class="divTableHead">Titel</div>
                        <div class="divTableHead">Preis
                            @if($user->country === 'Schweiz'){{ '(Fr)' }}@else{{'(€)'}}@endif
                        </div>
                        <div class="divTableHead">Kaufdatum</div>
                        <div class="divTableHead">Zustand</div>
                    </div>
                </div>
                <div class="divTableBody">
                    @foreach ($firstPageProducts as $product)
                        <div class="divTableRow">
                            <div class="divTableCell" style="width: 55%">
                                {{ $product->name }}
                            </div>
                            <div class="divTableCell">
                                {{ getNumberInGermanFormat($product->pivot->price) }}
                            </div>
                            <div class="divTableCell">
                                {{ \Carbon\Carbon::parse($product->pivot->purchased_date)->format('d.m.Y') }}
                            </div>
                            <div class="divTableCell">
                                {{ getProductCondition($product->pivot->condition) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="page-bottom">
            <span>Seite {{ $pageno }}
                @if($totalPage > 1)
                    von {{ $totalPage }}
                @endif
            </span>
        </div>
    @else
        <div class="page-bottom">
            <span>Seite {{ $pageno }} von {{ $totalPage }}</span>
        </div>
    @endif
    @if($productCount !== 0)
        @foreach ($afterPageProducts->chunk(18) as $chunk)
            <div class="page_break"></div>
            <br/><br/><br/>
            <div class="divTable blueTable bigger-table">
                <div class="divTableHeading">
                    <div class="divTableRow">
                        <div class="divTableHead">Titel</div>
                        <div class="divTableHead">Preis
                            @if($user->country === 'Schweiz'){{ '(Fr)' }}@else{{'(€)'}}@endif
                        </div>
                        <div class="divTableHead">Kaufdatum</div>
                        <div class="divTableHead">Zustand</div>
                    </div>
                </div>
                <div class="divTableBody">
                    @foreach($chunk as $product)
                        <div class="divTableRow">
                            <div class="divTableCell" style="width: 55%">
                                {{ $product->name }}
                            </div>
                            <div class="divTableCell">
                                {{ getNumberInGermanFormat($product->pivot->price) }}
                            </div>
                            <div class="divTableCell">
                                {{ \Carbon\Carbon::parse($product->pivot->purchased_date)->format('d.m.Y') }}
                            </div>
                            <div class="divTableCell">
                                {{ getProductCondition($product->pivot->condition) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="page-bottom">
                <span>Seite {{ ++$pageno }} von {{ $totalPage }}</span>
            </div>
        @endforeach
    @endif
</div>


</body>
</html>
