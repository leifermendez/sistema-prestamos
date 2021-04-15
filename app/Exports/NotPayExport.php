<?php

namespace App\Exports;

use App\db_credit;
use App\db_summary;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotPayExport implements FromView, WithHeadings
{
    public function __construct(string $date_start, string $date_end,  int  $user_id)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->user_id = $user_id;
    }
    public function view(): View
    {

        $data_credit =  db_credit::whereDate('credit.created_at', '>=', Carbon::createFromFormat('d/m/Y', $this->date_start),)
            ->whereDate('credit.created_at', '<=', Carbon::createFromFormat('d/m/Y', $this->date_end))
            ->where('credit.status', 'inprogress')
            ->where('credit.id_agent', $this->user_id)
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select(
                'credit.*',
                'users.name',
                'users.last_name',
            )
            ->orderBy('credit.created_at', 'asc')
            ->get();

        foreach ($data_credit as $credit) {
            if (db_credit::where('id', $credit->id)->exists()) {
                $summary  = db_summary::where('id_credit', $credit->id)
                    ->orderBy('summary.created_at', 'asc')->get();
                $credit->summary = $summary;
            }
        }

        $data = array('credit' => $data_credit);
        return view('not-payments.export-not-pay', $data);
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Cliente',
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
        ];
    }
}
