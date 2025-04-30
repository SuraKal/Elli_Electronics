<!DOCTYPE html>
<html lang="en">


<!-- Elli/index-13.html  22 Nov 2025 09:59:06 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <x-meta_links />

    <!-- Favicon -->
    <x-favicon />

    {{-- Font awsome --}}
    <script src="https://kit.fontawesome.com/e1bbce0eb6.js" crossorigin="anonymous"></script>


    <!-- Plugins CSS File -->
    <livewire:public.plugins.css />



</head>

<body>
    <div class="page-wrapper">

        {{-- Header --}}
        <livewire:public.layout.header />



        <main>
            {{ $slot }}
        </main>



        {{-- Footer --}}
        <livewire:public.layout.footer />


    </div><!-- End .page-wrapper -->



    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>


    {{-- Mobile header --}}
    <livewire:public.layout.mobile_header></livewire:public.layout.mobile_header>



    {{-- Login/Register Model --}}
    <livewire:public.layout.authentication_model></livewire:public.layout.authentication_model>






    <!-- Plugins JS File -->
    <livewire:public.plugins.js />


</body>
</html>
