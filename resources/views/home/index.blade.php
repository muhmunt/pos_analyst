@extends('layouts.app')
@section('title', __('home.home'))

@section('content')

    <div class="tw-pb-6 tw-bg-gradient-to-r tw-from-@if(!empty(session('business.theme_color'))){{session('business.theme_color')}}@else{{'primary'}}@endif-800 tw-to-@if(!empty(session('business.theme_color'))){{session('business.theme_color')}}@else{{'primary'}}@endif-900 xl:tw-pb-0 ">
        <div class="tw-px-5 tw-pt-3">
            <div class="sm:tw-flex sm:tw-items-center sm:tw-justify-between sm:tw-gap-12">
                <div class="tw-mt-2 sm:tw-w-1/2 md:tw-w-1/2">
                    <h1
                        class="tw-text-2xl md:tw-text-4xl tw-tracking-tight tw-text-primary-800 tw-font-semibold text-white tw-mb-10 md:tw-mb-0">
                        {{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
                    </h1>
                </div>

                @if (auth()->user()->can('dashboard.data'))
                    @if ($is_admin)
                        <div class="tw-mt-2 sm:tw-w-1/3 md:tw-w-1/4 ">
                            @if (count($all_locations) > 1)
                                {!! Form::select('dashboard_location', $all_locations, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang_v1.select_location'),
                                    'id' => 'dashboard_location',
                                ]) !!}
                            @endif
                        </div>
    
                        <div class="tw-mt-2 sm:tw-w-1/3 md:tw-w-1/4 tw-text-right">
                            @if ($is_admin)
                                <button type="button" id="dashboard_date_filter"
                                    class="tw-inline-flex tw-items-center tw-justify-center tw-w-full tw-gap-1 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-900 tw-transition-all tw-duration-200 tw-bg-white tw-rounded-lg sm:tw-w-auto hover:tw-bg-primary-50">
                                    <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                        <path d="M7 14h.013" />
                                        <path d="M10.01 14h.005" />
                                        <path d="M13.01 14h.005" />
                                        <path d="M16.015 14h.005" />
                                        <path d="M13.015 17h.005" />
                                        <path d="M7.01 17h.005" />
                                        <path d="M10.01 17h.005" />
                                    </svg>
                                    <span>
                                        {{ __('messages.filter_by_date') }}
                                    </span>
                                    <svg aria-hidden="true" class="tw-size-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 9l6 6l6 -6" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
            @if (auth()->user()->can('dashboard.data'))
                @if ($is_admin)
                    <div class="tw-grid tw-grid-cols-1 tw-gap-4 tw-mt-6 sm:tw-grid-cols-2 xl:tw-grid-cols-4 sm:tw-gap-5">
                    
                        <div
                            class="tw-transition-all tw-duration-200 tw-bg-white tw-shadow-sm hover:tw-shadow-md tw-rounded-xl  tw-ring-1 tw-ring-gray-200">
                            <div class="tw-p-4 sm:tw-p-5">
                                <div class="tw-flex tw-items-center tw-gap-4">
                                    <div
                                        class="tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-rounded-full sm:tw-w-12 sm:tw-h-12 tw-shrink-0 tw-bg-sky-100 tw-text-sky-500">
                                        <svg aria-hidden="true" class="tw-w-6 tw-h-6" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17h-11v-14h-2" />
                                            <path d="M6 5l14 1l-1 7h-13" />
                                        </svg>
                                    </div>

                                    <div class="tw-flex-1 tw-min-w-0">
                                        <p
                                            class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate tw-whitespace-nowrap">
                                            {{ __('home.total_sell') }}
                                        </p>
                                        <p
                                            class="total_sell tw-mt-0.5 tw-text-gray-900 tw-text-xl tw-truncate tw-font-semibold tw-tracking-tight tw-font-mono">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="tw-transition-all tw-duration-200 tw-bg-white tw-shadow-sm hover:tw-shadow-md tw-rounded-xl hover:tw--translate-y-0.5 tw-ring-1 tw-ring-gray-200">
                            <div class="tw-p-4 sm:tw-p-5">
                                <div class="tw-flex tw-items-center tw-gap-4">
                                    <div
                                        class="tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-text-green-500 tw-bg-green-100 tw-rounded-full sm:tw-w-12 sm:tw-h-12 tw-shrink-0">
                                        <svg aria-hidden="true" class="tw-w-6 tw-h-6" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2">
                                            </path>
                                            <path
                                                d="M14.8 8a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1">
                                            </path>
                                            <path d="M12 6v10"></path>
                                        </svg>
                                    </div>

                                    <div class="tw-flex-1 tw-min-w-0">
                                        <p
                                            class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate tw-whitespace-nowrap">
                                            {{ __('lang_v1.net') }} @show_tooltip(__('lang_v1.net_home_tooltip'))
                                        </p>
                                        <p
                                            class="net tw-mt-0.5 tw-text-gray-900 tw-text-xl tw-truncate tw-font-semibold tw-tracking-tight tw-font-mono">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="tw-transition-all tw-duration-200 tw-bg-white tw-shadow-sm hover:tw-shadow-md tw-rounded-xl hover:tw--translate-y-0.5 tw-ring-1 tw-ring-gray-200">
                            <div class="tw-p-4 sm:tw-p-5">
                                <div class="tw-flex tw-items-center tw-gap-4">
                                    <div
                                        class="tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-text-yellow-500 tw-bg-yellow-100 tw-rounded-full sm:tw-w-12 sm:tw-h-12 shrink-0">
                                        <svg aria-hidden="true" class="tw-w-6 tw-h-6" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M9 7l1 0" />
                                            <path d="M9 13l6 0" />
                                            <path d="M13 17l2 0" />
                                        </svg>
                                    </div>

                                    <div class="tw-flex-1 tw-min-w-0">
                                        <p
                                            class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate tw-whitespace-nowrap">
                                            {{ __('home.invoice_due') }}
                                        </p>
                                        <p
                                            class="invoice_due tw-mt-0.5 tw-text-gray-900 tw-text-xl tw-truncate tw-font-semibold tw-tracking-tight tw-font-mono">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    @if (auth()->user()->can('dashboard.data'))
        <div class="tw-px-5 tw-py-6">
            <!-- AI Insights & Summary Section -->
            <div class="ai-insights-container">
                <!-- Header -->
                <div class="ai-insights-header">
                    <div>
                        <h2 class="ai-insights-title">Insight Bisnis AI</h2>
                        <p class="ai-insights-subtitle">Analisis real-time</p>
                        <p class="ai-insights-subtitle" id="ai_insights_last_updated" style="margin-top: 4px; font-size: 12px;">Memuat...</p>
                    </div>
                    <button id="refresh_ai_insights" class="ai-refresh-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                </div>
                
                <!-- Performance Metrics Grid -->
                <div class="ai-metrics-grid">
                    <div class="ai-metric-card">
                        <div class="ai-metric-label">Tren Pendapatan</div>
                        <div class="ai-metric-value" id="revenue_trend">
                            <div class="ai-loading">
                                <div class="ai-loading-spinner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ai-metric-card">
                        <div class="ai-metric-label">Margin Laba</div>
                        <div class="ai-metric-value" id="profit_margin">
                            <div class="ai-loading">
                                <div class="ai-loading-spinner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ai-metric-card">
                        <div class="ai-metric-label">Efisiensi Penagihan</div>
                        <div class="ai-metric-value" id="collection_efficiency">
                            <div class="ai-loading">
                                <div class="ai-loading-spinner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ai-metric-card">
                        <div class="ai-metric-label">Kesehatan Stok</div>
                        <div class="ai-metric-value" id="stock_health">
                            <div class="ai-loading">
                                <div class="ai-loading-spinner"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations and Summary Row -->
                <div class="ai-content-grid">
                    <!-- AI Recommendations -->
                    <div class="ai-content-card">
                        <div class="ai-content-header">
                            <div class="ai-content-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6 364h-1m4 0h-1m-1 4v.01M19 10h.01M12 12h.01M12 19h.01M12 9a3 3 0 110 6 3 3 0 010-6z"></path>
                                </svg>
                            </div>
                            <h3 class="ai-content-title">Rekomendasi Cerdas</h3>
                        </div>
                        <div class="ai-recommendations-list" id="ai_recommendations">
                            <div class="ai-loading">
                                <div class="ai-loading-spinner"></div>
                                <p style="margin-top: 12px;">Membuat rekomendasi...</p>
                            </div>
                        </div>
                    </div>

                    <!-- AI Summary -->
                    <div class="ai-content-card">
                        <div class="ai-content-header">
                            <div class="ai-content-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="ai-content-title">Ringkasan Bisnis AI</h3>
                        </div>
                        <div class="ai-summary-content" id="ai_summary">
                            <div class="ai-loading">
                                <div class="ai-loading-spinner"></div>
                                <p style="margin-top: 12px;">Generating summary...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trending Products -->
                <div class="ai-content-card" style="margin-bottom: 24px;">
                    <div class="ai-content-header">
                        <div class="ai-content-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="ai-content-title">Produk Terlaris</h3>
                    </div>
                    <div id="trending_products" class="ai-trending-products">
                        <div class="ai-loading">
                            <div class="ai-loading-spinner"></div>
                            <p style="margin-top: 12px;">Memuat data produk...</p>
                        </div>
                    </div>
                </div>

                <!-- Detailed Insights -->
                <div class="ai-analysis-section">
                    <div class="ai-content-header">
                        <div class="ai-content-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="ai-content-title">Analisis Detail</h3>
                    </div>
                    <div id="detailed_analysis">
                        <div class="ai-loading">
                            <div class="ai-loading-spinner"></div>
                            <p style="margin-top: 12px;">Menganalisis data bisnis...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-gap-5 lg:tw-grid-cols-2">
                @if (auth()->user()->can('sell.view') || auth()->user()->can('direct_sell.view'))
                    @if (!empty($all_locations))
                        <div
                            class="tw-transition-all lg:tw-col-span-2 xl:tw-col-span-2 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md hover:tw--translate-y-0.5 tw-ring-gray-200">
                            <div class="tw-p-4 sm:tw-p-5">
                                <div class="tw-flex tw-items-center tw-gap-2.5">
                                    <div
                                        class="tw-border-2 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-w-10 tw-h-10">
                                        <svg aria-hidden="true" class="tw-size-5 tw-text-sky-500 tw-shrink-0"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M17 17h-11v-14h-2"></path>
                                            <path d="M6 5l14 1l-1 7h-13"></path>
                                        </svg>
                                    </div>

                                    <h3 class="tw-font-bold tw-text-base lg:tw-text-xl">
                                        {{ __('home.sells_last_30_days') }}
                                    </h3>
                                </div>
                                <div class="tw-mt-5">
                                    <div
                                        class="tw-grid tw-w-full tw-h-100 tw-border tw-border-gray-200 tw-border-dashed tw-rounded-xl tw-bg-gray-50 ">
                                        <p class="tw-text-sm tw-italic tw-font-normal tw-text-gray-400">
                                            {!! $sells_chart_1->container() !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (!empty($all_locations))
                        <div
                            class="tw-transition-all lg:tw-col-span-2 xl:tw-col-span-2 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md hover:tw--translate-y-0.5 tw-ring-gray-200">
                            <div class="tw-p-4 sm:tw-p-5">
                                <div class="tw-flex tw-items-center tw-gap-2.5">
                                    <div
                                        class="tw-border-2 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-w-10 tw-h-10">
                                        <svg aria-hidden="true" class="tw-size-5 tw-text-sky-500 tw-shrink-0"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M17 17h-11v-14h-2"></path>
                                            <path d="M6 5l14 1l-1 7h-13"></path>
                                        </svg>
                                    </div>
                                    <h3 class="tw-font-bold tw-text-base lg:tw-text-xl">
                                        {{ __('home.sells_current_fy') }}
                                    </h3>
                                </div>
                                <div class="tw-mt-5">
                                    <div
                                        class="tw-grid tw-w-full tw-h-100 tw-border tw-border-gray-200 tw-border-dashed tw-rounded-xl tw-bg-gray-50 ">
                                        <p class="tw-text-sm tw-italic tw-font-normal tw-text-gray-400">
                                            {!! $sells_chart_2->container() !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @can('stock_report.view')
                    <div
                        class="tw-transition-all lg:tw-col-span-2 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md hover:tw--translate-y-0.5 tw-ring-gray-200">
                        <div class="tw-p-4 sm:tw-p-5">
                            <div class="tw-flex tw-items-center tw-gap-2.5">
                                <div
                                    class="tw-border-2 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-w-10 tw-h-10">
                                    <svg aria-hidden="true" class="tw-text-yellow-500 tw-size-5 tw-shrink-0"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M12 8v4"></path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                                <div class="tw-flex tw-items-center tw-flex-1 tw-min-w-0 tw-gap-1">
                                    <div class="tw-w-full sm:tw-w-1/2 md:tw-w-1/2">
                                        <h3 class="tw-font-bold tw-text-base lg:tw-text-xl">
                                            {{ __('home.product_stock_alert') }}
                                            @show_tooltip(__('tooltip.product_stock_alert'))
                                        </h3>
                                    </div>
                                    <div class="tw-w-full sm:tw-w-1/2 md:tw-w-1/2">
                                        @if (count($all_locations) > 1)
                                            {!! Form::select('stock_alert_location', $all_locations, null, [
                                                'class' => 'form-control select2',
                                                'placeholder' => __('lang_v1.select_location'),
                                                'id' => 'stock_alert_location',
                                            ]) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tw-flow-root tw-mt-5  tw-border-gray-200">
                                <div class="tw--mx-4 tw--my-2 tw-overflow-x-auto sm:tw--mx-5">
                                    <div class="tw-inline-block tw-min-w-full tw-py-2 tw-align-middle sm:tw-px-5">
                                        <table class="table table-bordered table-striped" id="stock_alert_table"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('sale.product')</th>
                                                    <th>@lang('business.location')</th>
                                                    <th>@lang('report.current_stock')</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('business.enable_product_expiry') == 1)
                        <div
                            class="tw-transition-all lg:tw-col-span-1 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md hover:tw--translate-y-0.5 tw-ring-gray-200">
                            <div class="tw-p-4 sm:tw-p-5">
                                <div class="tw-flex tw-items-center tw-gap-2.5">
                                    <div
                                        class="tw-border-2 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-w-10 tw-h-10">
                                        <svg aria-hidden="true" class="tw-text-yellow-500 tw-size-5 tw-shrink-0"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 9v4"></path>
                                            <path
                                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                            </path>
                                            <path d="M12 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div class="tw-flex tw-items-center tw-flex-1 tw-min-w-0 tw-gap-1">
                                        <div class="tw-w-full sm:tw-w-1/2 md:tw-w-1/2">
                                            <h3 class="tw-font-bold tw-text-base lg:tw-text-xl">
                                                {{ __('home.stock_expiry_alert') }}
                                                @show_tooltip(
                                                __('tooltip.stock_expiry_alert', [
                                                'days'
                                                =>session('business.stock_expiry_alert_days', 30) ]) )
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="tw-flow-root tw-mt-5  tw-border-gray-200">
                                    <div class="tw--mx-4 tw--my-2 tw-overflow-x-auto sm:tw--mx-5">
                                        <div class="tw-inline-block tw-min-w-full tw-py-2 tw-align-middle sm:tw-px-5">
                                            <input type="hidden" id="stock_expiry_alert_days"
                                                value="{{ \Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d') }}">
                                            <table class="table table-bordered table-striped" id="stock_expiry_alert_table">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('business.product')</th>
                                                        <th>@lang('business.location')</th>
                                                        <th>@lang('report.stock_left')</th>
                                                        <th>@lang('product.expires_in')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan
                @if (auth()->user()->can('account.access') && config('constants.show_payments_recovered_today') == true)
                    <div
                        class="tw-transition-all lg:tw-col-span-2 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md hover:tw--translate-y-0.5 tw-ring-gray-200">
                        <div class="tw-p-4 sm:tw-p-5">
                            <div class="tw-flex tw-items-center tw-gap-2.5">
                                <div
                                    class="tw-border-2 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-w-10 tw-h-10">
                                    <svg aria-hidden="true" class="tw-text-yellow-500 tw-size-5 tw-shrink-0"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 9v4"></path>
                                        <path
                                            d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                        </path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                                <div class="tw-flex tw-items-center tw-flex-1 tw-min-w-0 tw-gap-1">
                                    <div class="tw-w-full sm:tw-w-1/2 md:tw-w-1/2">
                                        <h3 class="tw-font-bold tw-text-base lg:tw-text-xl">
                                            @lang('lang_v1.payment_recovered_today')
                                        </h3>
                                    </div>

                                </div>
                            </div>
                            <div class="tw-flow-root tw-mt-5  tw-border-gray-200">
                                <div class="tw--mx-4 tw--my-2 tw-overflow-x-auto sm:tw--mx-5">
                                    <div class="tw-inline-block tw-min-w-full tw-py-2 tw-align-middle sm:tw-px-5">
                                        <table class="table table-bordered table-striped" id="cash_flow_table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('messages.date')</th>
                                                    <th>@lang('account.account')</th>
                                                    <th>@lang('lang_v1.description')</th>
                                                    <th>@lang('lang_v1.payment_method')</th>
                                                    <th>@lang('lang_v1.payment_details')</th>
                                                    <th>@lang('account.credit')</th>
                                                    <th>@lang('lang_v1.account_balance')
                                                        @show_tooltip(__('lang_v1.account_balance_tooltip'))</th>
                                                    <th>@lang('lang_v1.total_balance')
                                                        @show_tooltip(__('lang_v1.total_balance_tooltip'))</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr class="bg-gray font-17 footer-total text-center">
                                                    <td colspan="5"><strong>@lang('sale.total'):</strong></td>
                                                    <td class="footer_total_credit"></td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection


<div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
</div>

@section('css')
    <style>
        .select2-container {
            width: 100% !important;
        }
        
        /* AI Insights Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .tw-animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }
        
        /* Smooth transitions for metric cards */
        .metric-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .metric-card:hover {
            transform: translateY(-4px);
        }
        
        /* Scrollbar styling for recommendations */
        #ai_recommendations::-webkit-scrollbar,
        #ai_summary::-webkit-scrollbar,
        #detailed_analysis::-webkit-scrollbar {
            width: 6px;
        }
        
        #ai_recommendations::-webkit-scrollbar-track,
        #ai_summary::-webkit-scrollbar-track,
        #detailed_analysis::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        #ai_recommendations::-webkit-scrollbar-thumb,
        #ai_summary::-webkit-scrollbar-thumb,
        #detailed_analysis::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        #ai_recommendations::-webkit-scrollbar-thumb:hover,
        #ai_summary::-webkit-scrollbar-thumb:hover,
        #detailed_analysis::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Pulse animation for loading states */
        @keyframes pulse-slow {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        .tw-animate-pulse-slow {
            animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Shimmer effect for loading */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .tw-animate-shimmer {
            animation: shimmer 2s infinite;
            background: linear-gradient(to right, #f0f0f0 8%, #e0e0e0 18%, #f0f0f0 33%);
            background-size: 1000px 100%;
        }
        
        /* Glow effect for active metrics */
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 5px rgba(139, 92, 246, 0.3);
            }
            50% {
                box-shadow: 0 0 20px rgba(139, 92, 246, 0.6);
            }
        }
        
        .metric-card-excellent {
            animation: glow 2s ease-in-out infinite;
        }
        
        /* Fix for dashboard date filter button */
        #dashboard_date_filter {
            pointer-events: auto !important;
            position: relative;
            z-index: 10;
            cursor: pointer;
        }
        
        #dashboard_date_filter:focus {
            outline: 2px solid rgba(59, 130, 246, 0.5);
            outline-offset: 2px;
        }
        
        /* Ensure daterangepicker dropdown is above other elements */
        .daterangepicker {
            z-index: 9999 !important;
        }
        
        /* Minimalist Modern AI Insights Section */
        .ai-insights-container {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 32px;
            margin-bottom: 24px;
        }
        
        .ai-insights-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .ai-insights-title {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .ai-insights-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        .ai-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #111827;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .ai-refresh-btn:hover {
            background: #1f2937;
            transform: translateY(-1px);
        }
        
        .ai-refresh-btn:active {
            transform: translateY(0);
        }
        
        .ai-metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .ai-metric-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s;
        }
        
        .ai-metric-card:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .ai-metric-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .ai-metric-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }
        
        .ai-metric-value.success {
            color: #059669;
        }
        
        .ai-metric-value.warning {
            color: #d97706;
        }
        
        .ai-metric-value.error {
            color: #dc2626;
        }
        
        .ai-metric-value.info {
            color: #2563eb;
        }
        
        .ai-content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .ai-content-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }
        
        .ai-content-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .ai-content-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #111827;
        }
        
        .ai-content-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }
        
        .ai-recommendations-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .ai-recommendation-item {
            padding: 16px;
            background: #f9fafb;
            border-left: 3px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }
        
        .ai-recommendation-item.priority-high {
            border-left-color: #dc2626;
            background: #fef2f2;
        }
        
        .ai-recommendation-item.priority-medium {
            border-left-color: #d97706;
            background: #fffbeb;
        }
        
        .ai-recommendation-item.priority-low {
            border-left-color: #2563eb;
            background: #eff6ff;
        }
        
        .ai-summary-content {
            font-size: 14px;
            color: #374151;
            line-height: 1.8;
        }
        
        .ai-summary-content p {
            margin-bottom: 12px;
        }
        
        .ai-analysis-section {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }
        
        .ai-analysis-item {
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        
        .ai-analysis-item:last-child {
            margin-bottom: 0;
        }
        
        .ai-analysis-item-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
        }
        
        .ai-analysis-item-content {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }
        
        .ai-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: #9ca3af;
        }
        
        .ai-loading-spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e5e7eb;
            border-top-color: #111827;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .ai-error {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: #dc2626;
        }
        
        .ai-error-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            color: #fca5a5;
        }
        
        /* Scrollbar styling */
        .ai-recommendations-list::-webkit-scrollbar,
        .ai-summary-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .ai-recommendations-list::-webkit-scrollbar-track,
        .ai-summary-content::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }
        
        .ai-recommendations-list::-webkit-scrollbar-thumb,
        .ai-summary-content::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        
        .ai-recommendations-list::-webkit-scrollbar-thumb:hover,
        .ai-summary-content::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Trending Products Styling */
        .ai-trending-products {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .ai-trending-product-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .ai-trending-product-item:hover {
            border-color: #d1d5db;
            background: #ffffff;
        }
        
        .ai-trending-product-info {
            flex: 1;
            min-width: 0;
        }
        
        .ai-trending-product-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }
        
        .ai-trending-product-sku {
            font-size: 12px;
            color: #6b7280;
        }
        
        .ai-trending-product-stats {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }
        
        .ai-trending-product-quantity {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }
        
        .ai-trending-product-unit {
            font-size: 12px;
            color: #6b7280;
        }
        
        .ai-trending-product-rank {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: #111827;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .ai-trending-product-rank.rank-1 {
            background: #fbbf24;
            color: #111827;
        }
        
        .ai-trending-product-rank.rank-2 {
            background: #9ca3af;
            color: #ffffff;
        }
        
        .ai-trending-product-rank.rank-3 {
            background: #d97706;
            color: #ffffff;
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    @if (!empty($all_locations))
        {!! $sells_chart_1->script() !!}
        {!! $sells_chart_2->script() !!}
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            @if (auth()->user()->can('account.access') && config('constants.show_payments_recovered_today') == true)

                // Cash Flow Table
                cash_flow_table = $('#cash_flow_table').DataTable({
                    processing: true,
                    serverSide: true,
                    fixedHeader:false,
                    "ajax": {
                        "url": "{{ action([\App\Http\Controllers\AccountController::class, 'cashFlow']) }}",
                        "data": function(d) {
                            d.type = 'credit';
                            d.only_payment_recovered = true;
                        }
                    },
                    "ordering": false,
                    "searching": false,
                    columns: [{
                            data: 'operation_date',
                            name: 'operation_date'
                        },
                        {
                            data: 'account_name',
                            name: 'account_name'
                        },
                        {
                            data: 'sub_type',
                            name: 'sub_type'
                        },
                        {
                            data: 'method',
                            name: 'TP.method'
                        },
                        {
                            data: 'payment_details',
                            name: 'payment_details',
                            searchable: false
                        },
                        {
                            data: 'credit',
                            name: 'amount'
                        },
                        {
                            data: 'balance',
                            name: 'balance'
                        },
                        {
                            data: 'total_balance',
                            name: 'total_balance'
                        },
                    ],
                    "fnDrawCallback": function(oSettings) {
                        __currency_convert_recursively($('#cash_flow_table'));
                    },
                    "footerCallback": function(row, data, start, end, display) {
                        var footer_total_credit = 0;

                        for (var r in data) {
                            footer_total_credit += $(data[r].credit).data('orig-value') ? parseFloat($(
                                data[r].credit).data('orig-value')) : 0;
                        }
                        $('.footer_total_credit').html(__currency_trans_from_en(footer_total_credit));
                    }
                });
            @endif

            // AI Insights functionality
            function loadAIInsights() {
                // Show loading state
                $('#revenue_trend').html('<div class="ai-loading"><div class="ai-loading-spinner"></div></div>');
                $('#profit_margin').html('<div class="ai-loading"><div class="ai-loading-spinner"></div></div>');
                $('#collection_efficiency').html('<div class="ai-loading"><div class="ai-loading-spinner"></div></div>');
                $('#stock_health').html('<div class="ai-loading"><div class="ai-loading-spinner"></div></div>');
                
                $('#ai_recommendations').html(`
                    <div class="ai-loading">
                        <div class="ai-loading-spinner"></div>
                        <p style="margin-top: 12px;">Membuat rekomendasi...</p>
                    </div>
                `);
                
                $('#ai_summary').html(`
                    <div class="ai-loading">
                        <div class="ai-loading-spinner"></div>
                        <p style="margin-top: 12px;">Membuat ringkasan...</p>
                    </div>
                `);
                
                $('#trending_products').html(`
                    <div class="ai-loading">
                        <div class="ai-loading-spinner"></div>
                        <p style="margin-top: 12px;">Memuat data produk...</p>
                    </div>
                `);
                
                $('#detailed_analysis').html(`
                    <div class="ai-loading">
                        <div class="ai-loading-spinner"></div>
                        <p style="margin-top: 12px;">Menganalisis data bisnis...</p>
                    </div>
                `);

                // Get date range from dashboard filter if available
                let start_date = null;
                let end_date = null;
                let location_id = $('#dashboard_location').val() || null;
                
                if ($('#dashboard_date_filter').length > 0 && $('#dashboard_date_filter').data('daterangepicker')) {
                    start_date = $('#dashboard_date_filter').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    end_date = $('#dashboard_date_filter').data('daterangepicker').endDate.format('YYYY-MM-DD');
                } else {
                    // Default to last 30 days
                    end_date = moment().format('YYYY-MM-DD');
                    start_date = moment().subtract(30, 'days').format('YYYY-MM-DD');
                }

                // Call real AI insights API
                console.log('🤖 AI Insights: Requesting insights...', {
                    start_date: start_date,
                    end_date: end_date,
                    location_id: location_id
                });
                
                $.ajax({
                    url: '/home/ai-insights',
                    method: 'GET',
                    data: {
                        start_date: start_date,
                        end_date: end_date,
                        location_id: location_id
                    },
                    success: function(insights) {
                        console.log('✅ AI Insights: Response received', insights);
                        console.log('📊 Metrics:', insights.metrics);
                        console.log('💡 Recommendations:', insights.recommendations);
                        console.log('📝 Summary:', insights.summary);
                        console.log('📋 Detailed Analysis:', insights.detailed_analysis);
                        
                        // Update last updated timestamp
                        if (insights.generated_at) {
                            const updatedTime = new Date(insights.generated_at).toLocaleString('id-ID');
                            $('#ai_insights_last_updated').text('Terakhir diperbarui: ' + updatedTime);
                        }
                        
                        // Display trending products
                        if (insights.trending_products && insights.trending_products.length > 0) {
                            let trendingHtml = '';
                            insights.trending_products.forEach((product, index) => {
                                const rankClass = index === 0 ? 'rank-1' : index === 1 ? 'rank-2' : index === 2 ? 'rank-3' : '';
                                const productName = product.name.split(' - ')[0] || product.name;
                                const productSku = product.name.split(' - ')[1] || '';
                                trendingHtml += `
                                    <div class="ai-trending-product-item">
                                        <div class="ai-trending-product-rank ${rankClass}">${index + 1}</div>
                                        <div class="ai-trending-product-info">
                                            <div class="ai-trending-product-name">${productName}</div>
                                            ${productSku ? `<div class="ai-trending-product-sku">${productSku}</div>` : ''}
                                        </div>
                                        <div class="ai-trending-product-stats">
                                            <div class="ai-trending-product-quantity">${product.quantity_sold || 0}</div>
                                            <div class="ai-trending-product-unit">${product.unit || 'unit'}</div>
                                        </div>
                                    </div>
                                `;
                            });
                            $('#trending_products').html(trendingHtml);
                        } else {
                            $('#trending_products').html(`
                                <div class="ai-loading">
                                    <p>Tidak ada data produk terlaris pada periode ini.</p>
                                </div>
                            `);
                        }
                        
                        // Format and display metrics
                        const revenueTrend = insights.metrics.revenue_trend;
                        const revenueClass = revenueTrend.direction === 'up' ? 'success' : 'error';
                        const revenueText = revenueTrend.direction === 'up' 
                            ? '↑ ' + Math.abs(revenueTrend.value) + '%'
                            : '↓ ' + Math.abs(revenueTrend.value) + '%';
                        $('#revenue_trend').html(`<span class="ai-metric-value ${revenueClass}">${revenueText}</span>`);
                        
                        const profitMargin = insights.metrics.profit_margin;
                        const profitClass = profitMargin.status === 'excellent' ? 'success' 
                            : profitMargin.status === 'good' ? 'info'
                            : profitMargin.status === 'fair' ? 'warning'
                            : 'error';
                        $('#profit_margin').html(`<span class="ai-metric-value ${profitClass}">${profitMargin.value}%</span>`);
                        
                        const collection = insights.metrics.collection_efficiency;
                        const collectionClass = collection.status === 'excellent' ? 'success' 
                            : collection.status === 'good' ? 'info'
                            : collection.status === 'fair' ? 'warning'
                            : 'error';
                        $('#collection_efficiency').html(`<span class="ai-metric-value ${collectionClass}">${collection.value}%</span>`);
                        
                        const stockHealth = insights.metrics.stock_health;
                        const stockClass = stockHealth.status === 'excellent' ? 'success' 
                            : stockHealth.status === 'good' ? 'info'
                            : stockHealth.status === 'fair' ? 'warning'
                            : 'error';
                        const stockText = stockHealth.status === 'excellent' ? 'Excellent' 
                            : stockHealth.status === 'good' ? 'Good' 
                            : stockHealth.status === 'fair' ? 'Fair' 
                            : 'Needs Attention';
                        $('#stock_health').html(`<span class="ai-metric-value ${stockClass}">${stockText}</span>`);
                        
                        // Update recommendations
                        let recommendationsHtml = '';
                        if (insights.recommendations && insights.recommendations.length > 0) {
                            insights.recommendations.forEach((rec) => {
                                const priorityClass = rec.priority === 'high' ? 'priority-high' 
                                    : rec.priority === 'medium' ? 'priority-medium' 
                                    : 'priority-low';
                                recommendationsHtml += `
                                    <div class="ai-recommendation-item ${priorityClass}">
                                        ${rec.message}
                                    </div>
                                `;
                            });
                        } else {
                            recommendationsHtml = `
                                <div class="ai-loading">
                                    <p>Semua sistem berjalan dengan baik! Tidak ada rekomendasi khusus saat ini.</p>
                                </div>
                            `;
                        }
                        $('#ai_recommendations').html(recommendationsHtml);
                        
                        // Update AI summary
                        if (insights.summary) {
                            $('#ai_summary').html(`
                                <div class="ai-summary-content">
                                    ${insights.summary.split('\n\n').map(paragraph => 
                                        `<p>${paragraph.trim()}</p>`
                                    ).join('')}
                                </div>
                            `);
                        } else {
                            $('#ai_summary').html(`
                                <div class="ai-loading">
                                    <p>Ringkasan tidak tersedia saat ini.</p>
                                </div>
                            `);
                        }
                        
                        // Update detailed analysis
                        if (insights.detailed_analysis && insights.detailed_analysis.length > 0) {
                            $('#detailed_analysis').html(
                                insights.detailed_analysis.map((section) => `
                                    <div class="ai-analysis-item">
                                        <div class="ai-analysis-item-title">${section.title}</div>
                                        <div class="ai-analysis-item-content">${section.content}</div>
                                    </div>
                                `).join('')
                            );
                        } else {
                            $('#detailed_analysis').html(`
                                <div class="ai-loading">
                                    <p>Data analisis detail tidak tersedia saat ini.</p>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ AI Insights: Error loading insights', {
                            status: status,
                            error: error,
                            response: xhr.responseJSON || xhr.responseText,
                            statusCode: xhr.status
                        });
                        
                        // Show error states
                        $('#revenue_trend').html('<span class="ai-metric-value error">Error</span>');
                        $('#profit_margin').html('<span class="ai-metric-value error">Error</span>');
                        $('#collection_efficiency').html('<span class="ai-metric-value error">Error</span>');
                        $('#stock_health').html('<span class="ai-metric-value error">Error</span>');
                        
                        $('#ai_recommendations').html(`
                            <div class="ai-error">
                                <svg class="ai-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p style="font-weight: 500; margin-bottom: 8px;">Gagal memuat rekomendasi</p>
                                <p style="font-size: 12px;">Silakan refresh atau periksa koneksi Anda.</p>
                            </div>
                        `);
                        $('#ai_summary').html(`
                            <div class="ai-error">
                                <svg class="ai-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p style="font-weight: 500; margin-bottom: 8px;">Gagal memuat ringkasan</p>
                                <p style="font-size: 12px;">Silakan refresh atau periksa koneksi Anda.</p>
                            </div>
                        `);
                        $('#trending_products').html(`
                            <div class="ai-error">
                                <svg class="ai-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p style="font-weight: 500; margin-bottom: 8px;">Gagal memuat produk terlaris</p>
                                <p style="font-size: 12px;">Silakan refresh atau periksa koneksi Anda.</p>
                            </div>
                        `);
                        $('#detailed_analysis').html(`
                            <div class="ai-error">
                                <svg class="ai-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p style="font-weight: 500; margin-bottom: 8px;">Gagal memuat analisis</p>
                                <p style="font-size: 12px;">Silakan refresh atau periksa koneksi Anda.</p>
                            </div>
                        `);
                    }
                });
            }

            // Load AI insights on page load
            loadAIInsights();

            // Refresh insights when button is clicked
            $('#refresh_ai_insights').on('click', function() {
                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.prop('disabled', true);
                $btn.addClass('tw-opacity-75 tw-cursor-not-allowed');
                $btn.html(`
                    <svg class="tw-w-4 tw-h-4 tw-animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Refreshing...</span>
                `);
                
                // Clear cache by adding timestamp
                loadAIInsights();
                
                setTimeout(() => {
                    $btn.prop('disabled', false);
                    $btn.removeClass('tw-opacity-75 tw-cursor-not-allowed');
                    $btn.html(originalHtml);
                }, 3000);
            });

            // Also refresh insights when dashboard data changes
            $('#dashboard_location').on('change', function() {
                setTimeout(loadAIInsights, 500);
            });
            
            // Listen for daterangepicker apply event
            $(document).on('apply.daterangepicker', '#dashboard_date_filter', function(ev, picker) {
                setTimeout(loadAIInsights, 500);
            });
        });
    </script>
    
@endsection