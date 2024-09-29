@extends('layouts.master')
@section('title', 'Register')
{{-- @section('content') --}}

@section('style')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <!-- Img SVG Section Start -->
        <div class="left">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500">
                <g id="freepik--Shadow--inject-354">
                    <ellipse id="freepik--path--inject-354" cx="250" cy="416.24" rx="193.89" ry="11.32"
                        style="fill:#f5f5f5"></ellipse>
                </g>
                <g id="freepik--bubble-speech--inject-354">
                    <path
                        d="M397.08,127.61a16.17,16.17,0,0,0-1.63-7.24c-.94-1.65-3.44-6-34.61-6v-1c31.75,0,34.27,4.42,35.48,6.54a17.07,17.07,0,0,1,1.75,7.7Z"
                        style="fill:#263238"></path>
                    <path d="M395.94,144.92l-1-.23a93.35,93.35,0,0,0,1.72-9.51l1,.13A90.49,90.49,0,0,1,395.94,144.92Z"
                        style="fill:#263238"></path>
                    <path
                        d="M393.28,121.6c-4.19-7.36-63.18-4.8-74.12-1.66-14.8,4.26-21.45,42.47-22.58,51.69,0,0,8.69-9.12,16.35-11.43,3.65,1.28,43.88,8.31,51.37,10.31,8.56,2.29,17.65,0,21.83-7.46S397.65,129.29,393.28,121.6Z"
                        style="fill:#263238"></path>
                    <path
                        d="M380.05,132.25a2.19,2.19,0,0,1-.36,0c-27.9-4-60.19-1.15-60.51-1.12a2.5,2.5,0,1,1-.45-5c.33,0,33.2-2.91,61.67,1.15a2.5,2.5,0,0,1-.35,5Z"
                        style="fill:#fff"></path>
                    <path
                        d="M376,145.63a2.18,2.18,0,0,1-.44,0,295.41,295.41,0,0,0-61-4,2.5,2.5,0,0,1-.3-5,300.57,300.57,0,0,1,62.16,4,2.5,2.5,0,0,1-.42,5Z"
                        style="fill:#fff"></path>
                    <path
                        d="M359.48,159.33a2.72,2.72,0,0,1-.69-.09,156.54,156.54,0,0,0-47-5.71,2.5,2.5,0,0,1-.32-5,158.36,158.36,0,0,1,48.69,5.89,2.5,2.5,0,0,1-.69,4.9Z"
                        style="fill:#fff"></path>
                </g>
                <g id="freepik--Emoji--inject-354">
                    <path
                        d="M111.36,112.45c3.21-7.84,44.84-11.7,56.09-10,15.22,2.32,27.08,42.07,29,53,0,0-9.78-7.94-17.68-9.24-3.45,1.73-24.83,9.3-32.4,11-8.65,1.91-17.51,2.23-22.61-4.61S108,120.63,111.36,112.45Z"
                        style="fill:#263238"></path>
                    <path
                        d="M167.45,102.46c-11.25-1.72-52.88,2.15-56.08,10a12.85,12.85,0,0,0-.57,5.66c8,12.65,20.26,22.37,34.34,23,17.09.56,34.07-7.89,40.66-17.89C180.84,112.66,174.52,103.54,167.45,102.46Z"
                        style="opacity:0.1"></path>
                    <circle cx="161.37" cy="97.37" r="29.12" transform="translate(-14.78 164.4) rotate(-51.94)"
                        style="fill:#263238"></circle>
                    <circle cx="161.37" cy="97.37" r="29.12" transform="translate(-14.78 164.4) rotate(-51.94)"
                        style="fill:#fff;opacity:0.4"></circle>
                    <path
                        d="M160,88.32c.35.71-.71,1.84-2.37,2.52s-3.28.67-3.64,0,.71-1.84,2.37-2.52S159.62,87.62,160,88.32Z"
                        style="fill:#263238"></path>
                    <path
                        d="M152.22,81.18a16.57,16.57,0,0,1,5.88-1.09,19.08,19.08,0,0,1,3,.2,15.64,15.64,0,0,1,3,.74A1,1,0,0,1,163.9,83h0c-.78.09-1.65.26-2.48.43s-1.65.43-2.47.7a18.83,18.83,0,0,0-4.7,2.33A9.51,9.51,0,0,1,156,84.28a12.64,12.64,0,0,1,2.31-1.59,15.45,15.45,0,0,1,2.59-1.09,13.83,13.83,0,0,1,2.79-.63l-.27,1.92a24.14,24.14,0,0,0-2.64-.71c-.92-.21-1.84-.36-2.78-.49s-1.89-.25-2.85-.31S153.22,81.27,152.22,81.18Z"
                        style="fill:#263238"></path>
                    <path
                        d="M179.56,75.35a11.32,11.32,0,0,0-1.5.86,7.19,7.19,0,0,0-1.24,1,8.83,8.83,0,0,0-1,1.19,7.9,7.9,0,0,0-.76,1.29l-1.17-1a6.94,6.94,0,0,1,2-.84,7.15,7.15,0,0,1,2.11-.22,6.36,6.36,0,0,1,3.82,1.38,13.18,13.18,0,0,0-1.92-.26,8.64,8.64,0,0,0-1.84.08,9.24,9.24,0,0,0-1.74.44,8.68,8.68,0,0,0-1.56.74l0,0a.79.79,0,0,1-1.09-.25.8.8,0,0,1,0-.72,6.13,6.13,0,0,1,1-1.66A6.28,6.28,0,0,1,176,76.21a5.79,5.79,0,0,1,1.71-.75A5.09,5.09,0,0,1,179.56,75.35Z"
                        style="fill:#263238"></path>
                    <path
                        d="M184.13,82.75c.07.76-1.25,1.49-3,1.64S178,84,177.94,83.27s1.25-1.49,2.95-1.64S184.05,82,184.13,82.75Z"
                        style="fill:#263238"></path>
                    <path
                        d="M160.73,92.16a60.85,60.85,0,0,1,21.66-6.25,1.17,1.17,0,0,1,1.25,1c.83,8.52-14.74,13-23,7A1,1,0,0,1,160.73,92.16Z"
                        style="fill:#263238"></path>
                    <path
                        d="M176.25,90.61a7.73,7.73,0,0,0-1.49,1,6.37,6.37,0,0,0-4.34.56,6.13,6.13,0,0,0-3.59,4.3,19.11,19.11,0,0,0,6,.06,18.43,18.43,0,0,0,4.39-1.18,11.47,11.47,0,0,0,5.33-4C181.38,89.73,178.74,89.41,176.25,90.61Z"
                        style="fill:#263238"></path>
                </g>
                <g id="freepik--Heart--inject-354">
                    <path
                        d="M238.63,34.36C225.5,21.05,196.15,30.48,207.34,49s36.22,32,41.11,39.07c3.33-14.43,12.61-23.63,18.64-35.69S257.28,22.53,238.63,34.36Z"
                        style="fill:#263238"></path>
                    <path
                        d="M238.63,34.36C225.5,21.05,196.15,30.48,207.34,49s36.22,32,41.11,39.07c3.33-14.43,12.61-23.63,18.64-35.69S257.28,22.53,238.63,34.36Z"
                        style="opacity:0.30000000000000004"></path>
                </g>
                <g id="freepik--Character--inject-354">
                    <polygon points="287.68 315.58 295.52 315.58 327.85 416.24 325.23 416.24 287.68 315.58"
                        style="fill:#263238"></polygon>
                    <polygon points="255.98 315.58 263.83 315.58 276.07 416.24 273.45 416.24 255.98 315.58"
                        style="fill:#263238"></polygon>
                    <polygon points="210.3 315.58 202.45 315.58 170.13 416.24 172.75 416.24 210.3 315.58"
                        style="fill:#263238"></polygon>
                    <polygon points="241.99 315.58 234.15 315.58 221.91 416.24 224.53 416.24 241.99 315.58"
                        style="fill:#263238"></polygon>
                    <path
                        d="M280.93,337.89c-37.86.44-91.67-.82-115.46-47.41-16.12-31.57-33.36-98.62,13.87-117.79s119.76,2.47,119.07,39.59,38.22,46.21,51,71.48C365.2,315.15,330.82,337.31,280.93,337.89Z"
                        style="fill:#263238"></path>
                    <path
                        d="M280.93,337.89c-37.86.44-91.67-.82-115.46-47.41-16.12-31.57-33.36-98.62,13.87-117.79s119.76,2.47,119.07,39.59,38.22,46.21,51,71.48C365.2,315.15,330.82,337.31,280.93,337.89Z"
                        style="fill:#fff;opacity:0.7000000000000001"></path>
                    <path
                        d="M320.66,302.54c-.4,5.75-27.74,8.53-61.06,6.21s-54.38-4.08-60.48-17.2c-12.3-26.47-13.89-104,19.44-101.66S321.06,296.79,320.66,302.54Z"
                        style="fill:#263238;opacity:0.30000000000000004"></path>
                    <path
                        d="M270.46,187.63l.26,1.79.31,1.91.67,3.86c.49,2.57,1,5.15,1.57,7.71a149.33,149.33,0,0,0,4.16,15c.43,1.2.82,2.44,1.31,3.61s.88,2.4,1.41,3.54,1,2.42,1.37,3.23c.19.43.34.8.42,1s.13.22-.71-.21a5.55,5.55,0,0,0-2.65-.52,5.46,5.46,0,0,0-1.8.42,6.87,6.87,0,0,0-.68.36,5.13,5.13,0,0,0-.49.37,2.08,2.08,0,0,0-.7.89c0,.13,0,.14.11.07a8.3,8.3,0,0,0,1.35-2.39c.95-2.14,1.77-4.78,2.65-7.22l8.35.41a39.59,39.59,0,0,1,.56,9.28,19.46,19.46,0,0,1-1.12,5.54,10.91,10.91,0,0,1-.91,1.88,9.24,9.24,0,0,1-2.1,2.42,8.72,8.72,0,0,1-.93.65,6.85,6.85,0,0,1-1.15.58,8.07,8.07,0,0,1-2.81.63,9,9,0,0,1-4.62-1.08,13.66,13.66,0,0,1-3.75-3,21.83,21.83,0,0,1-1.9-2.43,38.68,38.68,0,0,1-2.43-4.17,87.41,87.41,0,0,1-3.84-8.15,120.87,120.87,0,0,1-5.55-16.79c-.73-2.84-1.34-5.7-1.88-8.58-.27-1.44-.51-2.88-.73-4.34-.1-.73-.2-1.47-.29-2.21s-.17-1.44-.26-2.34Z"
                        style="fill:#ff8b7b"></path>
                    <path
                        d="M248.81,184.86c-5.09,9.48,7.68,34.6,7.68,34.6l23-12.51s-1.73-6.65-7.41-19.37C265.85,173.73,255,173.37,248.81,184.86Z"
                        style="fill:#263238"></path>
                    <path d="M278.64,223.77l.45-11.26,12.82,4.31S290.26,227,284.72,227Z" style="fill:#ff8b7b"></path>
                    <path
                        d="M287.64,204.5l4.24,2.27a3.92,3.92,0,0,1,1.85,4.71l-1.82,5.34-12.82-4.31,3.22-6.33A3.92,3.92,0,0,1,287.64,204.5Z"
                        style="fill:#ff8b7b"></path>
                    <path
                        d="M260.88,176.64a125.75,125.75,0,0,0-39-2.21,18.3,18.3,0,0,0-16.3,15.83c-5.21,39.39-1.91,60.34-2.16,71.12l59.37,5.26c-.48-11.28.42-40.72,6-78.54A10.22,10.22,0,0,0,260.88,176.64Z"
                        style="fill:#263238"></path>
                    <polygon points="309.59 310.46 320.73 310.73 325.46 285.06 314.31 284.78 309.59 310.46"
                        style="fill:#ff8b7b"></polygon>
                    <path
                        d="M322.31,308.78l-11.58-3.66a.85.85,0,0,0-1.06.46l-4.15,9.09a1.82,1.82,0,0,0,1.11,2.44c4.2,1.24,5.62,1.34,10.87,3,6.14,1.94,8.61,3.42,15.81,5.7,4.35,1.37,6.51-2.78,4.78-3.79-5.46-3.18-11.59-8.2-13.41-11.58A3.93,3.93,0,0,0,322.31,308.78Z"
                        style="fill:#263238"></path>
                    <polygon points="325.45 285.07 323.02 298.3 311.87 298.02 314.3 284.79 325.45 285.07"
                        style="opacity:0.2"></polygon>
                    <path
                        d="M330.5,218.31c-13.63-6.81-48.22,29.82-92.08,46.17-.95,16.73,17.79,25.34,37.85,22.9,19.87-2.42,27.21-12.95,33.32-27.45-3.44,14.89-.17,30.36-.17,30.36l17.29,4.88S343,224.53,330.5,218.31Z"
                        style="fill:#263238"></path>
                    <path
                        d="M330.5,218.31c-13.63-6.81-48.22,29.82-92.08,46.17-.95,16.73,17.79,25.34,37.85,22.9,19.87-2.42,27.21-12.95,33.32-27.45-3.44,14.89-.17,30.36-.17,30.36l17.29,4.88S343,224.53,330.5,218.31Z"
                        style="opacity:0.2"></path>
                    <polygon points="328.71 297.32 306.38 295.26 305.9 287.91 330.83 289.82 328.71 297.32"
                        style="fill:#263238"></polygon>
                    <path
                        d="M321,308.75a.29.29,0,0,1-.14-.24.27.27,0,0,1,.18-.25c.53-.19,5.29-1.81,6.52-.87a.83.83,0,0,1,.33.76h0a1.47,1.47,0,0,1-.67,1.2c-1.36.9-4.46,0-6.18-.59Zm6.15-1c-.79-.41-3.32.17-5.19.75,2.38.75,4.21.9,5,.4a1,1,0,0,0,.44-.8.3.3,0,0,0-.13-.3Z"
                        style="fill:#263238"></path>
                    <path
                        d="M321,308.75l-.06-.05a.25.25,0,0,1-.07-.25c0-.12.74-3.05,2.31-4a1.92,1.92,0,0,1,1.51-.24h0c.71.17.86.57.87.87,0,1.27-2.95,3.29-4.36,3.69A.27.27,0,0,1,321,308.75Zm3.82-3.95a1.26,1.26,0,0,0-.26-.09h0a1.46,1.46,0,0,0-1.11.18c-1,.63-1.67,2.35-1.93,3.2,1.47-.63,3.53-2.25,3.51-3C325,305,325,304.91,324.77,304.8Z"
                        style="fill:#263238"></path>
                    <path
                        d="M252.19,177.08c-6.55-2.93-5.38-6.85-3.23-11.14l-13.78-12.55c.49,5.51.39,14.73-3.41,19.55a3.73,3.73,0,0,0,.36,5.11,29.78,29.78,0,0,0,15.58,7.6c6.73,1.18,8.23-1.65,7.79-4.5A5.5,5.5,0,0,0,252.19,177.08Z"
                        style="fill:#ff8b7b"></path>
                    <path d="M240.8,158.51C239.33,158,239,160,239,162.82s4.79,7.78,8.39,7.35a15.45,15.45,0,0,1,1.59-4.23Z"
                        style="opacity:0.2"></path>
                    <path
                        d="M264.88,149.35c3.79-3.66,8.64-13.77,7.63-18.76A19.25,19.25,0,0,0,260,129.26a29.87,29.87,0,0,0-9.65,5l6.14,5.24-.12,3.54,3.42,3.79-1,3.42a1.61,1.61,0,0,0,2.28,1.88Z"
                        style="fill:#263238"></path>
                    <path
                        d="M237.89,136.29c-2.85,10.67-5.07,16.78-1.56,23.87,5.28,10.66,19.85,10.08,25.85.45,5.4-8.67,9.15-24.66.26-32.16A15.22,15.22,0,0,0,237.89,136.29Z"
                        style="fill:#ff8b7b"></path>
                    <path
                        d="M233,142.71c-.55-6.59-1-11.55-1-17.37,2.88-.73,7.32-2.71,12-.51a29.94,29.94,0,0,1,8.57,6.7l-7,4-.52,3.51-4,3.11.36,3.54a1.61,1.61,0,0,1-2.58,1.44Z"
                        style="fill:#263238"></path>
                    <path
                        d="M272.52,133.77c5.07-2.65,12-15.46.12-14.92-7.67.35-17.07,1.37-25.06-3.12,0,0,2.32,4,8.28,4.52,12.95,1.18,13.36-.92,17.23,0C279.9,121.73,272.52,133.77,272.52,133.77Z"
                        style="fill:#263238"></path>
                    <path
                        d="M273.54,122.21c-8.55-4.77-17.94-1.06-25.21-3.82s-15.08,1.56-16.4,7l20.61,6.19c7.81,5.61,9.6,6.78,13.88,5.51C272.64,135.21,282.08,127,273.54,122.21Z"
                        style="fill:#263238"></path>
                    <path d="M233.68,124.2c-3.66.68-5.61,3.89-2.45,8-1.15-4.43,2.37-5.94,2.37-5.94Z" style="fill:#263238">
                    </path>
                    <path
                        d="M229.49,144.92a10.42,10.42,0,0,0,4.3,6.75c3,2.08,5.76-.34,5.94-3.82.15-3.13-1.24-8-4.78-8.68S228.94,141.57,229.49,144.92Z"
                        style="fill:#ff8b7b"></path>
                    <path
                        d="M252.16,143.67c-.28.85-.06,1.69.5,1.87s1.24-.36,1.53-1.21.06-1.69-.5-1.87S252.45,142.82,252.16,143.67Z"
                        style="fill:#263238"></path>
                    <path
                        d="M262.51,147.52c-.28.85-.06,1.69.5,1.87s1.24-.36,1.53-1.21.06-1.69-.5-1.87S262.8,146.67,262.51,147.52Z"
                        style="fill:#263238"></path>
                    <path d="M259.3,147s.3,5.54,1.65,8.61c-2,.91-4.34-.56-4.34-.56Z" style="fill:#ff5652"></path>
                    <path
                        d="M252.24,156.1a7.32,7.32,0,0,1-3.9-4.35.26.26,0,1,1,.51-.14,7.09,7.09,0,0,0,4.64,4.43.25.25,0,0,1,.17.33.26.26,0,0,1-.33.17A7.74,7.74,0,0,1,252.24,156.1Z"
                        style="fill:#263238"></path>
                    <path
                        d="M250.82,138.54a.6.6,0,0,1-.21-.18.53.53,0,0,1,.14-.73,5.3,5.3,0,0,1,4.78-.74.53.53,0,1,1-.4,1h0a4.24,4.24,0,0,0-3.78.62A.51.51,0,0,1,250.82,138.54Z"
                        style="fill:#263238"></path>
                    <path
                        d="M268,144.86a.51.51,0,0,1-.34-.37,4.12,4.12,0,0,0-2.43-2.92.53.53,0,0,1,.35-1,5.21,5.21,0,0,1,3.11,3.66.54.54,0,0,1-.39.64A.51.51,0,0,1,268,144.86Z"
                        style="fill:#263238"></path>
                    <polygon points="347.39 400.35 356.53 393.97 345.12 370.49 335.98 376.87 347.39 400.35"
                        style="fill:#ff8b7b"></polygon>
                    <path
                        d="M356.29,390.94l-11.1,4.92a.85.85,0,0,0-.49,1.05l2.9,9.56a1.82,1.82,0,0,0,2.45,1.09c4-1.84,5.09-2.71,10.13-4.93,5.89-2.61,8.72-3.13,15.63-6.19,4.17-1.85,3-6.39,1.08-6-6.2,1.22-14.12,1.51-17.72.18A4,4,0,0,0,356.29,390.94Z"
                        style="fill:#263238"></path>
                    <polygon points="345.12 370.5 351 382.6 341.86 388.98 335.98 376.88 345.12 370.5" style="opacity:0.2">
                    </polygon>
                    <path
                        d="M295.85,308.81c-75.19-2.35-94-1.71-92.41-47.43l38.21,3.39s66.6,4.11,74.86,26.28c12.42,33.35,35.09,84.74,35.09,84.74l-15,9.92S305.8,348.06,295.85,308.81Z"
                        style="fill:#263238"></path>
                    <polygon points="355 378.44 335.8 390.02 331.05 384.38 352.27 371.14 355 378.44" style="fill:#263238">
                    </polygon>
                    <path
                        d="M355.26,391.82a.28.28,0,0,1-.27-.09.27.27,0,0,1,0-.3c.28-.5,2.77-4.85,4.32-5a.86.86,0,0,1,.75.35h0a1.47,1.47,0,0,1,.29,1.34c-.43,1.58-3.33,3-5,3.65Zm3.95-4.81c-.86.21-2.38,2.32-3.39,4,2.28-1,3.75-2.11,4-3a1,1,0,0,0-.2-.89.31.31,0,0,0-.3-.14Z"
                        style="fill:#263238"></path>
                    <path
                        d="M355.26,391.82h-.08a.24.24,0,0,1-.22-.14c-.06-.11-1.46-2.78-.92-4.53a1.94,1.94,0,0,1,1-1.18h0c.65-.34,1-.15,1.23.07.86.94,0,4.42-.83,5.66A.26.26,0,0,1,355.26,391.82Zm.25-5.49a1,1,0,0,0-.25.11h0a1.4,1.4,0,0,0-.72.87c-.35,1.15.3,2.86.67,3.67.69-1.44,1.16-4,.64-4.58C355.82,386.36,355.74,386.28,355.51,386.33Zm-.37-.13Z"
                        style="fill:#263238"></path>
                    <path
                        d="M291,209.34l-12-.19a3.11,3.11,0,0,0-2.3.93l-14.93,20a1,1,0,0,0,.11,1.36c.38.39.86.29,1.59.3l11.81.18a3.13,3.13,0,0,0,2.31-.92l14.77-19.77C292.87,210.56,292.94,209.34,291,209.34Z"
                        style="fill:#263238"></path>
                    <path
                        d="M228.36,187.76l.19,2.38.23,2.51c.17,1.68.35,3.36.55,5,.41,3.36.86,6.72,1.45,10a110.63,110.63,0,0,0,4.8,19.09c.52,1.49,1.15,2.95,1.76,4.31.28.71.41.86.37,1s.23.38,1.08.43a10.64,10.64,0,0,0,3.35-.44,33,33,0,0,0,4.13-1.49c1.43-.63,2.87-1.36,4.32-2.14s2.9-1.62,4.33-2.52,2.91-1.83,4.23-2.7l5.82,6c-1.26,1.58-2.46,2.95-3.8,4.34s-2.69,2.69-4.16,3.95a48.83,48.83,0,0,1-4.67,3.64,36.35,36.35,0,0,1-5.46,3.17,24.36,24.36,0,0,1-7,2.11,17.49,17.49,0,0,1-4.45,0,15.3,15.3,0,0,1-4.82-1.51,15.13,15.13,0,0,1-4.08-3,18.4,18.4,0,0,1-2.7-3.68c-1-1.81-1.92-3.57-2.73-5.39a106,106,0,0,1-6.87-21.94c-.74-3.69-1.37-7.38-1.82-11.08-.24-1.86-.44-3.71-.59-5.58-.08-.94-.16-1.87-.21-2.82s-.1-1.84-.13-2.94Z"
                        style="fill:#ff8b7b"></path>
                    <path
                        d="M209.93,182.46c-6.08,8.88,3.93,35.22,3.93,35.22l24.18-10s-1-6.8-5.3-20C228.06,173.21,217.3,171.7,209.93,182.46Z"
                        style="fill:#263238"></path>
                    <path d="M257.09,224.77l8.27-7.66,6,12.09s-8.33,6-12.25,2.12Z" style="fill:#ff8b7b"></path>
                    <path
                        d="M277.07,217.47l1.4,4.59a3.9,3.9,0,0,1-2,4.64l-5.06,2.5-6-12.09,6.75-2.22A3.92,3.92,0,0,1,277.07,217.47Z"
                        style="fill:#ff8b7b"></path>
                </g>
            </svg>
        </div>
        <!-- Img SVG Section End -->

        <!-- Register Section Start -->
        <div class="right">
            <h1 class="mb-3 mt-0">{{ __('Sign Up') }}
                <img class="logo text-center mb-1" src="images/icon.png" alt="">
            </h1>
            <div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('register') }}" method="post">
                @csrf

                <!-- Google btn Section Start -->
                <button class="oauthButton">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4"></path>
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853"></path>
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05"></path>
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335"></path>
                        <path d="M1 1h22v22H1z" fill="none"></path>
                    </svg>
                    {{ __('Continue with Google') }}
                </button>
                <!-- Google btn Section End -->

                <p class="text-center mb-0">{{ __('or') }}</p>

                <div class="row">

                    <!-- FirstName Section Start -->
                    <div class="col-md-6 mb-0">
                        <div class="form-outline mb-2">
                            <input type="text" id="firstName" placeholder="{{ __('First Name') }}"
                                class="form-control @error('firstName') is-invalid @enderror" name="firstName"
                                value="{{ old('firstName') }}" {{-- required autocomplete="firstName" autofocus --}} />

                            @error('firstName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- FirstName Section End -->

                    <!-- LastName Section Start -->
                    <div class="col-md-6 mb-0">
                        <div class="form-outline mb-2">
                            <input type="text" id="lastName" placeholder="{{ __('Last Name') }}"
                                class="form-control @error('lastName') is-invalid @enderror" name="lastName"
                                value="{{ old('lastName') }}" {{-- required autocomplete="lastName" --}} />

                            @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- LastName Section End -->

                    <!-- UserName Section Start -->
                    <div class="col-md-6 mb-0">
                        <div class="form-outline mb-2">
                            <input type="text" id="userName" placeholder="{{ __('User Name') }}"
                                class="form-control @error('userName') is-invalid @enderror" name="userName"
                                value="{{ old('userName') }}" {{-- required autocomplete="userName" --}} />

                            @error('userName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- UserName Section End -->

                    <!-- BirthDate Section Start -->
                    <div class="col-md-6 mb-0">
                        <div class="form-outline mb-2">
                            <input type="date" id="birthDate" placeholder="{{ __('Birth Date') }}"
                                class="form-control @error('birthDate') is-invalid @enderror" name="birthDate"
                                id="birthDate" value="{{ old('birthDate') }}" />

                            @error('birthDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- BirthDate Section End -->

                    <!-- Gender Section Start -->
                    <div class="gender-selection mt-0">
                        <label for="gender">{{ __('Gender') }}</label>
                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                            name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                        <label for="male">{{ __('Male') }}</label>
                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                            name="gender" id="female" value="female"
                            {{ old('gender') == 'female' ? 'checked' : '' }}>
                        <label for="female">{{ __('Female') }}</label>
                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                            name="gender" id="other" value="other"
                            {{ old('gender') == 'other' ? 'checked' : '' }}>
                        <label for="other">{{ __('Other') }}</label>

                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- Gender Section End -->

                    <!-- Email Section Start -->
                    <div class="form-outline mb-2">
                        <input type="email" id="email" placeholder="{{ __('Email or Phone') }}"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required />

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- Email Section End -->

                    <!-- Password Section Start -->
                    <div class="input-wrapper">
                        <div data-mdb-input-init class="form-outline mb-0">
                            <input type="password" id="password" placeholder="{{ __('Password') }}"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                value="{{ session('password') ?? old('password') }}" required
                                autocomplete="current-password" autofocus />

                            <label class="toggle-password" onclick="togglePasswordVisibility()">
                                <input type="checkbox" checked="checked">
                                <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" height="24px"
                                    viewBox="0 -960 960 960" width="24px" fill="#000">
                                    <path
                                        d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z" />
                                </svg>
                                <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="24px"
                                    viewBox="0 -960 960 960" width="24px" fill="#000">
                                    <path
                                        d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                </svg>
                            </label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Password Section End -->

                    <!-- Login/Register Section Start -->
                    <div class="button-container mb-0">
                        @if (Route::has('login'))
                            <div class="d-flex align-items-center justify-content-center pb-4">
                                <p class="mb-0 mt-4 me-2">{{ __('Already have an account?') }} <a
                                        href="{{ route('login') }}" class="text-dark"
                                        style="font-weight: bold">{{ __('Login!') }}</a>
                                </p>
                                <button type="submit" class="register mb-0 mt-4 me-2">{{ __('Sign Up') }}</button>
                            </div>
                        @endif
                    </div>
                    <!-- Login/Register Section End -->
                </div>
            </form>
        </div>
        <!-- Register Section End -->

    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const birthDateInput = document.getElementById('birthDate');

            // Display the placeholder initially
            if (!birthDateInput.value) {
                birthDateInput.type = 'text';
                birthDateInput.setAttribute('placeholder', 'Birth Date');
            }

            // Handle focus and blur events
            birthDateInput.addEventListener('focus', function() {
                birthDateInput.type = 'date';
                birthDateInput.removeAttribute('placeholder');
            });

            birthDateInput.addEventListener('blur', function() {
                if (!birthDateInput.value) {
                    birthDateInput.type = 'text';
                    birthDateInput.setAttribute('placeholder', 'Birth Date');
                }
            });
        });

        // For password toggle
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var checkbox = document.querySelector('.toggle-password input');
            var eyeIcon = document.querySelector('.eye');
            var eyeSlashIcon = document.querySelector('.eye-slash');

            if (checkbox.checked) {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'inline';
                eyeSlashIcon.style.display = 'none';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'inline';
            }
        }

        window.onload = function() {
            var eyeIcon = document.querySelector('.eye');
            var eyeSlashIcon = document.querySelector('.eye-slash');

            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'inline';
        };
    </script>
@endsection
