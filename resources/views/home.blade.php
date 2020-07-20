<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABCLeague</title>
    <link rel="stylesheet" href="https://media.readthedocs.org/css/sphinx_rtd_theme.css" type="text/css" />

    <script src="_static/js/modernizr.min.js"></script>

    <link rel="stylesheet" href="https://media.readthedocs.org/css/readthedocs-doc-embed.css" type="text/css" />
    <script type="text/javascript" src="_static/readthedocs-data.js"></script>

    <!-- Add page-specific data, which must exist in the page js, not global -->
    <script type="text/javascript">
        READTHEDOCS_DATA['page'] = 'preface'
        READTHEDOCS_DATA['source_suffix'] = '.rst'
    </script>

    <script type="text/javascript" src="_static/readthedocs-dynamic-include.js"></script>

    <!-- end RTD <extrahead> --></head>

<body class="wy-body-for-nav" role="document">
<div class="wy-grid-for-nav">
    <nav data-toggle="wy-nav-shift" class="wy-nav-side">
        <div class="wy-side-scroll">
            <div class="wy-side-nav-search">
                <a href="/" class="icon icon-home"> Szybko i na temat </a>
                <div role="search">
                    <form id="rtd-search-form" class="wy-form" action="search.html" method="get">
                        <input type="text" name="q" placeholder="Search docs" />
                        <input type="hidden" name="check_keywords" value="yes" />
                        <input type="hidden" name="area" value="default" />
                    </form>
                </div>
            </div>

            <div class="wy-menu wy-menu-vertical" data-spy="affix" role="navigation" aria-label="main navigation">
{{--                <ul class="current">--}}
{{--                    <li class="toctree-l1 current"><a class="current reference internal" href="#">Preface to the API Design Guide</a></li>--}}
{{--                    <li class="toctree-l1"><a class="reference internal" href="copyright.html">Copyright</a></li>--}}
{{--                    <li class="toctree-l1"><a class="reference internal" href="principles/index.html">Principles</a></li>--}}
{{--                    <li class="toctree-l1"><a class="reference internal" href="build_and_publish/index.html">Building and using APIs</a></li>--}}
{{--                    <li class="toctree-l1"><a class="reference internal" href="secure_apis.html">Secure APIs</a></li>--}}
{{--                    <li class="toctree-l1"><a class="reference internal" href="operate_and_improve_apis.html">Operate and improve APIs</a></li>--}}
{{--                </ul>--}}



            </div>
        </div>
    </nav>

    <section data-toggle="wy-nav-shift" class="wy-nav-content-wrap" style="background-color: #ffffff !important">
        <div class="wy-nav-content" style="background-color: #ffffff !important">
            <div class="rst-content">
                <div role="navigation" aria-label="breadcrumbs navigation">
                    <ul class="wy-breadcrumbs">
                        <li>Prototyp dokumentacji</li>
                        <li class="wy-breadcrumbs-aside">
                        </li>
                    </ul>
                    <hr/>
                </div>
                <div role="main" class="document" itemscope="itemscope" itemtype="http://schema.org/Article">
                    <div itemprop="articleBody">
                        <div class="section" id="preface-to-the-api-design-guide">
                            <h1>Metody GET - sprawy ogólne<a class="headerlink" href="#preface-to-the-api-design-guide" title="Permalink to this headline">¶</a></h1>
                            <p><strong>Konta</strong>.</p>
                            <p>GET /accounts </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca konta</p>
                                </div></blockquote>
                            <p>GET /accounts/region/{id] </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca konta z regionu o danym id</p>
                                </div></blockquote>
                            <p>GET /accounts/{id] </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca konta o danym id np. 50 oraz ILOŚć kodów</p>
                                </div></blockquote>
                            <p>GET /accounts/regionname/{regionname} </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca konta z danego regionu gdzie REGIONNAME == EUNE, EUW, NA, OCE itd.</p>
                                </div></blockquote>




                            <p><strong>Regiony</strong>.</p>
                            <p>GET /regions </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca regiony</p>
                                </div></blockquote>
                            <p>GET /region/{id} </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca informacje o regionie</p>
                                </div></blockquote>
                            <p>GET /available/regions </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca regiony w których konta nie są outofstock</p>
                                </div></blockquote>

                            <p><strong>Opinie</strong>.</p>
                            <p>GET /reviews </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca opinie</p>
                                </div></blockquote>
                            <p>GET /reviews/add/{tekst}/{author}/{stars} </p>
                            <blockquote class="epigraph">
                                <div><p>Dodawanie opinii - postujesz: "tekst", "author", "stars"</p>
                                </div></blockquote>

                            <p>GET /reviews/sum </p>
                            <blockquote class="epigraph">
                                <div><p>Informacje o opiniach (ilość i jakość)</p>
                                </div></blockquote>

                            <p><strong>Pomocnicze</strong>.</p>
                            <p>GET /currency </p>
                            <blockquote class="epigraph">
                                <div><p>Zwraca walute w zależności od tego w jakim kraju jesteś + zwraca ContinentCode (możliwe: AF, AN, AS, EU, NA, OC, SA) </p>
                                </div></blockquote>
                            <p>GET /convert/{price}/{curr}/{curr_sec} </p>
                            <blockquote class="epigraph">
                                <div>
                                    <p>price: cena obecna, curr: cena z jakiej konwertujesz, curr_sec: cena na jaką konwertujesz</p>
                                </div></blockquote>
                            <p>GET /coupon </p>
                            <blockquote class="epigraph">
                                <div>
                                    <p>Zwraca kupony </p>
                                </div></blockquote>

                            <h1>Płatności<a class="headerlink" href="#preface-to-the-api-design-guide" title="Permalink to this headline">¶</a></h1>
                            <p>POST /pay_paypal </p>
                            <bleevockquote class="epigraph">
                                <div>
                                    <p>Dane do wysłania: email, currency, price, quantity, description</p>
                                    <p>Dane powrotne: sam zobaczysz, jakby czegoś brakowało to wywali error code 500 albo empty </p>
                                </div></bleevockquote>

                            <p>POST /pay_stripe </p>
                            <blockquote class="epigraph">
                                <div>
                                    <p>Pobiera pieniądze z konta i informuje czy się udało (NIGDY NIE CALLUJ BEZ MOJEJ ZGODY BO JEST WERSJA LIVE (pobierze Ci hajs z konta))</p>
                                    <p>Dane do wysłania: price, name, currency, email, token <- token jest tworzony przez JS Stripe który sprawdza dane karty przed utworzeniem tokenu)</p>
                                    <p>Dane powrotne: success or failed </p>
                                </div></blockquote>

                            <p>GET /verify/{orderid} </p>
                            <blockquote class="epigraph">
                                <div>
                                    <p>Dane do wysłania: orderid</p>
                                    <p>Dane powrotne: info o zakupie </p>
                                </div></blockquote>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>






<script type="text/javascript">
    var DOCUMENTATION_OPTIONS = {
        URL_ROOT:'./',
        VERSION:'0.1',
        COLLAPSE_INDEX:false,
        FILE_SUFFIX:'.html',
        HAS_SOURCE:  true,
        SOURCELINK_SUFFIX: '.txt'
    };
</script>
<script type="text/javascript" src="https://media.readthedocs.org/javascript/jquery/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="https://media.readthedocs.org/javascript/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://media.readthedocs.org/javascript/underscore.js"></script>
<script type="text/javascript" src="https://media.readthedocs.org/javascript/doctools.js"></script>
<script type="text/javascript" src="https://media.readthedocs.org/javascript/readthedocs-doc-embed.js"></script>








<script type="text/javascript">
    jQuery(function () {
        SphinxRtdTheme.StickyNav.enable();
    });
</script>


</body>
</html>
