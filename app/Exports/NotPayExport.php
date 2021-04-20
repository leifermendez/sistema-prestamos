<?php

namespace App\Exports;

use App\db_credit;
use App\db_summary;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NotPayExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(string $date_start, string $date_end,  int  $user_id)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->user_id = $user_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data_credit  = db_credit::where('credit.id_agent', $this->user_id)
            ->where('credit.status', 'inprogress')
            ->join('users', 'users.id', '=', 'credit.id_user')
            ->orderBy('credit.created_at', 'asc')
            ->select(
                'credit.id as id_credit',
                'users.id as id_user',
                'users.name',
                'users.last_name'
            )
            ->get();

        $startDate = Carbon::createFromFormat('d/m/Y', $this->date_start);
        $endDate = Carbon::createFromFormat('d/m/Y', $this->date_end);
        $dateRanges = CarbonPeriod::create($startDate, $endDate);
        $daysOfWeek = [];

        foreach ($data_credit as $data) {
            if (db_credit::where('id_user', $data->id_user)->where('id_agent', $this->user_id)->exists()) {

                foreach ($dateRanges->toArray() as $dateRange) {
                    $day = Carbon::parse($dateRange)->Format('l');
                    $daysOfWeek[$day] =  db_summary::where('id_credit', $data->id_credit)
                        ->whereDate('summary.created_at', '=', $dateRange)
                        ->sum('amount');
                }
                $data->summary_day = $daysOfWeek;
            }
        }
        return $data_credit;
    }
    public function map($row): array
    {
        return [
            $row->name . ' ' . $row->last_name,
            $row->summary_day['Monday'] > 0 ?  $row->summary_day['Monday'] . '000' :  '0',
            $row->summary_day['Tuesday'] > 0 ?   $row->summary_day['Tuesday'] . '000' :  '0',
            $row->summary_day['Wednesday'] > 0 ?   $row->summary_day['Wednesday'] . '000' :  '0',
            $row->summary_day['Thursday'] > 0 ?    $row->summary_day['Thursday'] . '000' :  '0',
            $row->summary_day['Friday'] > 0 ?  $row->summary_day['Friday'] . '000' :  '0',
            $row->summary_day['Saturday'] > 0 ?   $row->summary_day['Saturday'] . '000' :  '0',
            $row->summary_day['Sunday'] > 0 ?   $row->summary_day['Sunday'] . '000' :  '0',
        ];
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
            'Domingo',
        ];
    }
}
