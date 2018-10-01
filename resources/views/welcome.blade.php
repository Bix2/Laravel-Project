<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="welcome-page">
<div class="container">
    <div id="main" class="row">
        <div class="logo"> 
            <svg height="151" viewbox="0 0 255 151" width="255" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d)">
                <path d="M5.53553 63.4645L63 6L68.5 11.5L13 67L63 117L179.5 0.5L185 6L66.5355 124.464C64.5829 126.417 61.4171 126.417 59.4645 124.464L5.53553 70.5355C3.58291 68.5829 3.58291 65.4171 5.53553 63.4645Z" fill="white"></path>
            </g>
            <g filter="url(#filter1_d)">
                <path d="M249.172 78.8284L191 137L185.5 131.5L241 76L191 26L74.5 142.5L69 137L188.172 17.8284C189.734 16.2663 192.266 16.2663 193.828 17.8284L249.172 73.1716C250.734 74.7337 250.734 77.2663 249.172 78.8284Z" fill="white"></path>
            </g>
            <defs>
                <filter color-interpolation-filters="sRGB" filterunits="userSpaceOnUse" height="133.429" id="filter0_d" width="188.929" x="0.0710602" y="0.5">
                    <feflood flood-opacity="0" result="BackgroundImageFix"></feflood>
                    <fecolormatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></fecolormatrix>
                    <feoffset dy="4"></feoffset>
                    <fegaussianblur stddeviation="2"></fegaussianblur>
                    <fecolormatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></fecolormatrix>
                    <feblend in2="BackgroundImageFix" mode="normal" result="effect1_dropShadow"></feblend>
                    <feblend in="SourceGraphic" in2="effect1_dropShadow" mode="normal" result="shape"></feblend>
                </filter>
                <filter color-interpolation-filters="sRGB" filterunits="userSpaceOnUse" height="133.843" id="filter1_d" width="189.343" x="65" y="16.6569">
                    <feflood flood-opacity="0" result="BackgroundImageFix"></feflood>
                    <fecolormatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></fecolormatrix>
                    <feoffset dy="4"></feoffset>
                    <fegaussianblur stddeviation="2"></fegaussianblur>
                    <fecolormatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></fecolormatrix>
                    <feblend in2="BackgroundImageFix" mode="normal" result="effect1_dropShadow"></feblend>
                    <feblend in="SourceGraphic" in2="effect1_dropShadow" mode="normal" result="shape"></feblend>
                </filter>
            </defs>
            </svg>

        </div>
        <div class="container container--welcome"> 
            <a href="login/fitbit/" class="btn btn-outline-primary">Login with FitBit</a>
        </div>

    </div>

    <footer class="footer">
        @include('includes.footer')
    </footer>

</div>
</body>
</html>
