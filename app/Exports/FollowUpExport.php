<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\FollowUpClient;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FollowUpExport extends Export implements FromArray, WithHeadings
{
    protected $request;

    public function __construct($request,$status)
    {
        parent::__construct();
        $this->request = $request;
        $this->status = $status;
    }

    public function array(): array
    {
        $request = (object)$this->request;
        $query = FollowUpClient::query();

        if (!empty($request->client))
            $query->where('client_id', $request->client);

        if (!empty($this->status) && $this->status != 'all')
            $query->where('status', $this->status);

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
            $query->whereIn('client_id', $client_ids);
        }

        $records = $query->orderBy('created', 'DESC')->with(['Client', 'TransAgent', 'Court', 'Company', 'User'])->get();

        $reults = [];
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $reults[] = [
                    'file_no'          => !empty($record->client->file_no) ? $record->client->file_no : '',
                    'share_holder'     => !empty($record->client->share_holder) ? $record->client->share_holder : '',
                    'survivor_name'    => !empty($record->client->survivor_name) ? $record->client->survivor_name : '',
                    'city'             => !empty($record->client->city) ? $record->client->city : '',
                    'last_user'        => !empty($record->user->name) ? ucwords($record->user->name) : '',
                    'follow_up_date'   => $record->dformat($record->follow_up_date),
                    'remarks'          => $record->remarks,
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
            'Share Holder',
            'Survivor Name',
            'City',
            'Last User',
            'Follow Up Date',
            'Remarks',
            'Created'
        ];
    }
}
