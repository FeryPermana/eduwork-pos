<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Profit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //day
        $day    = date('d');

        //week
        $week = Carbon::now()->subDays(7);

        $chart_sales_week = DB::table('transactions')
            ->addSelect(DB::raw('DATE(created_at) as date, SUM(grand_total) as grand_total'))
            ->where('created_at', '>=', $week)
            ->groupBy('date')
            ->get();

        if (count($chart_sales_week)) {
            foreach ($chart_sales_week as $result) {
                $label_bar[]    = $result->date;
                $data_bar[]   = $result->grand_total;
            }
        } else {
            $label_bar[]   = "";
            $data_bar[]  = "";
        }

        $chart_best_products = DB::table('transaction_details')
            ->select(DB::raw('products.title as title, SUM(transaction_details.qty) as total'))
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->groupBy('transaction_details.product_id', 'products.title') // Include both columns in GROUP BY
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();

        if (count($chart_best_products)) {
            foreach ($chart_best_products as $data) {
                $product[] = $data->title;
                $total[]   = (int)$data->total;
            }
        } else {
            $product[]   = "";
            $total[]  = "";
        }

        //count sales today
        $count_sales_today = Transaction::whereDay('created_at', $day)->count();

        //sum sales today
        $sum_sales_today = Transaction::whereDay('created_at', $day)->sum('grand_total');

        //sum profits today
        $sum_profits_today = Profit::whereDay('created_at', $day)->sum('total');

        //get product limit stock
        $products_limit_stock = Product::with('category')->where('stock', '<=', 10)->get();

        $data = [
            'label_bar' => $label_bar,
            'data_bar' => $data_bar,
            'product' => $product,
            'total' => $total,
            'count_sales_today' => $count_sales_today,
            'sum_sales_today' => $sum_sales_today,
            'sum_profits_today' => $sum_profits_today,
            'products_limit_stock' => $products_limit_stock
        ];

        return view('home', $data);
    }
}
