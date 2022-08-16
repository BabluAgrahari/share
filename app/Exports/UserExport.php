<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport extends Export implements FromArray, WithHeadings
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

        $query = User::query();

        if (!empty($request->name))
            $query->where('name', $request->name);

        if (!empty($request->email))
            $query->where('email', $request->email);

        if (!empty($request->mobile))
            $query->where('mobile', $request->mobile);

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

        $records = $query->orderBy('created', 'DESC')->get();

        $reults = [];
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $reults[] = [
                    'name'       => $record->name,
                    'email'            => $record->email,
                    'mobile'           => $record->mobile,
                    'city'             => $record->city,
                    'state'            => $record->state,
                    'pin'              => $record->pin,
                    'address'          => $record->address,
                    'role'             => $record->role,
                    'created'          => $record->dformat($record->created),
                ];
            }
        }
        return $reults;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Mobile',
            'City',
            'State',
            'Pin',
            'Address',
            'Role',
            'Created'
        ];
    }
}
