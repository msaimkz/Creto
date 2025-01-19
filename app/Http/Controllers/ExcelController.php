<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Mail\OrderEmail;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    public function userExcel(Request $request){
        
        return Excel::download(new UsersExport($request), 'users.xlsx');
    }

    public function OrderExcel(Request $request){
        
        return Excel::download(new OrdersExport($request), 'orders.xlsx');

    }
}
