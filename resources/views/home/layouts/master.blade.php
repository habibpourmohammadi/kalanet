<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    @include('home.layouts.head-tag')
    @yield('title')
</head>

<body>

    @include('home.layouts.header')


    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">
        @yield('content')
    </main>
    <!-- end main one col -->


    <!-- start body -->
    <section class="container-xxl body-container">
        <aside id="sidebar" class="sidebar">

        </aside>
        <main id="main-body" class="main-body">

        </main>
    </section>
    <!-- end body -->

    @include('home.layouts.footer')

    @include('home.layouts.script-tag')
    @yield('script')
</body>

</html>
