<?php

namespace App\Http\Controllers;

use App\Actions\Tec\ChartData;
use Illuminate\Http\Request;
use App\Models\{Checkin, Checkout, Contact, Item};

class DashboardController extends Controller
{
    public function form(Request $request)
    {
        return $request->validate([
            'month' => 'nullable|integer|date_format:n',
            'year'  => 'nullable|integer|date_format:Y',
        ]);
    }

    public function index(Request $request)
    {

        $this->form($request);
        $data = Item::selectRaw('COUNT(*) as items')
            ->addSelect(['checkins' => Checkin::selectRaw('COUNT(*) as checkins')->active()
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()]), ])
            ->addSelect(['checkouts' => Checkout::selectRaw('COUNT(*) as checkouts')->active()
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()]), ])
            ->addSelect(['previous_checkins' => Checkin::selectRaw('COUNT(*) as checkins')->active()
            ->whereBetween('date', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]), ])
            ->addSelect(['previous_checkouts' => Checkout::selectRaw('COUNT(*) as checkouts')->active()
            ->whereBetween('date', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]), ])
            ->addSelect(['contacts' => Contact::selectRaw('COUNT(*) as contacts')])->first();
        $chart = new ChartData($request->get('month'), $request->get('year'));
        return view('pages.dashboard.index', [
            'data'         => $data,
            'top_products' => $chart->topProducts(),
            'chart'        => ['year' => $chart->year(), 'month' => $chart->month()],
        ]);
    }
}
