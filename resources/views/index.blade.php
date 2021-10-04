<!doctype html>
<head>
    <meta charset="utf-8">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                    <div class="px-2">
                        <form>
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}"/>
                            <div class="form-group">
                                <label for="baseCurrency">Base Currency</label>
                                <!--Wow. CSP is working-->
                                <select class="form-control" id="baseCurrency" style="height:auto;" name="baseCurrency">
                                    <!--Wow. CSP is working-->
                                    @foreach($supportedCurrencies as $supportedCurrency)
                                        <hr class="custom-hr-heading"/>
                                        @if ($supportedCurrency !== 'EUR')
                                            <option value="{{$supportedCurrency}}">{{$supportedCurrency}}</option>
                                        @else
                                            <option selected value="{{$supportedCurrency}}">{{$supportedCurrency}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger" id="baseError"></span>
                            </div>
                            <div class="form-group">
                                <label for="targetCurrency">Target Currency</label>
                                <select class="form-control" id="targetCurrency" name="targetCurrency">
                                    @foreach($supportedCurrencies as $supportedCurrency)
                                        <hr class="custom-hr-heading"/>
                                        @if ($supportedCurrency !== 'USD')
                                            <option value="{{$supportedCurrency}}">{{$supportedCurrency}}</option>
                                        @else
                                            <option selected value="{{$supportedCurrency}}">{{$supportedCurrency}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger" id="targetError"></span>
                            </div>
                            <div class="form-group">
                                <label for="value">Value</label>
                                <input type="number" min="0.00" step="0.01" value="1.00" id="value" class="form-control" placeholder="Value">
                                <span class="text-danger" id="valueError"></span>
                            </div>
                            <button type="button" id="convertButton" class="btn btn-primary">Convert</button>
                        </form>
                        <div id="result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
