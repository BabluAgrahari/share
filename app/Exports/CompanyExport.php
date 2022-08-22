<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Court;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport extends Export implements FromArray, WithHeadings
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

        $query = Company::query();

        if (!empty($request->name))
            $query->where('company_name', 'LIKE', "%$request->name%");

        if (!empty($request->email))
            $query->where('email', $request->email);

        if (!empty($request->status))
            $query->where('status', $request->status);

        if (!empty($request->address))
            $query->where('address', $request->address);

        $records = $query->orderBy('created', 'DESC')->get();

        $reults = [];
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $reults[] = [
                    'c_name'           => $record->company_name,
                    'phone'            => $record->phone,
                    'email'            => $record->email,
                    'city'             => $record->city,
                    'state'            => $record->state,
                    'pin'              => $record->pin,
                    'address'          => $record->address,
                    'remarks'          => $record->remarks,
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
            'Company Name',
            'Phone',
            'Email',
            'City',
            'State',
            'Pin',
            'Address',
            'Remarks',
            'CP Designation',
            'CP Name',
            'CP Email',
            'CP Phone',
            'Created'
        ];
    }
}
