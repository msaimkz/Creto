<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($request)
    {

        $this->request = $request;
    }
    public function view(): View
    {
        $users = User::where('role', 0)->latest('users.created_at')->select('users.*', 'customer_details.mobile', 'customer_details.country_id')
            ->leftJoin('customer_details', 'users.id', '=', 'customer_details.user_id');


        if (!empty($this->request->get('keyword'))) {
            $users = $users->where('name', 'like', '%' .$this->request->get('keyword'). '%');
        }

        return view('Excel.user', [
            'users' => $users->get()
        ]);
    }
}
