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
            <div class="tw-py-6">
                <div class="tw-transition-all tw-duration-200 tw-bg-white tw-from-purple-50 tw-to-indigo-50 tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md tw-ring-gray-200">
                    <div class="tw-p-6 sm:tw-p-8">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-6">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-rounded-full tw-bg-gradient-to-r tw-from-purple-500 tw-to-indigo-600">
                                <svg aria-hidden="true" class="tw-w-6 tw-h-6 tw-text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M9 12h6"></path>
                                    <path d="M9 16h6"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="tw-text-xl tw-font-bold tw-text-gray-900">AI Business Insights</h3>
                                <p class="tw-text-sm tw-text-gray-600">Smart analysis of your business performance</p>
                            </div>
                            <button id="refresh_ai_insights" class="tw-ml-auto tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-black tw-bg-white tw-from-purple-500 tw-to-indigo-600 tw-rounded-lg hover:tw-from-purple-600 hover:tw-to-indigo-700 tw-transition-colors">
                                <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Insights
                            </button>
                        </div>
                        
                        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6">
                            <!-- Key Metrics Summary -->
                            <div class="tw-bg-white tw-rounded-lg tw-p-6 tw-shadow-sm tw-ring-1 tw-ring-gray-200">
                                <h4 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-mb-4">Performance Summary</h4>
                                <div class="tw-space-y-4">
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <span class="tw-text-sm tw-text-gray-600">Revenue Trend</span>
                                        <span class="tw-text-sm tw-font-medium tw-text-green-600" id="revenue_trend">Loading...</span>
                                    </div>
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <span class="tw-text-sm tw-text-gray-600">Profit Margin</span>
                                        <span class="tw-text-sm tw-font-medium" id="profit_margin">Loading...</span>
                                    </div>
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <span class="tw-text-sm tw-text-gray-600">Collection Efficiency</span>
                                        <span class="tw-text-sm tw-font-medium" id="collection_efficiency">Loading...</span>
                                    </div>
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <span class="tw-text-sm tw-text-gray-600">Stock Health</span>
                                        <span class="tw-text-sm tw-font-medium" id="stock_health">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <!-- AI Recommendations -->
                            <div class="tw-bg-white tw-rounded-lg tw-p-6 tw-shadow-sm tw-ring-1 tw-ring-gray-200">
                                <h4 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-mb-4">Smart Recommendations</h4>
                                <div class="tw-space-y-3" id="ai_recommendations">
                                    <div class="tw-flex tw-items-start tw-gap-3">
                                        <div class="tw-inline-flex tw-items-center tw-justify-center tw-w-6 tw-h-6 tw-rounded-full tw-bg-blue-100 tw-text-blue-600 tw-flex-shrink-0 tw-mt-0.5">
                                            <svg class="tw-w-3 tw-h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="tw-text-sm tw-text-gray-700">Analyzing your business data...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Insights -->
                        <div class="tw-mt-6 tw-bg-white tw-rounded-lg tw-p-6 tw-shadow-sm tw-ring-1 tw-ring-gray-200">
                            <h4 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-mb-4">Detailed Analysis</h4>
                            <div class="tw-prose tw-prose-sm tw-max-w-none" id="detailed_analysis">
                                <div class="tw-flex tw-items-center tw-justify-center tw-py-8">
                                    <div class="tw-animate-pulse tw-text-gray-400">
                                        Generating intelligent insights...
                                    </div>
                                </div>
                            </div>
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
                $('#revenue_trend').html('<span class="tw-animate-pulse">Analyzing...</span>');
                $('#profit_margin').html('<span class="tw-animate-pulse">Calculating...</span>');
                $('#collection_efficiency').html('<span class="tw-animate-pulse">Evaluating...</span>');
                $('#stock_health').html('<span class="tw-animate-pulse">Checking...</span>');
                
                $('#ai_recommendations').html(`
                    <div class="tw-flex tw-items-center tw-justify-center tw-py-4">
                        <div class="tw-animate-pulse tw-text-gray-400">Generating recommendations...</div>
                    </div>
                `);
                
                $('#detailed_analysis').html(`
                    <div class="tw-flex tw-items-center tw-justify-center tw-py-8">
                        <div class="tw-animate-pulse tw-text-gray-400">Analyzing business data...</div>
                    </div>
                `);

                // Simulate API call to get AI insights
                setTimeout(function() {
                    // This would typically be an AJAX call to your backend
                    // For now, we'll simulate the response
                    const insights = generateAIInsights();
                    
                    // Update metrics
                    $('#revenue_trend').html(insights.metrics.revenue_trend);
                    $('#profit_margin').html(insights.metrics.profit_margin);
                    $('#collection_efficiency').html(insights.metrics.collection_efficiency);
                    $('#stock_health').html(insights.metrics.stock_health);
                    
                    // Update recommendations
                    let recommendationsHtml = '';
                    insights.recommendations.forEach(rec => {
                        recommendationsHtml += `
                            <div class="tw-flex tw-items-start tw-gap-3">
                                <div class="tw-inline-flex tw-items-center tw-justify-center tw-w-6 tw-h-6 tw-rounded-full ${rec.type === 'warning' ? 'tw-bg-yellow-100 tw-text-yellow-600' : rec.type === 'success' ? 'tw-bg-green-100 tw-text-green-600' : 'tw-bg-blue-100 tw-text-blue-600'} tw-flex-shrink-0 tw-mt-0.5">
                                    <svg class="tw-w-3 tw-h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="tw-text-sm tw-text-gray-700">${rec.message}</p>
                            </div>
                        `;
                    });
                    $('#ai_recommendations').html(recommendationsHtml);
                    
                    // Update detailed analysis
                    $('#detailed_analysis').html(`
                        <div class="tw-space-y-4">
                            ${insights.detailed_analysis.map(section => `
                                <div>
                                    <h5 class="tw-font-semibold tw-text-gray-900 tw-mb-2">${section.title}</h5>
                                    <p class="tw-text-sm tw-text-gray-700">${section.content}</p>
                                </div>
                            `).join('')}
                        </div>
                    `);
                    
                }, 2000); // Simulate 2 second delay for AI processing
            }

            function generateAIInsights() {
                // This is a simulation - in real implementation, this would call your AI service
                // or backend API that processes the business data
                return {
                    metrics: {
                        revenue_trend: '<span class="tw-text-green-600">↑ 12% growth</span>',
                        profit_margin: '<span class="tw-text-blue-600">24.5%</span>',
                        collection_efficiency: '<span class="tw-text-yellow-600">78% - Needs attention</span>',
                        stock_health: '<span class="tw-text-green-600">Good</span>'
                    },
                    recommendations: [
                        {
                            type: 'warning',
                            message: 'Focus on collecting outstanding invoices to improve cash flow.'
                        },
                        {
                            type: 'info',
                            message: 'Consider restocking top-performing products based on recent sales trends.'
                        },
                        {
                            type: 'success',
                            message: 'Your profit margin is healthy - consider scaling successful product lines.'
                        }
                    ],
                    detailed_analysis: [
                        {
                            title: 'Revenue Performance',
                            content: 'Your business shows strong revenue growth of 12% compared to last period. The sales charts indicate consistent performance with some seasonal variations that could be optimized.'
                        },
                        {
                            title: 'Financial Health',
                            content: 'Current profit margins are healthy at 24.5%. However, collection efficiency at 78% indicates room for improvement in accounts receivable management.'
                        },
                        {
                            title: 'Inventory Insights',
                            content: 'Stock levels are generally good, but monitor the products in stock alerts to prevent potential stockouts. Consider implementing automated reordering for fast-moving items.'
                        },
                        {
                            title: 'Opportunities',
                            content: 'Based on payment recovery data, there are opportunities to improve payment collection processes. Implementing automated payment reminders could boost collection rates.'
                        }
                    ]
                };
            }

            // Load AI insights on page load
            loadAIInsights();

            // Refresh insights when button is clicked
            $('#refresh_ai_insights').on('click', function() {
                $(this).prop('disabled', true);
                loadAIInsights();
                setTimeout(() => {
                    $(this).prop('disabled', false);
                }, 2000);
            });

            // Also refresh insights when dashboard data changes
            $('#dashboard_location, #dashboard_date_filter').on('change', function() {
                setTimeout(loadAIInsights, 500);
            });
        });
    </script>
    
@endsection