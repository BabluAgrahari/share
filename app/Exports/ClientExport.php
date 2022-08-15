<?php

namespace App\Exports;

use App\Models\Client;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientExport extends Export implements FromArray, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function array(): array
    {
        $request = (object)$this->request;
        $query = Client::query();

        if (!empty($request->file_no))
            $query->where('file_no', 'LIKE', "%$request->file_no%");

        if (!empty($request->share_holder))
            $query->where('share_holder', $request->share_holder);

        if (!empty($request->status))
            $query->where('status', $request->status);

        if (!empty($request->date_range)) {
            list($start_date, $end_date) = explode('-', $request->date_range);
            $start_date = strtotime(trim($start_date) . " 00:00:00");
            $end_date   = strtotime(trim($end_date) . " 23:59:59");
        } else {
           $start_date = $this->start_date;
           $end_date   = $this->end_date;
        }
        $query->whereBetween('created', [$start_date, $end_date]);

        if (Auth::user()->role == 'staff' || Auth::user()->role == 'supervisor') {
            $client_ids = !empty(Auth::user()->client_id) ? json_decode(Auth::user()->client_id) : array();
            $query->whereIn('id', $client_ids);
        }

        $records = $query->orderBy('created', 'DESC')->with(['Company', 'Court'])->get();

        $reults = [];
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $total_unit = 0;
                if (!empty($record->company)) {
                    foreach ($record->company as $comp) {
                        $total_unit += $comp->unit;
                    }
                }
                $reults[] = [
                    'file_no'          => $record->file_no,
                    'folio_no'         => $record->folio_no,
                    'share_holder'     => $record->share_holder,
                    'survivor_name'    => $record->survivor_name,
                    'share_unit'       => $total_unit,
                    'follow_up_status' => ($record->follow_up_status == 1) ? 'Completed' : 'Pending',
                    'date'             => $record->dformat($record->date),
                    'court'            => !empty($record->court->court_name) ? $record->court->court_name : '',
                    'city'             => $record->city,
                    'state'            => $record->state,
                    'pin'              => $record->pin,
                    'address'          => $record->address,
                    'remarks'          => $record->remarks,
                    'cp_designation'   => $record->cp_designation,
                    'cp_name'          => $record->cp_name,
                    'cp_email'         => $record->cp_email,
                    'cp_mobile'        => $record->cp_phone,
                    'created'          => $record->dformat($record->created),
                ];
            }
        }
        return $reults;
    }

    public function headings(): array
    {
        return [
            'File No',
            'Folio No',
            'Share Holder',
            'Survivor Name',
            'Share Unit',
            'Follow Up Status',
            'Date',
            'Court',
            'City',
            'State',
            'Pin',
            'Address',
            'Remarks',
            'CP Designation',
            'CP Name',
            'CP Email',
            'CP Mobile',
            'Created'
        ];
    }
}
