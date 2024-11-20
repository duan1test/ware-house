<x-app-layout>
    <div class="md:px-0">
        <section class="-mt-4 mb-4 mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-md bg-white" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <div class="flex items-start justify-between">
                        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 truncate">{{ $data['checkins'] }}</h2>
                        @if($data['checkins'] != 0 && $data['previous_checkins'] != 0)
                            <span class="flex items-center space-x-1 text-sm font-medium leading-none {{ $data['checkins'] > $data['previous_checkins'] ? 'text-green-500' : 'text-red-500' }}">
                                @if($data['checkins'] > $data['previous_checkins'])
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                @else
                                    <i class="fa-solid fa-arrow-trend-down"></i>
                                @endif
                                <span>{{ number_format(($data['checkins'] / $data['previous_checkins']) * 100 - 100, 2) }}%</span>
                            </span>
                        @endif
                    </div>
                    <p class="leading-none text-gray-600">{{ __('common.dashboard.checkin') }}</p>
                </div>
        
                <div class="p-4 rounded-md bg-white" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <div class="flex items-start justify-between">
                        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 truncate">{{ $data['checkouts'] }}</h2>
                        @if($data['checkouts'] != 0 && $data['previous_checkouts'] != 0)
                            <span class="flex items-center space-x-1 text-sm font-medium leading-none {{ $data['checkouts'] > $data['previous_checkouts'] ? 'text-green-500' : 'text-red-500' }}">
                                @if($data['checkouts'] > $data['previous_checkouts'])
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                @else
                                    <i class="fa-solid fa-arrow-trend-down"></i>
                                @endif
                                <span>{{ number_format(($data['checkouts'] / $data['previous_checkouts']) * 100 - 100, 2) }}%</span>
                            </span>
                        @endif
                    </div>
                    <p class="leading-none text-gray-600">{{ __('common.dashboard.checkout') }}</p>
                </div>
        
                <div class="p-4 rounded-md bg-white" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <div class="flex items-start justify-between">
                        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 truncate">{{ $data['items'] }}</h2>
                    </div>
                    <p class="leading-none text-gray-600">{{ __('common.dashboard.item') }}</p>
                </div>
        
                <div class="p-4 rounded-md bg-white" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <div class="flex items-start justify-between">
                        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 truncate">{{ $data['contacts'] }}</h2>
                    </div>
                    <p class="leading-none text-gray-600">{{ __('common.dashboard.contact') }}</p>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="bg-white rounded-md" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <select id="monthSelector" class="form-select choices">
                        @php
                            $currentMonth = request()->month ?? \Carbon\Carbon::now()->month;
                        @endphp
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" 
                                @if ($currentMonth == $i) selected @endif>
                                {{ __('common.dashboard.month') . ' ' . $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="bg-white rounded-md" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <select id="yearSelector" class="form-select choices">
                        @php
                            $currentYear = \Carbon\Carbon::now()->year;
                            $selectedYear = request()->year ?? $currentYear;
                        @endphp
                        @for ($i = 0; $i < 5; $i++)
                            <option value="{{ $currentYear - $i }}" 
                                @if ($selectedYear == ($currentYear - $i)) selected @endif>
                                {{ $currentYear - $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        
        <div class="mt-4 bg-white rounded-md shadow overflow-x-auto">
            <div id="barChartContainer" style="min-width: 550px;"></div>
        </div>
        
        <div class="mt-4 flex items-start flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2 bg-white rounded-md shadow overflow-x-auto">
                <div id="pieChartContainer"></div>
            </div>
        
            <div class="w-full md:w-1/2 bg-white rounded-md shadow overflow-x-auto">
                <div id="radialChartContainer" style="min-width: 550px;"></div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script type="module">
            const dataChart = @json($chart);
            const topProducts = @json($top_products);
            const localeSetting = @json(get_settings('default_locale'));
            const translation = {
                barCharTitle: '{{ __('common.dashboard.bar_chart_title') }}',
                radial_chart_title: '{{ __('common.dashboard.radial_chart_title') }}',
                pie_chart_title: '{{ __('common.dashboard.pie_chart_title') }}',
                bar_chart_subtitle: '{{ __('common.dashboard.bar_chart_subtitle') }}',
                pie_chart_subtitle: '{{ __('common.dashboard.pie_chart_subtitle') }}',
                checkin: '{{ __('common.dashboard.checkin') }}',
                checkout: '{{ __('common.dashboard.checkout') }}',
                adjustment: '{{ __('common.dashboard.adjustment') }}',
                transfer: '{{ __('common.dashboard.transfer') }}',
                movement: '{{ __('common.dashboard.movement') }}',
            };

            $(document).ready(function() {

                function monthName(month, locale = localeSetting, style = 'short') {
                    let formatted = new Date(Date.parse(month));
                    return formatted.toLocaleString(locale, { month: style, year: '2-digit' });
                }

                function date(date, locale = localeSetting, style = 'medium') {
                    let formatted = new Date(Date.parse(date));
                    return formatted.toLocaleString(locale, { dateStyle: style });
                }

                function getYears() {
                    let years = [];
                    let date = new Date();
                    let currentYear = date.getFullYear();
                    for (let y = 2020; y <= currentYear; y++) {
                        years.push({ label: y + '', value: y + '' });
                    }
                    return years;
                }

                function sortValues(data) {
                    return Object.values(
                        Object.keys(data)
                            .sort()
                            .reduce(function(obj, key) {
                                obj[key] = data[key];
                                return obj;
                            }, {})
                    );
                }

                let categoriesBarChart = Object.keys(dataChart.year.checkin)
                .sort()
                .map(function(d) {
                    return monthName(d);
                });

                let categoriesRadialChart = Object.keys(dataChart.month.checkin)
                .sort()
                .map(function(d) {
                    return date(d);
                });
                
                // barChart
                let barChartOptions = {
                    chart: {
                        type: 'column',
                        spacingTop: 20,
                        style: { fontFamily: ['Roboto', 'sans-serif'] }
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: translation.barCharTitle,
                        style: { fontWeight: 'bold', paddingTop: '10px' }
                    },
                    subtitle: {
                        text: translation.bar_chart_subtitle,
                    },
                    colors: ['#059669', '#D97706', '#4F46E5', '#DC2626'],
                    xAxis: {
                        categories: categoriesBarChart, 
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        shared: true,
                        shadow: false,
                        useHTML: true,
                        borderRadius: '5',
                        borderColor: '#1F2937',
                        style: { color: '#fff' },
                        backgroundColor: '#1F2937'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [
                        {
                            name: translation.checkin,
                            data: sortValues(dataChart.year.checkin)
                        },
                        {
                            name: translation.checkout,
                            data: sortValues(dataChart.year.checkout)
                        },
                        {
                            name: translation.adjustment,
                            data: sortValues(dataChart.year.adjustment)
                        },
                        {
                            name: translation.transfer,
                            data: sortValues(dataChart.year.transfer)
                        }
                    ]
                };

                Highcharts.chart('barChartContainer', barChartOptions);

                // radial chart
                let radialChartOptions = {
                    chart: {
                        zoomType: 'xy',
                        spacingTop: 20,
                        style: { fontFamily: ['Roboto', 'sans-serif'] },
                    },
                    credits: {
                        enabled: false,
                    },
                    title: {
                        text: translation.radial_chart_title,
                        style: { fontWeight: 'bold', paddingTop: '10px' },
                    },
                    subtitle: {
                        text: translation.bar_chart_subtitle,
                    },
                    colors: ['#059669', '#D97706', '#4F46E5', '#DC2626'],
                    xAxis: [{
                        categories: categoriesRadialChart,
                        crosshair: true,
                    }],
                    yAxis: {
                        min: 0,
                        title: {
                            text: '',
                        },
                    },
                    tooltip: {
                        shared: true,
                        shadow: false,
                        useHTML: true,
                        borderRadius: '5',
                        borderColor: '#1F2937',
                        style: { color: '#fff' },
                        backgroundColor: '#1F2937',
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                enabled: false,
                            },
                        },
                    },
                    series: [
                        {
                            type: 'spline',
                            name: translation.checkin,
                            data: sortValues(dataChart.month.checkin),
                        },
                        {
                            type: 'spline',
                            name: translation.checkout,
                            data: sortValues(dataChart.month.checkout),
                        },
                        {
                            type: 'spline',
                            name: translation.transfer,
                            data: sortValues(dataChart.month.transfer),
                        },
                        {
                            type: 'spline',
                            name: translation.adjustment,
                            data: sortValues(dataChart.month.adjustment),
                        },
                    ],
                };
                Highcharts.chart('radialChartContainer', radialChartOptions);

                // pie chart
                let pieChartOptions = {
                    chart: {
                        type: 'pie',
                        spacingTop: 20,
                        plotShadow: false,
                        plotBorderWidth: null,
                        plotBackgroundColor: null,
                        style: { fontFamily: ['Roboto', 'sans-serif'] },
                    },
                    credits: {
                        enabled: false,
                    },
                    title: {
                        text: translation.pie_chart_title,
                        style: { fontWeight: 'bold', paddingTop: '10px' },
                    },
                    subtitle: {
                        text: translation.pie_chart_subtitle,
                    },
                    colors: ['#059669', '#D97706', '#4F46E5', '#DC2626', '#3182CE', '#DB2777', '#4B5563', '#805AD5', '#38B2AC', '#ECC94B'],
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                        shared: true,
                        shadow: false,
                        useHTML: true,
                        borderRadius: '5',
                        borderColor: '#1F2937',
                        style: { color: '#fff' },
                        backgroundColor: '#1F2937',
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false,
                            },
                            showInLegend: true,
                        },
                    },
                    series: [{
                        colorByPoint: true,
                        name: translation.movement,
                        data: topProducts.sort((a, b) => (a.y < b.y ? 1 : -1)).map((i, ii) => (ii ? i : { ...i, sliced: true, selected: true })),
                    }],
                };
                Highcharts.chart('pieChartContainer', pieChartOptions); 

            });

            $('.choices__inner').addClass('bg-white');

            $('#monthSelector, #yearSelector').on('change', function() {
                var selectedYear = $('#yearSelector').val();
                var selectedMonth = $('#monthSelector').val();
                window.location.href = "{{ route('dashboard') }}" + '?month=' + selectedMonth + '&year=' + selectedYear;
            });
        </script>
    @endpush
</x-app-layout>
