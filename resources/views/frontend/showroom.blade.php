@extends('frontend.layouts.main')

@section('main_content')

    <div id="app">

        <div class="breadcrumb-area breadcrumb-bg pt-205 breadcrumb-padding pb-210">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <div class="mb-4">
                        <button class="scam-btn" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-exclamation-triangle mr-2"></i> Achtung vor <strong>Betrugmasc...</strong>
                        </button>
                    </div>
                    <h2>Bibliotheken</h2>
                </div>
            </div>
        </div>
        <?php

        $customerSearchFilters = session()->get('customer_search_filters');
        $hasCustomerSearchFilters = (bool) $customerSearchFilters;
        $productSearchFilters = session()->get('product_search_filters');
        $hasProductSearchFilters = (bool) $productSearchFilters;

        $customerFilters = [
            'search_key' => '',
            'is_filtering' => false,
            'is_sorting' => false,
            'product_range' => [(int) $minProducts, (int) $maxProducts],
            'product_range_min' => (int) $minProducts,
            'product_range_max' => (int) $maxProducts,
            'membership_ids' => [],
            'sorting_lists' => [['label' => 'Produkt', 'value' => 'products_count']],
            'sorting_order_list' => [
                ['label' => 'Aufsteigend', 'value' => 'asc'],
                ['label' => 'Absteigend', 'value' => 'desc']
            ],
            'sort_by' => '',
            'sort_order' => '',
            'page' => isset($customerFilters['page']) ? (int) $customerFilters['page'] : 1,
        ];

        if ($hasCustomerSearchFilters) {
            $customerFilters = array_merge($customerFilters, $customerSearchFilters);
            $customerFilters['product_range'] = array_map(function ($range) {
                return (int) $range;
            }, (array) $customerFilters['product_range'] ?? []);
            $customerFilters['product_range_min'] = (int) ($customerFilters['product_range_min'] ?? $minProducts);
            $customerFilters['product_range_max'] = (int) ($customerFilters['product_range_max'] ?? $maxProducts);
            $customerFilters['is_filtering'] = (bool) filter_var($customerFilters['is_filtering'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $customerFilters['is_sorting'] = (bool) filter_var($customerFilters['is_sorting'] ?? false, FILTER_VALIDATE_BOOLEAN);
        }

        $productFilters = [
            'search_key' => '',
            'is_filtering' => false,
            'is_sorting' => false,
            'category_ids' => [],
            'sorting_lists' => [
                [
                    'label' => 'Kategorie',
                    'value' => 'product_category.title',
                ]
            ],
            'sorting_order_list' => [
                ['label' => 'Aufsteigend', 'value' => 'asc'],
                [ 'label' => 'Absteigend', 'value' => 'desc']
            ],
            'sort_by' => '',
            'sort_order' => '',
            'page' => isset($productFilters['page']) ? (int) $productFilters['page'] : 1,
        ];

        if ($hasProductSearchFilters) {
            $productFilters = array_merge($productFilters, $productSearchFilters);
            $productFilters['category_ids'] = array_map(function ($categoryId) {
                return (int) $categoryId;
            }, (array) $productFilters['category_ids'] ?? []);
            $productFilters['is_filtering'] = (bool) filter_var($productFilters['is_filtering'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $productFilters['is_sorting'] = (bool) filter_var($productFilters['is_sorting'] ?? false, FILTER_VALIDATE_BOOLEAN);
        }

        $isCustomerSearchSelected = session()->has('is_customer_default_search') ? ((bool) session('is_customer_default_search')) : true;

        ?>
        <section class="search-filter-section">
            <search-filter-container
            :config="{{ json_encode([
                'baseUrl' => url('/'),
                'storageUrl' => getProductStorageUrl(),
                'getInitialProducts' => $products,
                'getInitialCustomers' => $customers,
                'filterCustomersUrl' => route('frontend.filter_customers'),
                'filterProductsUrl' => route('frontend.filter_products'),
                'customerLibraryUrl' => url('/libraries').'/',
                'guestInquiryUrl' => route('guest.inquiry'),
                'bookInquiryUrl' => route('book.inquiry'),
                'dataProtectionUrl' => route('frontend.page.data_protection'),
                'bookUrl' => url('/books').'/',
                'emptyImageUrl' => getDummyImageUrl(),
                'product_conditions' => config('buch.product_conditions'),
                'product_condition_default' => config('buch.product_condition_default'),
                'debounce_time' => 600,
                'sliderItemLimit' => 6,
                'slider_responsive' => [
                    0 => ['items' => 1, 'nav' => true],
                    700 => ['items' => 2, 'nav' => true],
                    900 => ['items' => 3, 'nav' => true],
                    1100 => ['items' => 5, 'nav' => true],
                ],
                'getMemberships' => \App\DataHolders\Enum\Membership::getForSelect(),
                'getCategories' => \App\Models\ProductCategory::all(),
                'isSearchByCustomer' => $isCustomerSearchSelected,
                'customer_fields' => $customerFilters,
                'product_fields' => $productFilters,
            ]) }}"

        ></search-filter-container>
        </section>
    </div>

@endsection


@section('page_title', 'Buch Kunst Register | Entdecken Sie jetzt alle Sammlungen!')
@section('page_meta_props')
    @parent
    <meta name="description" content="Buch Kunst Register | Verwaltung und Handel mit Buch- und Kunstsammlungen | Stöbern Sie jetzt durch unsere Bibliotheken und entdecken Sie seltene Werke!" />
@endsection

@section('header_styles')
    @parent

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/vue-loading-overlay.css') }}">
@endsection

@section('footer_script')
    @parent

    @vite(['resources/jsBundler/frontend/showroom.js'])
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
@section('header_styles')
    @parent

@endsection
