<?php

namespace App\Http\Controllers;

use App\Low;
use App\Sale;
use App\User;
use App\Credit;
use App\Payment;
use App\Coupon;
use Carbon\Carbon;
use App\CreditDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Estadisticas';
       

        $date_start = $date_end = Carbon::today();

        if ($request->has('start') && !empty($request->get('start'))) 
        {
            $date_end = $date_start = Carbon::createFromFormat('d/m/Y', $request->get('start'));

            if (! empty($request->get('end'))) {
                $date_end = Carbon::createFromFormat('d/m/Y', $request->get('end'));
            }
        }

        $totalMoney = Payment::whereDate('created_at', '>=', $date_start->format('Y-m-d'))
            ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
            ->sum('amount');

        $totalCash = Payment::where('way_to_pay', 'cash')
            ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))   
            ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
            ->sum('amount');

        $totalCard = Payment::whereIn('way_to_pay', ['card', 'online'])
            ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
            ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
            ->sum('amount');

        $totalDues = CreditDetail::where('is_payed', 1)
            ->whereDate('fee_date', '>=', $date_start->format('Y-m-d'))
            ->whereDate('fee_date', '<=', $date_end->format('Y-m-d'))
            ->sum('fee_amount');

        $totalDuesExpired = CreditDetail::where('is_expired', 1)
            ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
            ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
            ->sum('fee_amount');

        $lowCoupon = Low::LowCoupon($date_start->format('Y-m-d'), $date_end->format('Y-m-d'), 1);
        $lowCredit = Low::LowCoupon($date_start->format('Y-m-d'), $date_end->format('Y-m-d'), 0);
        $lowSale   = Low::LowCoupon($date_start->format('Y-m-d'), $date_end->format('Y-m-d'), 2);
        $refund    = Low::Refund($date_start->format('Y-m-d'), $date_end->format('Y-m-d'), 2);
        $discounts = Sale::where('discount', '!=', NULL)
                           ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                           ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                           ->get();
        //Graficas
        $chartSales = [
            'simple' => [
                'count' => Sale::where('type', 'simple')
                    ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#00a65a',
                'label' => 'Ventas directas',
            ],
            'online' => [
                'count' => Sale::where('type', 'online')
                    ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#ff5733',
                'label' => 'Ventas online',
            ],
            'other' => [
                'count' => Sale::where('type', 'other')
                    ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#ff335b',
                'label' => 'Ventas otras cuentas',
            ],
            'sing' => [
                'count' => Sale::where('type', 'sing')
                    ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#f39c12',
                'label' => 'Ventas por seña',
            ],
            'credit' => [
                'count' => Sale::whereNotIn('type', ['simple', 'sing'])
                    ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#3c8dbc',
                'label' => 'Creditos',
            ]
        ];
        array_multisort($chartSales, SORT_DESC);

        $chartDues = [
            'payed' => [
                'count' => CreditDetail::where('is_payed', 1)
                    ->whereDate('fee_date', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('fee_date', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#00a65a',
                'label' => 'Pagadas',
            ],
            'expired' => [
                'count' => CreditDetail::where([
                        ['is_payed', false],
                        ['is_expired', true]
                    ])
                    ->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date_end->format('Y-m-d'))
                    ->count(),
                'color' => '#d33724',
                'label' => 'Vencidas',
            ]
        ];
        array_multisort($chartDues, SORT_DESC);

        $users = User::with([
                'payments' => function ($query) use ($date_start, $date_end) 
                {
                    $query->whereDate('created_at', '>=', $date_start->format('Y-m-d'))
                        ->whereDate('created_at', '<=', $date_end->format('Y-m-d'));
                }
            ])
            ->with([
                'sales' => function ($query) use ($date_start, $date_end)
                {
                    $query->where('created_at', '>=', $date_start)
                        ->where('created_at', '<=', $date_end);
                }
            ])->get();

        

        $users->each(function ($user){
            $user->payments->filter()->all();

            $user->sales->filter()->all();
        });

        return view('home')->with(compact(
            'title',
            'totalMoney',
            'totalCash',
            'totalCard',
            'totalDues',
            'totalDuesExpired',
            'refund',
            'chartSales',
            'chartDues',
            'date_start',
            'date_end',
            'users',
            'lowCoupon',
            'lowCredit',
            'lowSale',
            'discounts'
        ));
    }   

}