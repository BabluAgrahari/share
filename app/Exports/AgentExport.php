<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\FollowUpClient;
use App\Models\TransferAgent;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgentExport extends Export implements FromArray, WithHeadings
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

        $query = TransferAgent::query();

        if (!empty($request->transfer_agent))
            $query->where('transfer_agent', 'LIKE', "%$request->transfer_agent%");

        if (!empty($request->email))
            $query->where('email', $request->email);

        if (!empty($request->phone))
            $query->where('phone', $request->phone);

        if (!empty($request->status))
            $query->where('status', $request->status);

        $records = $query->orderBy('created', 'DESC')->get();

        $reults = [];
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $reults[] = [
                    'agent_name'       => $record->transfer_agent,
                    'phone_no'         => $record->phone,
                    'email'            => $record->email,
                    'city'             => $record->city,
                    'state'            => $record->state,
                    'pin'              => $record->pin,
                    'address'          => $record->address,
                    'cp_designation'   => $record->cp_designation,
                    'cp_name'          => $record->cp_name,
                    'cp_email'         => $record->cp_email,
                    'cp_phone'         => $record->cp_phone,
                    'created'          => $record->dformat($record->created),
                ];
            }
        }
        return $reults;
    }

    public function headings(): array
    {
        return [
            'Agent Name',
            'Phone No',
            'Email',
            'City',
            'State',
            'Pin',
            'Address',
            'CP Designation',
            'CP Name',
            'CP Email',
            'CP Phone',
            'Created'
        ];
    }
}
